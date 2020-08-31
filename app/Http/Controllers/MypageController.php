<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Target;

class MypageController extends Controller
{
    
    public function index(){
        $target = new Target();
        $users = User::all();
        $targets = Target::all();
        return view('mypage/index',compact('users','targets','target'));
    }

    public function ajaxRequestPost(Request $request){
        $input = $request -> all();
        $target = new Target();

        $target->title = $request->title;
        $target->detail = $request->detail;
        $target->archievement = $request->archievement;
        $target-> user_id = 1;
        $target->save();
        return response()->json(['success'=>$input]);
    }
}
