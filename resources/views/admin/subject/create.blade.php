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
              <label for="name">Nama Subject</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan nama subject" value="{{ old('name') }}">
            </div>
            <div class="form-group">
              <label for="description">Deskripsi</label>
              <textarea name="description" rows="4" class="form-control" placeholder="Masukkan deskripsi subject">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
              <label for="time">Waktu Voting</label>
              <input type="text" class="form-control datepicker" name="time" id="time" placeholder="Masukkan masuk voting" value="{{ old('time') }}">
            </div>
            <div class="form-group">
              <label for="status">Status</label>
              <select class="form-control" name="status" id="status">
                <option {{ old('status')=='1'?'selected':'' }} value="1">Aktif</option>
                <option {{ old('status')=='0'?'selected':'' }} value="0">Tidak Aktif</option>
              </select>
            </div>
            <div class="form-group">
              <label for="participants">Partisipan</label>
              @foreach ($group as $key => $g)
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="participants[]" value="{{ $g->id }}" {{ @in_array($g->id,old('participants')) ? 'checked' : '' }} class="custom-control-input" id="{{ $g->uuid }}">
                  <label class="custom-control-label" for="{{ $g->uuid }}">{{ $g->name }}</label>
                </div>
              @endforeach
            </div>
            <button type="submit" class="btn btn-danger">Simpan</button>
            <a href="{{ route('admin.subject.index') }}" name="description" class="btn btn-dark">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
