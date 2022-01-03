<?php

namespace App\Http\Controllers\Backend;

use App\Models\Option;
use App\Models\Question;
use App\Models\UserQuestionAnswer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    
    public function index()
    {
        $data = [];
        return view('backend.index', compact('data'));
    }

    public function filterData($from_date = "", $to_date="")
    {
        $data = [];
        $data['user_count'] = User::whereBetween('created_at',[$from_date, $to_date])->role('3')->get()->count();
        $data['admin_count'] = User::whereBetween('created_at',[$from_date, $to_date])->role('2')->get()->count();
        $data['department_count'] = Department::whereBetween('created_at',[$from_date, $to_date])->get()->count();
        $data['quiz_count'] = Quiz::whereBetween('created_at',[$from_date, $to_date])->get()->count();
        return response()->json(['success'=>true,'data' =>$data]); 
    }
}
