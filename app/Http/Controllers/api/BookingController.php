<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $schedules = Route::where('origin_city', $request->origin_city)
            ->Where('destination_city', $request->destination_city)
            ->with(['schedules' => function ($query) {
                $query->with(['armada.classes']);
                $query->with(['armada.classes.price']);
            }])
            ->get();

        return response()->json($schedules);
    }
}
