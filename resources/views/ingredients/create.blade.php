@extends('layouts.app')

@section('content')
<div class="container">
  <h2 class="text-center">Create an ingredient</h2>

  <form action="{{ route('ingredients.store') }}" method="post">
    @csrf

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
        <input name="name" type="text" class="form-control" placeholder="Name" required>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
        <input name="provider" type="text" class="form-control" placeholder="Provider" required>
      </div>
    </div>
    <div class="text-center">
      <input type="submit" class="btn btn-primary col-sm-12 col-md-4 mb-4" value="Add">
    </div>
  </form>
</div>
@endsection
