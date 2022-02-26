@extends('layouts.nonav', ['title' => 'Payment Page'])

@section('content')
<div class="container vh-100 d-flex justify-content-center align-items-center">
   @if(session()->has('success'))
   <div class="card dashboard-card" style="width: 1000px;">
      <div class="card-body">
         <div class="row align-items-center">
            <div class="col">
               <a href="{{ route('order.index') }}">
                  <img src="{{ asset("img/icon/logo waiter.png") }}" class="logo-waiter-seat">
               </a>
            </div>
            <div class="col">
               <p class="paymentPage-text" style="color: #0DF900;">{{session()->get('success')}}</p>
               <p class="text-muted">you will be redirected to pemesanan menu in <span id="paymentPage-counter">10</span> seconds</p>
            </div>
         </div>
      </div>
   </div>
   @endif

   @if(session()->has('error'))
   <div class="card dashboard-card" style="width: 1000px;">
      <div class="card-body">
         <div class="row align-items-center">
            <div class="col">
               <a href="{{ route('order.index') }}">
                  <img src="{{ asset("img/icon/logo waiter.png") }}" class="logo-waiter-seat">
               </a>
            </div>
            <div class="col">
               <p class="paymentPage-text text-danger" style="color: #0DF900;">{{session()->get('error')}}</p>
               <p class="text-muted">you will be redirected to pemesanan menu in <span id="paymentPage-counter">10</span> seconds</p>
            </div>
         </div>
      </div>
   </div>
   @endif
</div>

<script>
   let interval = setInterval(function() {
      var i = document.getElementById('paymentPage-counter');
      if (parseInt(i.innerHTML) <= 0) {
         clearInterval(interval);
        return location.href = "{{ URL::to('/pemesanan')}}";
      }
      if (parseInt(i.innerHTML) != 0) {
         i.innerHTML = parseInt(i.innerHTML) - 1;
      }
   }, 1000);

   // setTimeout(function() {
   //    location.href = "{{ URL::to('/pemesanan')}}";
   // }, 1000);
</script>
@endsection