@extends('layouts.backend.app')

@push('css')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('assets/backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush


@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Role
        <small>Update role and then assign permissions to that role</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row justify-content-center">
        <div class="col-md-6 col-md-offset-3">
          <div class="box">
            <div class="box-header">
              @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif
              <form method="post" action="{{ url('roles/update/'.$role->id) }}" enctype="multipart/form-data">
              	@csrf
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Role Name</label>
                    <input type="text" name="name" class="form-control" value="{{$role->name}}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Assign Permissions</label>
                  </div>
                <table id="example2" class="table table-bordered table-hover">
                  <thead style="display: none">
                  <tr>
                    <th>Permissions</th>
                    <th>Check Mark</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($permissions as $permission)
                  <tr>
                    <td>{{ $permission->name }}</td>
                    <td>
                      <input type="checkbox" name="permissions[]" value="{{$permission->id}}"{{in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked':''}}>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
                <div class="box-footer text-right">
                  <button type="submit" class="btn btn-success">Submit</button>
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
<!-- DataTables -->
<script src="{{ asset('assets/backend/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend//bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
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
@endpush