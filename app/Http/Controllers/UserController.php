<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Group;
use Validator;
use Str;

class UserController extends Controller
{
  public function index()
  {
    $query = User::where('id','!=',auth()->user()->id)
    ->orderBy('created_at','asc')
    ->paginate(20)
    ->appends($_GET);
    $data = [
      'title' => 'Daftar User',
      'data' => $query,
    ];

    return view('admin.user.index',$data);
  }

  public function create()
  {
    $data = [
      'title' => 'Tambah User',
      'group' => Group::orderBy('created_at','asc')->get(),
    ];

    return view('admin.user.create',$data);
  }

  public function store(Request $r)
  {
    $roles = [
      'name' => 'required',
      'username' => 'required|unique:users,username',
      'password' => 'required',
      'role' => 'required',
    ];
    $messages = [
      'name.required' => 'Nama User harus diisi',
      'username.required' => 'Username harus diisi',
      'username.unique' => 'Username telah digunakan',
      'password.required' => 'Password harus diisi',
      'role.required' => 'Role harus dipilih',
    ];

    Validator::make($r->all(),$roles,$messages)->validate();

    $insert = new User;
    $insert->uuid = (string) Str::uuid();
    $insert->name = $r->name;
    $insert->username = $r->username;
    $insert->password = bcrypt($r->password);
    $insert->group_id = $r->group;
    $insert->role = $r->role;
    if ($insert->save()) {
      return redirect()->route('admin.user.index')->with('message','Data berhasil disimpan');
    }
    return redirect()->back()->withErrors('Tidak dapat menyimpan data');
  }

  public function edit($uuid)
  {
    $query = User::where('uuid',$uuid)->first();
    $data = [
      'title' => 'Edit User',
      'data' => $query,
      'group' => Group::orderBy('created_at','asc')->get(),
    ];

    return view('admin.user.edit',$data);
  }

  public function update(Request $r,$uuid)
  {
    $roles = [
      'name' => 'required',
      'username' => 'required|unique:users,username,'.$uuid.',uuid',
      'role' => 'required',
    ];
    $messages = [
      'name.required' => 'Nama User harus diisi',
      'username.required' => 'Username harus diisi',
      'username.unique' => 'Username telah digunakan',
      'role.required' => 'Role harus dipilih',
    ];

    Validator::make($r->all(),$roles,$messages)->validate();

    $insert = User::where('uuid',$uuid)->first();
    $insert->name = $r->name;
    $insert->username = $r->username;
    if ($r->password) {
      $insert->password = bcrypt($r->password);
    }
    $insert->group_id = $r->group;
    $insert->role = $r->role;
    if ($insert->save()) {
      return redirect()->route('admin.user.index')->with('message','Data berhasil disimpan');
    }
    return redirect()->back()->withErrors('Tidak dapat menyimpan data');
  }

  public function destroy($uuid)
  {
    $query = User::where('uuid',$uuid)->first();
    if ($query->delete()) {
      $query->choiceBySubject()->detach();
      $query->participants()->detach();
      return redirect()->route('admin.user.index')->with('message','Data berhasil dihapus');
    }
  }

  public function import(Request $r)
  {
    if ($r->hasFile('batch') && $r->batch->extension() == 'txt') {
      $file = fopen($r->batch->path(),'r');
      $header = fgetcsv($file,1000,',');
      $data = [];
      while (($csv = fgetcsv($file,1000,',')) !== false) {
        $part = [];
        foreach ($csv as $key => $p) {
          $part[$header[$key]] = $p;
        }
        array_push($data,$part);
      }
      fclose($file);

      $c = 0;
      foreach ($data as $key => $u) {
        $group_id = null;
        if ($u['grup']!='') {
          $group = Group::where('name',$u['grup'])->first();
          if ($group) {
            $group_id = $group->id;
          }else {
            $group = new Group;
            $group->uuid = (string) Str::uuid();
            $group->name = $u['grup'];
            $group->save();
            $group_id = $group->id;
          }
        }
        $user = User::where('username',$u['username'])->first();
        if (!$user) {
          $user = new User;
          $user->uuid = (string) Str::uuid();
        }
        $user->username = $u['username'];
        $user->password = bcrypt($u['password']);
        $user->name = $u['nama'];
        $user->group_id = $group_id;
        $user->role = $u['role'];
        if ($user->save()) {
          $c++;
        }
      }
      return redirect()->route('admin.user.index')->with('message',$c.' Data berhasil diimport');
    }
    return redirect()->back()->withErrors('Tidak dapat menyimpan data');
  }
}
