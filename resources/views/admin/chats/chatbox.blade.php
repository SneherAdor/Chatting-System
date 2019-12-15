@extends('layouts.backend.app')
@section('title', 'Chat Box')
@push('css')

{{--   <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/4.0.2/bootstrap-material-design.css'> --}}
  <link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
  <link rel="stylesheet" href="{{ asset('assets/backend/chat/style.css') }}">

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush
@section('content')
<!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Chat List</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                @foreach($users as $key => $value)
                <li class="user_id">
                    <a href="#"></i>
                    {{ $value }}
                    </a>
                </li>
                @endforeach
                {{-- <li><a href="#"><i class="fa fa-envelope-o"></i> Sent</a></li> --}}
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Messages</h3>

              <div class="box-tools pull-right">
                <div class="has-feedback">
                  <input type="text" class="form-control input-sm" placeholder="Search Mail">
                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                  @foreach($chats as $chat)
                  <tr>
                    <td class="mailbox-name user_id" ><a href="#">{{$chat->user_id}}</a></td>
                    <td class="mailbox-subject">{{$chat->message}}</td>
                    <td class="mailbox-date">{{$chat->created_at->diffForHumans()}}</td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              <div class="mailbox-controls">
                {{$chats->links()}}
              </div>
            </div>
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->


              
<div id="chat-circle" class="btn btn-raised">
        <div id="chat-overlay"></div>
            <i class="material-icons">message</i>
</div>
  
  <div class="chat-box">
    <div class="chat-box-header">
      QbyteSoft
      <span class="chat-box-toggle"><i class="material-icons">close</i></span>
    </div>
    <div class="chat-box-body">
      <div class="chat-box-overlay">   
      </div>
      <div class="chat-logs" id="conversation-logs">

            <div id="cm-msg-1" class="chat-msg user"><span class="msg-avatar"><img src="https://image.crisp.chat/avatar/operator/7a702e9c-85b7-4ded-aa9a-ec2edda6f43b/240/?1575851691353"></span><div class="cm-msg-text"> msg</div></div>
       
      </div><!--chat-log -->
    </div>
    <div class="chat-input">      
      <form method="POST">
        <input type="text" id="chat-input" placeholder="Send a message..."/>
        <input type="hidden" id="chat-type" value="agent" />
        <input type="hidden" id="agent_id" value="{{Auth::id()}}" />
      <button type="submit" class="chat-submit" id="chat-submit"><i class="material-icons">send</i></button>
      </form>      
    </div>
  </div>





@endsection

@push('js')

    <!-- DataTables -->
    <script src="{{ asset('assets/backend/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/backend//bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js'></script>
    <script  src="{{ asset('assets/backend/chat/agent.js') }}"></script>
@endpush