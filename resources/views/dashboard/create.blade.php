<x-app>
  <x-slot:title>
    Dashboard | New Post
    </x-slot>
    <style>
      main {
        min-height: 10vh !important;
      }
    </style>
    <div class="dashboard">
      <x-alert />
      <h1>Create a new post</h1>
      <form method="POST" action="{{ route('dashboard.posts.store') }}">
        @csrf
        <div class="form-col">
          <label>Title</label>
          <input type="text" name="title" value="{{ old('title') }}">
        </div>

        <div class="form-col">
          <label>Body</label>
          <textarea name="body" id="" cols="30" rows="10">{{ old('body') }}</textarea>
        </div>

        <div class="form-col">
          <label>Author</label>
          <input type="text" value="{{ auth()->user()->name }}" readonly>
        </div>
        <div class="form-footer">
          <div class="form-col">
            <input type="submit" value="Create">
          </div>
          <div class="form-col">
            <a class="button-back" href="{{ route('dashboard.index') }}">Back</a>
          </div>
        </div>
      </form>
    </div>
</x-app>