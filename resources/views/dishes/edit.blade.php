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
    });

    window.onload = function(){
      $('.checked').click();
    }

    $('#saveChanges').click(function () {
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
  <h1 class="text-center">Edit</h1>

  <form action="{{ route('dishes.update', $dish->id) }}" method="post">
    @csrf
    @method('PUT')

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
        <input id="name" name="name" type="text" class="form-control" placeholder="Name" value="{{ $dish->name }}" required>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
        <input id="price" name="price" type="number" class="form-control" placeholder="Price" value="{{ $dish->price }}" required>
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
              <?php $temp = false ?>
              @foreach ($itsIngredients as $itsIngredient)
                @if ($ingredient->id == $itsIngredient->id)
                  <td> <input class="checked" type="checkbox" name="ingredients" value="{{ $itsIngredient->id }}"> </td>
                  <td> <input style="width: 55px" id="{{ $itsIngredient->id }}" type="number"
                              value="{{ $itsIngredient->pivot->quantity }}" min="1"> </td>
                  <?php $temp = true ?>
                  @break
                @endif
              @endforeach
              @if ($temp == false)
                <td> <input type="checkbox" name="ingredients" value="{{ $ingredient->id }}"> </td>
                <td> <input style="width: 55px" id="{{ $ingredient->id }}" type="number"
                      value="1" min="1"> </td>
              @endif
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <input type="text" id="ingredients" name="ingredients" hidden>
    <div class="text-center">
      <input id="saveChanges" type="submit" class="btn btn-primary col-sm-12 col-md-4 mb-4" value="Save Changes">
    </div>
  </form>
</div>
@endsection
