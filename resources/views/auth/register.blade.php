@extends('layouts.login.app')
@section('title', 'Sign Up')
@push('css-login')

@endpush
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
    <p class="login-box-msg"> @lang('dashboard.sign_up') </p>

    <form method="post" action="{{ url('registration/store') }}" enctype="multipart/form-data" id="user_create_form">
        @csrf

        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

        <div class="box-body">

            {{-- Name --}}
            <div class="form-group">
                <label for="name"> @lang('dashboard.name') </label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="off" autofocus placeholder="Enter name">
                @error('name')
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email"> @lang('dashboard.email') </label>
                <input id="email" type="text" placeholder="Enter email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="off">
                <span style="color:#FF0000" id="email_unique_error"></span>
                @error('email')
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password"> @lang('dashboard.password') </label>
                <div class="input-group">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="off" placeholder="Type password">
                    <label id="password-error" class="error" for="password" style="color:red;"></label>
                    <div class="input-group-addon eye-open" style="cursor:help">
                        <i class="fa fa-eye text-danger i-open"></i>
                    </div>
                    <div class="input-group-addon eye-close" style="cursor:pointer;display:none;">
                        <i class="fa fa-eye-slash text-primary i-close"></i>
                    </div>
                </div>
                @error('password')
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            {{-- Confirmed Password --}}
            <div class="form-group">
                <label for="password_again"> @lang('dashboard.confirm_password') </label>
                <input id="password_again" type="password" class="form-control left" name="password_confirmation" autocomplete="off" placeholder="Re-type password">
            </div>
            
            {{-- Photo --}}
            <div class="form-group">
                
                <label for="photo"> @lang('dashboard.photo') </label><br>


                @if (isset($photo))
                    <img id="output"/ height="auto" width="100" style="border: 1px solid #dedede; margin: 5px; padding: 5px" src="{{ url('assets/backend/dist/img/user.png') }}">
                @else
                    <img id="output"/ height="auto" width="100" style="border: 1px solid #dedede; margin: 5px; padding: 5px" src="{{ url('assets/backend/dist/img/user.png') }}">
                @endif
                
                <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" accept="image/*" onchange="loadFile(event)" size="40"  autofocus>
                
                
                @error('photo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="box-footer text-right">
                <a href="{{ url('login') }}" class="btn btn-danger btn-flat text-bold pull-left" id="user_create_cancel"> @lang('dashboard.cancel') </a>
                <button type="submit" class="btn btn-success btn-flat text-bold" id="user_create_submit">
                    <i class="spinner fa fa-spinner fa-spin" style="display: none;"></i> 
                    <span id="user_create_submit_text"> @lang('dashboard.sign_up') </span>
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
    
          @if (Route::has('password.request'))
             <a class="btn-link" href="{{ route('password.request') }}">
                 @lang('dashboard.forgot_password') 
             </a> | 
          @endif
    <a href="{{ url('login') }}" class="text-center"> @lang('dashboard.login_text') </a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection

@push('js-login')
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
 {{-- iCheck --}}
    <script src="{{ asset('assets/backend/plugins/iCheck/icheck.min.js') }}"></script>
    {{-- Jquery validation --}}
    <script src="{{ asset('assets/backend/bower_components/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/backend/bower_components/jquery-validation/additional-methods.min.js') }}"></script>

    <script>
        $('input').iCheck({
            radioClass: 'iradio_flat-green',
        });
    </script>


    {{-- Image Load --}}
    <script>
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>

    {{-- Jquery Validate Form--}}
    
    <script>
        $.validator.setDefaults({
            highlight: function(element) {
                $(element).parent('div').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).parent('div').removeClass('has-error');
            },
        });

        $(document).ready(function() {
            $('#user_create_form').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 6,
                    },
                    password_confirmation: {
                        equalTo: '#password',
                    },
                    photo: {
                        extension: "jpg|jpeg|png|gif|bmp",
                    },
                },
                messages: {
                    name: {
                        required: __('validation.required'),
                    },
                    email: {
                        required: __('validation.required'),
                    },
                    password: {
                        required: __('validation.required'),
                    },
                    photo: {
                        extension: "Please select (png, jpg, jpeg, gif or bmp) file!"
                    },
                },
                submitHandler: function(form)
                {
                    $("#user_create_submit").attr("disabled", true);
                    $(".spinner").show();
                    $("#user_create_submit_text").text('Submitting ...');
                    $('#user_create_submit').click(false);
                    form.submit();
                }
            });
        });
    </script>

    {{-- Unique Role Name Check --}}
    <script>
        
        var email_error = false;
        /**
        * [check submit button should be disabled or not]
        */
        function enableDisableButton()
        {
            if (!email_error) {
                $('form').find("button[type='submit']").prop('disabled',false);
            } else {
                $('form').find("button[type='submit']").prop('disabled',true);
            }
        }
    
        $(document).ready(function() {
            $("#email").on('input', function (e) {

                var email = $('#email').val();
                var _token    = $('#token').val();
                // console.log(_token);

                $.ajax({

                    method: "POST",
                    url: SITE_URL+"/users/email-check-on-add",
                    dataType: "json",
                    data: {
                        'email': email,
                        '_token': _token,
                    }
                })
                .done(function(response) {
                    if (response.status == false) {

                        $('#email_unique_error').addClass('error').html(response.fail).css("font-weight", "bold");
                        email_error = true;
                        enableDisableButton();

                    } else if (response.status == true) {
                       
                        $('#email_unique_error').html('');
                        email_error = false;
                        enableDisableButton();

                    }
                });
            });
        });

    </script>

    {{-- Password Hide-Show --}}
    <script>
        $('.eye-open').on('click', function() {
            // console.log('test');
            $('.eye-open').hide();
            $('.eye-close').show();

            var input = document.getElementById('password');
            var input_again = document.getElementById('password_again');
            if (input.type === "password") { 
                input.type = "text"; 
                input_again.type = "text"; 
            } 
        });

        $('.eye-close').on('click', function() {
            // console.log('test');
            $('.eye-close').hide();
            $('.eye-open').show();

            var input = document.getElementById('password');
            var input_again = document.getElementById('password_again');
            if (input.type === "text") { 
                input.type = "password"; 
                input_again.type = "password"; 
            } 
        });
    </script>
@endpush
