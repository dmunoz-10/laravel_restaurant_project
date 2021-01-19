@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>ORDERS:</h3><br>
    @foreach ($orders as $order)
      <a href="{{ route('orders.show', $order->id) }}">{{ $order->id }} -
        table number: {{ $order->table_number }} - {{ $order->status == 'N' ? 'Opened' : 'Closed' }}</a><br>
    @endforeach
    <a class="create btn btn-primary" href="{{ route('orders.create') }}">Create a new order</a>
    <div class="text-center">
      <div class="pagination">
        {{ $orders->links() }}
      </div>
    </div>
  </div>
@endsection
