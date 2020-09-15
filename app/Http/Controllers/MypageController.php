<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Target;
use App\Models\Goal;

class MypageController extends Controller
{

    public function index(){
        $newTarget = new Target();
        $newGoal = new Goal();

        $users = User::all();
        $targets = Target::with('goals')->orderByDesc('created_at')->get();
        $created_at = Target::pluck('created_at');
        $targetsCount = $targets->count();
        return view('mypage/index',compact('users','newTarget','targets','created_at','targetsCount','newGoal'));
    }

    public function ajaxRequestPost(Request $request){

        $target = new Target();
        $target->title = $request['title'];
        $target->detail = $request['detail'];
        $target->archievement = 0;
        $target->confirmation = 0;
        $target->complete = 0;
        $target-> user_id = 1;
        $target->save();

        $latestGoals = [];
        foreach($request['goal'] as $oneOfGoals){
        $goal = new Goal();
        $goal->title = $oneOfGoals;
        $goal->checked = 0;
        $goal->user_id = 1;
        $goal->target_id = $target->id;
        $goal->save();
        $latestGoals[] = $goal;
        }

        $latestTarget = Target::orderByDesc('created_at')->first();
        $latestTargetTime = $latestTarget->created_at;

        return response()->json([$latestTarget,$latestTargetTime,$latestGoals]);
    }
    public function ajaxCheckBox(Request $request){

        $id = $request['id'];
        $goal = Goal::find($id);
        $goal->checked=$goal->checked==0 ? 1:0;
        $goal->update();

        $targetId = $goal->target_id;
        $target = Target::find($targetId);
        $allGoals = Target::with('goals')->find($targetId)->goals->count();
        $checkedGoals = Target::with('goals')->find($targetId)->goals->where('checked',1)->count();
        $target->archievement = 100*$checkedGoals/$allGoals;
        $target->confirmation = $target->archievement==100 ? 1:0;
        $target->update();

        return response()->json([$target]);
    }

    public function ajaxCompTarget(Request $request){
        $target = Target::find($request['id']);
        $target->complete = 1;
        $target->update();
    }
}
