<?php

namespace App\Http\Controllers\Web;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
  protected $user;
  public function __construct()
  {
    $this->user = Auth::user();
  }
  public function index()
  {
    $posts = Post::filter(request(['search', 's']))->latest()->where('user_id', $this->user->id)->paginate(10)->appends(request()->query());
    return view('dashboard.index', compact('posts'));
  }

  public function create()
  {
    return view('dashboard.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'title' => 'required|string|max:255',
      'body' => 'required|string',
    ]);
    Gate::authorize('create', Post::class);

    // Generate the slug from the title
    $slug = Str::slug($request->title);

    // Ensure the slug is unique by appending a number if needed
    $slugExists = Post::where('slug', $slug)->exists();
    if ($slugExists) {
      $slug = $slug . '-' . Str::random(5);  // Append a random string to make it unique
    }


    $author = $this->user->id;
    Post::create([
      'title' => $request->title,
      'body' => $request->body,
      'user_id' => $author,
      'slug' => $slug
    ]);
    return redirect()->route('dashboard.index')->with('success', 'Post created successfully');
  }

  public function edit(Post $post)
  {
    Gate::authorize('view', $post);
    return view('dashboard.edit', compact('post'));
  }

  public function update(Request $request, Post $post)
  {
    Gate::authorize('update', $post);

    $request->validate([
      'title' => 'required|string|max:255',
      'body' => 'required|string',
    ]);

    // First, check if the title has actually changed
    $titleHasChanged = $request->title !== $post->title;

    // Generate the new slug only if the title has changed
    if ($titleHasChanged) {
      $slug = Str::slug($request->title);

      // Check if the slug already exists (and isn't the current post's slug)
      $slugExists = Post::where('slug', $slug)->where('id', '!=', $post->id)->exists();
      if ($slugExists) {
        // If the slug exists, append a random string to make it unique
        $slug = $slug . '-' . Str::random(5);
      }
    } else {
      // If the title didn't change, keep the current slug
      $slug = $post->slug;
    }

    // Update the post with the new title, body, and slug (if changed)
    $post->update([
      'title' => $request->title,
      'body' => $request->body,
      'slug' => $slug,
    ]);

    return redirect()->route('dashboard.index')->with('success', 'Post updated successfully');
  }


  public function destroy(Post $post)
  {
    Gate::authorize('delete', $post);
    $post->delete();
    return redirect()->route('dashboard.index')->with('success', 'Post deleted successfully');
  }
}
