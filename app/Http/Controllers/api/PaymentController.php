<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentRequest\Xendit;
use App\Http\Controllers\ResponseApi;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
  /**
   * Get list payment method with group by parent
   */
  public function list()
  {
    $listPayment = PaymentMethod::where('isActivated', 1)->with(['childrens'])->whereNull('parent')->get();
    $data = $listPayment->map(function ($item) {
      $data = [
        'sort' => $item->sort,
        'name' => $item->name,
        'code' => $item->code,
        'children' => $item->childrens?->map(function ($child) {
          return [
            'code' => $child->code,
            'name' => $child->name,
            'icon' => $child->icon,
            'country' => $child->country,
            'currency' => $child->currency,
            'sort' => $child->sort,
          ];
        })->toArray()
      ];
      return $data;
    })->toArray();

    $result = new ResponseApi;
    $result->setStatusCode(Response::HTTP_OK);
    $result->title('List Payment');
    $result->message('OK');
    $result->data($data);
    return $result;
  }

  public function createVA(Request $request)
  {
    $validated = Validator::make($request->all(), [
      'external_id' => 'required',
      'name' => 'required',
      'bank_code' => 'required',
      'expected_amount' => 'required',
      'channel' => 'required',
    ]);

    if ($validated->fails()) {
      $response = new ResponseApi;
      $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
      $response->title('Payment');
      $response->message('Failed');
      $response->formError($validated->errors());
      return $response;
    }
    $response = new ResponseApi;
    $createVA = Xendit::VirtualAccountCreate($request->external_id, $request->bank_code, $request->name);

    if ($createVA) {
      $payment = new Payment;
      $payment->external_id = $createVA->external_id;
      $payment->user_id = auth()->user()->id;
      $payment->channel = $request->channel;
      $payment->code = $request->bank_code;
      $payment->name = $request->name;
      $payment->account_number = $createVA->account_number;
      $payment->expected_amount = $request->expected_amount;
      $payment->status = $createVA->status;
      $payment->save();

      // response success
      $response->setStatusCode(Response::HTTP_CREATED);
      $response->title('Payment');
      $response->message('Created');
      $response->data($payment);
      return $response;
    }

    // response failed
    $response->setStatusCode(Response::HTTP_BAD_REQUEST);
    $response->title('Payment');
    $response->message('Failed');
    $response->data(null);
    return $response;
  }

  public function callbackVirtualAccountPaid(Request $request)
  {
    $response = new ResponseApi;

    /**
     * check token webhook from xendit
     * token can be get from environment XENDIT_CALLBACK_TOKEN
     */
    if ($request->header('X-CALLBACK-TOKEN') != env('XENDIT_CALLBACK_TOKEN')) {
      // response failed
      $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
      $response->title('who are you?');
      $response->message('UNAUTHORIZED');
      $response->data(null);
      return $response;
    }
    DB::transaction(function () use ($request) {
      // update payment to paid
      $payment = Payment::where('external_id', $request->external_id)->first();
      $payment->status = 'PAID';
      $payment->save();

      // update transaction to paid
      $transaction = Transaction::where('transaction_code', $request->external_id)->first();
      $transaction->status = 'PAID';
      $transaction->save();

      // create user notification
      $notification = new UserNotification;
      $notification->user_id = $transaction->user_id;
      $notification->title = 'Success';
      $notification->body = 'Ticket has been paid';
      $notification->save();
    });

    // response success
    $response->setStatusCode(Response::HTTP_OK);
    $response->title('Payment');
    $response->message('OK');
    $response->data(null);
    return $response;
  }
}
