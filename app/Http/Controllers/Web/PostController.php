<?php

namespace App\Http\Controllers\Web;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::filter(request(['search', 's']))->latest()->with('author')->paginate(10)->appends(request()->query());
        return view('posts.index', compact('posts'));
    }

    public function show($slug)
    {
        // Retrieve the post by slug
        $post = Post::where('slug', $slug)->firstOrFail();

        // Pass the post to the view
        return view('posts.show', compact('post'));
    }
}
