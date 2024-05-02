<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $tasks = Task::where('author_id', Auth::user()->id)->get();
            return redirect()->route('dashboard')->with(['tasks' => Auth::user()->tasks]);
        }

        return "user not found!";
    }

    public function logout()
    {
        Auth::logout();
        return view('Auth.login');
    }
}
