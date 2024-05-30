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
}
