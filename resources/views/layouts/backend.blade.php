<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Starter</title>


    <link rel="stylesheet" href="{{mix('css/app.css')}}">


</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/home" class="nav-link">Home</a>
                </li>
            </ul>


        </nav>


        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="index3.html" class="brand-link">
                <img src="/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{config('app.name')}}</span>
            </a>

            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/logo.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{auth()->user()->name}}</a>
                    </div>
                </div>


                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <li class="nav-item menu-open">
                            <router-link to="/users" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Users
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </router-link>

                            <router-link to="/profile/{{auth()->user()->id}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    My Profile
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </router-link>

                            <router-link to="#" class="nav-link ">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Transactions
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </router-link>

                            <router-link to="#" class="nav-link ">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Logs
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </router-link>


                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="nav-link ">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Logout
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        </li>
                    </ul>
                </nav>

            </div>

        </aside>

        <div class="content-wrapper">

            <div class="content">
                <div class="container-fluid p-5">
                    <router-view></router-view>
                </div>
            </div>

        </div>




        <footer class="main-footer">

            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>

            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>
    </div>


    <script src="{{mix('js/app.js')}}"></script>
</body>

</html>