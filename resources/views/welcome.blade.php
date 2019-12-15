@extends('layouts.backend.app')
@section('title', 'Dashboard')
@section('content')
@php
  // get all permissions from DB
  $allPermissions = \DB::table('permissions')->get();
  // get all roles from DB
  $allRoles = \DB::table('roles')->get();
  // get all user from DB
  $allUsers = \DB::table('users')->get();
  // Get all user where status is equal to active
  $activeUsers = \DB::table('users')->where('status', 'active')->get();
  // Get all user where status is equal to inactive
  $inactiveUsers = \DB::table('users')->where('status', 'inactive')->get();
  // Get all user where status is equal to disable
  $disabledUsers = \DB::table('users')->where('status', 'disabled')->get();
  // Get last added three user
  $recentUsers = \DB::table('users')->orderBy('id', 'desc')->take(3)->get();
  // Get all last 7 activities from DB
  $activities = \Spatie\Activitylog\Models\Activity::orderBy('id', 'desc')->take(7)->get();
  // Calculatin of percentage of users like active, inactive, disable
  function getUserPercentage($partOfUser){
    $allUsers = \DB::table('users')->get();
    $totalUser = $allUsers->count();
     return ($partOfUser * 100)/$totalUser;
  }
@endphp
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$allUsers->count()}}</h3>
              <p> @lang('dashboard.total_user') </p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ url('users') }}" class="small-box-footer"> @lang('dashboard.more_info')  <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$allRoles->count()}}</sup></h3>

              <p> @lang('dashboard.total_role') </p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ url('roles') }}" class="small-box-footer"> @lang('dashboard.more_info')  <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$allPermissions->count()}}</h3>

              <p> @lang('dashboard.total_permissions') </p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ url('roles') }}" class="small-box-footer"> @lang('dashboard.more_info')  <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p> @lang('dashboard.unique_visitor') </p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer"> @lang('dashboard.more_info')  <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->

      <!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">

                    <!-- TABLE: LATEST ORDERS -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"> @lang('dashboard.activities') </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th> @lang('dashboard.activities_description') </th>
                    <th> @lang('dashboard.time') </th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($activities as $activity)
                  <tr>
                    <td>
                      <a href="{{ url('users/profile/' . $activity->causer_id) }}">{{$activity->causer['name']}}</a> {{ $activity->description }}
                    </td>
                    <td>
                      {{ $activity->created_at->diffForHumans() }}
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="{{ url('activities') }}" class="btn btn-sm btn-default btn-flat pull-right"> @lang('dashboard.more_info') </a>
            </div>
            <!-- /.box-footer -->
          </div>

        </div>
        <!-- /.col -->

        <div class="col-md-4">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title"> @lang('dashboard.users') </h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                          <!-- Info Boxes Style 2 -->
          <div class="info-box text-success">
            <span class="info-box-icon ">{{$activeUsers->count()}}</span>

            <div class="info-box-content">
              <span class="info-box-number">Active User(s)</span>

              <div class="progress">
                <div class="progress-bar bg-green" style="width: {{getUserPercentage($activeUsers->count())}}%"></div>
              </div>
              <span class="progress-description">
                    {{round(getUserPercentage($activeUsers->count()))}}% Active user in {{$allUsers->count()}}
               </span>
            </div>
            <!-- /.info-box-content -->
          </div>
         <div class="info-box text-warning">
          <span class="info-box-icon ">{{$inactiveUsers->count()}}</i></span>

          <div class="info-box-content">
            <span class="info-box-number">Inactive User(s)</span>

            <div class="progress">
              <div class="progress-bar bg-yellow" style="width: {{getUserPercentage($inactiveUsers->count())}}%"></div>
            </div>
            <span class="progress-description">
                  {{round(getUserPercentage($inactiveUsers->count()))}}% Inactive user in {{$allUsers->count()}}
                </span>
          </div>
          <!-- /.info-box-content -->
        </div>
            <div class="info-box text-danger">
              <span class="info-box-icon ">{{$disabledUsers->count()}}</span>

              <div class="info-box-content">
                <span class="info-box-number">Disabled User(s)</span>

                <div class="progress">
                  <div class="progress-bar bg-red" style="width: {{getUserPercentage($disabledUsers->count())}}%"></div>
                </div>
                <span class="progress-description">
                      {{round(getUserPercentage($disabledUsers->count()))}}% Disabled user in {{$allUsers->count()}}
                    </span>
              </div>
              <!-- /.info-box-content -->
            </div>

          <!-- /.info-box -->
              </div>
            </div>


          <!-- PRODUCT LIST -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"> @lang('dashboard.recently_added_users') </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
                @foreach($recentUsers as $recentUser)
                  <li class="item">
                  <div class="product-img">
                    @isset ($recentUser->photo)
                      <img src="{{ url('storage/users/' . $recentUser->photo) }}" alt="User Image">  
                    @else
                    <img src="{{ url('assets/backend/dist/img/user.png') }}" alt="User Image">
                    @endisset

                  </div>
                  <div class="product-info">
                    <a href="{{ url('users/profile/' . $recentUser->id) }}" class="product-title">{{$recentUser->name}}
                      @php
                        if ($recentUser->status == 'active') {
                            $labelClass = 'success';
                        } elseif($recentUser->status== 'inactive') {
                            $labelClass = 'warning';
                        } else {
                            $labelClass = 'danger';
                        }
                      @endphp
                      <span class="label label-{{$labelClass}} pull-right">
                        @foreach(["active" => "Active", "inactive" => "Inactive", "disabled" => "Disabled"] AS $key => $value)    
                        {{ $recentUser->status == $key ? $value : "" }}
                        @endforeach
                      </span>
                    </a>
                    <span class="product-description">
                          {{ $recentUser->email }}
                        </span>
                  </div>
                </li>
                @endforeach
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="{{ url('users') }}" class="uppercase"> @lang('dashboard.more_info') </a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

@endsection