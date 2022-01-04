<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class ScoreboardController extends Controller
{
    public function index()
    {
        $departments = Department::get();
        $users = User::with('attempt','department')->withCount('user_question','user_question_ans')->whereHas('attempt', function ($query) {
            $query->where('user_id', '!=', null);
        })->paginate(20);
        return view('backend.scoreboard.index',compact('users','departments'));
    }

    public function viewDetails(Request $request,$id)
    {
        $user = User::findOrFail($id)->with('attempt','attempt.quiz','attempt.userQuestionAnswer','department')->withCount('user_question','user_question_ans','attempt')->whereHas('attempt', function ($query) {
            $query->where('user_id', '!=', null);
        })->first();
        return view('backend.scoreboard.user-details')->with('user', $user);        
    }
}
