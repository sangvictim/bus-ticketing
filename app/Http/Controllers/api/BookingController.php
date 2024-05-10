<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseApi;
use App\Models\Route;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Get the schedules.
     */
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

    /**
     * Get the history transaction.
     * @return \Illuminate\Http\JsonResponse
     */
    public function history(): JsonResponse
    {
        return ResponseApi::success('History Transaction', auth()->user()->transactions);
    }

    /**
     * Get the seat.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function seat(Request $request): JsonResponse
    {
        $transaction = Transaction::find($request->transaction_id);
        if (!$transaction) {
            return response()->json([
                'code' => 404,
                'message' => 'Transaction not found',
            ]);
        }
        $transaction->armada_seat = $request->armada_seat;
        $transaction->save();
        return response()->json($transaction);
    }

    public function transaction(Request $request): JsonResponse
    {

        $transaction =  new Transaction;
        $transaction->status = 'BOOKED';
        $transaction->total_price = $request->total_price;
        $transaction->price = $request->price;
        $transaction->discount = $request->discount;
        $transaction->discount_type = $request->discount_type;
        $transaction->origin_city = $request->origin_city;
        $transaction->destination_city = $request->destination_city;
        $transaction->armada_code = $request->armada_code;
        $transaction->armada_name = $request->armada_name;
        $transaction->armada_class = $request->armada_class;
        $transaction->armada_seat = $request->armada_seat;
        $transaction->save();
        return response()->json($transaction);
    }
}
