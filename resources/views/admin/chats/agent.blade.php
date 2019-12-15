@extends('layouts.backend.app')
@section('title', 'Activities')
@push('css')

  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/4.0.2/bootstrap-material-design.css'>
  <link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
  <link rel="stylesheet" href="{{ asset('assets/backend/chat/style.css') }}">


<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush
@section('content')
<!-- Content Header (Page header) -->
<!-- Main content -->
 

              
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
      <button type="submit" class="chat-submit" id="chat-submit"><i class="material-icons">send</i></button>
      </form>      
    </div>
  </div>

    <!-- /.content -->
@endsection

@push('js')

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js'></script>
<script  src="{{ asset('assets/backend/chat/agent.js') }}"></script>

@endpush