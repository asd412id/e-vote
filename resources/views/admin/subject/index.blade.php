@extends('admin')
@section('admin_content')
  <div class="card bg-danger text-light">
    <div class="card-header">
      <span class="h5">{{ $title }}</span>
      <a href="{{ route('admin.subject.create') }}" class="btn btn-sm btn-light text-danger float-right"><i class="fa fa-plus"></i> Tambah Data</a>
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
            <th>Deskripsi</th>
            <th>Mulai</th>
            <th>Selesai</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @if (count($data))
            @foreach ($data as $key => $v)
              <tr>
                <td class="text-center">{{ ($data->firstItem()+$key).'.' }}</td>
                <td width="30%">{{ $v->name??'-' }}</td>
                <td width="30%">{{ $v->description??'-' }}</td>
                <td width="20%">{{ $v->start->locale('id')->translatedFormat('d/m/Y H:i') }}</td>
                <td width="20%">{{ $v->end->locale('id')->translatedFormat('d/m/Y H:i') }}</td>
                <td width="20%">{!! $v->status?'<span class="badge badge-success">Aktif</span>':'<span class="badge badge-danger">Tidak Aktif</span>' !!}</td>
                <td>
                  <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <a href="{{ route('admin.subject.show',['uuid'=>$v->uuid]) }}" class="btn btn-info" title="Detail"><i class="fa fa-info-circle"></i></a>
                    <a href="{{ route('admin.candidate.index',['subject_uuid'=>$v->uuid]) }}" class="btn btn-warning" title="Participants"><i class="fa fa-users"></i></a>
                    <a href="{{ route('admin.subject.edit',['uuid'=>$v->uuid]) }}" class="btn btn-info" title="Edit"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('admin.subject.destroy',['uuid'=>$v->uuid]) }}" class="btn btn-danger confirm" title="Hapus" data-text="Yakin ingin menghapus?"><i class="fa fa-trash"></i></a>
                  </div>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="7" class="text-center text-danger font-weight-bold">Data tidak tersedia</td>
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
