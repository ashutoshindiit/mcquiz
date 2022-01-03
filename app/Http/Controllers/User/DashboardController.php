<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Quiz;
use App\Models\User;
use App\Models\UserAttemptQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function filterData($from_date = "", $to_date="")
    {
        $user_id = Auth::user()->id;
        $department_id = Auth::user()->department_id;
        $data = [];
        $data['allquiz'] = Quiz::whereBetween('created_at',[$from_date, $to_date])->where('department_id',$department_id)->get()->count();
        $data['attemptquiz'] = UserAttemptQuiz::whereBetween('created_at',[$from_date, $to_date])->where('user_id',$user_id)->get()->count();
        return response()->json(['success'=>true,'data' =>$data]); 
    }   
}
