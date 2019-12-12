<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Level;
use App\LevelUser;

class UsersController extends Controller
{
    public function index() {
        $users = User::All();
        return response()->json($users);
    }

    public function show(Request $request) {
        try {
            $user = User::findOrFail($request->userId);
            return response()->json($user);
        } catch (\Exception $e) {
            dd('User not found', $e);
        }
    }
}
