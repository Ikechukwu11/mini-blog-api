<x-app>
  <x-slot:title>
    Login to your dashboard
    </x-slot>

    <div class="auth">
      <x-alert />
      <h3 style="text-align:center;margin-bottom:10px">Login to your account</h3>
      <form method="POST">
        @csrf
        <div class="form-col">
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div class="form-col">
          <label>Password</label>
          <input type="password" name="password" value="">
        </div>

        <div class="form-col">
          <input type="submit" value="Log in">
        </div>
      </form>
    </div>

</x-app>