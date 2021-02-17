<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Validator;

class MainController extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function login($redirect=null)
  {
    $data = [
      'title' => 'Halaman Login',
    ];

    return view('login',$data);
  }

  public function loginProcess()
  {
    $r = request();
    $roles = [
      'username' => 'required',
      'password' => 'required',
    ];

    $messages = [
      'username.required' => 'Username harus diisi!',
      'password.required' => 'Password harus diisi!',
    ];

    Validator::make($r->all(),$roles,$messages)->validate();

    $credential = [
      'username' => $r->username,
      'password' => $r->password,
    ];
    if (auth()->attempt($credential,true)) {
      return $r->redirect ? redirect(urldecode($r->redirect)) : redirect()->back();
    }
    return redirect()->back()->withErrors('Username atau password tidak benar!');
  }

  public function logout()
  {
    auth()->logout();
    return redirect()->route('login');
  }

  public function adminDashboard()
  {
    $data = [
      'title' => 'Beranda Admin'
    ];

    return view('admin.dashboard',$data);
  }
}
