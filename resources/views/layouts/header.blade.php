<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Kampung Kelapa | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="shortcut icon" href="{{ asset('/favicon.ico')}}">
  <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/dist/fonts/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/skins/_all-skins.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/dist/fonts/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/ionicons.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/flat/blue.css') }}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/morris/morris.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/datepicker3.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/jquery.dataTables_themeroller.css') }}">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
      .table>thead>tr>th {
          vertical-align: middle;
          text-align: center;
      }
      .dataTables_filter {
          text-align: right;
      }
  </style>
</head>
<body class="hold-transition sidebar-collapse skin-red-light sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <!-- Logo
    <a href="{{ url('/') }}" class="logo">
      <span class="logo-mini"></span>
      <span class="logo-lg"><b> Kampung </b> Kelapa</span>
    </a>
    -->
    <nav class="navbar navbar-static-top navbarbg">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
          <a href="{{ url('/') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b> Kampung </b> Kelapa</span>
    </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('assets/dist/img/avatar5.png') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="{{ asset('assets/dist/img/avatar5.png') }}" class="img-circle" alt="User Image">
                <p>
                  {{ Auth::user()->name }} 
                  <small>Anggota sejak {{ Auth::user()->created_at }}</small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-right">
                  <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Keluar</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">
    <!--

    <section class="sidebar">
      <!Sidebar user panel -->
      <!-- 
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('assets/dist/img/user2-160x160.png') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
        </div>
      </div>
      <form style="display:none;" action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Pencarian...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <ul class="sidebar-menu">
        <li class="header">NAVIGASI UTAMA</li>
        <li class="treeview">
          <a href="{{ url('/dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dasbor</span>
          </a>
        </li>
        @if(Auth::user()->role=="M")
        <li class="treeview">
          <a href="{{ route('unit_kerja.index') }}">
            <i class="fa fa-user"></i> <span>Pengguna</span>
          </a>
        </li>
        <li class="treeview">
          <a href="{{ route('deadlines.index') }}">
            <i class="fa fa-calendar"></i> <span>Tenggat Waktu</span>
          </a>
        </li>
        @endif
        <li class="treeview @if(Request::is('progres_pjbs') || 
                                Request::is('status_pengisian*')|| 
                                Request::is('pjb_setahun')|| 
                                Request::is('*_pjbs') || 
                                Request::is('*_pjbs/*') || 
                                Request::is('*_pradipas') || 
                                Request::is('*_pradipas/*') ||
                                (Request::is('*_spp') && !Request::is('report_*')) || 
                                (Request::is('*_spp/*') && !Request::is('report_*'))
                                )
                                active 
                            @endif">
          <a href="#">
            <i class="fa fa-home"></i> <span>DIPA</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('/penyerapan_anggaran_pradipas') }}"><i class="fa fa-fw"></i>Anggaran Pra-DIPA</a></li>
            <li><a href="{{ url('/penyerapan_anggaran_target_pjbs') }}"><i class="fa fa-fw"></i>Anggaran & Target PBJ</a></li>
            <li><a href="{{ url('/pjb_setahun') }}"><i class="fa fa-fw"></i>Paket PBJ Setahun</a></li>
            <li><a href="{{ url('/kop_spp') }}"><i class="fa fa-fw"></i>KOP & SPP</a></li>
            <li><a href="{{ url('/realisasi_anggaran_target_pjbs') }}"><i class="fa fa-fw"></i>Realisasi Anggaran & PBJ</a></li>
            <li><a href="{{ url('/progres_pjbs') }}"><i class="fa fa-fw"></i>Progres PBJ</a></li>
            <li><a href="{{ url('/status_pengisian') }}"><i class="fa fa-fw"></i>Status Pengisian</a></li>
          </ul>
        </li>
        @if(Auth::user()->role=="M")
        <li class="treeview @if(Request::is('report_*'))
                                active 
                            @endif">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('/report') }}"><i class="fa fa-fw"></i>Laporan Anggaran</a></li>
            <li><a href="{{ url('/report_kop_spp') }}"><i class="fa fa-fw"></i>Laporan Kop & SPP</a></li>
          </ul>
        </li>        
        @endif        
      </ul>
    </section>
  -->
  </aside>
