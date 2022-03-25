<!doctype html>
<html lang="es">

<head>
    <title>Clinica</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--  Fonts and icons     -->
    {{-- <link href="/css/material-dashboard-vue.css" rel="stylesheet" > --}}
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic">
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
</head>

<body>
    <div id="app">
        @yield('content')
    </div>
</body>
<script src="{{asset('js/app.js')}}"></script>

</html>