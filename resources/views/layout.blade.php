<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ strip_tags($title) }}</title>
  <link rel="stylesheet" href="{{ asset('vendors/bootstrap/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/fontawesome/css/all.min.css') }}">
  @yield('css')
  <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}">
  @yield('head')
</head>

<body>
  @yield('content')
  <script src="{{ asset('js/jquery.min.js') }}" charset="utf-8"></script>
  <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}" charset="utf-8"></script>
  @yield('script')
  <script src="{{ asset('js/scripts.js') }}" charset="utf-8"></script>
  @yield('foot')
</body>

</html>