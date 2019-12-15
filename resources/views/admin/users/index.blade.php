@extends('layouts.backend.app')
@section('title', 'All Users')
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
                        <h3 class="box-title"> @lang('dashboard.all_users') </h3>
                        <div class="box-tools">
                            <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                <div class="box-footer text-right">
                                    <a href="{{ url('users/create') }}" class="btn btn-success btn-flat"> @lang('dashboard.add_new_user') </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding" id="userTable">
                        <table class="table table-hover text-center">
                            <tr>
                                <th> @lang('dashboard.id') </th>
                                <th> @lang('dashboard.user') </th>
                                <th> @lang('dashboard.email') </th>
                                <th> @lang('dashboard.photo') </th>
                                <th> @lang('dashboard.role') </th>
                                <th> @lang('dashboard.date') </th>
                                <th> @lang('dashboard.status') </th>
                                <th> @lang('dashboard.action') </th>
                            </tr>
                            @foreach($users as $key=>$user)
                            <tr>
                                <td>{{ $key=$key+1 }}</td>
                                <td>{{ $user->name }}  <span class="label label-success">{{$user->id == Auth::user()->id ? 'It\'s you!' : ''}}</span></td>
                                <td>{{ $user->email }}</td>
                                <td><img src="{{ url('storage/users/' . $user->photo) }}" height="48" width="48" alt=""></td>
                                <td>{{  $user->roles()->pluck('name')->implode(' ') }}</td>
                                <td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
                                
                                @php
                                if ($user->status == 'active') {
                                    $labelClass = 'success';
                                } elseif($user->status== 'inactive') {
                                    $labelClass = 'warning';
                                } else {
                                    $labelClass = 'danger';
                                }
                                @endphp
                                
                                <td><span class="label label-{{$labelClass}}">
                                    @foreach(["active" => "Active", "inactive" => "Inactive", "disabled" => "Disabled"] AS $key => $value)    
                                    {{ $user->status == $key ? $value : "" }}
                                    @endforeach
                                    
                                </span></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ url('users/profile/' . $user->id) }}" type="button" class="btn btn-success btn-flat"><i class="fa fa-eye"></i></a>
                                        <a href="{{ url('users/edit/' . $user->id) }}" type="button" class="btn btn-primary btn-flat"><i class="fa fa-edit"></i></a>
                                        
                                        <button onclick="userDelete({{$user->id}})" class="btn btn-danger btn-flat"><i class="fa  fa-trash-o"></i></button>

                                        <form action="{{ url('users/delete/'.$user->id) }}" id="delete-form-{{$user->id}}" method="POST" style="display:none;">
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
                    <div class="box-footer">
                        {{ $users->links() }}
                    </div>
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
    <script src="{{ asset('assets/backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    {{-- Sweet Alert --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

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
        function userDelete(id)
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
                $.ajax({
                    type: "get",
                    url: 'users/delete/'+id,
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    success: function () {
                        $("#userTable").load(location.href+" #userTable");
                    }
                })
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire(
                'Cancelled',
                'Your user record is safe  !',
                'error'
                )
            }
            })
        }
    </script>
@endpush