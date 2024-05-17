<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Response API
 * @method static \App\Http\Controllers\ApiResponse success(mixed $data = [])
 */
class ResponseApi extends JsonResponse
{
  protected string $title;
  protected string $message;
  protected array $errors = [];

  public function __construct(string $message = '', string $title = '')
  {
    $this->title = "OK";
    $this->message = "Success";

    parent::__construct();
  }

  public function create(mixed $data = []): static
  {
    return static::statusCode(static::HTTP_OK)->data($data);
  }

  public function success(mixed $data = []): static
  {
    return static::create($data);
  }
  public function statusCode(int $code): static
  {
    return $this->setStatusCode($code);
  }

  public function message(string $message): static
  {
    $this->message = $message;
    return $this->synchronizeData();
  }

  public function getMessage(): string
  {
    return $this->message;
  }

  public function title(string $message): static
  {
    $this->message = $message;
    return $this->synchronizeData();
  }

  public function getTitle(): string
  {
    return $this->title;
  }

  protected function synchronizeData(): static
  {
    return static::setData([
      "title" => $this->getTitle(),
      "message" => $this->getMessage(),
      "data" => $this->data,
      "errors" => $this->errors
    ]);
  }

  public function data(mixed $data = []): static
  {
    $this->data = $data;
    return $this->synchronizeData();
  }
}
