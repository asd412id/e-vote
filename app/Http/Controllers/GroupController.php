<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\Group;
use Validator;
use Str;

class GroupController extends Controller
{
  public function index()
  {
    $query = Group::orderBy('created_at','asc')
    ->paginate(20)
    ->appends($_GET);
    $data = [
      'title' => 'Daftar Grup',
      'data' => $query
    ];

    return view('admin.group.index',$data);
  }

  public function create()
  {
    $data = [
      'title' => 'Tambah Grup',
    ];

    return view('admin.group.create',$data);
  }

  public function store(Request $r)
  {
    $roles = [
      'name' => 'required',
    ];
    $messages = [
      'name.required' => 'Nama Grup harus diisi',
    ];

    Validator::make($r->all(),$roles,$messages)->validate();

    $insert = new Group;
    $insert->uuid = (string) Str::uuid();
    $insert->name = $r->name;
    $insert->description = $r->description;
    if ($insert->save()) {
      return redirect()->route('admin.group.index')->with('message','Data berhasil disimpan');
    }
    return redirect()->back()->withErrors('Tidak dapat menyimpan data');
  }

  public function edit($uuid)
  {
    $query = Group::where('uuid',$uuid)->first();
    $data = [
      'title' => 'Edit Grup',
      'data' => $query
    ];

    return view('admin.group.edit',$data);
  }

  public function update(Request $r,$uuid)
  {
    $roles = [
      'name' => 'required',
    ];
    $messages = [
      'name.required' => 'Nama Grup harus diisi',
    ];

    Validator::make($r->all(),$roles,$messages)->validate();

    $insert = Group::where('uuid',$uuid)->first();
    $insert->name = $r->name;
    $insert->description = $r->description;
    if ($insert->save()) {
      return redirect()->route('admin.group.index')->with('message','Data berhasil disimpan');
    }
    return redirect()->back()->withErrors('Tidak dapat menyimpan data');
  }

  public function destroy($uuid)
  {
    $query = Group::where('uuid',$uuid)->first();
    if ($query->delete()) {
      return redirect()->route('admin.group.index')->with('message','Data berhasil dihapus');
    }
  }
}
