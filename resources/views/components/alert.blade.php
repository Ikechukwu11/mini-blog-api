<div class="alert-container">
  @if(session('success'))
  <div class="alert alert-success">
    <div class="alert-text">{{ session('success') }}</div>
    <button onclick="closeAlert()" class="alert-close">&times;</button>
  </div>
  @endif

  @if(session('error'))
  <div class="alert alert-error">
    <div class="alert-text">{{ session('error') }}</div>
    <button onclick="closeAlert()" class="alert-close">&times;</button>
  </div>
  @endif

  @if ($errors->any())
  @foreach ($errors->all() as $error)
  <div class="alert alert-error">
    <div class="alert-text">{{ $error }}</div>
    <button onclick="closeAlert()" class="alert-close">&times;</button>
  </div>
  @endforeach
  @endif
</div>

<script>
  function closeAlert() {
    const alert = document.querySelector('.alert-container .alert');
    if (alert) {
      alert.style.display = 'none';
    }
  }
</script>