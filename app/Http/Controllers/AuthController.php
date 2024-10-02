<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|string|email|max:255',
            'password' => 'required|string|min:8|max:255'
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password))
            abort(401);

        return new JsonResource(['token' => $user->createToken('primary', expiresAt: now()->addDays(31))->plainTextToken]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:25',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8|max:255'
        ]);

        User::create([
            ...$data,
            'email' => Str::lower($data['email'])
        ]);
    }
}
