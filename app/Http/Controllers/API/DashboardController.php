<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
  protected $user;
  public function __construct()
  {
    $this->user = Auth::user();
  }
  // Get all posts for the authenticated user
  public function index()
  {
    $posts = Post::latest()
      ->where('user_id', $this->user->id)
      ->paginate(10); // Adjusted to paginate 10 posts per page

    return response()->json([
      'data' => $posts,
      'message' => 'Posts retrieved successfully',
    ], 200);
  }

  // Create a new post
  public function store(Request $request)
  {
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
      'title' => 'required|string|max:255',
      'body' => 'required|string',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors(),
        'message' => 'Validation failed',
      ], 422);
    }

    Gate::authorize('create', Post::class);

    // Generate the slug from the title
    $slug = $this->generateUniqueSlug($request->title);

    // Create the post
    $post = Post::create([
      'title' => $request->title,
      'body' => $request->body,
      'user_id' => $this->user->id,
      'slug' => $slug,
    ]);

    return response()->json([
      'data' => $post,
      'message' => 'Post created successfully',
    ], 201); // HTTP 201 for resource creation
  }

  // Get a single post
  public function show(Post $post)
  {
    Gate::authorize('view', $post);

    return response()->json([
      'data' => $post,
      'message' => 'Post retrieved successfully',
    ], 200);
  }

  // Update a post
  public function update(Request $request, Post $post)
  {
    Gate::authorize('update', $post);

    // Validate the incoming request
    $validator = Validator::make($request->all(), [
      'title' => 'required|string|max:255',
      'body' => 'required|string',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors(),
        'message' => 'Validation failed',
      ], 422);
    }

    // Check if the title has changed
    $titleHasChanged = $request->title !== $post->title;

    // Generate the new slug only if the title has changed
    if ($titleHasChanged) {
      $slug = $this->generateUniqueSlug($request->title, $post->id);
    } else {
      // Keep the current slug if the title hasn't changed
      $slug = $post->slug;
    }

    // Update the post
    $post->update([
      'title' => $request->title,
      'body' => $request->body,
      'slug' => $slug,
    ]);

    return response()->json([
      'data' => $post,
      'message' => 'Post updated successfully',
    ], 200);
  }

  // Delete a post
  public function destroy(Post $post)
  {
    Gate::authorize('delete', $post);

    // Delete the post
    $post->delete();

    return response()->json([
      'message' => 'Post deleted successfully',
    ], 200);
  }

  // Helper method to generate unique slug
  private function generateUniqueSlug($title, $postId = null)
  {
    $slug = Str::slug($title);
    $slugExists = Post::where('slug', $slug)->where('id', '!=', $postId)->exists();

    if ($slugExists) {
      $slug = $slug . '-' . Str::random(5); // Append random string to make it unique
    }

    return $slug;
  }
}
