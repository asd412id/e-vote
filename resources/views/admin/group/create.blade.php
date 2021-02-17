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
          <form method="post">
            @csrf
            <div class="form-group">
              <label for="name">Nama Grup</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan nama grup" value="{{ old('name') }}">
            </div>
            <div class="form-group">
              <label for="description">Deskripsi</label>
              <textarea name="description" rows="4" class="form-control" placeholder="Masukkan deskripsi grup">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-danger">Simpan</button>
            <a href="{{ route('admin.group.index') }}" name="description" class="btn btn-dark">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
