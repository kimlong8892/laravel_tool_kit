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
        $productRow = $data['product_row'] ?? null;
        $arrayItemId = [];

        foreach ($productRow as $productRowTemp) {
            $productRowTemp = json_decode($productRowTemp['product'] ?? '', true);
            if (!empty($productRowTemp) && !empty($productRowTemp['itemId'])) {
                $arrayItemId[] = $productRowTemp['itemId'];
            }
        }

        $productDB = DB::table('products')
            ->whereIn('itemId', $arrayItemId)
            ->get()->mapWithKeys(function ($item) {
                return [$item->itemId => $item->id];
            })->toArray();

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

        // product_row_insert
        if (!empty($productRow)) {
            $arrayInsertPostProduct = [];

            $postProductDB = DB::table('post_product')
                ->where('post_id', '=', $post->id)
                ->get()->mapWithKeys(function ($item) {
                    return [$item->post_id . '_' . $item->product_id => json_decode($item->images, true)];
                })->toArray();

            DB::beginTransaction();
            foreach ($productRow as $item) {
                $product = json_decode($item['product'] ?? '', true);
                $content = $item['content'] ?? '';
                $listImageUpload = $item['image'] ?? [];
                $listImageRemove = array_filter($item['list_image_remove'] ?? []);

                if (!empty($listImageRemove)) {
                    $listImageRemove = array_keys($listImageRemove);
                }

                $productId = null;
                $arrayInsertOrUpdate = [
                    'post_id' => $post->id
                ];

                if (!empty($product)) {
                    $productId = $productDB[$product['itemId']] ?? null;

                    if (empty($productId)) {
                        $productId = DB::table('products')
                            ->insertGetId([
                                'itemId' => $product['itemId'],
                                'price' => $product['price'],
                                'imageUrl' => $product['imageUrl'],
                                'productName' => $product['productName'],
                                'offerLink' => $product['offerLink'],
                                'productLink' => $product['productLink'],
                                'shopName' => $product['shopName']
                            ]);
                    }

                    $arrayInsertOrUpdate['product_id'] = $productId;
                }

                $arrayInsertOrUpdate['content'] = $content ?? '';

                if (!empty($listImageUpload)) {
                    $listImageArray = [];

                    foreach ($listImageUpload as $imageProduct) {
                        $imageName = rand(11111, 999999) . time();
                        $imagePath = 'images_upload/post_images/' . $post->id . '/products';
                        $listImageArray[] = uploadImage($imageProduct, $imageName, $imagePath, true);
                    }

                    $arrayInsertOrUpdate['images'] = $listImageArray;
                }

                if (!empty($item['is_update']) && !empty($item['product_id_old'])) {
                    $listImageExist = $postProductDB[$post->id . '_' . $item['product_id_old']] ?? null;

                    if (!empty($listImageRemove) && !empty($listImageExist)) {
                        foreach ($listImageExist as $imageKey => $imageValue) {
                            if (in_array($imageValue, $listImageRemove)) {
                                unset($listImageExist[$imageKey]);
                                $imagePathRemove = public_path('images_upload/post_images/' . $post->id . '/products/' . $imageValue);

                                if (File::exists($imagePathRemove)) {
                                    File::delete($imagePathRemove);
                                }
                            }
                        }
                    }

                    $arrayInsertOrUpdate['images'] = array_merge($arrayInsertOrUpdate['images'] ?? [], $listImageExist);
                    $arrayInsertOrUpdate['images'] = json_encode($arrayInsertOrUpdate['images'] ?? []);

                    DB::table('post_product')
                        ->where('product_id', '=', $item['product_id_old'])
                        ->where('post_id', '=', $post->id)
                        ->update($arrayInsertOrUpdate);
                } else {
                    $arrayInsertPostProduct[] = $arrayInsertOrUpdate;
                }
            }
            DB::commit();

            if (!empty($arrayInsertPostProduct)) {
                DB::table('post_product')
                    ->insert($arrayInsertPostProduct);
            }
        }

        $post->save();
        return $post->getAttribute('id');
    }


    public function getDetail($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null {
        return Post::with(['Categories', 'Tags'])->find($id);
    }

    public function destroy($id): int {
        DB::table('posts')
            ->where('id', '=', $id)
            ->delete();

        return $id;
    }

    public function getListPostInHomeWeb(): \Illuminate\Contracts\Pagination\LengthAwarePaginator {
        return Post::with(['Categories', 'Tags'])
            ->where('status', '=', 'public')
            ->paginate(config('custom.home')['post']['per_page'] ?? 10);
    }
}
