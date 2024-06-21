<?php

namespace App\Http\Controllers\PaymentRequest;

use Illuminate\Support\Facades\Http;

class Xendit
{
  protected static string $baseUrl = 'https://api.xendit.co/';

  public static function VirtualAccountCreate($externalId, $bank_code, $name)
  {
    $client = Http::withBasicAuth(env('XENDIT_API_KEY'), '');
    $response = $client->post(self::$baseUrl . 'callback_virtual_accounts', [
      'external_id' => $externalId,
      'bank_code' => $bank_code,
      'name' => $name,
    ]);
    return json_decode($response->body());
  }

  /**
   * Create E-Wallet just for DANA, SHOPEE, LINKAJA
   * @param $channel_code type of ID_OVO, ID_DANA, ID_SHOPEEPAY, ID_LINKAJA
   */
  public static function EwalletCreate($reference_id, $amount, $channel_code, $channel_properties)
  {
    $client = Http::withBasicAuth(env('XENDIT_API_KEY'), '');
    $response = $client->post(self::$baseUrl . 'ewallets/charges', [
      "reference_id" => $reference_id,
      "checkout_method" =>  "ONE_TIME_PAYMENT",
      "currency" =>  "IDR",
      "amount" =>  $amount,
      "channel_code" =>  $channel_code,
      "channel_properties" => $channel_properties
    ]);
    return json_decode($response->body());
  }
}
