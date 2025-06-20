<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{ $title ?? ''}} {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="/assets/css/material-dashboard.css?v=2.0.2" rel="stylesheet" />
ss
    @stack('styles')

</head>

<body class="sidebar-mini">
<div class="wrapper ">
    <div class="sidebar" data-color="green" data-background-color="black" >
        <!--
          Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

          Tip 2: you can also add an image using data-image tag
      -->
        <div class="logo">
            <a href="#" class="simple-text logo-mini">
                DL
            </a>
            <a href="#" class="simple-text logo-normal">
                Dialiba
            </a>
        </div>
        <div class="sidebar-wrapper">

            <ul class="nav">
                <li class="nav-item active ">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fas fa-igloo"></i>
                        <p> Accueil </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#talibe">
                        <i class="fas fa-user"></i>
                        <p> Talibés</p>
                    </a>
                    <div class="collapse" id="talibe">
                        <ul class="nav">
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('talibe.index') }}">
                                    <span class="sidebar-mini"> L </span>
                                    <span class="sidebar-normal"> LISTER </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('talibe.create') }}">
                                    <span class="sidebar-mini"> A</span>
                                    <span class="sidebar-normal"> NOUVEAU </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('talibe.deleted') }}">
                                    <span class="sidebar-mini"> P</span>
                                    <span class="sidebar-normal"> POUBELLE </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#dieuwrigne">
                        <i class="fas fa-user-graduate"></i>
                        <p> Dieuwrignes</p>
                    </a>
                    <div class="collapse" id="dieuwrigne">
                        <ul class="nav">
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('dieuw.index') }}">
                                    <span class="sidebar-mini"> L </span>
                                    <span class="sidebar-normal"> LISTER</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('dieuw.create') }}">
                                    <span class="sidebar-mini"> A </span>
                                    <span class="sidebar-normal"> NOUVEAU </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#tarbiya">
                        <i class="fas fa-male"></i>
                        <p> Ndongo Tarbiya</p>
                    </a>
                    <div class="collapse" id="tarbiya">
                        <ul class="nav">
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('tarbiya.index') }}">
                                    <span class="sidebar-mini"> L </span>
                                    <span class="sidebar-normal"> LISTER</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('tarbiya.create') }}">
                                    <span class="sidebar-mini"> A </span>
                                    <span class="sidebar-normal"> NOUVEAU </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#daara">
                        <i class="fas fa-home"></i>
                        <p> Daaras

                        </p>
                    </a>
                    <div class="collapse" id="daara">
                        <ul class="nav">
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('daara.index') }}">
                                    <span class="sidebar-mini"> L </span>
                                    <span class="sidebar-normal"> LISTER </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('daara.create') }}">
                                    <span class="sidebar-mini"> N </span>
                                    <span class="sidebar-normal">NOUVEAU</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#consultation">
                        <i class="material-icons">grid_on</i>
                        <p> Consultations </p>
                    </a>
                    <div class="collapse" id="consultation">
                        <ul class="nav">
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('consultation.index') }}">
                                    <span class="sidebar-mini"> L </span>
                                    <span class="sidebar-normal"> LISTER </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('consultation.create') }}">
                                    <span class="sidebar-mini"> N </span>
                                    <span class="sidebar-normal"> NOUVEAU </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#medecin">
                        <i class="fas fa-user-md"></i>
                        <p>Médecins</p>
                    </a>
                    <div class="collapse" id="medecin">
                        <ul class="nav">
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('medecin.index') }}">
                                    <span class="sidebar-mini"> L </span>
                                    <span class="sidebar-normal"> LISTER </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('medecin.create') }}">
                                    <span class="sidebar-mini"> N </span>
                                    <span class="sidebar-normal"> NOUVEAU </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link"  href="{{ url('galerie') }}">
                        <i class="fas fa-images"></i>
                        <p> Galerie</p>
                    </a>
                </li>

            </ul>
        </div>
    </div>

    <div class="main-panel">
        <!-- Navbar -->

        <!-- End Navbar -->

        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="">
                        {{-- <div class="card-icon" style="margin-left: 10px; margin-top: 10px">
                             <i class="material-icons">keyboard_arrow_left</i>
                         </div>--}}
                        <div class="card-body">
                            <button class="btn" onclick="history.back()" data-toggle="tooltip"  data-placement="left" title="Cliquez pour retourner à la page précédente">
                              <span class="btn-label">
                                <i class="material-icons">keyboard_arrow_left</i>
                              </span>
                                Précedent
                            </button>
                            <button class="btn btn-success" onclick="history.forward()"  data-toggle="tooltip"  data-placement="left" title="Cliquez pour accéder à la page suivante">
                                Suivant
                                <span class="btn-label">
                                <i class="material-icons">keyboard_arrow_right</i>
                              </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
        </div>


        <footer class="footer">
            <div class="container-fluid">

                <div class="copyright float-center">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>, Réalisé avec <i class="material-icons">favorite</i> par
                    <a href="#" >Groupe KhidmaTech</a> pour Serigne Hamsatou
                </div>
            </div>
        </footer>
    </div>
</div>

<script src="/assets/js/core/jquery.min.js" type="text/javascript"></script>
<script src="/assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="/assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
<!--    <script src="/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>-->

@stack('scripts-scroll')
<!-- Plugin for the momentJs  -->
<script src="/assets/js/plugins/moment.min.js"></script>
<!--  Plugin for Sweet Alert -->
<!-- <script src="/assets/js/plugins/sweetalert2.js"></script> -->
<!-- Forms Validations Plugin -->
<script src="/assets/js/plugins/jquery.validate.min.js"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="/assets/js/plugins/jquery.bootstrap-wizard.js"></script>
<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="/assets/js/plugins/bootstrap-selectpicker.js"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="/assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="/assets/js/plugins/jquery.dataTables.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<!-- Library for adding dinamically elements -->
<!-- <script src="/assets/js/plugins/arrive.min.js"></script> -->
<!-- Chartist JS -->
<!-- <script src="/assets/js/plugins/chartist.min.js"></script> -->
<!--  Notifications Plugin    -->
<script src="/assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="/assets/js/material-dashboard.min.js?v=2.0.2" type="text/javascript"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="/assets/demo/demo.js"></script>

<script>
    $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        // md.initDashboardPageCharts();
    });
</script>


@stack('scripts')
</body>

</html>
