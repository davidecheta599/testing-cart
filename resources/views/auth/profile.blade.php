@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <h1>PROFILE PAGE</h1>
         </div>

         <br>
        <h2>My Order</h2>



         <hr>

          @foreach($orders as $order)
   <div class="panel panel-default">
          <div class="panel-body">
           <ul class="list-group">
               @foreach($order->cart->items as $item)
                   <li class="list-group-item"><span class="badge">${{ $item['price'] }} </span>
                     {{ $item['item']['title'] }} | {{$item['qty'] }} units

                      <img src=" {{ $item['item']['imagePath'] }} " alt="Smiley face" height="100" width="100">
                   </li>
                   @endforeach
            </ul>
          </div>
          <div class="panel-footer">
                        <strong>Total Price: ${{ $order->cart->totalPrice }}</strong>

          </div>
     </div>
     @endforeach
    </div>
</div>
@endsection

