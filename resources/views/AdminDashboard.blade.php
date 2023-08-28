@extends('layouts.AdminLayout')

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
@section('admindashboard')

  <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                

                <div class="card-body">
                  <h5 class="card-title">Sales </h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $totalPaidAmount }}</h6>
                      <span class="text-success small pt-1 fw-bold">Total Paid Amounts </span> <span class="text-muted small pt-2 ps-1">for all the logged in users</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->
            <h5 class="card-title">Users with Remaining Amount</h5>
            <ul>
                @foreach($usersWithRemainingAmount as $user)
                    <li>{{ $user->name }} - Remaining Amount: {{ $user->remainingamount }} - Date of the last purchase is : {{$final = date("d-m-Y", strtotime($user->date_first_purchase ));}} - Date of the next purchase : {{$final = date("d-m-Y", strtotime($user->date_first_purchase . "+1 month"));}}  </li>
                @endforeach
            </ul>
@endsection