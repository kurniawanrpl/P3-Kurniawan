<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{ asset('admin/images/favicon.ico') }}" type="image/ico" />

    <title>Gentelella Alela!</title>

    <!-- Bootstrap -->
    <link href="{{ asset('admin/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('admin/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('admin/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('admin/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="{{ asset('admin/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ asset('admin/vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('admin/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('admin/build/css/custom.min.css') }}" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span></span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
              @if($global_outlet && $global_outlet->foto)
    <img src="{{ asset('uploads/outlet/' . $global_outlet->foto) }}" alt="Foto Outlet"
         style="width: 70px; height: 70px; object-fit: cover; border-radius: 50%;">
@else
    <img src="{{ asset('images/default-outlet.png') }}" alt="Foto Default" 
         style="width: 70px; height: 70px; object-fit: cover; border-radius: 50%;">
@endif
              </div>
              <div class="profile_info">
                <span>{{ $global_outlet->nama_outlet ?? 'Nama Outlet Tidak Diketahui' }}</span>
                <h2>{{Auth::user()->name}} </h2>
                
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> dasboard <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('dasboard') }}">Dashboard</a></li>
                     
                      @if(in_array(Auth::user()->role, ['admin','owner']))
                      <li><a href="{{ url('user/admin') }}">admin</a></li>
                      @endif
                      @if(in_array(Auth::user()->role, ['owner','admin','supervisor','petugas']))
                      <li><a href="{{ url('user/karyawan') }}">petugas</a></li>
                        @endif
                        @if(in_array(Auth::user()->role, ['owner','admin','supervisor']))
                      <li><a href="{{ route('user.supervisor') }}">supervisor</a></li>
                      @endif
                      @if(in_array(Auth::user()->role, ['owner','admin','supervisor']))
                      <li><a href="{{ route('setting.edit') }}">setting</a></li>
                      @endif

                       @if(in_array(Auth::user()->role, ['admin','owner']))
                      <li><a href="{{ route('outlets.index') }}">outlets</a></li>
                      @endif
                      @if(in_array(Auth::user()->role, ['admin','owner','petugas','supervisor']))
                      <li><a href="{{ route('user.pengguna') }}">pengguna</a></li>
                      @endif
                     
                    </ul>
                  </li>
                  <li><a herf=""><i class="fa fa-edit"></i> barang <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                     
                      
                      
                    @if(in_array(Auth::user()->role, ['owner','admin','supervisor','petugas']))
                      <li><a href="{{ route('paket_laundry.index') }}">paket laundry</a></li>
                      <li><a href="{{ route('promo.member') }}">promo buat member</a></li>
                      @endif
                     
                     
                      @if(in_array(Auth::user()->role, ['pengguna']))
                      <li><a href="{{ route('member.bayar') }}">daftar member</a></li>
@endif 
                      <li><a href="{{ route('members.index') }}">member</a></li>
                      <li><a href="{{ route('transaksi.index') }}">transaksi</a></li>
                     
                    
                    </ul>
                  </li>
                
                  
                 
                </ul>
              </div>
             

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{url ('logout')}}">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
         
        <div class="top_nav">
          <div class="nav_menu">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              @if(session('error'))
    <div class="alert alert-danger mt-3">
        {{ session('error') }}
    </div>
@endif
              <nav class="nav navbar-nav">
              <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                  <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('admin/images/img.jpg') }}" alt="">John Doe
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"  href="{{route ('profile.index')}}"> Profile</a>
                      <a class="dropdown-item"  href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                      @php
    $role = auth()->user()->role ?? null;
    $member = auth()->user()->member ?? null;
@endphp

{{-- Untuk admin, supervisor, dan petugas --}}
@if (in_array($role, ['admin', 'supervisor', 'petugas']))
    <a class="dropdown-item" href="{{ route('topup.histori') }}">Histori Top Up</a>

{{-- Untuk user biasa yang sudah menjadi member dan status pembayaran sudah paid --}}
@elseif ($role === 'pengguna' && $member && $member->midtrans_payment_status === 'paid')
    <a class="dropdown-item" href="{{ route('topup.index') }}">Top Up</a>
    <a class="dropdown-item" href="{{ route('topup.histori') }}">Histori Top Up</a>
@endif
                    <a class="dropdown-item"  href="{{url ('logout')}}"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </div>
                </li>

                <li role="presentation" class="nav-item dropdown open">
                @php
    $role = auth()->user()->role ?? null;
@endphp

@if(in_array($role, ['admin', 'supervisor', 'petugas']))
    <div class="alert alert-info text-end">
        Anda adalah <strong>{{ ucfirst($role) }}</strong>
    </div>
@elseif($global_member)
    <div class="alert alert-success text-end">
        <strong>Saldo Anda:</strong> Rp{{ number_format($global_member->saldo, 0, ',', '.') }}
    </div>
@else
    <div class="alert alert-warning text-end">
        Anda belum memiliki akun member.
    </div>
@endif


                  <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                   
                    
                   
                   
                    <li class="nav-item">
                      <div class="text-center">
                        <a class="dropdown-item">
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          
          <!-- /top tiles -->
          @yield('content')

          
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>


    
    <!-- jQuery -->
    <script src="{{ asset('admin/vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('admin/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('admin/vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('admin/vendors/nprogress/nprogress.js') }}"></script>
    <!-- Chart.js -->
    <script src="{{ asset('admin/vendors/Chart.js/dist/Chart.min.js') }}"></script>
    <!-- gauge.js -->
    <script src="{{ asset('admin/vendors/gauge.js/dist/gauge.min.js') }}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{ asset('admin/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('admin/vendors/iCheck/icheck.min.js') }}"></script>
    <!-- Skycons -->
    <script src="{{ asset('admin/vendors/skycons/skycons.js') }}"></script>
    <!-- Flot -->
    <script src="{{ asset('admin/vendors/Flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('admin/vendors/Flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('admin/vendors/Flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('admin/vendors/Flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('admin/vendors/Flot/jquery.flot.resize.js') }}"></script>
    <!-- Flot plugins -->
    <script src="{{ asset('admin/vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
    <script src="{{ asset('admin/vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/flot.curvedlines/curvedLines.js') }}"></script>
    <!-- DateJS -->
    <script src="{{ asset('admin/vendors/DateJS/build/date.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('admin/vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
    <script src="{{ asset('admin/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('admin/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('admin/vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('admin/build/js/custom.min.js') }}"></script>
    <script type="text/javascript">
    function topUpSaldo(snapToken) {
        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                alert("Top-up berhasil!");
                // Kirimkan informasi ke server untuk memperbarui status pembayaran
            },
            onPending: function(result) {
                alert("Top-up pending. Silakan tunggu konfirmasi.");
            },
            onError: function(result) {
                alert("Terjadi kesalahan pada pembayaran.");
            }
        });
    }
</script>
	
  </body>
</html>
