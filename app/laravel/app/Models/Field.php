<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find($id)
 */
class Field extends Model {
    use HasFactory;

    protected $table = 'fields';

    protected $fillable = [
        'title',
        'name',
        'type',
        'values',
        'parent_id'
    ];

    public function ChildFields(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Field::class, 'parent_id');
    }
}
