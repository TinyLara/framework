<?php

namespace TinyLara\Log;

use Monolog\Logger as Monolog;

class LogServiceProvider
{
  public $app;
  public function __construct($app)
  {
    $this->app = $app;
  }

  public function register()
  {
    $this->app->singleton('log', function () {
      return $this->createLogger();
    });
  }

  public function createLogger()
  {
    $log = new \TinyLara\Log\LogWriter;
    return $log;
  }

}
