<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThreadResource;
use App\Models\Conference;
use App\Models\Event;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index(Request $request, Conference $conference, Event $event)
    {
        $data = $request->validate([
            'search' => 'nullable|string|max:255'
        ]);

        $query = $event->threads();

        $query->when($data['search'] ?? false, fn(Builder $when) => $when
            ->where('name', 'LIKE', "%{$data['search']}%")
        );

        return ThreadResource::collection($query->get())->additional([
            'total' => $event->threads()->count()
        ]);
    }

    public function store(Request $request, Conference $conference, Event $event)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50'
        ]);

        return new ThreadResource($event->threads()->create($data));
    }

    public function show(Conference $conference, Event $event, Thread $thread)
    {
        return new ThreadResource($thread);
    }

    public function update(Request $request, Conference $conference, Event $event, Thread $thread)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50'
        ]);

        $thread->update($data);
    }

    public function destroy(Conference $conference, Event $event, Thread $thread)
    {
        $thread->delete();
    }
}
