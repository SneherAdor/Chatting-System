@extends('layouts.backend.app')
@section('title', 'Activities')
@push('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush
@section('content')
<!-- Content Header (Page header) -->
<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">@lang('dashboard.activities')</h3>
                        <hr style="border:1px solid #f4f4f4; margin:12px 0 !important">
                        <div class="box-tools">
                            <div class="input-group input-group-sm hidden-xs">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>@lang('dashboard.activities_description')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lastActivities as $lastActivity)
                                <tr>
                                    <td><b><a href="#">{{$lastActivity->causer['name']}}</a> {{ $lastActivity->description }} - <i>{{ $lastActivity->created_at->diffForHumans() }}</i></b></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>
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
                'paging'      : true,
                'lengthChange': false,
                'searching'   : true,
                'ordering'    : false,
                'info'        : false,
                'autoWidth'   : true
            })
        })
    </script>
@endpush