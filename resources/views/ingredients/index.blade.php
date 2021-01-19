@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>INGREDIENTS:</h3><br>
    @foreach ($ingredients as $ingredient)
      <a href="{{ route('ingredients.show', $ingredient->id) }}">{{ $ingredient->name }}</a><br>
    @endforeach
    <a class="create btn btn-primary" href="{{ route('ingredients.create') }}">Create a new ingredient</a>
    <div class="text-center">
      <div class="pagination">
        {{ $ingredients->links() }}
      </div>
    </div>
  </div>
@endsection
