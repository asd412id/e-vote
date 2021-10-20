@extends('layout')
@section('content')
<div class="card bg-danger text-center text-light rounded-0 border-0">
  <div class="card-header">
    <span class="h5">{{ $title }}</span>
  </div>
  <div class="card-body bg-white text-dark">
    <h2 class="text-center mb-3">Jumlah Suara yang Masuk: {{ $subject->progress() }}%</h2>

    @foreach ($subject->candidates as $key => $c)
    <div class="col-md-{{12/count($subject->candidates)}} col-12 mb-3 float-left">
      <div class="card">
        <div class="card-body text-center h4" style="height: 270px">
          <img src="{{ \Storage::disk('public')->url(@$c->opt['photo']) }}" alt=""
            class="photo img-thumbnail img-fluid h-100 w-auto">
        </div>
        <div class="card-footer text-center h5">
          <em class="d-block mx-auto border mb-1 p-1">{{ $subject->candidateProgress($c->id) }}%</em>
          <span class="d-block">{{ ($key+1).'. '.$c->name }}</span>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
@section('foot')
<script>
  setTimeout(()=>{
      location.reload();
    },60000)
</script>
@endsection