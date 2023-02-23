<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory;

    protected $table = 'campaigns';

    protected $fillable = [
        'cookie_duration',
        'logo',
        'max_com',
        'merchant',
        'name',
        'scope',
        'accesstrade_id',
        'name_custom',
        'enabled'
    ];

    public function Coupons(): HasMany {
        return $this->hasMany(Coupon::class, 'campaign_id');
    }
}
