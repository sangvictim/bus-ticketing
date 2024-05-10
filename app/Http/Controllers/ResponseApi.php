<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

abstract class ResponseApi
{
  public static function success($title, $data, $currentPage = null, $totalPage = null)
  {
    return response()->json(
      [
        'code' => Response::HTTP_OK,
        'message' => 'OK',
        'title' => $title,
        'data' => $data,
        'currentPage' => $currentPage,
        'totalPage' => $totalPage,
      ]
    );
  }
}
