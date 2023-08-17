@extends('layouts.BNPLRESULTLOGGED')
@section('navbar')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">TmkiiN Pay</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <div class="d-flex right">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{$installments['email']}}
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
</div>
    </div>
  </div>
</nav>
@endsection
@section('bnplresult')
<!--<h2>BNPL Information</h2>


<p>Price: {{ $installments['price'] }}</p>

<h3>Monthly Installments:</h3>
<ul>
    @foreach ($installments['monthly_installments'] as $installment)
        <li>{{ $installment['month'] }} - ${{ $installment['amount'] }}</li>
    @endforeach
</ul>
<ul>
@foreach ($installments['monthly_installments'] as $index => $installment)
    @if ($index === 0)
         Today : {{$ldate = date('Y-m-d H:i:s');}}
         
        <p>Amount to pay today: ${{ $installment['amount'] }}</p>
        <p>Next Amount is : {{$final = date("Y-m-d", strtotime("+1 month"));}} --- ${{ $installment['amount'] }} </p>
        <p>The last ammount will be in : {{$final = date("Y-m-d", strtotime("+2 month"));}} --- ${{ $installment['amount'] }}  </p>
    @endif
    <li>{{ $installment['month'] }} - ${{ $installment['amount'] }}</li>
@endforeach
</ul>-->

<div class="box">
    <div class="price">
     <p class="pricedetails"><i class="bi bi-cart-check-fill"></i> Your cart has a total of : {{ $installments['price'] }} $</p>
    </div>
    <div class="split">
     <p class="splitdetails"><i class="bi bi-credit-card-2-back-fill"></i> Split Your Payment in 3 Amounts :</p>
     
     @foreach ($installments['monthly_installments'] as $index => $installment)
    @if ($index === 0)
       <!--  Today : {{$ldate = date('Y-m-d H:i:s');}}-->
         
         <p class="first">Pay today          <p class="number">${{ number_format($installment['amount'], 3) }}</p></p>
         @endif
         @if ($index === 1)
       <!--  Today : {{$ldate = date('Y-m-d H:i:s');}}-->
         
         <p class="first">{{$final = date("Y-m-d", strtotime("+1 month"));}}          <p class="number">${{ number_format($installment['amount'], 3) }}</p></p>
         @endif
         @if ($index === 2)
       <!--  Today : {{$ldate = date('Y-m-d H:i:s');}}-->
         
         <p class="first">{{$final = date("Y-m-d", strtotime("+2 month"));}}          <p class="number">${{ number_format($installment['amount'], 3) }}</p></p>
         @endif
         @endforeach
   
    </div>
    <div class="paydetails">
     <p class="payinfo"><i class="bi bi-credit-card-2-front-fill"></i> Payment Informations</p>
     <form class="row g-3 infoform" method="POST" action="{{ route('make-payment') }}">
     @csrf
     <div class="mb-3 row">
    <label for="staticEmail" class="col-sm-2 col-form-label cn">Card Number</label> 
    <div class="col-sm-10">
      <input type="text" name="cn" class="form-control" id="staticEmail" >
    </div>
  </div>
  <div class="mb-3 row">
    
    <label for="inputPassword" class="col-sm-2 col-form-label cn">CVV</label>
    <div class="col-sm-10">
      <input type="text" class="form-control cvv" name="cvv" id="inputPassword">
    </div>
  </div>

 
  <div class="mb-3 row">
    <label for="inputPassword" class="col-sm-2 col-form-label cn1">Expiry date</label>
    <div class="col-sm-10">
      <input type="text" name="ed" class="form-control edate" id="inputPassword">
    </div>
  </div>
  @foreach ($installments['monthly_installments'] as $index => $installment)
    @if ($index === 0)
       <!--  Today : {{$ldate = date('Y-m-d H:i:s');}}-->
         
       <div class="col-auto ">
    <button type="submit" class="btn  mb-3 paybtn" name="totalAmount" value="{{ number_format($installment['amount'], 3) }}">Pay today ${{ number_format($installment['amount'], 3) }}</button>
  </div>
         @endif
       
         @endforeach

</form>
    </div>
</div>

<h2>Items:</h2>
        <ul>
        @foreach ($installments['items'] as $item)
    <li>{{ $item['title'] }}</li>
    <li>{{ $item['qty'] }}</li>
@endforeach

            
        </ul>
@endsection