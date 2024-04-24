<?php

if (!function_exists('responseOk')) {
  function responseOk($key, $default = null)
  {
    return response()->json(
      [
        'key' => $key,
        'value' => $default
      ]
    );
  }
}
