<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static find($id)
 */
class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'name',
        'image',
        'description',
        'content',
        'status',
        'view',
        'slug',
        'admin_id'
    ];

    public function getImage(): String {
        if (empty($this->getAttribute('image'))) {
            return '';
        }

        if (filter_var($this->getAttribute('image'), FILTER_VALIDATE_URL)) {
            return $this->getAttribute('image');
        }

        return asset('images_upload/post_images/' . $this->getAttribute('id') . '/' . $this->getAttribute('image'));
    }

    public function Admin(): BelongsTo {
        return $this->belongsTo(Admin::class, 'admin_id');
    }


    public function Categories(): BelongsToMany {
        return $this->belongsToMany(
            Category::class,
            'post_category',
            'post_id',
            'category_id'
        );
    }

    public function Tags(): BelongsToMany {
        return $this->belongsToMany(
            Tag::class,
            'post_tag',
            'post_id',
            'tag_id'
        );
    }

    public function getTagString(): string {
        return implode(',', $this->Tags()->pluck('name')->toArray());
    }

    public function getTagIds(): array {
        return $this->Tags()->get()->mapWithKeys(function ($item) {
            return [$item->id => true];
        })->toArray();
    }

    public function Products(): BelongsToMany {
        return $this->belongsToMany(
            Product::class,
            'post_product',
            'post_id',
            'product_id'
        )->withPivot(['content', 'images']);
    }
}
