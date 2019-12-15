@extends('layouts.login.app')
@section('title', 'Reset Password')
@section('content')
<body class="hold-transition login-page">
<div class="login-box">
  @php 
        $siteName = \DB::table('general_settings')->where('id', '1')->value('name');
  @endphp
  <div class="login-logo">
    <a href="#"><b>{{ $siteName }}</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    @if($errors->any())
    <h4 class="login-box-msg text-success"><b>{{$errors->first()}}</b></h4>
    @endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group row">
        <label for="email" class="col-md-12 col-form-label text-md-right"> @lang('dashboard.email_address') </label>

        <div class="col-md-12">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-12 col-form-label text-md-right"> @lang('dashboard.password') </label>

        <div class="col-md-12">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password-confirm" class="col-md-12 col-form-label text-md-right"> @lang('dashboard.confirm_password') </label>

        <div class="col-md-12">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>
    </div>

    <div class="form-group text-right">
        <div class="col-md-12">
            <button type="submit" class="btn btn-success">
                 @lang('dashboard.reset_password') 
            </button>
        </div>
    </div>
</form><br>

    <div class="social-auth-links text-center">
      
      @php
          $github_status = env('GITHUB_STATUS');
          $facebook_status = env('FACEBOOK_STATUS');
          $google_status = env('GOOGLE_STATUS');
      @endphp
      <p>- OR -</p>
      {{-- Social Media login button --}}
      @isset($github_status) 
      @if($github_status == 'enable')
      <a href="{{ url('login/github') }}" class="btn btn-social-icon btn-github"><i class="fa fa-github"></i></a>
      @endif
      @endisset

      @isset($facebook_status)
      @if($facebook_status == 'enable')
      <a href="{{ url('login/facebook') }}" class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
      @endif
      @endisset

      @isset($google_status)
      @if($google_status == 'enable')
      <a href="{{ url('login/google') }}" class="btn btn-social-icon btn-google"><i class="fa fa-google-plus"></i></a>
      @endif
      @endisset
      
      
        
    </div>
    <!-- /.social-auth-links -->
    
    <div align="center">
      <a href="{{ url('login') }}" class="text-center">Login</a> | 
      <a href="{{ url('users/registration') }}" class="text-center">Register a new user</a>
    </div>

  </div>
  <!-- /.login-box-body -->
</div>
@endsection
