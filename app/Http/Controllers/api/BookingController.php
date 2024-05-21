<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseApi;
use App\Models\Route;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    $result = new ResponseApi;
    $result->setStatusCode(Response::HTTP_OK);
    $result->title('Schedules');
    $result->data($schedules);
    return $result;
  }

  /**
   * Get the history transaction.
   */
  public function history(): JsonResponse
  {
    $result = new ResponseApi;
    $result->setStatusCode(Response::HTTP_OK);
    $result->title('History Transaction');
    $result->data(auth()->user()->transactions);
    return $result;
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
    return ResponseApi::success(Response::HTTP_OK, 'Seat', 'Seat', $transaction);
  }

  public function transaction(Request $request): JsonResponse
  {
    $result = new ResponseApi;
    $check = Transaction::where('user_id', auth()->user()->id)->where('status', 'BOOKED')->first();
    if ($check) {
      $result->setStatusCode(Response::HTTP_PAYMENT_REQUIRED);
      $result->message('Transaction Conflict');
      $result->title('Transaction already booked');
      $result->data($check);
      return $result;
    }

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

    $result->setStatusCode(Response::HTTP_CREATED);
    $result->message('Transaction Created');
    $result->title('Transaction');
    $result->data($transaction);
    return $result;
  }
}
