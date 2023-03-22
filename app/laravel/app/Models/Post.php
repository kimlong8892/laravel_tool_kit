<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    public function getImage(): String {
        if (filter_var($this->getAttribute('image'), FILTER_VALIDATE_URL)) {
            return $this->getAttribute('image');
        }

        return asset($this->getAttribute('image'));
    }

    public function Admin(): BelongsTo {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
