<!doctype html>
<html lang="es">

<head>
  <title>Clinica!</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- Material Kit CSS -->
  <link href="{{asset('/css/material-kit.css?v=2.0.5')}}" rel="stylesheet" />
</head>

<body class="@yield('ClassBody')">
  <nav class="navbar navbar-color-on-scroll navbar-transparent fixed-top navbar-expand-lg" color-on-scroll="100">
    <div class="container">
      <div class="navbar-translate">
        <a class="navbar-brand" href="/">
          Clinica Maternal </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="sr-only">Toggle navigation</span>
          <span class="navbar-toggler-icon"></span>
          <span class="navbar-toggler-icon"></span>
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">

        @guest
            <li class="nav-item">
              <a href="{{route('home')}}" class="nav-link">
                <i class="material-icons">home</i> Home
              </a>
          </li>
        @else
            <li class="nav-item">
              <a href="{{route('logout')}}" class="nav-link">
                  <i class="material-icons">flight takeoff</i> Log out

              </a>
          </li>
        @endguest
            @guest
                <li class="nav-item">
                    <a href="{{route('login')}}" class="nav-link">
                        <i class="material-icons">account_box</i> Login
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link">
                        <i class="material-icons">apps</i> Dashboard
                    </a>
                </li>
            @endguest
        </ul>
      </div>
    </div>
  </nav>
  
  @section('header')
    <div class="page-header header-filter" data-parallax="true" style="background-image: url('./img/bg3.jpg')">
        <div class="container">
        <div class="row">
            <div class="col-md-8 ml-auto mr-auto">
            <div class="brand text-center">
                <h1>Las Palmeras</h1>
                <h3 class="title text-center">Estamos trabajando para ti</h3>
            </div>
            </div>
        </div>
        </div>
    </div>
  @show
  
  @section('MainContent')
    <div class="main main-raised">
        <div class="container">
            <div class="section text-center">
            <h2 class="title">
                @yield('content')
            </h2>
            </div>
        </div>
    </div>
  @show
  <footer class="footer footer-default">
    <div class="container">
      <nav class="float-left">
        <ul>
          <li>
            <a href="">
              KeePeer
            </a>
          </li>
        </ul>
      </nav>
      <div class="copyright float-right">
        &copy;
        <script>
          document.write(new Date().getFullYear())
        </script>, TADS <i class="material-icons">favorite</i> en
        <a href="" target="blank">Univesidad Don Bosco</a>
      </div>
    </div>
  </footer>
  @yield('scripts')
</body>

</html>