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
@section('paid')
<form action="{{ route('submitInstallments') }}" method="post">
    @csrf
<div class="split1">
     <p class="splitdetails"><i class="bi bi-credit-card-2-back-fill"></i> Split Your Payment in 3 Amounts :</p>
     
     @foreach ($installments['monthly_installments'] as $index => $installment)
    @if ($index === 0)
       <!--  Today : {{$ldate = date('Y-m-d H:i:s');}}-->
         
         <p class="first" >Paid today  </p>        <p class="number" name="paidamount" value="${{ number_format($installment['amount'], 3) }}">${{ number_format($installment['amount'], 3) }}</p>
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
    <h2>Items:</h2>
        <ul>
        @foreach ($installments['items'] as $item)
    <li>{{ $item['title'] }}</li>
    <li>{{ $item['qty'] }}</li>
@endforeach
</ul>
    <button type="submit" class="btn  mb-3 paybtn1" name="totalAmount" value="{{ number_format($installment['amount'], 3) }}">Confirm Your payment to Recieve a mail for the next amount</button>

    </form>

            
      
@endsection