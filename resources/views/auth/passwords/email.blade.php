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
    @if (session('status'))
        <div class="alert" role="alert">
            <p class="text-success"><b>{{ session('status') }}</b></p>
        </div>
    @endif

    @if($errors->any())
    <h4 class="login-box-msg text-success"><b>{{$errors->first()}}</b></h4>
    @endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="form-group row">
        <label for="email" class="col-md-12 col-form-label text-md-right"> @lang('dashboard.email_address') </label><br>

        <div class="col-md-12">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group text-right">
        <div class="col-md-12">
            <button type="submit" class="btn btn-success">
                 @lang('dashboard.send_password_reset_link') 
            </button>
        </div>
    </div>
</form>

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
      <a href="{{ url('login') }}" class="text-center"> @lang('dashboard.login_text') </a> | 
      <a href="{{ url('users/registration') }}" class="text-center"> @lang('dashboard.register_new_user') </a>
    </div>
    

  </div>
  <!-- /.login-box-body -->
</div>
@endsection
