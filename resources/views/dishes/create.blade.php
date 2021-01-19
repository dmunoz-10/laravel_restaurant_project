@extends('layouts.app')

@section('style')
<style>

</style>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function () {
    $(':input[type="number"]').not('#price').hide();

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
      $.each($("input[name = 'ingredients']:checked"), function () {
        let temp = {};
        temp['id'] = $(this).val();
        temp['quantity'] = $('#' + $(this).val()).val();
        selected.push(temp);
      });

      let temp2 = selected.map(function (element) {
        return '' + element.id + '-' + element.quantity;
      }).join(',');

      $('#ingredients').val(temp2);
    });
  });
</script>
@endsection

@section('content')
<div class="container">
  <h1 class="text-center">Create a dish</h1>

  <form action="{{ route('dishes.store') }}" method="post">
    @csrf

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
        <input id="name" name="name" type="text" class="form-control" placeholder="Name" required>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
        <input id="price" name="price" type="number" class="form-control" placeholder="Price" required>
      </div>
    </div>
    <h3>Add ingredients</h3>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Provider</th>
            <th scope="col">Add</th>
            <th scope="col">Quantity</th>
          </tr>
        </thead>
        <tbody class="text-center">
          @foreach($ingredients as $ingredient)
            <tr>
              <td>{{ $ingredient->name }}</td>
              <td>{{ $ingredient->provider }}</td>
              <td> <input type="checkbox" name="ingredients" value="{{ $ingredient->id }}"> </td>
              <td> <input style="width: 55px" id="{{ $ingredient->id }}" type="number"
                    value="1" min="1"> </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <input type="text" id="ingredients" name="ingredients" hidden>
    <div class="text-center">
      <input id="add" type="submit" class="btn btn-primary col-sm-12 col-md-4 mb-4" value="Add">
    </div>
  </form>
</div>
@endsection
