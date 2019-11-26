
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <base href="{{ URL::to('/').'/'.config('backend.backendRoute').'/' }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@if(isset($title)){{ $title }}@endif - Quản trị website</title>

  <!-- Font Awesome Icons -->
  @yield('css')
    <link rel="stylesheet" href="{{asset('assets/default/css/fontawesome-stars.css')}}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/font-awesome/css/font-awesome.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/myadmin.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->

  <script src="{{asset('assets/default/js/jquery.barrating.min.js')}}"></script>
  <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap -->
  <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
  <!-- PAGE SCRIPTS -->
  <script src="{{ asset('adminlte/js/admin.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script type="text/javascript">
        function selectFileWithCKFinder( elementId, previewSrc ) {
            CKFinder.popup( {
                chooseFiles: true,
                width: 800,
                height: 600,
                onInit: function( finder ) {
                    finder.on( 'files:choose', function( evt ) {
                        var file = evt.data.files.first();
                        var output = document.getElementById( elementId );
                        output.value = file.getUrl();

                        var pr = document.getElementById( previewSrc );
                        pr.src  = file.getUrl();
                    } );

                    finder.on( 'file:choose:resizedImage', function( evt ) {
                        var output = document.getElementById( elementId );
                        output.value = evt.data.resizedUrl;
                    } );
                }
            } );


        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function(){
            $(".Switch").on('click',function() {
                $.ajax({
                    url: "{{ url('/').'/'.$backendUrl.'/ajax' }}",
                    type : "post",
                    dataType:"text",
                    data : {
                        action : 'updateToggle',
                        table : $(this).attr('data-table'),
                        col : $(this).attr('data-col'),
                        id: $(this).attr('data-id')
                    },
                }).done(function() {
                });
            });

        });
    </script>

  @yield('js-head')
</head>
<body class="hold-transition sidebar-mini sidebar-collapse" bsurl="{{ url("/") }}" adminroute="{{ $backendUrl }}" style="height: auto;">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('home')}}" target="_blank" class="nav-link">Trang chủ</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('orders.backend.total')}}" class="nav-link">Đơn hàng</a>
      </li>

    </ul>

    <!-- SEARCH FORM -->
    <form action="{{route('orders.backend.total')}}" class="form-inline ml-3" method="GET">
      <div class="input-group input-group-sm">
        <input name="order" class="form-control form-control-navbar" type="search" placeholder="Nhập mã đơn hàng" aria-label="Tìm kiếm">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image" style="width: 30px;margin-right: 10px;">
         </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>

          <a href="{{ url($backendUrl.'/users').'/'.Auth::user()->id.'/edit' }}" class="dropdown-item">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Sửa thông tin
          </a>

          <a href="/logout" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out" aria-hidden="true"></i> Thoát
          </a>
          {!! Form::open(array('route' => 'logout','method'=>'POST', 'id'=>'logout-form', 'style'=>"display: none;")) !!}{!! Form::close() !!}
        </div>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

  @include('backend.layouts.sidebar');

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      @include('backend.layouts.headermain')
      @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <!-- Default to the left -->
    <strong>Copyright &copy; 2010-{{date("Y")}} <a href="https://nencer.com">Nencer JSC</a>.</strong> All rights reserved.
    <div class="float-right d-sm-none d-md-block">
      Phiên bản {{config('app.version')}}
    </div>
  </footer>
</div>
<!-- ./wrapper -->

@include('backend.layouts.uploadsjs')
@yield('js')

<input type="hidden" id="notifi-audio-mtopup" value="{{ asset('assets/audio/mtopup.mp3') }}" />
<input type="hidden" id="notifi-audio-charging" value="{{ asset('assets/audio/charging.mp3') }}" />
<!-- Js alert notifi new order -->
<script type="text/javascript">
  $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
  });
  var audioElement = document.createElement('audio');

  function getNofication(){
    $.ajax({
      url: '{{ route("backend.ajaxgetnotification") }}',
      method: 'POST',
      success: function (data) {
        data = $.parseJSON(data);
        if(data.message){
          messText = data.message;
          audioSrc = $('#notifi-audio-'+data.module).val();
          if(audioSrc!==undefined && audioSrc!=''){
            audioElement.setAttribute('src', audioSrc);
            audioElement.play();
          }
        }
      }
    });
  }
  var notifi;
  notifi = setInterval(getNofication,25000);
</script>

</body>
</html>
