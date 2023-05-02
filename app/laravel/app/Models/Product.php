<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static find($id)
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    public function ProductsHistoryPrice(): HasMany {
        return $this->hasMany(ProductHistory::class, 'product_id');
    }

    public function EcSite(): BelongsTo {
        return $this->belongsTo(EcSite::class, 'ec_site');
    }
}
