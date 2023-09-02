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
            <!-- Button to trigger the Add User modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
    Add New User
</button>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="remainingamount" class="form-label">email </label>
                        <input type="text" id="remainingamount" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="remainingamount" class="form-label">Give the new User a password </label>
                        <input type="password" id="remainingamount" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="remainingamount" class="form-label">Remaining Amount</label>
                        <input type="number" id="remainingamount" name="remainingamount" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

            <h5 class="card-title">Users with Remaining Amount</h5>
            <ul>
                @foreach($usersWithRemainingAmount as $user)
                    <li>{{ $user->name }} - Remaining Amount: {{ $user->remainingamount }} - Date of the last purchase is : {{$final = date("d-m-Y", strtotime($user->date_first_purchase ));}} - Date of the next purchase : {{$final = date("d-m-Y", strtotime($user->date_first_purchase . "+1 month"));}}  </li>
                    <li>This User purchased {{$user->payment_number}} times  </li>
                    <li>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal{{ $user->id }}">Update</button>
        </li>
        <li>
    <form action="{{ route('user.delete', ['id' => $user->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit">Delete</button>
    </form>
</li>
                    @endforeach
            </ul>
            @foreach($usersWithRemainingAmount as $user)
    <div class="modal fade" id="updateModal{{ $user->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('user.update', ['id' => $user->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel{{ $user->id }}">Update This User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="newRemainingAmount{{ $user->id }}">New User Name:</label>
                        <input type="text" id="newRemainingAmount{{ $user->id }}" name="newusername" class="form-control">
                    </div>
                    <div class="modal-body">
                        <label for="newRemainingAmount{{ $user->id }}">New Remaining Amount:</label>
                        <input type="text" id="newRemainingAmount{{ $user->id }}" name="newRemainingAmount" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@endsection