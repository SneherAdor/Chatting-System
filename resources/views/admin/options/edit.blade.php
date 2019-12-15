@extends('layouts.backend.app')
@section('title', 'Options Settings')
@push('css')
    {{-- iCheck --}}
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/iCheck/square/green.css') }}">
@endpush


@section('content')

    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="row justify-content-center">
            <div class="col-md-6 col-md-offset-3">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">@lang('dashboard.option_settings')</h3>
                        <hr style="border:1px solid #f4f4f4; margin:12px 0 !important">
                            <form id="setting_edit_form" method="post" action="{{ url('settings/options/update/') }}">
                                @csrf
                                <div class="box-body">
                                    @php
                                        $registration = \DB::table('option_settings')->where('name', 'registration')->value('option');
                                        $reg_mail_status = \DB::table('option_settings')->where('name', 'reg_mail_status')->value('option');
                                        $reg_mail_to = \DB::table('option_settings')->where('name', 'reg_mail_to')->value('option');
                                        $defaultStatus = \DB::table('option_settings')->where('name', 'default-status')->value('option');
                                        $email_verify = \DB::table('option_settings')->where('name', 'email_verify')->value('option');
                                    @endphp

                                    {{-- SignUp --}}
                                    <div class="form-group">
                                        <label for="registration">@lang('dashboard.sign_up')</label>
                                        <br><i>@lang('dashboard.sign_up_helper_text')</i><br>

                                        <input id="registration" class="form-control" type="radio" name="registration" value="enable" @isset($registration){{$registration == 'enable' ? 'checked' : ''}}@endisset> @lang('dashboard.enable')

                                        <input id="registration" class="form-control" type="radio" name="registration" value="disable" @isset($registration){{$registration == 'disable' ? 'checked' : ''}}@endisset> @lang('dashboard.disable')<br>
                                        
                                        @error('registration')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    {{-- SignUp Default status --}}
                                    <div class="form-group">
                                        <label for="defaultstatus">@lang('dashboard.sign_up_default_status')</label>
                                        <br><i>@lang('dashboard.sign_up_default_status_helper_text')</i><br>

                                        <input id="defaultstatus" class="form-control" type="radio" name="defaultstatus" value="active" @isset($defaultStatus){{$defaultStatus == 'active' ? 'checked' : ''}}@endisset> @lang('dashboard.active')

                                        <input id="defaultstatus" class="form-control" type="radio" name="defaultstatus" value="inactive" @isset($defaultStatus){{$defaultStatus == 'inactive' ? 'checked' : ''}}@endisset> @lang('dashboard.inactive')

                                        <input id="defaultstatus" class="form-control" type="radio" name="defaultstatus" value="disabled" @isset($defaultStatus){{$defaultStatus == 'disabled' ? 'checked' : ''}}@endisset> @lang('dashboard.disable')<br>
                                        
                                        @error('defaultstatus')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    {{-- Send mail when someone signup --}}
                                    <div class="form-group">
                                        <label for="reg_mail_status">@lang('dashboard.sign_up_mail')</label>
                                        <br><i>@lang('dashboard.sign_up_mail_helper_text')</i><br>

                                        <input id="reg_mail_status" class="form-control" type="radio" name="reg_mail_status" value="enable" @isset($reg_mail_status){{$reg_mail_status == 'enable' ? 'checked' : ''}}@endisset> @lang('dashboard.enable')

                                        <input id="reg_mail_status" class="form-control" type="radio" name="reg_mail_status" value="disable" @isset($reg_mail_status){{$reg_mail_status == 'disable' ? 'checked' : ''}}@endisset> @lang('dashboard.disable')<br>
                                        
                                        @error('reg_mail_status')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    {{-- Whom send to sign up mail --}}
                                    <div class="form-group">
                                        <label for="reg_mail_to">@lang('dashboard.sign_up_mail_send_to')</label>

                                        <input id="reg_mail_to" class="form-control" type="email" name="reg_mail_to" value="@isset($reg_mail_to){{$reg_mail_to}}@endisset">
                                        
                                        @error('reg_mail_to')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Email verification --}}
                                <hr>
                                    <div class="form-group">
                                        <label for="email_verify">@lang('dashboard.email_verification')</label>
                                        <br><i>@lang('dashboard.email_verification_helper_text')</i><br>

                                        <input id="email_verify" class="form-control" type="radio" name="email_verify" value="enable" @isset($email_verify){{$email_verify == 'enable' ? 'checked' : ''}}@endisset> @lang('dashboard.enable')

                                        <input id="email_verify" class="form-control" type="radio" name="email_verify" value="disable" @isset($email_verify){{$email_verify == 'disable' ? 'checked' : ''}}@endisset> @lang('dashboard.disable')<br>
                                        
                                        @error('email_verify')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                {{-- Button --}}
                                <div class="box-footer text-right">
                                    <button type="submit" class="btn btn-success btn-flat text-bold" id="setting_edit_submit">
                                        <i class="spinner fa fa-spinner fa-spin" style="display: none;"></i> 
                                        <span id="setting_edit_submit_text">@lang('dashboard.update_button')</span>
                                    </button>
                                </div>
                            </form>
                    </div>
                        <!-- /.box -->
                </div>
                    <!-- /.col -->
            </div>
                <!-- /.row -->
        </div>
    </section>
    <!-- /.content -->
        
@endsection
        
@push('js')

    {{-- iCheck --}}
    <script src="{{ asset('assets/backend/plugins/iCheck/icheck.min.js') }}"></script>

    {{-- Jquery validation --}}
    <script src="{{ asset('assets/backend/bower_components/jquery-validation/jquery.validate.min.js') }}"></script>


    {{-- iCheck script --}}
    <script>
        $('input').iCheck({
            radioClass: 'iradio_square-green',
        });
    </script>
    <script>
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>


    {{-- Jquery Validate --}}
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
            $('#setting_edit_form').validate({
                submitHandler: function(form)
                {
                    $("#setting_edit_submit").attr("disabled", true);
                    $(".spinner").show();
                    $("#setting_edit_submit_text").text('Updating ...');
                    $('#setting_edit_submit').click(false);
                    form.submit();
                }
            });
        });
    </script>
@endpush
