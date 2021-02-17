@extends('admin')
@section('admin_content')
  <div class="card bg-danger text-light">
    <div class="card-header">
      <span class="h5">{{ $title }}</span>
      <div class="d-inline-block float-right">
        <form action="{{ route('admin.user.import') }}" id="fbatch" enctype="multipart/form-data" method="post" class="d-inline-block mr-1">
          @csrf
          <input type="file" name="batch" class="d-none" id="batch" accept=".csv" onchange="$('#fbatch').submit()">
          <button type="button" class="btn btn-sm btn-secondary" onclick="$('#batch').click()"><i class="fa fa-upload"></i> Import</button>
        </form>
        <a href="{{ route('admin.user.create') }}" class="btn btn-sm btn-light text-danger float-right"><i class="fa fa-plus"></i> Tambah Data</a>
      </div>
    </div>
    <div class="card-body bg-white text-black">
      @if (session()->has('message'))
        <div class="font-weight-bold text-success mb-3">
          {{ session()->get('message') }}
        </div>
      @endif
      <table class="table table-hover table-striped">
        <thead class="bg-danger text-light">
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Grup</th>
            <th>Role</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @if (count($data))
            @foreach ($data as $key => $v)
              <tr>
                <td class="text-center">{{ ($data->firstItem()+$key).'.' }}</td>
                <td width="30%">{{ $v->name??'-' }}</td>
                <td width="30%">{{ $v->username??'-' }}</td>
                <td width="30%">{{ $v->group->name??'-' }}</td>
                <td width="30%" class="text-capitalize">{{ $v->role??'-' }}</td>
                <td>
                  <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <a href="{{ route('admin.user.edit',['uuid'=>$v->uuid]) }}" class="btn btn-info" title="Edit"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('admin.user.destroy',['uuid'=>$v->uuid]) }}" class="btn btn-danger confirm" title="Hapus" data-text="Yakin ingin menghapus?"><i class="fa fa-trash"></i></a>
                  </div>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="6" class="text-center text-danger font-weight-bold">Data tidak tersedia</td>
            </tr>
          @endif
        </tbody>
      </table>
      @if ($data->hasPages())
        <div class="text-right">
          <div class="d-inline-block">
            {!! $data->links() !!}
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection
