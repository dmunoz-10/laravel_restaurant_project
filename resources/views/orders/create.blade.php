@extends('layouts.app')

@section('script')
<script type="text/javascript">
  $(document).ready(function () {
    $(':input[type="number"]').not('#tableNumber').hide();

    $('form input:checkbox').click(function () {
      $('#' + $(this).val()).toggle();
      if ($(this).prop("checked") == true) {
        $('#' + $(this).val()).prop('required', true);
      } else {
        $('#' + $(this).val()).prop('required', false);
      }
    });

    $('#add').click(function () {
      let selected = [];
      $.each($("input[name = 'dishes']:checked"), function () {
        let temp = {};
        temp['id'] = $(this).val();
        temp['quantity'] = $('#' + $(this).val()).val();
        temp['price'] = $('#' + $(this).val()).attr('name');
        selected.push(temp);
      });

      let temp2 = selected.map(function (element) {
        return '' + element.id + '-' + element.quantity + '-' + element.price;
      }).join(',');

      $('#dishes').val(temp2);
    });
  });
</script>
@endsection

@section('content')
<div class="container">
  <h2 class="text-center">Create an order</h2>

  <form action="{{ route('orders.store') }}" method="post">
    @csrf

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
        <input id="tableNumber" name="tableNumber" type="number" class="form-control" placeholder="Table Number" required>
      </div>
    </div>
    <h3>Add dishes</h3>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Add</th>
            <th scope="col">Quantity</th>
          </tr>
        </thead>
        <tbody class="text-center">
          @foreach($dishes as $dish)
            <tr>
              <td>{{ $dish->name }}</td>
              <td>$ {{ number_format($dish->price, 2) }}</td>
              <td> <input type="checkbox" name="dishes" value="{{ $dish->id }}"> </td>
              <td> <input style="width: 55px" name='{{ $dish->price }}' id="{{ $dish->id }}"
                    type="number" value="1" min="1"> </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <input type="text" id="dishes" name="dishes" hidden>
    <div class="text-center">
      <input type="submit" id="add" class="btn btn-primary col-sm-12 col-md-4 mb-4" value="Add">
    </div>
  </form>
</div>
@endsection
