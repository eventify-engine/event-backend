<?php

namespace App\Http\Controllers\Conference;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConferenceResource;
use App\Models\Conference;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!($from = $request->header('From')))
            abort(400);

        if (!($pattern = config('app.frontend_user_host')))
            abort(500);

        $regexPattern = '/^' . str_replace('\*', '(.*?)', preg_quote($pattern, '/')) . '$/';

        if (!preg_match($regexPattern, $from, $matches))
            abort(404);

        return new ConferenceResource(
            Conference::where('host_prefix', $matches[1])->firstOrFail()
        );
    }
}
