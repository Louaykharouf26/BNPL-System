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
      {{ auth()->user()->email }}
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
@section('afterpay')
<h5 class="typewriter"><span>Thanks for paying your installement ! See you Next month !</span></h5>
@endsection