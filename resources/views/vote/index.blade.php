@extends('layout')
<h1 class="text-center pt-5">Selamat Datang</h1>
<h4 class="text-center">{{ auth()->user()->name }}</h4>

<div class="col-md-4 offset-md-4 col-12 mt-3">
  @if ($errors->any())
    <div class="font-weight-bold text-danger text-center p-0 mb-0 mb-3">{!! implode('<br>',$errors->all()) !!}</div>
  @endif
  <div class="card card-body">
    @if (count($subject))
      <div class="text-center h5">Klik pilihan di bawah untuk mulai melakukan voting online</div>

      @foreach ($subject as $key => $s)
        <a href="{{ route('vote.voting',['uuid'=>$s->uuid]) }}" class="d-block btn btn-lg btn-danger mt-2">
          {{ $s->name }}
        </a>
      @endforeach
    @else
      <div class="text-center h5">Tidak ada subject voting saat ini</div>
    @endif
  </div>
  <div class="text-center my-3">
    <a href="{{ route('logout') }}" class="btn btn-secondary confirm" data-text="Yakin ingin keluar? Pastikan Anda sudah melakukan voting">Keluar</a>
  </div>
</div>
