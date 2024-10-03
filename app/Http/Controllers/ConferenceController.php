<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConferenceResource;
use App\Models\Conference;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    public function index()
    {
        return ConferenceResource::collection(Conference::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50'
        ]);

        return new ConferenceResource($request->user()->conferences()->create($data));
    }

    public function show(Conference $conference)
    {
        return new ConferenceResource($conference);
    }
}
