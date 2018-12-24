<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Id Watch </title>

        <link type="text/css" href="{{ asset('adminHelper/bootstrap.min.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('adminHelper/bootstrap-responsive.min.css') }}" rel="stylesheet">
        <link href="{{ asset('adminHelper/theme.css') }}" rel="stylesheet">
        <link href="{{ asset('adminHelper/style.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('adminHelper/icons/css/font-awesome.css') }}" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
</head>
<body>
    <div id="mainLayout">
        <app-layout></app-layout>
    </div>
</body>
    <script src="{{ asset('js/init.js') }}"></script>
    <script src="{{ asset('adminHelper/jquery-ui-1.10.1.custom.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('adminHelper/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('adminHelper/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('adminHelper/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
        <script src="{{ asset('adminHelper/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
        <script src="{{ asset('adminHelper/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
        <script src="{{ asset('adminHelper/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>

    <script src="{{ asset('js/app.js') }}"></script>
</html>
