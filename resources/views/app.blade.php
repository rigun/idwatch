<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Id Watch </title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <link href="{{ asset('helper/line-icon/css/simple-line-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('helper/elegant-icon/style.css') }}" rel="stylesheet">
    <link href="{{ asset('helper/revolution/css/settings.css') }}" rel="stylesheet">
    <link href="{{ asset('helper/revolution/css/layers.css') }}" rel="stylesheet">
    <link href="{{ asset('helper/revolution/css/navigation.css') }}" rel="stylesheet">
    <link href="{{ asset('helper/owl-carousel/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('helper/bootstrap-selector/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('helper/jquery-ui/jquery-ui.css') }}"rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div id="mainLayout">
        <app-layout></app-layout>
    </div>
</body>
    <script src="{{ asset('js/init.js') }}"></script>
    <script src="{{ asset('helper/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('helper/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
    <script src="{{ asset('helper/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script src="{{ asset('helper/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
    <script src="{{ asset('helper/revolution/js/extensions/revolution.extension.video.min.js') }}"></script>
    <script src="{{ asset('helper/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
    <script src="{{ asset('helper/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
    <script src="{{ asset('helper/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
    <script src="{{ asset('helper/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
    <script src="{{ asset('helper/counterup/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('helper/counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('helper/bootstrap-selector/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('helper/image-dropdown/jquery.dd.min.js') }}"></script>
    <script src="{{ asset('helper/isotope/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('helper/isotope/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('helper/magnify-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('helper/vertical-slider/js/jQuery.verticalCarousel.js') }}"></script>
    <script src="{{ asset('helper/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/smoothscroll.js') }}"></script>
    <!-- <script src="{{ asset('js/theme.js') }}"></script> -->
    <script src="{{ asset('js/app.js') }}"></script>


</html>
