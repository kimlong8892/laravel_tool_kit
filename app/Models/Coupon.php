<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, $categoryId)
 */
class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'code',
        'description',
        'category_id',
        'start_time',
        'end_time',
        'enabled',
        'link'
    ];

    protected $table = 'coupons';

    public function Category(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
