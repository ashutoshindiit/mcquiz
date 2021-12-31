<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function test()
    {
        
        if(Auth::check()){
            $user = Auth::user();
            echo $user->id;
            $my_role = Role::where('id', '=', 1)->firstOrFail();
            echo "<pre>";
            print_r($my_role);
            $user->assignRole($my_role); 
            $user->save();
            echo "test";
            print_r($user->roles);
        }
        if( Auth::user()->can('manage_role')){
            echo "yes";
        }
        else{
            echo "no";
        }
    }
}
