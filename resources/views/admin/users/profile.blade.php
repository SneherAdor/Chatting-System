@extends('layouts.backend.app')
@section('title', 'Profile')

@push('css')
    {{-- iCheck --}}
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/iCheck/flat/green.css') }}">

@endpush

@section('content')
<div class="row"><br>
    <div class="col-md-6 col-md-offset-3">
        <div class="box box-success">
                    <div class="box-body box-profile">
              @if(isset($user->photo))
              <img class="profile-user-img img-responsive img-circle" src="{{ url('storage/users/'.$user->photo) }}" alt="User profile picture">
              @else
                <img class="profile-user-img img-responsive img-circle" src="{{ url('assets/backend/dist/img/user.png') }}" alt="User profile picture">
              @endif
              <h3 class="profile-username text-center">{{ $user->name }}</h3>

              <p class="text-muted text-center">{{ $user->getRoleNames()->implode('name') }}</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b> @lang('dashboard.email') </b> <a class="pull-right">{{ $user->email }}</a>
                </li>
                <li class="list-group-item">
                  <b> @lang('dashboard.registered_at') </b> <a class="pull-right">{{$user->created_at->diffForHumans()}}</a>
                </li>
                @php
                if ($user->status == 'active') {
                    $labelClass = 'success';
                } elseif($user->status== 'inactive') {
                    $labelClass = 'warning';
                } else {
                    $labelClass = 'danger';
                }
                @endphp
                <li class="list-group-item">
                  <b> @lang('dashboard.status') </b> <a class="pull-right">
                    <span class="label label-{{$labelClass}}">
                        @foreach(["active" => "Active", "inactive" => "Inactive", "disabled" => "Disabled"] AS $key => $value)    
                        {{ $user->status == $key ? $value : "" }}
                        @endforeach
                        
                    </span></a>
                </li>
              </ul>

              <a href="{{ url('users/edit/' . $user->id) }}" class="btn btn-success btn-block"><b> @lang('dashboard.update_button') </b></a>
</div>
        </div>

    </div>
</div>
@endsection


@push('js')
@endpush