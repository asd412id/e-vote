<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
  use HasFactory;

  protected $table = 'candidates';
  protected $fillable = [
    'uuid',
    'subject_id',
    'name',
    'opt',
  ];

  protected $casts = [
    'opt' => 'array',
  ];

  public function subject()
  {
    return $this->belongsTo(Subject::class,'subject_id');
  }

  public function voters()
  {
    return $this->belongsToMany(User::class,'vote','candidate_id','user_id');
  }
}
