@extends('admin')
@section('admin_content')
  <div class="row">
    <div class="col-md-6">
      <div class="card bg-danger text-white">
        <div class="card-header">
          <span class="h5">{{ $title }}</span>
        </div>
        <div class="card-body bg-white text-dark">
          @if ($errors->any())
            <div class="text-center font-weight-bold text-danger mb-3">
              {!! implode(', ',$errors->all()) !!}
            </div>
          @endif
          <form method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="name">Nama Kandidat</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan nama Kandidat" value="{{ old('name') }}">
            </div>
            <div class="form-group">
              <label for="photo">Foto</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="photo" accept=".jpeg,.jpg,.png" class="custom-file-input" id="photo">
                  <label class="custom-file-label" for="photo">Pilih Foto</label>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-danger">Simpan</button>
            <a href="{{ route('admin.candidate.index',['subject_uuid'=>$subject_uuid]) }}" name="description" class="btn btn-dark">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
