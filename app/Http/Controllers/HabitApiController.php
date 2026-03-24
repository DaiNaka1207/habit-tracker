<?php

namespace App\Http\Controllers;

use App\Http\Resources\HabitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HabitApiController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $habits = $request->user()
            ->habits()
            ->with('logs')
            ->get();

        return HabitResource::collection($habits);
    }
}
