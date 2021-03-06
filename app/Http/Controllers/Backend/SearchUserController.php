<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchUserController extends Controller
{
    public function search(Request $request)
    {
        $term = $request->name;

        $users = User::where('first_name', 'LIKE', '%'.$term.'%')
                        ->orWhere('last_name', 'LIKE', '%'.$term.'%')
                        ->orWhere('email', 'LIKE', '%'.$term.'%')
                        ->take(20)->get();

        return view('backend.users.search', ['users' => $users]);
    }

}
