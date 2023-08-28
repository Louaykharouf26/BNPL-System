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
            <li><a class="dropdown-item" href="#">Role : {{ auth()->user()->role }}</a></li>
         
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
@section('bnplresult')
<div class="box">
    <div class="price">
        <p class="pricedetails"><i class="bi bi-cart-check-fill"></i> You Still need to pay : {{ $installments['price'] }} $</p>
    </div>
    <div class="split">
        <p class="splitdetails"><i class="bi bi-credit-card-2-back-fill"></i> Split Your Payment:</p>

        @foreach ($installments['monthly_installments'] as $index => $installment)
            @if ($index === 0)
                <p class="first">Pay today <p class="number">${{ number_format($installment['amount'], 3) }}</p></p>
            @endif
            @if ($index === 1)
                <p class="first">{{$final = date("d-m-Y", strtotime("+1 month"));}}       <p class="number">${{ number_format($installment['amount'], 3) }}</p></p>
            @endif
        @endforeach
    </div>
    <div class="paydetails">
        
        <form class="row g-3 infoform" method="POST" action="{{ route('reminder-payment') }}">
            @csrf
            
            @foreach ($installments['monthly_installments'] as $index => $installment)
                @if ($index === 0)
                    <div class="col-auto ">
                        <button type="submit" class="btn mb-3 paybtn" name="totalAmount" value="{{ number_format($installment['amount'], 3) }}">Pay today ${{ number_format($installment['amount'], 3) }}</button>
                    </div>
                @endif
            @endforeach
        </form>
    </div>
</div>@endsection