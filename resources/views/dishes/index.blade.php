@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>DISHES:</h3><br>
    @foreach ($dishes as $dish)
      <a href="{{ route('dishes.show', $dish->id) }}">{{ $dish->name }}</a><br>
    @endforeach
    <a class="create btn btn-primary" href="{{ route('dishes.create') }}">Create a new dish</a>
    <div class="text-center">
      <div class="pagination">
        {{ $dishes->links() }}
      </div>
    </div>
  </div>
@endsection
