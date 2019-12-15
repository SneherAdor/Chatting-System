@extends('layouts.backend.app')
@section('title', 'Create New Role')
@push('css')
    {{-- iCheck --}}
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/iCheck/flat/green.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush


@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">  @lang('dashboard.add_new_roles') </h3>
                        <hr style="border:1px solid #f4f4f4; margin:12px 0 !important">
                        <form method="post" action="{{ url('roles/store') }}" enctype="multipart/form-data" id="role_create_form">
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                            
                            <div class="box-body">

                                {{-- Role Name --}}
                                <div class="form-group">
                                    <h4 for="name" class="text-bold"> @lang('dashboard.role_name') </h4>
                                    <input type="text" name="name" class="form-control" placeholder=" @lang('dashboard.role_name') " value="{{ old('name') }}" id="name" autocomplete="off">
                                    <span style="color:#FF0000" id="role_unique_error"></span>
                                    <span style="color:#00a65a" id="role_unique_success"></span>
                                    @error('name')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Assign Permission --}}
                                <div class="form-group">
                                    <h4 for="exampleInputEmail1" class="text-bold"> @lang('dashboard.permissions') </h4>
                                </div>
                                @error('permissions')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center"> @lang('dashboard.permissions') </th>
                                            <th class="text-center"> @lang('dashboard.click_to_check') </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permissions as $permission)
                                            <tr>

                                            <?php $replaceUnderscore = array("_" => " "); ?>

                                                <td class="text-center">{{ ucwords(strtr($permission->name, $replaceUnderscore)) }}</td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="permissions[]" value="{{$permission->id}}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- Role Submit Button --}}
                                <div class="box-footer text-right col-md-12">
                                    <a href="{{ url('roles') }}" class="btn btn-danger btn-flat text-bold pull-left"> @lang('dashboard.cancel') </a>
                                    <button type="submit" class="btn btn-success btn-flat text-bold" id="role_create_submit">
                                        <i class="spinner fa fa-spinner fa-spin" style="display: none;"></i> 
                                        <span id="role_create_submit_text"> @lang('dashboard.submit') </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
    
@endsection
        
@push('js')

    {{-- iCheck --}}
    <script src="{{ asset('assets/backend/plugins/iCheck/icheck.min.js') }}"></script>
    {{-- Jquery validation --}}
    <script src="{{ asset('assets/backend/bower_components/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('assets/backend/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(function () {
            $('#example1').DataTable()
            $('#example2').DataTable({
                'paging'      : false,
                'lengthChange': false,
                'searching'   : true,
                'ordering'    : false,
                'info'        : false,
                'autoWidth'   : false
            })
        })
    </script>

    {{-- iCheck image-color --}}
    <script>
        $('input').iCheck({
            checkboxClass: 'icheckbox_flat-green',
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
            $('#role_create_form').validate({
                rules: {
                    name: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: __('dashboard.role_name_required'),
                        maxlength: __('dashboard.role_name_must_be_between')
                    },
                },
                submitHandler: function(form)
                {
                    $("#role_create_submit").attr("disabled", true);
                    $(".spinner").show();
                    $("#role_create_submit_text").text(__('dashboard.updating'));
                    $('#role_create_submit').click(false);
                    form.submit();
                }
            });
        });
    </script>

    {{-- Unique Role Name Check --}}
    <script>
        
        var role_name_error = false;
        /**
        * [check submit button should be disabled or not]
        */
        function enableDisableButton()
        {
            if (!role_name_error) {
                $('form').find("button[type='submit']").prop('disabled',false);
            } else {
                $('form').find("button[type='submit']").prop('disabled',true);
            }
        }
    
        $(document).ready(function() {
            $("#name").on('input', function (e) {

                var role_name = $('#name').val();
                var _token    = $('#token').val();
                // console.log(_token);

                $.ajax({

                    method: "POST",
                    url: SITE_URL+"/roles/role-name-check-on-add",
                    dataType: "json",
                    data: {
                        'role_name': role_name,
                        '_token': _token,
                    }
                })
                .done(function(response) {
                    if (response.status == false) {

                        $('#role_unique_error').addClass('error').html(response.fail).css("font-weight", "bold");
                        $('#role_unique_success').html('');
                        role_name_error = true;
                        enableDisableButton();

                    } else if (response.status == true) {

                        if (!($('#name').val())) {

                            $('#role_unique_success').html('');
                            $('#role_unique_error').addClass('error').html(__('dashboard.role_name_required')).css("font-weight", "bold");
                            role_name_error = true;
                            enableDisableButton();

                        } else if (role_name.length <= 15) {

                            $('#role_unique_success').addClass('success').html(response.success).css("font-weight", "bold");
                            $('#role_unique_error').html('');
                            role_name_error = false;
                            enableDisableButton();

                        } else if (role_name.length > 15) {

                            $('#role_unique_success').html('');
                            $('#role_unique_error').addClass('error').html(__('dashboard.role_name_must_be_between')).css("font-weight", "bold");
                            role_name_error = true;
                            enableDisableButton();

                        }
                    }
                });
            });
        });

    </script>
    
    

@endpush