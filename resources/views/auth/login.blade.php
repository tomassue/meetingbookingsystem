<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Meeting Booking System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('theme/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('theme/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('theme/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('theme/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('theme/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('theme/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('theme/vendor/simple-datatables/style.css')}}" rel="stylesheet">
  <link href="{{asset('theme/vendor/apexcharts/css/bootstrap.min.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('theme/css/login.css')}}" rel="stylesheet">
  <link href="{{asset('theme/app.css')}}" rel="stylesheet">
</head>

<body>
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-12 d-flex flex-column align-items-center justify-content-center">
              <div class="card mb-3">

                <div class="card-body">
                  <div class="row">
                    <div class="col mt-5">
                      <div class="col-md 6 pt-4 pb-2 d-flex justify-content-center">
                        <div class="row ">
                          <div class="col d-flex justify-content-center">
                            <img src="images/cdo-seal.png" alt="booking" class="img-fluid">
                          </div>
                          <div class="col" style="">
                            <img src="images/rise.png" alt="booking" class="img-fluid">
                          </div>
                        </div>
                      </div>

                      <form class="row g-3 needs-validation" method="POST" action="{{ route('login') }}" novalidate>
                        @csrf
                        <div class="col-12">
                          <div class="input-group has-validation">
                            <!-- <input type="text" name="username" class="form-control" placeholder="Username" required>
                            <div class="invalid-feedback">Please enter your username.</div> -->

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                        </div>

                        <div class="col-12">
                          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                          @error('password')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>

                        <div class="col-12 d-flex justify-content-center">
                          <button class="btn btn-primary col-md-6" type="submit">Login</button>
                        </div>
                      </form>
                    </div>

                    <div class="col">
                      <img src="images/booking.png" alt="booking" class="img-fluid">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main><!-- End #main -->

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>