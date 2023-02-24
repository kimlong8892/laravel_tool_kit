<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    public function Campaign(): BelongsTo {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function Coupons(): HasMany {
        return $this->hasMany(Coupon::class, 'category_id');
    }
}
