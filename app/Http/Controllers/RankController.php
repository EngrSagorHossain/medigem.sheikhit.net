<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rank;

class RankController extends Controller
{
    //make rank
    public function makeRank(Request $request){
        $rank = new Rank();
        $rank->user_id = $request->user()->id;
        $rank->exam_id = $request->exam_id;
        $rank->score = $request->score;
        $rank->save();
        return response()->json(['rank' => $rank], 201);
    }

    
    public function getRanksOnExamId(Request $request, $exam_id)
    {
        $ranks = Rank::with(['user', 'exam'])
                     ->where('exam_id', $exam_id)
                     ->orderBy('score', 'desc')
                     ->get();
       
        return response()->json(['ranks' => $ranks], 200);
    }
    
}
