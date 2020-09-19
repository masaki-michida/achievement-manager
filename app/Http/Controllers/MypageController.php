<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Target;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{

    public function index(){
        $newTarget = new Target();
        $newGoal = new Goal();
        $user = Auth::user()->id;

        $targets = Target::with('goals')->where('user_id',$user)->orderByDesc('created_at')->where('complete',0)->get();
        $created_at = Target::where('user_id',$user)->where('complete',0)->pluck('created_at');
        $targetsCount = $targets->count();
        return view('mypage/index',compact('newTarget','targets','created_at','targetsCount','newGoal'));
    }

    public function ajaxRequestPost(Request $request){

        $nullCounter = count($request['goal'],null);
        $notNull = count($request['goal']) - $nullCounter;

        $request['goal'] = ($nullCounter > 1)&&($notNull > 1) ? array_filter($request['goal']): $request['goal'];

        $validatedData = $request->validate([
            'title' => ['required','max:20'],
            'goal.*' =>['required','max:20'],
        ],
        [
            'required' => '必須入力です',
            'goal.*.required' => '一つ以上入力してください',
            'max' => '20文字以内で入力してください'
        ]);

        $target = new Target();
        $user = Auth::user()->id;

        $target->title = $request['title'];
        $target->detail = $request['detail'];
        $target->archievement = 0;
        $target->confirmation = 0;
        $target->complete = 0;
        $target-> user_id = $user;
        $target->save();

        $latestGoals = [];
        foreach($request['goal'] as $oneOfGoals){
        $goal = new Goal();
        $goal->title = $oneOfGoals;
        $goal->checked = 0;
        $goal->user_id = $user;
        $goal->target_id = $target->id;
        $goal->save();
        $latestGoals[] = $goal;
        }

        $latestTargetTime = $target->created_at;

        return response()->json([$target,$latestTargetTime,$latestGoals]);
    }
    public function ajaxCheckBox(Request $request){

        $id = $request['id'];
        $goal = Goal::find($id);
        $goal->checked=$goal->checked==0 ? 1:0;
        $goal->update();

        $targetId = $goal->target_id;
        $target = Target::with('goals')->find($targetId);
        $allGoals = $target->goals->count();
        $checkedGoals = $target->goals->where('checked',1)->count();
        $target->archievement = floor(100*$checkedGoals/$allGoals);
        $target->confirmation = $target->archievement==100 ? 1:0;
        $target->update();

        return response()->json([$target]);
    }

    public function ajaxCompTarget(Request $request,$id){
        $target = Target::find($id);
        $target->complete = 1;
        $target->update();
        return redirect("/mypage");
    }
}
