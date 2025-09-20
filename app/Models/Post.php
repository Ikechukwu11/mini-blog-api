<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'slug'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'updated_at'
    ];

    /**
     * Search Filters
     */

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['search']) && $filters['search']) {
            $query->where('title', 'like', '%' . $filters['search'] . '%')
                ->orWhere('body', 'like', '%' . $filters['search'] . '%');
        }

        if (isset($filters['s']) && $filters['s']) {
            $query->where('title', 'like', '%' . $filters['s'] . '%')
                ->orWhere('body', 'like', '%' . $filters['s'] . '%');
        }

        return $query;
    }

    /**
     * Get the author of the post (user).
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
