@extends('layout')
<h3 class="text-center pt-5">Selamat Datang</h3>
<h5 class="text-center">Silahkan Login untuk Melanjutkan</h5>

<div class="col-md-4 offset-md-4 col-12">
  @if ($errors->any())
    <div class="font-weight-bold text-danger text-center p-0 mb-0 mt-4">{!! implode('<br>',$errors->all()) !!}</div>
  @endif
  <form method="post">
    @csrf
    @if (request()->redirect)
      <input type="hidden" name="redirect" value="{{ request()->redirect }}">
    @endif
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan Username" required autofocus>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password" required>
    </div>
    <button type="submit" class="btn btn-success">Login</button>
  </form>
</div>
