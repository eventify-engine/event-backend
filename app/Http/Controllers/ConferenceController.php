<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConferenceResource;
use App\Models\Conference;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'search' => 'nullable|string|max:255'
        ]);

        $query = Conference::query();

        $query->when($data['search'] ?? false, fn(Builder $when) => $when
            ->where('name', 'LIKE', "%{$data['search']}%")
        );

        return ConferenceResource::collection($query->get());
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

    public function update(Request $request, Conference $conference)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50'
        ]);

        $conference->update($data);
    }
}
