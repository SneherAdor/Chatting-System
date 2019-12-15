
@include('layouts.backend.partials.header')


@php
    $skinTheme = \DB::table('general_settings')->where('id', '1')->value('theme'); 
@endphp

<body class="hold-transition {{$skinTheme}} sidebar-mini">
    <div class="wrapper">
        
        @include('layouts.backend.partials.topbar')
        
        @include('layouts.backend.partials.sidebar')
        
        
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            
            <!-- Flash Message  -->
            <section class="content-header">
                <div class="flash-container">
                    @if(Session::has('message'))
                    <div class="alert {{ Session::get('alert-class') }} text-center" style="margin-bottom:0px;" role="alert"><i class="icon fa fa-check"></i>
                        {{ Session::get('message') }}
                        <a href="#" style="float:right;" class="alert-close" data-dismiss="alert">&times;</a>
                    </div>
                    @endif
                    <div class="alert alert-success text-center" id="success_message_div" style="margin-bottom:0px;display:none;" role="alert">
                        <a href="#" style="float:right;" class="alert-close" data-dismiss="alert">&times;</a>
                        <i class="icon fa fa-check"></i><p id="success_message"></p>
                    </div>
                    
                    <div class="alert alert-danger text-center" id="error_message_div" style="margin-bottom:0px;display:none;" role="alert">
                        <p><a href="#" style="float:right;" class="alert-close" data-dismiss="alert">&times;</a></p>
                        <p id="error_message"></p>
                    </div>
                </div>
            </section>
            <!-- /.Flash Message  -->
            
            @yield('content')
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        
        
    @include('layouts.backend.partials.footer')
