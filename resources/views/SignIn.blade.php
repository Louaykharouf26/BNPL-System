@extends('layouts.Auth')

@section('SignIn')
<div class="container" id="signinbx">

 <p class="welcome">Welcome to <span class="wiin">TMKiiN Pay</span></p> 
 <p class="Sin">Sign in</p>
 <p class="NA1">No Account ?</p>
 <a href="{{ url('SignUp') }}" class="signUp" >Sign up</a>

 <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="staticEmail" class="col-sm-2 col-form-label" id="label1">Enter your username or email address</label>

                            <div class="col-md-6">
                                <input id="staticEmail" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Username or email address"> 

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputPassword" class="col-sm-2 col-form-label" id="label2">Enter your Password </label>

                            <div class="col-md-6">
                                <input  type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="inputPassword" placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 remember">
                            <div class="col-md-6 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label remlabel" for="remember">
                                    Remember me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="signbtn">
                                Sign in
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link forget" href="{{ url('/forget') }}">
                                    Forgot Password
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

 










  
  
 
  
</div>
@endsection