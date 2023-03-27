<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\BaseRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PostRepository extends BaseRepository implements PostRepositoryInterface {
    public function getListInAdmin(): \Illuminate\Contracts\Pagination\LengthAwarePaginator {
        $perPage = config('custom.post')['per_page'] ?? 10;
        return Post::with(['Admin'])
            ->paginate($perPage);
    }

    private function uploadImageAvatar($image, $post): string {
        $imagePath = 'images_upload/post_images/' . $post->getAttribute('id');
        return uploadImage($image, 'avatar', $imagePath, true);
    }

    private function insertOrUpdateCategories($listCategory, $post) {
        $arrayInsertProductCategory = [];

        foreach ($listCategory as $categoryId) {
            $arrayInsertProductCategory[] = [
                'post_id' => $post->getAttribute('id'),
                'category_id' => $categoryId
            ];
        }

        DB::table('post_category')->insert($arrayInsertProductCategory);
    }

    private function insertOrUpdateTags($tags, $post) {
        $arrayPostTagInsert = [];
        $arrayInsertTag = [];

        foreach ($tags as $tag) {
            $arrayInsertTag[] = [
                'name' => $tag,
                'slug' => makeSlug($tag),
                'created_at' => Carbon::now()
            ];
        }

        if (!empty($arrayInsertTag)) {
            DB::table('tags')->insertOrIgnore($arrayInsertTag);
        }

        $arrayTagDB = DB::table('tags')
            ->whereIn('name', $tags)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->name => $item->id];
            });

        foreach ($tags as $tag) {
            if (!empty($arrayTagDB[$tag])) {
                $arrayPostTagInsert[] = [
                    'post_id' => $post->getAttribute('id'),
                    'tag_id' => $arrayTagDB[$tag]
                ];
            }
        }

        if (!empty($arrayPostTagInsert)) {
            DB::table('post_tag')->insert($arrayPostTagInsert);
        }
    }

    public function store($data): int {
        $post = new Post();
        $image = $data['image'] ?? null;
        $listCategory = $data['category_id'] ?? null;
        $tags = $data['tags'] ?? null;

        $data = $this->mapDataRequest($post, $data);
        $post->fill($data);
        $post->save();

        // image
        if (!empty($image)) {
            $post->setAttribute('image', $this->uploadImageAvatar($image, $post));
            $post->save();
        }

        // categories
        if (!empty($listCategory)) {
            $this->insertOrUpdateCategories($listCategory, $post);
        }

        // tag
        if (!empty($tags)) {
            $this->insertOrUpdateTags($tags, $post);
        }


        return $post->getAttribute('id');
    }

    public function update($id, $data): int {
        $post = Post::find($id);
        $image = $data['image'] ?? null;
        $listCategory = $data['category_id'] ?? null;
        $tags = $data['tags'] ?? null;
        $customFields = $data['custom_field'] ?? null;

        $data = $this->mapDataRequest($post, $data);
        $post->fill($data);

        // image
        if (!empty($image)) {
            $post->setAttribute('image', $this->uploadImageAvatar($image, $post));
            $post->save();
        }

        // categories
        if (!empty($listCategory)) {
            $this->insertOrUpdateCategories($listCategory, $post);
        }

        // tag
        if (!empty($tags)) {
            DB::table('post_tag')
                ->where('post_id', '=', $post->getAttribute('id'))
                ->delete();
            $this->insertOrUpdateTags($tags, $post);
        }

        // list field
        if (!empty($customFields)) {
            $this->InsertOrUpdateCustomField($post, $customFields);
        }

        $post->save();
        return $post->getAttribute('id');
    }

    private function uploadImageField($valueValue, $fieldId): string {
        sleep(0.1);
        return uploadImage($valueValue, time() . rand (1111111, 9999999), 'images_upload/custom_field_images/' . $fieldId, true);
    }

    private function InsertOrUpdateCustomField($post, $lisField) {
        $arrayPostFieldInsert = [];

        $arrayListFieldDB = DB::table('post_field')
            ->whereIn('field_id', array_keys($lisField))
            ->get()->mapWithKeys(function ($item) {
                return [$item->field_id => true];
            })->toArray();

        $arrayListFieldDBCheckIsProductSelect = DB::table('fields')
            ->whereIn('id', array_keys($lisField))
            ->where('is_select_product', '=', true)
            ->get()->mapWithKeys(function ($item) {
                return [$item->id => $item->is_select_product];
            })->toArray();

        $arrayInsertProduct = [];

        DB::beginTransaction();
        foreach ($lisField as $fieldId => $value) {
            if (!empty($value)) {
                if (!empty($arrayListFieldDBCheckIsProductSelect[$fieldId])) {
                    $valueArray = $value;
                    $value = [];
                    foreach ($valueArray as $productItem) {
                        $productItem = json_decode($productItem, true);

                        if (!empty($productItem['itemId'])) {
                            $arrayInsertProduct[$productItem['itemId']] = [
                                'itemId' => $productItem['itemId'],
                                'price' => $productItem['price'],
                                'imageUrl' => $productItem['imageUrl'],
                                'productName' => $productItem['productName'],
                                'offerLink' => $productItem['offerLink'],
                                'productLink' => $productItem['productLink'],
                                'shopName' => $productItem['shopName'],
                                'created_at' => Carbon::now()
                            ];
                            $value[] = $productItem['itemId'];
                        } else {
                            $value[] = $productItem;
                        }


                    }
                }

                $valueArray = $value;
                if (is_array($valueArray)) {
                    $isListImage = array_reduce($valueArray, function ($result, $item) { return $result && $item instanceof \Illuminate\Http\UploadedFile;}, true);

                    if ($isListImage) {
                        $value = [];
                        File::deleteDirectory(public_path('images_upload/custom_field_images/' . $fieldId));

                        foreach ($valueArray as $valueValue) {
                            $value[] = $this->uploadImageField($valueValue, $fieldId);
                        }
                    }
                }

                if ($value instanceof \Illuminate\Http\UploadedFile) {
                    File::deleteDirectory(public_path('images_upload/custom_field_images/' . $fieldId));
                    $value = $this->uploadImageField($value, $fieldId);
                }

                if (is_array($value)) {
                    $value = json_encode($value);
                }

                if (empty($arrayListFieldDB[$fieldId])) {
                    $arrayPostFieldInsert[] = [
                        'post_id' => $post->id,
                        'field_id' => $fieldId,
                        'value' => $value
                    ];
                } else {
                    DB::table('post_field')
                        ->where('post_id', '=', $post->id)
                        ->where('field_id', '=', $fieldId)
                        ->update([
                            'value' => $value
                        ]);
                }
            }
        }
        DB::commit();

        if (!empty($arrayInsertProduct)) {
            $listProductExist = DB::table('products')
                ->whereIn('itemId', array_column($arrayInsertProduct, 'itemId'))
                ->get();

            DB::beginTransaction();
            foreach ($listProductExist as $productUpdate) {
                DB::table('products')
                    ->where('id', $productUpdate->id)
                    ->update($arrayInsertProduct[$productUpdate->itemId]);
                unset($arrayInsertProduct[$productUpdate->itemId]);
            }
            DB::commit();

            DB::table('products')->insert($arrayInsertProduct);
        }

        DB::table('post_field')->insert($arrayPostFieldInsert);
    }

    public function getDetail($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null {
        return Post::with(['Categories'])->find($id);
    }

    public function destroy($id): int {
        DB::table('posts')
            ->where('id', '=', $id)
            ->delete();

        return $id;
    }

    public function getCustomFields($parentId = null): \Illuminate\Support\Collection {
        return DB::table('fields')
            ->where('entity', '=', 'post')
            ->where('parent_id', '=', $parentId)
            ->get();
    }

    public function getCustomFieldsValue($postId) {
        return DB::table('post_field')
            ->where('post_id', '=', $postId)
            ->get()->mapWithKeys(function ($item) {
                return [$item->field_id => $item->value];
            })->toArray();
    }
}
