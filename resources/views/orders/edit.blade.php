@extends('layouts.app')

@section('script')
<script type="text/javascript">
  $(document).ready(function () {
    $(':input[type="number"]').not('#tableNumber').hide();

    $('form input:checkbox').click(function () {
      $('#' + $(this).val()).toggle();
    });

    window.onload = function(){
      $('.checked').click();
    }

    $('#saveChanges').click(function () {
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
  <h2 class="text-center">Edit</h2>

  <form action="{{ route('orders.update', $order->id) }}" method="post">
    @csrf
    @method('PUT')

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
        <input id="tableNumber" name="tableNumber" type="number" class="form-control" placeholder="Table Number"
        value="{{ $order->table_number }}" required>
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
              <?php $temp = false ?>
              @foreach ($itsDishes as $itsDish)
                @if ($dish->id == $itsDish->id)
                  <td> <input class="checked" type="checkbox" name="dishes" value="{{ $itsDish->id }}"> </td>
                  <td> <input style="width: 55px" name='{{ $itsDish->price }}' id="{{ $itsDish->id }}"
                        type="number" value="{{ $itsDish->pivot->quantity }}" min="1"> </td>
                  <?php $temp = true ?>
                  @break
                @endif
              @endforeach
              @if ($temp == false)
                <td> <input type="checkbox" name="dishes" value="{{ $dish->id }}"> </td>
                <td> <input style="width: 55px" name='{{ $dish->price }}' id="{{ $dish->id }}"
                      type="number" value="1" min="1"> </td>
              @endif
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <input type="text" id="dishes" name="dishes" hidden>
    <div class="text-center">
      <input type="submit" id="saveChanges" class="btn btn-primary col-sm-12 col-md-4 mb-4" value="Save Changes">
    </div>
  </form>
</div>
@endsection
