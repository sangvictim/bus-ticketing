<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseApi;
use App\Models\City;
use App\Models\Route;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
  /**
   * Get the schedules.
   * Unathorized
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
   * Get the cities.
   * Unathorized
   */
  public function cities()
  {
    $cities = City::select('id', 'name')->get();
    $cities = $cities->map(function ($city) {
      return [
        'value' => strval($city->id),
        'label' => $city->name
      ];
    });
    $result = new ResponseApi;
    $result->setStatusCode(Response::HTTP_OK);
    $result->title('Cities');
    $result->data($cities);
    $result->setHeader([
      'Content-Type' => 'application/json',
      'cache-control' => 'public, max-age=3600'
    ]);
    return $result;
  }

  /**
   * Get the history transaction.
   */
  public function history(): JsonResponse
  {
    $transactions = Transaction::where('user_id', auth()->user()->id)->with([
      'user' => function ($query) {
        $query->select('id', 'name');
      },
      'details',
    ])->get();
    $result = new ResponseApi;
    $result->setStatusCode(Response::HTTP_OK);
    $result->title('History Transaction');
    $result->data($transactions);
    return $result;
  }

  /**
   * Get the seat.
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   * TODO: check availability seat where transaction
   */
  public function seat(Request $request): JsonResponse
  {
    $result = new ResponseApi;
    $transaction = Transaction::where('transaction_code', $request->transaction_code)->first();
    if (!$transaction) {
      $result->setStatusCode(Response::HTTP_NOT_FOUND);
      $result->title('Transaction not found');
      $result->message('Transaction not found');
      $result->data(null);
      return $result;
    }
    $transaction->seat_number = $request->seat_number;
    $transaction->save();

    $result->title('Seat Updated');
    $result->data($transaction);
    return $result;
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

    $validator = Validator::make($request->all(), [
      'total_amount' => 'required',
      'origin_city' => 'required',
      'destination_city' => 'required',
      'qty_passanger' => 'required',
      'details.*.passager_name' => 'required',
      'details.*.price' => 'required',
      'details.*.armada_code' => 'required',
      'details.*.armada_name' => 'required',
      'details.*.armada_class' => 'required',
      'details.*.seat_number' => 'required',
    ]);

    if ($validator->fails()) {
      $result->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
      $result->title('Transaction');
      $result->message('Failed');
      $result->formError($validator->errors());
      return $result;
    }
    DB::transaction(function () use ($request, $result) {
      $transaction =  new Transaction;
      $transaction->user_id = auth()->user()->id;
      $transaction->transaction_code = 'TRIP-' . microtime(true);
      $transaction->status = 'BOOKED';
      $transaction->total_amount = $request->total_amount;
      $transaction->qty_passanger = $request->qty_passanger;
      $transaction->origin_city = $request->origin_city;
      $transaction->destination_city = $request->destination_city;
      $transaction->departure = $request->departure;
      $transaction->save();

      $transaction->details()->createMany($request->details);

      $result->setStatusCode(Response::HTTP_CREATED);
      $result->message('Transaction Created');
      $result->title('Transaction');
      $result->data($transaction);
      return $result;
    });
  }
}
