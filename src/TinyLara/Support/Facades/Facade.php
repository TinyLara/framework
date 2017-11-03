<?php

namespace TinyLara\Support\Facades;

abstract class Facade
{
  protected static $app;
  
  protected static function getFacadeAccessor()
  {
    throw new RuntimeException('Facade does not implement getFacadeAccessor method.');
  }

  public static function __callStatic($method, $args)
  {
    $instance = static::$app[static::getFacadeAccessor()];
    return $instance->$method(...$args);
  }

  public static function setFacadeApplication($app)
  {
    static::$app = $app;
  }
}