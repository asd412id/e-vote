<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Str;

class Admin extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    $user = new User;
    $user->uuid = (string) Str::uuid();
    $user->name = 'Administrator';
    $user->username = 'admin';
    $user->password = bcrypt('Smpn39sinjai#');
    $user->role = 'admin';
    $user->save();
  }
}
