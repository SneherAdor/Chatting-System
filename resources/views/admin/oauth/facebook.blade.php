@extends('layouts.backend.app')
@section('title', 'OAuth Settings')
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
                        <h3 class="box-title">@lang('dashboard.oauth_settings')</h3>
                        <hr style="border:1px solid #f4f4f4; margin:12px 0 !important">
                          <!-- Custom Tabs -->
                          <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                              <li class="e"><a href="{{ url('settings/github') }}"><i class="fa  fa-github"></i> @lang('dashboard.github')</a></li>
                              <li class="active"><a href="{{ url('settings/facebook') }}"><i class="fa fa-facebook-official text-primary"></i> @lang('dashboard.facebook')</a></li>
                              <li class=""><a href="{{ url('settings/google') }}"><i class="fa  fa-google-plus text-danger"></i> @lang('dashboard.google')</a></li>
                            </ul>
                            <div class="tab-content">
                              <!-- /.tab-pane -->
                              <div class="tab-pane active">
                                <form id="facebook_edit_form" method="post" action="{{ url('settings/oauth/update/2') }}">
                                @csrf
                                <div class="box-body">

                                    {{--  Client ID --}}
                                    <div class="form-group">
                                        <label for="client_id">@lang('dashboard.client_id')</label>
                                        <input id="client_id" type="text" class="form-control @error('client_id') is-invalid @enderror" name="client_id" value="{{config('services.facebook.client_id')}}" autocomplete="off" autofocus>
                                        
                                        @error('client_id')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    {{--  Client Secret --}}
                                    <div class="form-group">
                                        <label for="client_secret">@lang('dashboard.client_secret')</label>
                                        <input id="client_secret" type="text" class="form-control @error('client_secret') is-invalid @enderror" name="client_secret" value="{{config('services.facebook.client_secret')}}" autocomplete="off" autofocus>
                                        
                                        @error('client_secret')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    {{--  Callback URL --}}
                                    <div class="form-group">
                                        <label for="redirect">@lang('dashboard.callback_url')</label>
                                        <input id="redirect" type="redirect" class="form-control @error('redirect') is-invalid @enderror" name="redirect" value="{{config('services.facebook.redirect')}}" autocomplete="off" autofocus>
                                        
                                        @error('redirect')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    {{--  Status --}}
                                    <div class="form-group">
                                        @php
                                            $facebook_status = config('services.facebook.status');
                                        @endphp
                                        <label for="status">@lang('dashboard.status') </label><br>
                                        <input id="status" type="radio" name="status" value="enable" @isset($facebook_status){{$facebook_status == 'enable' ? 'checked' : ''}}@endisset> @lang('dashboard.enable')  
                                        <input type="radio" name="status" value="disable" @isset($facebook_status){{$facebook_status == 'disable' ? 'checked' : ''}}@endisset> @lang('dashboard.disable')<br>
                                        
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
                                        <span id="facebook_edit_form_submit_text">@lang('dashboard.update_button')</span>
                                    </button>
                                </div>
                            </form>
                              </div>
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
            $('#facebook_edit_form').validate({
                submitHandler: function(form)
                {
                    $("#facebook_edit_form").attr("disabled", true);
                    $(".spinner").show();
                    $("#facebook_edit_form_submit_text").text(__('dashboard.updating'));
                    $('#facebook_edit_form_submit').click(false);
                    form.submit();
                }
            });
        });
    </script>
@endpush
