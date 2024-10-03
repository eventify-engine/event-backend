<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Conference;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request, Conference $conference)
    {
        $data = $request->validate([
            'search' => 'nullable|string|max:255'
        ]);

        $query = $conference->events();

        $query->when($data['search'] ?? false, fn(Builder $when) => $when
            ->where('name', 'LIKE', "%{$data['search']}%")
        );

        return EventResource::collection($query->get());
    }

    public function store(Request $request, Conference $conference)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50'
        ]);

        return new EventResource($conference->events()->create($data));
    }

    public function show(Conference $conference, Event $event)
    {
        return new EventResource($event);
    }

    public function update(Request $request, Conference $conference, Event $event)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50'
        ]);

        $event->update($data);
    }

    public function destroy(Conference $conference, Event $event)
    {
        $event->delete();
    }
}
