@if (Session::has('success'))
  <div class="container alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success:</strong> {{ Session::get('success') }}.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif

@if (Session::has('error'))
  <div class="container alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error:</strong> {{ Session::get('error') }}.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif

@if (count($errors) > 0)
  <div class="container alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error(s):</strong>
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
