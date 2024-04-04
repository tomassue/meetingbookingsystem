<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Meeting Booking System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.1/sweetalert2.all.min.js">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js">

  <link href="{{asset('theme/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('theme/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('theme/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('theme/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('theme/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('theme/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('theme/vendor/simple-datatables/style.css')}}" rel="stylesheet">
  <link href="{{asset('theme/vendor/apexcharts/css/bootstrap.min.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('theme/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('theme/app.css')}}" rel="stylesheet">
  <link href="{{asset('theme/css/calendar.css')}}" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center mb-5" style="height: 100px !important; ">

    <div class="d-flex align-items-center justify-content-between">
      <div class="">
        <a href="" class="logo d-flex align-items-center justify-content-center">
          <img src="{{ asset('images/cdo-seal.png') }}" class="img-fluid" alt="">
          <img src="{{ asset('images/rise.png') }}" class="img-fluid" alt="">
        </a>
      </div>
      <i class="bi bi-list toggle-sidebar-btn" style="color: #2B4F43;"></i>

      <div>
        <h1 class="dtitle1 px-3 mt-1">Meeting Booking System</h1>
      </div>
    </div><!-- End Logo -->

    <ul class="navbar-nav ms-auto d-flex justify-content-right" style="margin-left: 40% !important">
      <!-- Authentication Links -->
      @guest
      @if (Route::has('login'))
      <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
      </li>
      @endif

      @if (Route::has('register'))
      <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
      </li>
      @endif
      @else
      <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          {{ Auth::user()->name }}
        </a>

        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </div>
      </li>
      @endguest
    </ul>


    <nav class="header-nav ms-auto">

    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar mt-5">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item ">
        <a class="nav-link collapsed {{ 'schedule' == request()->path() ? 'active' : '' }}" href="{{route('schedule')}} " href="{{route('schedule')}}">
          <span class="bi bi-grid"> </span>
          <span>My Schedule</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed {{ 'book' == request()->path() ? 'active' : '' }}" href="{{route('book')}} " href="{{route('book')}}">
          <span class="bi bi-layout-text-window-reverse"> </span>
          <span>Book Meeting</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed {{ 'viewsched' == request()->path() ? 'active' : '' }}" href="{{route('viewsched')}} " href="{{route('viewsched')}}">
          <span class="bi bi-calendar2-week"> </span>

          <span>View Schedule</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed {{ 'request' == request()->path() ? 'active' : '' }}" href="{{route('request')}} " href="{{route('request')}}">
          <span class="ri-git-pull-request-line"> </span>
          <span>Request</span>
        </a>
      </li>


    </ul>

  </aside>

  <main id="main" class="main mt-5">

    @yield('content')

  </main>

  <!-- ======= Footer ======= -->
  @include('layouts.footer')

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="{{asset('theme/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('theme/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('theme/vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset('theme/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('theme/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="{{asset('theme/js/main.js')}}"></script>
  @yield('scripts')
</body>

</html>