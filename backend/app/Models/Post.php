<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'created_at' => 'datetime:d/m/Y',
        ];
    }

    public function category() {
        return $this->belongsTo(PostCategory::class);
    }

    public function scopeSearch($query, $request = null, $ownPosts = false) {
        $query->from('posts as p');

        // $query->join('users as u', 'p.author_id', '=', 'u.id');
        $query->join('post_categories as c', 'p.category_id', '=', 'c.id');

        $query->select('p.id', 'p.author_id', 'p.title', 'p.summary', 'p.created_at', 'c.name as category', 'c.slug as category_slug');

        // $query->orderBy('p.id', 'desc');

        if ($request) {

        }

        if ($ownPosts) {
            $query->where('p.author_id', Auth::id());
        }
    }
}
