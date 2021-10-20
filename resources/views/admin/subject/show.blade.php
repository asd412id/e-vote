@extends('admin')
@section('admin_content')
<div class="card bg-danger text-light">
  <div class="card-header">
    <span class="h5">{{ $title }}</span>
    <a href="{{ route('admin.subject.index') }}" class="btn btn-sm btn-light text-danger float-right"><i
        class="fa fa-arrow-left"></i> Kembali</a>
  </div>
  <div class="card-body bg-white text-dark">
    <h2 class="text-center mb-3">Jumlah Suara yang Masuk: {{ $subject->progress() }}%</h2>

    @foreach ($subject->candidates as $key => $c)
    <div class="col-md-{{12/count($subject->candidates)}} col-12 mb-3 float-left">
      <div class="card">
        <div class="card-body text-center h4" style="height: 270px">
          <img src="{{ \Storage::disk('public')->url(@$c->opt['photo']) }}" alt=""
            class="photo img-thumbnail img-fluid h-100 w-100" style="object-fit: cover;object-position: top">
        </div>
        <div class="card-footer text-center h6">
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