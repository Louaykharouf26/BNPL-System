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
            <li><p class="dropdown-item" >Role : {{ auth()->user()->role }}</p></li>

            <li><hr class="dropdown-divider"></li>
            <form action="{{ route('logout') }}" method="POST">
    @csrf
    <li><button class="dropdown-item"  type="submit"><i class="bi bi-box-arrow-right"></i> Logout</button> </li>
</form>
            
          </ul>
</div>
    </div>
  </div>
</nav>
@endsection


@section('paid')

<form action="{{ route('submitreminderInstallments') }}" method="post">
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
         
         <p class="first">{{$final = date("d-m-Y", strtotime("+1 month"));}}          <p class="number">${{ number_format($installment['amount'], 3) }}</p></p>
         @endif
         @if ($index === 2)
       <!--  Today : {{$ldate = date('Y-m-d H:i:s');}}-->
         
         <p class="first">{{$final = date("d-m-Y", strtotime("+2 month"));}}          <p class="number">${{ number_format($installment['amount'], 3) }}</p></p>
         @endif
         @endforeach
   
    </div>
    <div class="items">
    
    <button type="submit" class="btn  mb-3 paybtn1" name="totalAmount" value="{{ number_format($installment['amount'], 3) }}">Confirm Your payment to Recieve a mail for the next amount</button>
    </div>
    </form>

            
 
@endsection