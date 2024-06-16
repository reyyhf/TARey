<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.jpeg') }}">
    <link rel="icon" href="{{ asset('assets/images/favicon.jpeg') }}" type="image/x-icon">

    <title>Aplikasi Penjadwalan</title>

    @vite(['resources/js/app.js', 'resources/css/app.scss'])
</head>

<body>
    <div id="app"></div>
</body>

</html>
