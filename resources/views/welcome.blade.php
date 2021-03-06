<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    @if (config('app.env')=='production')
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Book Self</title>
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet" />
    <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
    <style>
        #nprogress .bar {
            background: #29d !important;
        }
    </style>
</head>
<body>
<div id="app" >
    <v-app>
        <app-home></app-home>
    </v-app>
</div>
<script src="{{mix('js/app.js')}}"></script>
</body>
</html>
