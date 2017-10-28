<?php

namespace TinyLara\Http;

/**
* Request
*/
class Request
{
  public $response;
  public function __construct(Response $response)
  {
    $this->response = $response;
  }
}