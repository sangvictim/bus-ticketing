<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * Response API
 */
class ResponseApi extends JsonResponse
{
  protected string $message;
  protected string $title;
  protected mixed $data = [];

  function __construct()
  {
    $this->message = 'OK';
    $this->title = 'Response Title';

    parent::__construct();
  }

  public function message(string $message)
  {
    $this->message = $message;
    return $this->synchronizeData();
  }

  public function getMessage()
  {
    return $this->message;
  }

  public function title(string $title)
  {
    $this->title = $title;
    return $this->synchronizeData();
  }

  public function getTitle()
  {
    return $this->title;
  }

  public function data(mixed $data)
  {
    $this->data = $data;
    return $this->synchronizeData();
  }

  public function getOriginData()
  {
    return $this->data;
  }

  public function error(string $error)
  {
    return parent::setData([
      'message' => $error,
      'title' => $this->getTitle(),
    ]);
  }

  public function formError(mixed $formError)
  {
    return parent::setData([
      'message' => $this->getMessage(),
      'title' => $this->getTitle(),
      'formError' => $formError
    ]);
  }

  protected function synchronizeData(): static
  {
    return parent::setData([
      'message' => $this->getMessage(),
      'title' => $this->getTitle(),
      'data' => $this->getOriginData()
    ]);
  }

  public function statusCode(int $code): static
  {
    return $this->setStatusCode($code);
  }
}
