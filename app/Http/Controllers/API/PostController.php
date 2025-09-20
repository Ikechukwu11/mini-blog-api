<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostController extends Controller
{
    //All posts.

    public function index()
    {
        try {
            // Retrieve the posts with authors, ordered by latest, paginated
            $posts = Post::filter(request(['search', 's']))->latest()->with('author')->paginate(10)->appends(request()->query());

            return response()->json([
                'data' => $posts,
                'message' => 'Posts retrieved successfully',
            ], 200);
        } catch (\Exception $e) {
            // Catch any other unexpected errors
            return response()->json([
                'message' => 'Something went wrong while retrieving posts.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    //Single Post by id or slug
    public function show($slug)
    {
        try {
            // Retrieve the post by slug
            $post = Post::where('slug', $slug)->orWhere('id', $slug)->with('author')->firstOrFail();

            return response()->json([
                'data' => $post,
                'message' => 'Post retrieved successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
            // Post not found
            return response()->json([
                'message' => 'Post not found',
                'error' => 'The post with the given slug does not exist.',
            ], 404);
        } catch (\Exception $e) {
            // Catch any other unexpected errors
            return response()->json([
                'message' => 'Something went wrong while retrieving the post.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
