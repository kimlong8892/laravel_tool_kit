<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static paginate(mixed $perPage)
 * @method static find($id)
 */
class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        'image',
        'slug',
        'parent_id'
    ];

    public function ChildCategories(): HasMany {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getImage(): String {
        if (empty($this->getAttribute('image'))) {
            return '';
        }

        if (filter_var($this->getAttribute('image'), FILTER_VALIDATE_URL)) {
            return $this->getAttribute('image');
        }

        return asset('images_upload/category_images/' . $this->getAttribute('id') . '/' . $this->getAttribute('image'));
    }
}
