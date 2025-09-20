<x-app>
  <x-slot:title>
    Dashboard | My Posts
    </x-slot>
    <style>
      main {
        min-height: 10vh !important;
      }

      ul {
        list-style: none;
        display: flex;
      }
    </style>
    <div class="dashboard" style="max-width: 800px">
      <x-alert />
      <div class="dashboard-header">
        <h1>My Posts</h1>
        <a class="button" href="{{ route('dashboard.posts.create') }}">New Post</a>
      </div>

      <form style="margin-bottom: 10px">
        <div class="form-footer" style="flex-wrap: nowrap!important;">
          <input type="text" placeholder="Enter a search keyword" name="s"
            value="{{ request()->query('s') ?? request()->query('search')}}">
          <input type="submit" value="Search">
        </div>

      </form>
      @if($posts->isEmpty())
      <h3 class="text-error">You have not created any posts yet</h3>
      @endif

      <div class="blog-cards">
        @foreach ($posts as $post)

        <div class="blog-card">
          <div class="title">
            <h2>{{ $post->title }}</h2>
          </div>
          <div class="meta">
            <small>{{ $post->author->name }}</small>
            <small>{{ $post->created_at->diffForHumans() }}</small>
          </div>
          <div class="content">
            <p>{{ Str::substr($post->body, 0, 50) }}...</p>
          </div>
          <div class="footer">
            <small>
              <a class="view" target="_blank" href="{{ route('posts.show', $post?->slug ) }}">View Post</a>
            </small>

            <small>
              <a class="edit" href="{{ route('dashboard.posts.edit', $post->id) }}">Edit Post</a>
            </small>

            <form onsubmit="return confirm('Are you sure you want to delete this post?')" method="POST"
              action="{{ route('dashboard.posts.destroy', $post->id) }}">
              @csrf
              @method('DELETE')
              <small>
                <input type="submit" class="text-error" value="Delete Post" />
              </small>
            </form>
          </div>
        </div>

        @endforeach

      </div>

      <div class="pagination">
        {{ $posts->links() }}
      </div>
    </div>
</x-app>