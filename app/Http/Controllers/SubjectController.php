<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\Subject;
use App\Models\Group;
use App\Models\User;
use Validator;
use Str;
use Carbon\Carbon;

class SubjectController extends Controller
{
  public function index()
  {
    $query = auth()->user()->subjects()
      ->orderBy('status', 'desc')
      ->orderBy('start', 'asc')
      ->paginate(20)
      ->appends($_GET);
    $data = [
      'title' => 'Daftar Subject Voting',
      'data' => $query
    ];

    return view('admin.subject.index', $data);
  }

  public function create()
  {
    $data = [
      'title' => 'Tambah Subject',
      'group' => Group::all(),
    ];

    return view('admin.subject.create', $data);
  }

  public function store(Request $r)
  {
    $roles = [
      'name' => 'required',
      'time' => 'required',
    ];
    $messages = [
      'name.required' => 'Nama Subject harus diisi',
      'time.required' => 'Waktu voting harus diisi',
    ];

    Validator::make($r->all(), $roles, $messages)->validate();

    $range = explode(" - ", $r->time);
    $start = Carbon::createFromFormat('d/m/Y H:i', $range[0]);
    $end = Carbon::createFromFormat('d/m/Y H:i', $range[1]);

    $participants = $r->participants ? User::whereIn('group_id', $r->participants)->select('id')->get()->pluck('id') : [];

    $insert = new Subject;
    $insert->uuid = (string) Str::uuid();
    $insert->name = $r->name;
    $insert->description = $r->description;
    $insert->author = auth()->user()->id;
    $insert->start = $start;
    $insert->end = $end;
    $insert->status = $r->status;
    if ($insert->save()) {
      $insert->participants()->sync($participants);
      return redirect()->route('admin.subject.index')->with('message', 'Data berhasil disimpan');
    }
    return redirect()->back()->withErrors('Tidak dapat menyimpan data');
  }

  public function edit($uuid)
  {
    $query = auth()->user()->subjects->where('uuid', $uuid)->first();
    $data = [
      'title' => 'Edit Subject (' . $query->name . ')',
      'group' => Group::all(),
      'group_id' => $query->participants()->select('group_id')->get()->pluck('group_id')->toArray(),
      'data' => $query,
    ];

    return view('admin.subject.edit', $data);
  }

  public function update(Request $r, $uuid)
  {
    $roles = [
      'name' => 'required',
      'time' => 'required',
    ];
    $messages = [
      'name.required' => 'Nama Subject harus diisi',
      'time.required' => 'Waktu voting harus diisi',
    ];

    Validator::make($r->all(), $roles, $messages)->validate();

    $range = explode(" - ", $r->time);
    $start = Carbon::createFromFormat('d/m/Y H:i', $range[0]);
    $end = Carbon::createFromFormat('d/m/Y H:i', $range[1]);

    $participants = $r->participants ? User::whereIn('group_id', $r->participants)->select('id')->get()->pluck('id') : [];

    $insert = auth()->user()->subjects->where('uuid', $uuid)->first();
    $insert->name = $r->name;
    $insert->description = $r->description;
    $insert->start = $start;
    $insert->end = $end;
    $insert->status = $r->status;
    if ($insert->save()) {
      $insert->participants()->sync($participants);
      return redirect()->route('admin.subject.index')->with('message', 'Data berhasil disimpan');
    }
    return redirect()->back()->withErrors('Tidak dapat menyimpan data');
  }

  public function destroy($uuid)
  {
    $query = Subject::where('uuid', $uuid)->first();
    if ($query->delete()) {
      $query->participants()->detach();
      $query->voters()->detach();
      return redirect()->route('admin.subject.index')->with('message', 'Data berhasil dihapus');
    }
  }

  public function show($uuid)
  {
    $subject = auth()->user()->subjects->where('uuid', $uuid)->first();
    $data = [
      'title' => 'Detail (' . $subject->name . ')',
      'subject' => $subject,
    ];

    return view('admin.subject.show', $data);
  }
}
