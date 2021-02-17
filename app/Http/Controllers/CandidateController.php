<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\Subject;
use App\Models\Candidate;
use App\Models\User;
use Validator;
use Str;
use Carbon\Carbon;

class CandidateController extends Controller
{
  public function index($subject_uuid)
  {
    $subject = auth()->user()->subjects()
    ->where('uuid',$subject_uuid)->first();
    $query = $subject->candidates()
    ->orderBy('created_at','asc')
    ->paginate(20)
    ->appends($_GET);
    $data = [
      'title' => 'Daftar Kandidat '.$subject->name,
      'data' => $query,
      'subject_uuid' => $subject_uuid,
    ];

    return view('admin.candidate.index',$data);
  }

  public function create($subject_uuid)
  {
    $data = [
      'title' => 'Tambah Kandidat',
      'subject_uuid' => $subject_uuid,
    ];

    return view('admin.candidate.create',$data);
  }

  public function store(Request $r,$subject_uuid)
  {
    $roles = [
      'name' => 'required',
    ];
    $messages = [
      'name.required' => 'Nama Kandidat harus diisi',
    ];

    $subject = auth()->user()->subjects->where('uuid',$subject_uuid)->first();

    $insert = new Candidate;
    $insert->uuid = (string) Str::uuid();
    $insert->name = $r->name;
    $insert->subject_id = $subject->id;
    if ($r->hasFile('photo')) {
      $ext = ['jpeg','jpg','png'];
      if (in_array($r->photo->extension(),$ext)) {
        $photo = $r->photo->store('photo','public');
        $insert->opt = ['photo' => $photo];
      }
    }
    if ($insert->save()) {
      return redirect()->route('admin.candidate.index',['subject_uuid'=>$subject_uuid])->with('message','Data berhasil disimpan');
    }
    return redirect()->back()->withErrors('Tidak dapat menyimpan data');
  }

  public function edit($subject_uuid,$uuid)
  {
    $query = Candidate::where('uuid',$uuid)->first();
    $data = [
      'title' => 'Edit Kandidat ('.$query->name.')',
      'data' => $query,
      'subject_uuid' => $subject_uuid,
    ];

    return view('admin.candidate.edit',$data);
  }

  public function update(Request $r,$subject_uuid,$uuid)
  {
    $roles = [
      'name' => 'required',
    ];
    $messages = [
      'name.required' => 'Nama Kandidat harus diisi',
    ];

    $subject = auth()->user()->subjects->where('uuid',$subject_uuid)->first();

    $insert = Candidate::where('uuid',$uuid)->first();
    $insert->name = $r->name;

    if ($r->hasFile('photo')) {
      $ext = ['jpeg','jpg','png'];
      if (in_array($r->photo->extension(),$ext)) {
        \Storage::disk('public')->delete(@$insert->opt['photo']);
        $photo = $r->photo->store('photo','public');
        $insert->opt = ['photo' => $photo];
      }
    }

    if ($insert->save()) {
      return redirect()->route('admin.candidate.index',['subject_uuid'=>$subject_uuid])->with('message','Data berhasil disimpan');
    }
    return redirect()->back()->withErrors('Tidak dapat menyimpan data');
  }

  public function destroy($subject_uuid,$uuid)
  {
    $query = Candidate::where('uuid',$uuid)->first();
    if ($query->delete()) {
      \Storage::disk('public')->delete($query->opt['photo']);
      $query->voters()->detach();
      return redirect()->route('admin.candidate.index',['subject_uuid'=>$subject_uuid])->with('message','Data berhasil dihapus');
    }
  }
}
