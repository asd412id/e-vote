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
          <form method="post" action="{{ route('admin.user.update',['uuid'=>$data->uuid]) }}">
            @csrf
            <div class="form-group">
              <label for="name">Nama</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan Nama Lengkap" value="{{ old('name')??$data->name }}">
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan Username" value="{{ old('username')??$data->username }}">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password" id="password" placeholder="Kosongkan jikat tidak ingin mengubah" value="">
            </div>
            <div class="form-group">
              <label for="group">Grup</label>
              <select class="form-control" name="group" id="group">
                <option  value="">Pilih Grup</option>
                @foreach ($group as $key => $v)
                  <option {{ (old('group')==$v->id || $data->group_id==$v->id)?'selected':'' }} value="{{ $v->id }}">{{ $v->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="role">Role</label>
              <select class="form-control" name="role" id="role">
                <option {{ (old('role')=='guest' || $data->role=='guest')?'selected':'' }} value="guest">Guest</option>
                <option {{ (old('role')=='admin' || $data->role=='admin')?'selected':'' }} value="admin">Admin</option>
              </select>
            </div>
            <button type="submit" class="btn btn-danger">Simpan</button>
            <a href="{{ route('admin.user.index') }}" name="description" class="btn btn-dark">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
