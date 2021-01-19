@extends('layouts.app')

@section('content')
<div class="container">
  @guest
    <div class="text-center">
        <h2 class="display-4">WELCOME TO {{ config('app.name') }}!</h2>
        <p>
          We are one of the best restaurant ever, {{ config('app.name') }} is more than a name,
          more than a brand, it's your family, <strong>our family</strong>. We have the best
          dishes in the world, with the best chef in the whole world, yeah <strong>world</strong>,
          'cause if alien exists, their chefs are not better than ours. So do not hesitate, come
          here and try our best dishes, you will love them, <strong>you will love us</strong>.
        </p>
    </div>
  @else
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><strong>{{ config('app.name') }} - The Best restaurant</strong></div>

                <div class="card-body">
                  <p>
                    Do your best, and maybe you could be the employee of the month, with a double pay for
                    your effort, and remember, <strong>we are a family :D.</strong>
                  </p>
                </div>
            </div>
        </div>
    </div>
  @endguest
</div>
@endsection
