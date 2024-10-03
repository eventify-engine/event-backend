<?php

namespace App\Http\Controllers\Conference;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ShowController extends Controller
{
    public function __invoke(Request $request)
    {
        return new JsonResource([
            'url' => $request->header('From')
        ]);
    }
}
