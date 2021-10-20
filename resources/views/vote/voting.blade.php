@extends('layout')
@section('content')
<h4 class="text-center pt-3">Selamat Datang</h4>
<h5 class="text-center">{{ auth()->user()->name }}</h5>
@if ($errors->any())
<div class="font-weight-bold text-danger text-center p-0 mb-0 mb-3">{!! implode('<br>',$errors->all()) !!}</div>
@endif
<div class="col-md-10 offset-md-1 col-12 mt-3" id="voting">
  <div class="text-center h1">{{ $subject->name }}</div>
  @if (count($subject->candidates) && !$subject->voters->where('id',auth()->user()->id)->first())
  <div class="h4 text-center mb-3">{!! $subject->description?nl2br($subject->description):'Yang mana yang Anda pilih?'
    !!}</div>
  <form action="" method="post" id="fchoice">
    @csrf
    <input type="hidden" name="choice" id="choice">
    @foreach ($subject->candidates as $key => $c)
    <div class="col-md-{{12/count($subject->candidates)}} col-12 mb-3 float-left">
      <div class="card candidate" id="{{ $c->uuid }}">
        <div class="card-body text-center">
          <img src="{{ \Storage::disk('public')->url(@$c->opt['photo']) }}" alt="" class="photo img-fluid img-thumbnail"
            style="object-fit: cover;object-position: top">
        </div>
        <div class="card-footer text-center font-weight-bold h6">
          {{ ($key+1).'. '.$c->name }}
        </div>
      </div>
    </div>
    @endforeach
    <div class="clearfix"></div>
    <div class="text-center">
      <button type="submit" class="btn btn-lg btn-danger" disabled>SIMPAN PILIHAN</button>
    </div>
  </form>
  @else
  @php
  $vote = auth()->user()->vote->where('subject_id',$subject->id)->first();
  @endphp
  <div class="h4 text-center mb-3">Terima Kasih telah Berpartisipasi dalam Pemungutan Suara {{ $subject->name }}</div>
  <div class="h4 text-center mb-3 text-danger">Anda telah melakukan pemungutan suara pada hari {{
    $vote->created_at->locale('id')->translatedFormat('l, j F Y') }} pukul {{ $vote->created_at->format('H:i') }}</div>
  <h2 class="text-center mb-3">Jumlah Suara yang Masuk: {{ $subject->progress() }}%</h2>

  @foreach ($subject->candidates as $key => $c)
  <div class="col-md-{{12/count($subject->candidates)}} col-12 mb-3 float-left">
    <div class="card">
      <div class="card-body text-center h4">{{ $subject->candidateProgress($c->id) }}%</div>
      <div class="card-footer text-center h5">{{ $c->name }}</div>
    </div>
  </div>
  @endforeach
  @endif
  <div class="text-center my-3">
    <a href="{{ route('vote.index') }}" class="btn btn-lg btn-dark">KEMBALI</a>
  </div>
</div>
@endsection
@section('foot')
@if ($subject->voters->where('id',auth()->user()->id)->first())
<script>
  setTimeout(()=>{
      location.reload();
    },60000)
</script>
@endif
@endsection