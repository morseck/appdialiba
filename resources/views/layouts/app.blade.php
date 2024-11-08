<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ndongoyi | Authentification</title>

    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <link href="../assets/css/material-dashboard.css?v=2.0.2" rel="stylesheet" />
</head>
<body class="offline-doc">
{{--    <div id="app">
        <main class="py-4">--}}
            @yield('content')
{{--        </main>
    </div>--}}


    <footer class="footer">
        <div class="container-fluid">
            <div class="copyright float-right">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script>, Réalisé par
                <a href="#" target="_blank">KhidmaTech</a> pour Serigne Hamsatou.
            </div>
        </div>
    </footer>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery.min.js" type="text/javascript"></script>
    <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
    <script src="../assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Plugin for the momentJs  -->
    <!-- <script src="../assets/js/plugins/moment.min.js"></script> -->
    <!--  Plugin for Sweet Alert -->
    <!-- <script src="../assets/js/plugins/sweetalert2.js"></script> -->
    <!-- Forms Validations Plugin -->
    <!-- <script src="../assets/js/plugins/jquery.validate.min.js"></script> -->
    <!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <!-- <script src="../assets/js/plugins/jquery.bootstrap-wizard.js"></script> -->
    <!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <!-- <script src="../assets/js/plugins/bootstrap-selectpicker.js"></script> -->
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <!-- <script src="../assets/js/plugins/bootstrap-datetimepicker.min.js"></script> -->
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
    <!-- <script src="../assets/js/plugins/jquery.dataTables.min.js"></script> -->
    <!--  Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <!-- <script src="../assets/js/plugins/bootstrap-tagsinput.js"></script> -->
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <!-- <script src="../assets/js/plugins/jasny-bootstrap.min.js"></script> -->
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <!-- <script src="../assets/js/plugins/fullcalendar.min.js"></script> -->
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <!-- <script src="../assets/js/plugins/jquery-jvectormap.js"></script> -->
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <!-- <script src="../assets/js/plugins/nouislider.min.js"></script> -->
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script> -->
    <!-- Library for adding dinamically elements -->
    <!-- <script src="../assets/js/plugins/arrive.min.js"></script> -->
    <!--  Google Maps Plugin    -->
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
    <!-- Chartist JS -->
    <!-- <script src="../assets/js/plugins/chartist.min.js"></script> -->
    <!--  Notifications Plugin    -->
    <!-- <script src="../assets/js/plugins/bootstrap-notify.js"></script> -->
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/material-dashboard.min.js?v=2.0.2" type="text/javascript"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <!-- <script src="../assets/demo/demo.js"></script> -->

</body>
</html>
