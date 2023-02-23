<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    public function Campaign(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
}
