<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConferenceResource;
use App\Models\Conference;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rule;

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

        return ConferenceResource::collection($query->get())->additional([
            'total' => Conference::count()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:50',
            'host_prefix' => ['required', 'string', 'max:25', 'regex:/^[a-z0-9-]+$/', 'unique:conferences,host_prefix']
        ]);

        return new ConferenceResource($request->user()->conferences()->create($data));
    }

    public function hostPrefix(Request $request)
    {
        $data = $request->validate([
            'value' => ['required', 'string', 'max:25']
        ]);

        return new JsonResource([
            'id' => Conference::where('host_prefix', $data['value'])->first()?->id ?? null
        ]);
    }

    public function show(Conference $conference)
    {
        return new ConferenceResource($conference);
    }

    public function update(Request $request, Conference $conference)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:50',
            'host_prefix' => [
                'required',
                'string',
                'max:25',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('conferences', 'host_prefix')->ignore($conference->id)
            ]
        ]);

        $conference->update($data);
    }

    public function destroy(Conference $conference)
    {
        $conference->delete();
    }
}
