@extends('admin')
@section('admin_content')
  <div class="card bg-danger text-light">
    <div class="card-header">
      <span class="h5">{{ $title }}</span>
      <a href="{{ route('admin.candidate.create',['subject_uuid'=>$subject_uuid])}}" class="btn btn-sm btn-light text-danger float-right"><i class="fa fa-plus"></i> Tambah Data</a>
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
            <th>Foto</th>
            <th>Nama</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @if (count($data))
            @foreach ($data as $key => $v)
              <tr>
                <td class="text-center">{{ ($data->firstItem()+$key).'.' }}</td>
                <td width="30%">
                  <img src="{{ \Storage::disk('public')->url(@$v->opt['photo']) }}" width="100" alt="">
                </td>
                <td width="70%">{{ $v->name??'-' }}</td>
                <td>
                  <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <a href="{{ route('admin.candidate.edit',['subject_uuid'=>$v->subject->uuid,'uuid'=>$v->uuid]) }}" class="btn btn-info" title="Edit"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('admin.candidate.destroy',['subject_uuid'=>$v->subject->uuid,'uuid'=>$v->uuid]) }}" class="btn btn-danger confirm" title="Hapus" data-text="Yakin ingin menghapus?"><i class="fa fa-trash"></i></a>
                  </div>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="4" class="text-center text-danger font-weight-bold">Data tidak tersedia</td>
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
