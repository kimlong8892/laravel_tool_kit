<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find($id)
 * @method static where(string $string, string $string1, string $string2)
 */
class Field extends Model {
    use HasFactory;

    protected $table = 'fields';

    protected $fillable = [
        'name',
        'type',
        'values',
        'parent_id',
        'entity'
    ];

    public function ChildFields(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Field::class, 'parent_id');
    }
}
