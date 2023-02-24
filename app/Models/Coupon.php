<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'enabled'
    ];

    protected $table = 'coupons';

    public function Category(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
