@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-6 col-sm-6 col-md-3">
      <h5>Dish:</h5>
      <h1>{{ $dish->name }}</h1><br>
      <h3>Price: ${{ number_format($dish->price, 2) }}</h3>
    </div>
    <div class="col-3 col-sm-3 col-md-1 offset-md-7">
      <a class="btn btn-success" href="{{ route('dishes.edit', $dish->id) }}">Edit</a>
    </div>
    <div class="col-3 col-sm-3 col-md-1">
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">
        Delete
      </button>
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">DELETE DISH {{ $dish->name }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Are you sure?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
              <form class="{{ route('dishes.destroy', $dish->id ) }}" method="post">
                @csrf
                @method('DELETE')
                <input type="submit" class="btn btn-danger" value="DELETE">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if (!empty($ingredients[0]))
    <h2>Ingredients:</h2>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Provider</th>
            <th scope="col">Quantity</th>
          </tr>
        </thead>
        <tbody class="text-center">
          @foreach($ingredients as $ingredient)
            <tr>
              <td>{{ $ingredient->name }}</td>
              <td>{{ $ingredient->provider }}</td>
              <td>{{ $ingredient->pivot->quantity }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection
