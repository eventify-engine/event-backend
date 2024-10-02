<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return new JsonResource([
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email
        ]);
    }
}
