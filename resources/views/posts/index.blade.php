<x-app>
	<x-slot:title>
		Home | All Posts
		</x-slot>
		<style>
			main {
				min-height: 10vh !important;
			}
		</style>
		<div class="posts" style="max-width: 800px">
			<h1 style="text-align:center">All Posts</h1>

			@if($posts->isEmpty())
			<h3 class="text-error">No posts yet</h3>
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
					<div>
						<small>
							<a class="read-more" href="{{ route('posts.show', $post->slug) }}">Read more</a>
						</small>
					</div>
				</div>

				@endforeach

			</div>

			<div class="pagination">
				{{ $posts->links() }}
			</div>
		</div>
</x-app>