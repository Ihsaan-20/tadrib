<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('frontend/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('Frontened/img/favicon.ico') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Light Bootstrap Dashboard - Free Bootstrap 4 Admin Dashboard by Creative Tim</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet"
        href="{{ asset('frontend/fonts/https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css') }}" />
    <!-- CSS Files -->
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('frontend/css/light-bootstrap-dashboard.css') }}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('frontend/css/demo.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-image="img/sidebar-5.jpg">

            @include('frontend.layouts.sidebar')
           
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            @include('frontend.layouts.search-bar')
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            @yield('app')
                        </div>
                    </div>
                </div>
            </div>
            @include('frontend.layouts.footer')
        </div>
    </div>

</body>
<!--   Core JS Files   -->
<script src="{{ asset('frontend/js/core/jquery.3.2.1.min.js') }}" type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if (Session::has('success'))
        Swal.fire({
            title: "Success",
            text: "{{ session()->get('success') }}",
            icon: "success"
        });
    @endif

    @if (Session::has('error'))
        Swal.fire({
            title: "Error",
            text: "{{ session()->get('error') }}",
            icon: "error"
        });
    @endif

    @if (Session::has('info'))
        Swal.fire({
            title: "Info",
            text: "{{ session()->get('Info') }}",
            icon: "info"
        });
    @endif

    @if (Session::has('warning'))
        Swal.fire({
            title: "Warning",
            text: "{{ session()->get('warning') }}",
            icon: "warning"
        });
    @endif
</script>



@yield('customJs')

<!-- Include jQuery in your HTML file if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    // Attach an input event listener to the phone_number field
        $('.phone_number').on('input', function() {
        // Remove non-numeric characters from the input
        var phoneNumber = $(this).val().replace(/\D/g, '');

        // Limit the input to 15 characters
        phoneNumber = phoneNumber.substring(0, 15);

        // Update the input value
        $(this).val(phoneNumber);
        });


   // Attach an input event listener to the duration field
   $('.duration').on('input', function() {
      // Get the entered value
      var duration = $(this).val();

      // Remove non-numeric characters from the input
      var numericValue = duration.replace(/\D/g, '');

      // Format the numeric value to "HH:mm"
      var formattedValue = numericValue.replace(/(\d{2})(\d{2})/, '$1:$2');

      // Limit the input to 5 characters, including the colon
      formattedValue = formattedValue.substring(0, 5);

      // Update the input value
      $(this).val(formattedValue);
    });

  });
</script>







<script src="{{ asset('frontend/js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('frontend/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="{{ asset('frontend/js/plugins/bootstrap-switch.js') }}"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript"
    src="{{ asset('frontend/js/https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE') }}"></script>
<!--  Chartist Plugin  -->
<script src="{{ asset('frontend/js/plugins/chartist.min.js') }}"></script>
<!--  Notifications Plugin    -->
<script src="{{ asset('frontend/js/plugins/bootstrap-notify.js') }}"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="{{ asset('frontend/js/light-bootstrap-dashboard.js?v=2.0.0') }} " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ asset('frontend/js/demo.js') }}"></script>

</html>
