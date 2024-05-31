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

  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

  <!-- SUMMERNOTE -->
  <link href="{{asset('summernote/summernote-lite.css')}}" rel="stylesheet">

  <!-- AlpineJS -->
  <!-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> -->

  <!-- sweetalert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .sidebar-nav .nav-link.collapsed {
      color: #fff;
      background-color: #0a927c !important;
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

  <!-- summernote -->
  <script src="{{asset('summernote/summernote-lite.js')}}"></script>

  @yield('scripts')

  @stack('scripts')

  @livewireScripts

</body>

<script>
  Livewire.onPageExpired((response, message) => {})

  // To make bootstrap tooltip work
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })

  Livewire.on('showaddMemoModal', key => {
    $('#addMemoModal').modal('show');
  })

  window.livewire.on('showMeetingModal', startDate => {
    $('#viewBookMeetingModal').modal('show');
  })

  Livewire.on('showaddDepartmentModal', key => {
    $('#addDepartmentModal').modal('show');
  })

  Livewire.on('hideaddDepartmentModal', key => {
    $('#addDepartmentModal').modal('hide');
  })

  Livewire.on('hideaddUserModal', key => {
    $('#addUserModal').modal('hide');
  })

  Livewire.on('showaddUserModal', key => {
    $('#addUserModal').modal('show');
  })

  Livewire.on('hideaddNewFileModal', key => {
    $('#addNewFileModal').modal('hide');
  })

  Livewire.on('hideviewBookMeetingModal', key => {
    $('#viewBookMeetingModal').modal('hide');
  })

  Livewire.on('showApproveConfirmationAlert', key => {
    Swal.fire({
      title: 'Are you sure you want to approve?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      width: '25em',
      showCancelButton: true,
      confirmButtonColor: '#0a927c',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes!'
    }).then((result) => {
      if (result.isConfirmed) {
        Livewire.emit('approveMeeting');
      }
    });
  })

  Livewire.on('showDeclineConfirmationAlert', key => {
    Swal.fire({
      title: 'Are you sure you want to decline?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      width: '25em',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes!'
    }).then((result) => {
      if (result.isConfirmed) {
        Livewire.emit('declineMeeting');
      }
    });
  })

  Livewire.on('showViewMeetingModal', key => {
    // console.log('wew');
    $('#viewMeetingModal').modal('show');
  })

  Livewire.on('showResetPasswordConfirmationAlert', key => {
    Swal.fire({
      title: 'Are you sure you want to continue?',
      text: 'Once you reset the password, there is no way to go back!',
      icon: 'warning',
      width: '25em',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes!'
    }).then((result) => {
      if (result.isConfirmed) {
        Livewire.emit('resetPassword');
      }
    });
  })
</script>

</html>