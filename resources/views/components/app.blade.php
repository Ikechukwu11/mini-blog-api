<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#000000">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $title ? "$title - " . config('app.name', 'Mini Blog') : config('app.name', 'Mini Blog') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

  <!-- Styles / Scripts -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body>
  <header class="header">
    <a href="/">{{config('app.name', 'Mini Blog')}}</a>

    <nav class="navbar">
      <a class="{{ request()->routeIs('home') ||  request()->routeIs('posts.index') ? 'active':'' }}"
        href="{{ route('posts.index') }}">Posts</a>
      @auth
      <a href="{{ url('/dashboard') }}" class="{{ request()->routeIs('dashboard.index') ? 'active':'' }}">
        My Posts
      </a>
      <a class="{{ request()->routeIs('dasboard.posts.create') ? 'active':'' }}"
        href="{{ route('dashboard.posts.create') }}">New
        Post</a>
      <a href="{{ url('/logout') }}" class="">
        Logout
      </a>
      @else

      <a href="{{ route('login.show') }}" class="{{ request()->routeIs('login.show') ? 'active':'' }}">
        Log in
      </a>

      @if (Route::has('register.show'))
      <a href="{{ route('register.show') }}" class="{{ request()->routeIs('register.show') ? 'active':'' }}">
        Register
      </a>
      @endif
      @endauth
    </nav>

  </header>

  <main>
    {{ $slot }}
  </main>

</body>

</html>