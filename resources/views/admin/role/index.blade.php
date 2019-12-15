@extends('layouts.backend.app')
@section('title', 'Roles View')

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"> @lang('dashboard.roles') </h3>
                        
                        <div class="box-tools">
                            <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                <div class="box-footer text-right">
                                    @can('create_role')
                                    <a href="{{ url('roles/create') }}" class="btn btn-success btn-flat"> @lang('dashboard.add_new_roles') </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover text-center">
                            <tr>
                                <th> @lang('dashboard.role_name') </th>
                                <th> @lang('dashboard.permissions') </th>
                                <th> @lang('dashboard.action') </th>
                            </tr>
                            @foreach($roles as $key=>$role)
                            <tr>
                                <td>{{ ucwords($role->name) }}</td>
                                <?php 
                                $replaceUnderscore = array("_" => " "); 
                                $permissions = $role->permissions;
                                ?>
                                <td style="width: 50%">
                                    @foreach($permissions as $permission)
                                     <span class="label label-default" style="margin: 1px">
                                        {{ ucwords(strtr($permission['name'], $replaceUnderscore))}}
                                    </span>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ url('roles/edit/'.$role->id) }}" type="button" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                        
                                        <button onclick="roleDelete({{$role->id}})" class="btn btn-danger btn-flat"><i class="fa  fa-trash-o"></i></button>
                                        
                                        <form action="{{ url('roles/delete/'.$role->id) }}" id="delete-form-{{$role->id}}" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->

@endsection


@push('js')
    <!-- DataTables -->
    <script src="{{ asset('assets/backend/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/backend//bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    {{-- Sweet Alert --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js"></script>
    <script>
        $(function () {
            $('#example1').DataTable()
            $('#example2').DataTable({
                'paging'      : true,
                'lengthChange': false,
                'searching'   : true,
                'ordering'    : false,
                'info'        : false,
                'autoWidth'   : false
            })
        })
    </script>

    <script>
        function roleDelete(id)
        {
            Swal.fire({
                title: 'Are you sure to delete?',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: "#dd4b39",
                confirmButtonColor: "#00a65a",
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire(
                    'Cancelled',
                    'Your role record is safe  !',
                    'error'
                    )
                }
            })
        }
    </script>
@endpush