<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
