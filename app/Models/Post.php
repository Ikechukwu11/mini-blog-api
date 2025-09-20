<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'slug'];

    /**
     * Get the author of the post (user).
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
