<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
