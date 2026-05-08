<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'movie_title', 'image_url'])]
class FavoriteMovie extends Model
{
    protected $table = 'favorite_movies';
    protected $primaryKey = 'id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
