<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <link rel="icon" href="{{asset('favicon.ico')}}">
    <meta name="description" content="O site Chick 10 tem como foco a venda de churros gourmet. Com isso, ofereça ao seu paladar uma nova experiência comprando os nossos churros.">
    <meta name="keywords" content="chick 10, chick10, churros, churros gourmet, sobremesa, gourmet">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chick 10 - Churros</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('bootstrap/bootstrap.min.css')}}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('css/global.css')}}">
    @yield('css')

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('fontawesome/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('fontawesome/solid.css')}}">
    <link rel="stylesheet" href="{{asset('fontawesome/brands.css')}}">
</head>
<body>

@yield('main')

<script src="{{asset('bootstrap/bootstrap.bundle.min.js')}}"></script>
@yield('js')
</body>
</html>