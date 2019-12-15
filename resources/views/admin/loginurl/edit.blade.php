@extends('layouts.backend.app')
@section('title', 'Login URL Redirect Settings')
@push('css')
@endpush


@section('content')

    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="row justify-content-center">
            <div class="col-md-6 col-md-offset-3">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">@lang('dashboard.edit_login_url')</h3>
                        <hr style="border:1px solid #f4f4f4; margin:12px 0 !important">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @foreach($loginUrl as $url)
                            <form id="setting_edit_form" method="post" action="{{ url('settings/login-url/update/'.$url->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="box-body">

                                    {{-- Login URL Redirect --}}
                                    <div class="form-group">
                                        <label for="name">@lang('dashboard.login_url_redirect')</label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="url" value="{{ $url->option }}" autocomplete="off" autofocus>
                                        
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Button --}}
                                <div class="box-footer text-right">
                                    <button type="submit" class="btn btn-success btn-flat text-bold" id="setting_edit_submit">
                                        <i class="spinner fa fa-spinner fa-spin" style="display: none;"></i> 
                                        <span id="setting_edit_submit_text">@lang('dashboard.update_button')</span>
                                    </button>
                                </div>
                            </form>
                        @endforeach
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

    {{-- Jquery validation --}}
    <script src="{{ asset('assets/backend/bower_components/jquery-validation/jquery.validate.min.js') }}"></script>

    {{-- Image Load --}}
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
                rules: {
                    url: {
                        required: true,
                    },
                },
                messages: {
                    url: {
                        required: __('dashboard.login_url_empty')
                    }
                },
                submitHandler: function(form)
                {
                    $("#setting_edit_submit").attr("disabled", true);
                    $(".spinner").show();
                    $("#setting_edit_submit_text").text(__('dashboard.updating'));
                    $('#setting_edit_submit').click(false);
                    form.submit();
                }
            });
        });
    </script>
@endpush
