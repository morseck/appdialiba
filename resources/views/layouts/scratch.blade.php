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
  <link href="/assets/css/new.css?v=2.0.2" rel="stylesheet" />

  @stack('styles')

</head>

<body class="sidebar-mini">
  <div class="wrapper ">
    <div class="sidebar" data-color="green" data-background-color="black" >
      <div class="logo">
        <a href="#" class="simple-text logo-mini">
          N Y
        </a>
        <a href="#" class="simple-text logo-normal">
            <span style="visibility: hidden ">Ndongo yi</span>
        </a>
      </div>
      <div class="sidebar-wrapper">
          <a href="{{ route('home') }}" class="logo-normal">
              <img class="w-100" src="/assets/img/attazkira-removebg.png" alt="">
          </a>

        <ul class="nav">
          <li class="nav-item {{ Request::is('/') ? 'active' : '' }} ">
            <a class="nav-link" href="{{ route('home') }}">
              <i class="fas fa-igloo"></i>
              <p> Accueil </p>
            </a>
          </li>


            <!--talibe-->
            @if(auth()->user()->hasPermission('view-talibes') ||
                auth()->user()->hasPermission('create-talibes') ||
                auth()->user()->hasPermission('edit-talibes') ||
                auth()->user()->hasPermission('delete-talibes') ||
                auth()->user()->hasPermission('view-talibes-archives') ||
                auth()->user()->hasPermission('restore-talibes-archives') ||
                auth()->user()->is_admin
                )
                <li class="nav-item {{ Request::is('talibe*') ? 'active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#talibe">
                  <i class="fas fa-user"></i>
                  <p> Talibés</p>
                </a>
                <div class="collapse" id="talibe">
                  <ul class="nav">
                      <!--Lister talibe-->
                      @if(auth()->user()->hasPermission('view-talibes') ||
                          auth()->user()->is_admin
                       )
                        <li class="nav-item ">
                          <a class="nav-link" href="{{ route('talibe.index') }}">
                            <span class="sidebar-mini"> L </span>
                            <span class="sidebar-normal"> LISTER </span>
                          </a>
                        </li>
                      @endif

                      <!--Creer talibe-->
                      @if(auth()->user()->hasPermission('create-talibes') ||
                          auth()->user()->is_admin
                       )
                        <li class="nav-item ">
                          <a class="nav-link" href="{{ route('talibe.create') }}">
                            <span class="sidebar-mini"> N</span>
                            <span class="sidebar-normal"> NOUVEAU </span>
                          </a>
                        </li>
                      @endif

                          <!--Lister archive talibe-->
                      @if(auth()->user()->hasPermission('view-talibes-archives') ||
                          auth()->user()->is_admin
                     )
                        <li class="nav-item ">
                          <a class="nav-link" href="{{ route('talibe.deleted') }}">
                            <span class="sidebar-mini"> A</span>
                            <span class="sidebar-normal"> ARCHIVES </span>
                          </a>
                        </li>
                      @endif
                  </ul>
                </div>
              </li>
            @endif


            <!--Dieuwrine-->
            @if(auth()->user()->hasPermission('view-dieuwrine') ||
              auth()->user()->hasPermission('create-dieuwrine') ||
              auth()->user()->hasPermission('edit-dieuwrine') ||
              auth()->user()->hasPermission('delete-dieuwrine') ||
              auth()->user()->is_admin
              )
                <li class="nav-item  {{ Request::is('dieuw*') ? 'active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#dieuwrigne">
                      <i class="fas fa-user-graduate"></i>
                      <p> Dieuwrignes</p>
                    </a>
                    <div class="collapse" id="dieuwrigne">
                      <ul class="nav">

                          <!--Lister Dieuwrine-->
                          @if(auth()->user()->hasPermission('view-dieuwrine') ||
                              auth()->user()->is_admin
                           )
                            <li class="nav-item ">
                              <a class="nav-link" href="{{ route('dieuw.index') }}">
                                <span class="sidebar-mini"> L </span>
                                <span class="sidebar-normal"> LISTER</span>
                              </a>
                            </li>
                          @endif

                      <!--Creer Dieuwrine-->
                          @if(auth()->user()->hasPermission('create-dieuwrine') ||
                              auth()->user()->is_admin
                         )
                            <li class="nav-item ">
                              <a class="nav-link" href="{{ route('dieuw.create') }}">
                                <span class="sidebar-mini"> A </span>
                                <span class="sidebar-normal"> NOUVEAU </span>
                              </a>
                            </li>
                          @endif

                      </ul>
                    </div>
                </li>
            @endif

            <!--Ndongo Tarbiya-->
            @if(auth()->user()->hasPermission('view-tarbiya') ||
              auth()->user()->hasPermission('create-tarbiya') ||
              auth()->user()->hasPermission('edit-tarbiya') ||
              auth()->user()->hasPermission('delete-tarbiya') ||
              auth()->user()->is_admin
              )
                <li class="nav-item  {{ Request::is('tarbiya*') ? 'active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#tarbiya">
                    <i class="fas fa-male"></i>
                    <p> Ndongo Tarbiya</p>
                </a>
                <div class="collapse" id="tarbiya">
                    <ul class="nav">

                        <!--Lister Tarbiya-->
                        @if(auth()->user()->hasPermission('view-tarbiya') ||
                            auth()->user()->is_admin
                          )
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('tarbiya.index') }}">
                                    <span class="sidebar-mini"> L </span>
                                    <span class="sidebar-normal"> LISTER</span>
                                </a>
                        </li>
                        @endif

                        <!--Creer Tarbiya-->
                        @if(
                          auth()->user()->hasPermission('create-tarbiya') ||
                          auth()->user()->is_admin
                          )
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('tarbiya.create') }}">
                                    <span class="sidebar-mini"> A </span>
                                    <span class="sidebar-normal"> NOUVEAU </span>
                                </a>
                            </li>
                        @endif

                    </ul>
                </div>
            </li>
            @endif


            <!--Daara-->
            @if(auth()->user()->hasPermission('view-daara') ||
              auth()->user()->hasPermission('create-daara') ||
              auth()->user()->hasPermission('edit-daara') ||
              auth()->user()->hasPermission('delete-daara') ||
              auth()->user()->is_admin
              )
                <li class="nav-item  {{ Request::is('daara*') ? 'active' : '' }} ">
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
            @endif

            <!--consultations-->
            @if(auth()->user()->hasPermission('view-campagne-consultation') ||
              auth()->user()->is_admin
              )
                <li class="nav-item {{ Request::is('consultation*') ? 'active' : '' }}">
            <a class="nav-link collapse"  href="{{ route('consultation.index') }}">
              <i class="material-icons">grid_on</i>
              <p> Consultations </p>
            </a>
          </li>
            @endif


            <!--Medecin-->
            @if(auth()->user()->hasPermission('view-medecin') ||
              auth()->user()->hasPermission('create-medecin') ||
              auth()->user()->hasPermission('edit-medecin') ||
              auth()->user()->hasPermission('delete-medecin') ||
              auth()->user()->is_admin
              )
                <li class="nav-item {{ Request::is('medecin*') ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#medecin">
              <i class="fas fa-user-md"></i>
              <p>Médecins</p>
            </a>
            <div class="collapse" id="medecin">
              <ul class="nav">
                  <!--Lister Medecin-->
                  @if(auth()->user()->hasPermission('view-medecin') ||
                     auth()->user()->is_admin
                 )
                    <li class="nav-item ">
                  <a class="nav-link" href="{{ route('medecin.index') }}">
                    <span class="sidebar-mini"> L </span>
                    <span class="sidebar-normal"> LISTER </span>
                  </a>
                </li>
                  @endif

                  <!--Creer Medecin-->
                  @if(auth()->user()->hasPermission('create-medecin') ||
                     auth()->user()->is_admin
                   )
                     <li class="nav-item ">
                  <a class="nav-link" href="{{ route('medecin.create') }}">
                    <span class="sidebar-mini"> N </span>
                    <span class="sidebar-normal"> NOUVEAU </span>
                  </a>
                </li>
                  @endif
              </ul>
                </div>
            </li>
            @endif

            <!--Galerie-->
            @if(auth()->user()->hasPermission('view-galerie') ||
              auth()->user()->is_admin
              )
                <!--Lister Galerie-->
                <li class="nav-item {{ Request::is('galerie*') ? 'active' : '' }}">
                    <a class="nav-link"  href="{{ url('galerie') }}">
                      <i class="fas fa-images"></i>
                      <p> Galerie</p>
                    </a>
                </li>
            @endif

            <!-- Administration-->
            @if(
             auth()->user()->is_admin
             )
                <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#admin">
                    <i class="fa fa-toolbox"></i>
                    <p> Administration</p>
                </a>
                <div class="collapse" id="admin">
                    <ul class="nav">

                        <!-- Administration reporting dashbord-->
                        <li class="nav-item ">
                            <a class="nav-link"  href="{{ url('admin/dashboard') }}">
                                <i class="fa fa-clipboard-list"></i>
                                <p>Reporting</p>
                            </a>
                        </li>

                        <!-- Administration users-->
                            <li class="nav-item ">
                            <a class="nav-link" data-toggle="collapse" href="#users">
                                <i class="fa fa-users"></i>
                                <p> Utilisateurs</p>
                            </a>
                            <div class="collapse" id="users">
                                <ul class="nav">

                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ route('users.index') }}">
                                            <span class="sidebar-mini"> L </span>
                                            <span class="sidebar-normal"> LISTER </span>
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ route('users.create') }}">
                                            <span class="sidebar-mini"> N</span>
                                            <span class="sidebar-normal"> NOUVEAU </span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>


                        <!-- Administration roles-->
                        <li class="nav-item ">
                            <a class="nav-link" data-toggle="collapse" href="#roles">
                                <i class="fas fa-user-tag"></i>
                                <p> Roles</p>
                            </a>
                            <div class="collapse" id="roles">
                                <ul class="nav">

                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ route('roles.index') }}">
                                            <span class="sidebar-mini"> L </span>
                                            <span class="sidebar-normal"> LISTER </span>
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ route('roles.create') }}">
                                            <span class="sidebar-mini"> N</span>
                                            <span class="sidebar-normal"> NOUVEAU </span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        <!-- Administration permissions-->
                        <li class="nav-item ">
                            <a class="nav-link" data-toggle="collapse" href="#permissions">
                                <i class="fas fa-key"></i>
                                <p> Permissions</p>
                            </a>
                            <div class="collapse" id="permissions">
                                <ul class="nav">

                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ route('permissions.index') }}">
                                            <span class="sidebar-mini"> L </span>
                                            <span class="sidebar-normal"> LISTER </span>
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ route('permissions.create') }}">
                                            <span class="sidebar-mini"> N</span>
                                            <span class="sidebar-normal"> NOUVEAU </span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>
            </li>
            @endif

            <!--LOGS-->
            @if(
                auth()->user()->hasPermission('view-logs-transaction') ||
                auth()->user()->hasPermission('view-logs-framework') ||
                auth()->user()->is_admin
             )
                <li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#logs">
                        <i class="fas fa-clipboard-list"></i>
                        <p>Logs</p>
                    </a>
                    <div class="collapse" id="logs">
                        <ul class="nav">
                            <!--Lister Logs transaction-->
                            @if(auth()->user()->hasPermission('view-logs-transaction') ||
                               auth()->user()->is_admin
                           )
                                <li class="nav-item ">

                                    <a class="nav-link"  href="{{ url('transaction-logs?') }}">
                                        <span class="sidebar-mini"> L T </span>
                                        <span class="sidebar-normal"> Logs Transaction </span>
                                    </a>
                                </li>
                            @endif
                            <!--Lister Logs framework-->
                            @if(auth()->user()->hasPermission('view-logs-transaction') ||
                               auth()->user()->is_admin
                           )
                                <li class="nav-item ">

                                    <a class="nav-link"  href="{{ route('logs.index') }}">
                                        <span class="sidebar-mini"> L F </span>
                                        <span class="sidebar-normal"> Logs Framework </span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </li>
            @endif

        </ul>
      </div>

    </div>

<div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top " id="navigation-example">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-minimize">
              <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
              </button>
            </div>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" data-target="#navigation-example">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>

          <div class="collapse navbar-collapse justify-content-end">
              <form class="navbar-form" method="get" action="{{route('reccherche_talibe')}}">
                <div class="input-group no-border">
                  <input type="text" name="recherche" class="form-control" placeholder="Recherche...">
                </div>
              </form>
              <ul class="navbar-nav" style="padding-right:35px;padding-left: 50px;">
                <li class="nav-item">
                  <a class="nav-link" href="#" title="Profil" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-lock fa-3x"></i>
                    <p class="d-lg-none d-md-block">
                      Administrateur
                    </p>
                  </a>
                  <!-- dropdown -->
                    <div class="dropdown-menu dropdown-menu-right text-black-50" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item" href="#">
                          <span style="color: black">Mon compte</span>
                      </a>

                       <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                           <span style="color: black">Déconnexion</span>
                       </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                    </div>
                  <!-- dropdown end -->
                </li>
              </ul>
        </div>

        </div>
      </nav>
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

          @if(isset($showPageTitle) && $showPageTitle)
          <div class="card">

              <div class="card-body">
                  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                      <h1 class="h2">@yield('page-title')</h1>
                      @yield('page-actions')
                  </div>
                  @if(session('success'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                          {{ session('success') }}
                          <button type="button" class="close" data-dismiss="alert">
                              <span>&times;</span>
                          </button>
                      </div>
                  @endif

                  @if(session('error'))
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          {{ session('error') }}
                          <button type="button" class="close" data-dismiss="alert">
                              <span>&times;</span>
                          </button>
                      </div>
                  @endif

                  @if($errors->any())
                      <div class="alert alert-danger">
                          <ul class="mb-0">
                              @foreach($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif
              </div>
          </div>
          @endif
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
