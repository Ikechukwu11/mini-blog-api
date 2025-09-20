<x-app>
  <x-slot:title>
    Edit Post | {{ $post?->title }}
    </x-slot>
    <style>
      main {
        min-height: 10vh !important;
      }
    </style>
    <div class="dashboard">
      <x-alert />
      <h1>Edit post</h1>
      <form method="POST" action="{{ route('dashboard.posts.update', $post) }}">
        @csrf
        @method('PUT')
        <div class="form-col">
          <label>Title</label>
          <input type="text" name="title" value="{{ old('title') ?? $post->title }}">
        </div>

        <div class="form-col">
          <label>Body</label>
          <textarea name="body" id="" cols="30" rows="10">{{ old('body') ?? $post->body }}</textarea>
        </div>

        <div class="form-col">
          <label>Author</label>
          <input type="text" value="{{ auth()->user()->name }}" readonly>
        </div>
        <div class="form-footer">

          <div class="form-col">
            <input type="submit" value="Update">
          </div>

          <div class="form-col">
            <a class="button-back" href="{{ route('dashboard.index') }}">Back</a>
          </div>
        </div>
      </form>
    </div>
</x-app>