@extends('layouts.backend.app')
@section('title', 'General Settings')
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
                        <h3 class="box-title"> @lang('dashboard.edit_settings') </h3> 
                        {{-- {{Lang::set('dashboard.role_name_required', 'Millat')}} --}}
                        <hr style="border:1px solid #f4f4f4; margin:12px 0 !important">
                        @foreach($generalSettings as $generalSetting)
                            <form id="setting_edit_form" method="post" action="{{ url('settings/general/update/'.$generalSetting->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="box-body">

                                    {{-- Site Name --}}
                                    <div class="form-group">
                                        <label for="name"> @lang('dashboard.site_name') </label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $generalSetting->name }}" autocomplete="off" autofocus>
                                        
                                        @error('name')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"> @lang('dashboard.email') </label>
                                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $generalSetting->email }}" autocomplete="off">
                                        @error('email')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    {{-- Language --}}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"> @lang('dashboard.select_langauage') </label>
                                        
                                        <select id="language" name="language" class="form-control @error('language') is-invalid @enderror" autocomplete="off" autofocus>
                                            <option value="en" {{$generalSetting->language == 'en' ? 'selected': ''}}>English</option>

                                            <option value="bn" {{$generalSetting->language == 'bn' ? 'selected': ''}}>Bangla</option>

                                            <option value="ar" {{$generalSetting->language == 'ar' ? 'selected': ''}}>Arabic</option>

                                            <option value="es" {{$generalSetting->language == 'es' ? 'selected': ''}}>Spanish</option>

                                            <option value="fr" {{$generalSetting->language == 'fr' ? 'selected': ''}}>French</option>

                                            <option value="hi" {{$generalSetting->language == 'hi' ? 'selected': ''}}>Hindi</option>

                                            <option value="pt" {{$generalSetting->language == 'pt' ? 'selected': ''}}>Portuguese</option>

                                            <option value="ru" {{$generalSetting->language == 'ru' ? 'selected': ''}}>Russia</option>
                                            <option value="zh" {{$generalSetting->language == 'zh' ? 'selected': ''}}>Chinese</option>
                                        </select>
                                        
                                        @error('language')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    {{-- Theme --}}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"> @lang('dashboard.select_theme') </label>
                                        
                                        <select id="theme" name="theme" class="form-control @error('theme') is-invalid @enderror" autocomplete="off" autofocus>
                                            
                                            <option value="skin-blue" {{$generalSetting->theme == 'skin-blue' ? 'selected': ''}}>Blue</option>
                                            
                                            <option value="skin-blue-light" {{$generalSetting->theme == 'skin-blue-light' ? 'selected': ''}}>Blue Light</option>
                                            
                                            <option value="skin-yellow" {{$generalSetting->theme == 'skin-yellow' ? 'selected': ''}}>Yellow</option>
                                            
                                            <option value="skin-yellow-light" {{$generalSetting->theme == 'skin-yellow-light' ? 'selected': ''}}>Yellow Light</option>
                                            
                                            <option value="skin-green" {{$generalSetting->theme == 'skin-green' ? 'selected': ''}}>Green</option>
                                            
                                            <option value="skin-green-light" {{$generalSetting->theme == 'skin-green-light' ? 'selected': ''}}>Green Light</option>
                                            
                                            <option value="skin-purple" {{$generalSetting->theme == 'skin-purple' ? 'selected': ''}}>Purple</option>
                                            
                                            <option value="skin-purple-light" {{$generalSetting->theme == 'skin-purple-light' ? 'selected': ''}}>Purple Light</option>
                                            
                                            <option value="skin-red" {{$generalSetting->theme == 'skin-red' ? 'selected': ''}}>Red</option>
                                            
                                            <option value="skin-red-light" {{$generalSetting->theme == 'skin-red-light' ? 'selected': ''}}>Red Light</option>
                                            
                                            <option value="skin-black" {{$generalSetting->theme == 'skin-black' ? 'selected': ''}}>Black</option>
                                            
                                            <option value="skin-black-light" {{$generalSetting->theme == 'skin-black-light' ? 'selected': ''}}>Black Light</option>
                                            
                                        </select>
                                        
                                        @error('theme')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    {{-- Logo --}}
                                    <div class="form-group">
                                        
                                        @php  
                                        $logo = \DB::table('general_settings')->where('id', '1')->value('logo'); 
                                        @endphp
                                        
                                        <label for="exampleInputEmail1"> @lang('dashboard.logo') </label><br>
                                        <?php
                                        if(!isset($logo)){
                                            ?>
                                            <img id="output"/ height="auto" width="100" style="border: 1px solid #dedede; margin: 5px; padding: 5px" src="{{ asset('assets/backend') }}/dist/img/logo.png">
                                            <?php
                                        }else{
                                            ?>
                                            <img id="output"/ height="auto" width="100" style="border: 1px solid #dedede; margin: 5px; padding: 5px" src="{{ asset('storage/logo/').'/'.$logo }}">
                                            <?php
                                        }
                                        ?>
                                        <input id="logo" type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" accept="image/*" onchange="loadFile(event)" size="40" autocomplete="logo" autofocus>
                                        
                                        
                                        @error('logo')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Button --}}
                                <div class="box-footer text-right">
                                    <button type="submit" class="btn btn-success btn-flat text-bold" id="setting_edit_submit">
                                        <i class="spinner fa fa-spinner fa-spin" style="display: none;"></i> 
                                        <span id="setting_edit_submit_text"> @lang('dashboard.update_button') </span>
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
                    name: {
                        maxlength: 20,
                    },
                    email: {
                        email: true,
                    },
                },
                messages: {
                    name: {
                        maxlength: __('dashboard.site_name_max_char')
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
