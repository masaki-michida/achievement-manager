<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Target;
use App\Models\Goal;
use Carbon\Carbon;

class MypageController extends Controller
{

    public function index(){
        $newTarget = new Target();
        $newGoal = new Goal();

        $users = User::all();
        $targets = Target::with('goals')->orderByDesc('created_at')->get();
        $created_at = Target::pluck('created_at')->toArray();
        $targetsCount = $targets->count();
        return view('mypage/index',compact('users','newTarget','targets','created_at','targetsCount','newGoal'));
    }

    public function ajaxRequestPost(Request $request){
        $target = new Target();
        $goal = new Goal();

        $target->title = $request->title;
        $target->detail = $request->detail;
        $target->archievement = 0;
        $target-> user_id = 1;
        $target->save();

        $goal->title = $request->goal;
        $goal->user_id = 1;
        $goal->target_id = $target->id;
        $goal->save();

        $latestTarget = Target::orderByDesc('created_at')->first();
        $latestTargetTime = $latestTarget->created_at;

        return response()->json([$latestTarget,$latestTargetTime,$goal->title]);
    }
}
