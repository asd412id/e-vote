@extends('admin')
@section('admin_content')
  <div class="card bg-danger text-light">
    <div class="card-header">
      <span class="h5">{{ $title }}</span>
      <a href="{{ route('admin.subject.index') }}" class="btn btn-sm btn-light text-danger float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body bg-white text-dark">
      <h2 class="text-center mb-3">Jumlah Suara yang Masuk: {{ $subject->progress() }}%</h2>

      @foreach ($subject->candidates as $key => $c)
        <div class="col-md-{{12/count($subject->candidates)}} col-12 mb-3 float-left">
          <div class="card">
            <div class="card-body text-center h4">{{ $subject->candidateProgress($c->id) }}%</div>
            <div class="card-footer text-center h5">{{ $c->name }}</div>
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
