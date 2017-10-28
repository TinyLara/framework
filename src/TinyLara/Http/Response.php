<?php

namespace TinyLara\Http;

/**
* Response
*/
class Response
{
  
  public $return;

  public function __construct() {}

  public function send()
  {
    \View::process($this->return);
  }
}