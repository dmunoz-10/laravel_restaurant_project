@extends('layouts.app')

@section('content')
<div class="container">
  <h2 class="text-center">Edit</h2>

  <form action="{{ route('ingredients.update', $ingredient->id) }}" method="post">
    @csrf
    @method('PUT')

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
        <input name="name" type="text" class="form-control" placeholder="Name" value="{{ $ingredient->name }}" required>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
        <input name="provider" type="text" class="form-control" placeholder="Provider" value="{{ $ingredient->provider }}" required>
      </div>
    </div>
    <div class="text-center">
      <input type="submit" class="btn btn-primary col-sm-12 col-md-4 mb-4" value="Save Changes">
    </div>
  </form>
</div>
@endsection
