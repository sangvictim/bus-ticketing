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
      'originCity' => function ($query) {
        $query->select('id', 'name');
      },
      'destinationCity' => function ($query) {
        $query->select('id', 'name');
      },
      'armadaClass' => function ($query) {
        $query->select('id', 'name');
      }
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
    $transaction->armada_seat = $request->armada_seat;
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
      'total_price' => 'required',
      'origin_city' => 'required',
      'destination_city' => 'required',
      'armada_code' => 'required',
      'armada_name' => 'required',
      'armada_class' => 'required',
      'armada_seat' => 'required',
    ]);

    if ($validator->fails()) {
      $result->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
      $result->title('Transaction');
      $result->message('Failed');
      $result->formError($validator->errors());
      return $result;
    }

    $transaction =  new Transaction;
    $transaction->status = 'BOOKED';
    $transaction->user_id = auth()->user()->id;
    $transaction->transaction_code = 'TRIP-' . microtime(true);
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
    $transaction->departure = $request->departure;
    $transaction->save();

    $result->setStatusCode(Response::HTTP_CREATED);
    $result->message('Transaction Created');
    $result->title('Transaction');
    $result->data($transaction);
    return $result;
  }
}
