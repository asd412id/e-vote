<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\Subject;
use App\Models\Candidate;
use App\Models\Vote;
use Carbon\Carbon;

class VoteController extends Controller
{
  public function index()
  {
    $now = Carbon::now();
    $subject = auth()->user()->participants()->where('status',true)
    ->where('start','<=',$now->toDateTimeString())
    ->where('end','>=',$now->toDateTimeString())
    ->whereHas('candidates')
    ->get();
    $data = [
      'title' => 'Selamat Datang',
      'subject' => $subject
    ];

    return view('vote.index',$data);
  }

  public function voting($uuid)
  {
    $now = Carbon::now();
    $subject = auth()->user()->participants()->where('status',true)
    ->where('start','<=',$now->toDateTimeString())
    ->where('end','>=',$now->toDateTimeString())
    ->where('uuid',$uuid)
    ->whereHas('candidates')
    ->first();
    if (!$subject) {
      return redirect()->route('vote.index')->withErrors('Subjek voting tidak ditemukan');
    }
    $data = [
      'title' => 'Voting '.$subject->name,
      'subject' => $subject
    ];

    return view('vote.voting',$data);
  }

  public function votingSubmit(Request $r,$uuid)
  {
    $cek = Candidate::where('uuid',$r->choice)->first();
    if (!$cek) {
      return redirect()->route('vote.index')->withErrors('Kandidat tidak ditemukan');
    }
    $vote = new Vote;
    $vote->user_id = auth()->user()->id;
    $vote->subject_id = $cek->subject->id;
    $vote->candidate_id = $cek->id;
    if ($vote->save()) {
      return redirect()->back()->with('message','Terima kasih telah berpartisipasi');
    }
    return redirect()->back()->withErrors('Terjadi kesalahan! Voting tidak disimpan');
  }
}
