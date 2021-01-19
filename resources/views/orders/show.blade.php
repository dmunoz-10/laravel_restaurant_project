@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-6 col-sm-6 col-md-6">
      <h5>Order:</h5>
      <h1>{{ $order->id }}</h1><br>
      <h3>Table number: {{ $order->table_number }}</h3>
      @if ($order->status == 'N')
        <h3>Status: Opened</h3>
      @else
        <h3>Status: Closed</h3>
        <h3>Amount to be paid: ${{ number_format($order->total_amount, 2) }}</h3>
      @endif
    </div>
    @if ($order->status == 'N')
      <div class="col-3 col-sm-3 col-md-1 offset-md-3">
        <a class="btn btn-success" href="{{ route('orders.edit', $order->id) }}">Edit</a>
      </div>

      <div class="col-3 col-sm-3 col-md-1">
        <form class="" action="{{ route('orders.close', $order->id) }}" method="post">
          @csrf
          @method('PUT')
          <input class="btn btn-secondary" type="submit" value="Close">
        </form>
      </div>

      <div class="col-3 col-sm-3 col-md-1">
    @else
      <div class="col-3 col-sm-3 col-md-1 offset-md-5">
    @endif
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">
        Delete
      </button>
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">DELETE ORDER {{ $order->id }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Are you sure?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
              <form class="{{ route('orders.destroy', $order->id ) }}" method="post">
                @csrf
                @method('DELETE')
                <input type="submit" class="btn btn-danger" value="Delete">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if (!empty($dishes[0]))
    <h3>Dishes:</h3>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
          </tr>
        </thead>
        <tbody class="text-center">
          @foreach($dishes as $dish)
            <tr>
              <td>{{ $dish->name }}</td>
              <td>$ {{ number_format($dish->price, 2) }}</td>
              <td>{{ $dish->pivot->quantity }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection
