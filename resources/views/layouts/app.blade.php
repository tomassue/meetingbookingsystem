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
  <!-- <link href="{{asset('theme/vendor/apexcharts/css/bootstrap.min.css')}}" rel="stylesheet"> -->

  <!-- Template Main CSS File -->
  <link href="{{asset('theme/css/style.css')}}" rel="stylesheet">
  <!-- <link href="{{asset('theme/css/app.css')}}" rel="stylesheet"> -->
  <link href="{{asset('theme/css/calendar.css')}}" rel="stylesheet">

  <!-- JQuery 1.13 -->
  <link rel="stylesheet" href="{{asset('jquery-ui-1.13.2/jquery-ui.min.css')}}">

  <style>
    .sidebar-nav .nav-link.collapsed {
      color: #fff;
      background-color: #0a927c !important;
      width: 110% !important;
    }
  </style>

  @livewireStyles
</head>

<body>

  <livewire:navigation />

  <main id="main" class="main mt-5">
    <!-- @yield('content') -->
    <section class="section">
      {{ $slot }}
    </section>
  </main>

  <!-- ======= Footer ======= -->
  @include('layouts.footer')

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  @livewireScripts
</body>

<script>
  window.livewire.on('createBookMeetingModal', startDate => {
    $('#createBookMeetingModal').modal('show');
  })

  Livewire.on('hideaddDepartmentModal', key => {
    $('#addDepartmentModal').modal('hide');
  })
</script>

</html>