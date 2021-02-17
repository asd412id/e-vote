<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
  use HasFactory;
  protected $table = 'subjects';
  protected $fillable = [
    'uuid',
    'name',
    'description',
    'author',
    'start',
    'end',
    'status',
  ];

  protected $dates = ['start','end','created_at','updated_at'];

  public function author()
  {
    return $this->belongsTo(User::class,'author');
  }

  public function participants()
  {
    return $this->belongsToMany(User::class,'participants','subject_id','user_id');
  }

  public function voters()
  {
    return $this->belongsToMany(User::class,'vote','subject_id','user_id');
  }

  public function candidates()
  {
    return $this->hasMany(Candidate::class,'subject_id');
  }

  public function getTimeAttribute()
  {
    return $this->start->format('d/m/Y H:i').' - '.$this->end->format('d/m/Y H:i');
  }

  public function progress()
  {
    $progress = $this->voters->count() / $this->participants->count() * 100;
    return round($progress,2);
  }

  public function candidateProgress($candidate_id)
  {
    $candidate = $this->candidates->where('id',$candidate_id)->first()
    ->voters->count();
    $progress = $candidate / $this->participants->count() * 100;
    return round($progress,2);
  }
}
