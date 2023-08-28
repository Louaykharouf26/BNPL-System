@extends('layouts.Auth')

@section('SignUp')
<div class="container" id="signinbx">
 <p class="welcome">Welcome to <span class="wiin">TMKiiN Pay</span></p> 
 <p class="Sup">Sign Up</p>
 <p class="NA1">Have an Account ?</p>
 <a href="{{ url('SignIn') }}" class="signUp">Sign in</a>
 <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class=" mb-3">
                            <label for="name1" class="col-sm-2 col-form-label" id="labelname">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name1" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="User name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class=" mb-3">
                            <label for="staticEmail1" class="col-md-4 col-form-label text-md-end" id="label1v0">{{ __('Enter your username or email address') }}</label>

                            <div class="col-md-6">
                                <input id="staticEmail1" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Username or email address">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class=" mb-3">
                            <label for="inputPassword2" class="col-sm-2 col-form-label" id="label2v0">{{ __('Enter your Password') }}</label>

                            <div class="col-md-6">
                                <input id="inputPassword2" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"  >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end" id="confirm" >{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        


                        <div class="row mb-3 ">
                        <select id="password-confirm1" class="form-select" name="role"  aria-label="Default select example">
  <option selected>Select Your Role</option>
  <option value="User">User</option>
  <option value="Admin">Admin</option>
  <option value="Merchant">Merchant</option>
</select>
                        </div>
                        


                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="signupbtn">
                                    {{ __('Sign Up') }}
                                </button>
                            </div>
                        </div>
                    </form>



</div>

 
   
@endsection