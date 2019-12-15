@extends('layouts.login.app')
@section('title', 'Login to start session')
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
    <h4 class="login-box-msg text-danger"><b>{{$errors->first()}}</b></h4>
    @endif
    <p class="login-box-msg"> @lang('dashboard.sign_in_to_start_session') </p>

    <form action="{{ route('login') }}" method="post">
        @csrf
      <div class="form-group has-feedback">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember"> @lang('dashboard.remember_me') </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat"> @lang('dashboard.login_text') </button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="social-auth-links text-center">
      
      @php
          $github_status = env('GITHUB_STATUS');
          $facebook_status = env('FACEBOOK_STATUS');
          $google_status = env('GOOGLE_STATUS');
      @endphp
      <p>-  @lang('dashboard.or')  -</p>
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
    
          @if (Route::has('password.request'))
             <a class="btn-link" href="{{ route('password.request') }}">
                 @lang('dashboard.forgot_password') 
             </a> | 
          @endif
    <a href="{{ url('users/registration') }}" class="text-center"> @lang('dashboard.register_new_user') </a>

  </div>
  <!-- /.login-box-body -->
</div>
@endsection