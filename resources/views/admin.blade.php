@extends('layout')
@section('css')
  <link rel="stylesheet" href="{{ asset('vendors') }}/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="{{ asset('vendors') }}/daterangepicker/daterangepicker.css">
@endsection
@section('content')
  <div id="header">
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-danger">
      <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Halaman Admin</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i>&nbsp;&nbsp;{{ auth()->user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="{{ route('logout') }}"><i class="fa fa-sign-out-alt"></i> Logout</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </div>
  <div id="sidebar">
    <div class="d-flex flex-row">
      <div class="pt-1 bg-primary flex-fill"></div>
      <div class="pt-1 bg-secondary flex-fill"></div>
      <div class="pt-1 bg-success flex-fill"></div>
      <div class="pt-1 bg-danger flex-fill"></div>
      <div class="pt-1 bg-warning flex-fill"></div>
      <div class="pt-1 bg-info flex-fill"></div>
      <div class="pt-1 bg-light flex-fill"></div>
      <div class="pt-1 bg-dark flex-fill"></div>
    </div>
    <ul class="nav nav-pills danger flex-column">
      @php
      $menus = [
        'Grup' => route('admin.group.index'),
        'User' => route('admin.user.index'),
        'Subject' => route('admin.subject.index'),
      ];
      @endphp
      <li class="nav-item">
        <a class="nav-link{{ request()->url() == route('admin.dashboard') ? ' active':'' }}" href="{{ route('admin.dashboard') }}">Beranda</a>
      </li>
      @foreach ($menus as $key => $m)
        <li class="nav-item">
          <a class="nav-link{{ strpos(request()->url(),$m) !== false ? ' active':'' }}" href="{{ $m }}">{{ $key }}</a>
        </li>
      @endforeach
    </ul>
  </div>
  <div id="admin-content" class="p-3">
    @yield('admin_content')
  </div>
@endsection
@section('script')
  <script src="{{ asset('vendors') }}/moment/moment.min.js"></script>
  <script src="{{ asset('vendors') }}/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <script src="{{ asset('vendors') }}/daterangepicker/daterangepicker.js"></script>
@endsection
