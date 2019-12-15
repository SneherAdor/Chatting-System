@extends('layouts.backend.app')
@section('title', 'Mail Setup')
@push('css')
    {{-- iCheck --}}
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/iCheck/square/green.css') }}">
@endpush


@section('content')

    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">@lang('dashboard.mail_setup')</h3>
                        <hr style="border:1px solid #f4f4f4; margin:12px 0 !important">
                          <!-- Custom Tabs -->
                          <div class="nav-tabs-custom">
                            <div class="tab-content">
                              <div class="tab-panee" id="tab_1">
                              </div>
                              <!-- /.tab-pane -->
                              <div class="tab-pane active" id="tab_2">
                                <form id="facebook_edit_form" method="post" action="{{ url('settings/mail/update/1') }}">
                                @csrf
                                <div class="box-body">

                                    {{--  mail_driver --}}
                                    <div id="disablemail">
                                        <div class="form-group">
                                        <label for="mail_driver">@lang('dashboard.mail_driver')</label>
                                        <input id="mail_driver" type="text" class="form-control @error('mail_driver') is-invalid @enderror" name="mail_driver" value="{{config('mail.driver')}}" autocomplete="off" autofocus>
                                        
                                        @error('mail_driver')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    {{--  Mail Host --}}
                                    <div class="form-group">
                                        <label for="mail_host">@lang('dashboard.mail_host')</label>
                                        <input id="mail_host" type="text" class="form-control @error('mail_host') is-invalid @enderror" name="mail_host" value="{{config('mail.host')}}" autocomplete="off" autofocus>
                                        
                                        @error('mail_host')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    {{--  Mail Port --}}
                                    <div class="form-group">
                                        <label for="mail_port">@lang('dashboard.mail_port')</label>
                                        <input id="mail_port" type="text" class="form-control @error('mail_port') is-invalid @enderror" name="mail_port" value="{{config('mail.port')}}" autocomplete="off" autofocus>
                                        
                                        @error('mail_port')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    {{--  Mail User Name --}}
                                    <div class="form-group">
                                        <label for="mail_username">@lang('dashboard.mail_encryption')</label>
                                        <input id="mail_username" type="text" class="form-control @error('mail_username') is-invalid @enderror" name="mail_username" value="{{config('mail.username')}}" autocomplete="off" autofocus>
                                        
                                        @error('mail_username')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    {{--  Mail Password --}}
                                    <div class="form-group">
                                        <label for="mail_password">@lang('dashboard.mail_password')</label>
                                        <input id="mail_password" type="text" class="form-control @error('mail_password') is-invalid @enderror" name="mail_password" value="{{config('mail.password')}}" autocomplete="off" autofocus>
                                        
                                        @error('mail_password')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    {{--  Mail Encryption --}}
                                    <div class="form-group">
                                        <label for="mail_encryption">@lang('dashboard.mail_encryption')</label>
                                        <input id="mail_encryption" type="text" class="form-control @error('mail_encryption') is-invalid @enderror" name="mail_encryption" value="{{config('mail.encryption')}}" autocomplete="off" autofocus>
                                        
                                        @error('mail_encryption')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    {{--  Mail From --}}
                                    <div class="form-group">
                                        <label for="mail_encryption">@lang('dashboard.mail_from')</label>
                                        <input id="mail_from" type="text" class="form-control @error('mail_from') is-invalid @enderror" name="mail_from" value="{{config('mail.from.name')}}" autocomplete="off" autofocus>
                                        
                                        @error('mail_from')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    </div>

                                    {{--  Status --}}
                                    <div class="form-group">
                                        @php
                                            $mail_status = env('MAIL_STATUS');
                                        @endphp
                                        <label for="status">@lang('dashboard.status') </label><br>
                                        <input id="status" type="radio" name="status" value="enable" @isset($mail_status){{$mail_status == 'enable' ? 'checked' : ''}}@endisset> @lang('dashboard.enable')  
                                        <input id="hide" type="radio" name="status" value="disable" @isset($mail_status){{$mail_status == 'disable' ? 'checked' : ''}}@endisset>  @lang('dashboard.disable')<br>
                                        
                                        @error('status')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Button --}}
                                <div class="box-footer text-right">
                                    <button type="submit" class="btn btn-success btn-flat text-bold" id="facebook_edit_form_submit">
                                        <i class="spinner fa fa-spinner fa-spin" style="display: none;"></i> 
                                        <span id="facebook_edit_form_submit_text"> @lang('dashboard.update_button')</span>
                                    </button>
                                </div>
                            </form>
                              </div>
                              <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                          </div>
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
            $('#github_edit_form').validate({
                submitHandler: function(form)
                {
                    $("#github_edit_form").attr("disabled", true);
                    $(".spinner").show();
                    $("#github_edit_form_submit_text").text(__('dashboard.updating'));
                    $('#github_edit_form_submit').click(false);
                    form.submit();
                }
            });
        });
    </script>

   {{-- hide form and show form element --}}

@endpush
