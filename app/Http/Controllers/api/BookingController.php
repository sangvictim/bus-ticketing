<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $schedules = Route::where('origin_city', $request->origin_city)
            ->Where('destination_city', $request->destination_city)
            ->with(['schedules' => function ($query) use ($request) {
                $query->whereHas('armada', function ($query) {
                    $query->where('status', 'ACTIVE');
                });
                if ($request->class_id) {
                    $query->whereHas('armada.classes', function ($query) use ($request) {
                        $query->where('id', $request->class_id);
                    });
                }
                $query->with(['armada.classes.price']);
            }])
            ->get();

        return response()->json($schedules);
    }

    public function history(): JsonResponse
    {
        $history = auth()->user()->transactions();
        return response()->json([$history]);
    }
}
