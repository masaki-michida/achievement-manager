<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Target;
use Carbon\Carbon;

class MypageController extends Controller
{

    public function index(){
        $newTarget = new Target();
        $users = User::all();
        $targets = Target::orderByDesc('created_at')->get();
        $created_at = Target::pluck('created_at')->toArray();
        $targetsCount = $targets->count();
        return view('mypage/index',compact('users','newTarget','targets','created_at','targetsCount'));
    }

    public function ajaxRequestPost(Request $request){
        $input = $request -> all();
        $target = new Target();

        $target->title = $request->title;
        $target->detail = $request->detail;
        $target->archievement = $request->archievement;
        $target-> user_id = 1;
        $target->save();
        $latestTarget = Target::orderByDesc('created_at')->first();
        $latestTargetTime = $latestTarget->created_at;
        return response()->json([$latestTarget,$latestTargetTime]);
    }
}
