<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable;

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'uuid',
    'name',
    'username',
    'password',
    'role',
    'group_id',
    'opt',
  ];

  /**
  * The attributes that should be hidden for arrays.
  *
  * @var array
  */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
  * The attributes that should be cast to native types.
  *
  * @var array
  */
  protected $casts = [
    'opt' => 'array',
  ];

  public function getOptAttribute($value)
  {
    return (object) $value;
  }

  public function group()
  {
    return $this->belongsTo(Group::class);
  }

  public function subjects()
  {
    return $this->hasMany(Subject::class,'author');
  }

  public function participants()
  {
    return $this->belongsToMany(Subject::class,'participants','user_id','subject_id');
  }

  public function choiceBySubject()
  {
    return $this->belongsToMany(Subject::class,'vote','user_id','subject_id');
  }

  public function choiceByCandidate()
  {
    return $this->belongsToMany(Candidate::class,'vote','user_id','candidate_id');
  }

  public function vote()
  {
    return $this->hasMany(Vote::class);
  }
}
