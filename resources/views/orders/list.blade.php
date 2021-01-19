@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Order list per day</h1>
    <form class="form" action="{{ route('orders.orderList') }}" method="get">
      <div class="row">
        <div class="col-6 offset-1 col-xs-6 col-md-3 text-center">
          <input class="form-control" type="date" name="date" required>
        </div>
        <div class="col-3 col-xs-6 col-md-2 text-center">
          <input type="submit" class="btn btn-primary" value="Search">
        </div>
      </div>
    </form>
    @isset ($orders)
      @if (!empty($orders[0]))
        <h1>Date: {{ $date }}</h1>
        <h2>Total amount: ${{ number_format($orders->total_amount, 2) }}</h2>
        <div class="table table-responsive">
          <table class="table table-hover">
            <thead class="thead-dark text-center">
              <th scope="col">ID</th>
              <th scope="col">Table Number</th>
              <th scope="col">Amount</th>
            </thead>
            <tbody class="text-center">
              @foreach ($orders as $order)
                <tr>
                  <td>{{ $order->id }}</td>
                  <td>{{ $order->table_number }}</td>
                  <td>$ {{ number_format($order->amount, 2) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <h2>No orders were created in this date ({{ $date }}).</h2>
      @endif
    @endisset
  </div>
@endsection
