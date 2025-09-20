<x-app>
  <x-slot:title>
    Post | {{ $post->title }}
    </x-slot>

    <style>
      main {
        min-height: 10vh !important;
      }
    </style>

    <div class="posts" style="max-width: 800px; margin: 0 auto;">
      <h1>{{ $post->title }}</h1>
      <div class="meta">
        <small>{{ $post->author->name }}</small>
        <small>{{ $post->created_at->diffForHumans() }}</small>
      </div>

      <div class="content">
        <p>{{ $post->body }}</p>
      </div>

      <div>
        <a href="{{ route('posts.index') }}">Back to All Posts</a>
      </div>
    </div>
</x-app>