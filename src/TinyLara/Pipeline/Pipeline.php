<?php

namespace TinyLara\Pipeline;

use TinyLara\Stone\Application;
use TinyLara\Contracts\Pipeline as PipelineContract;

use Closure;

class Pipeline implements PipelineContract
{
  public $container;
  public $passable;
  public $pipes = [];
  public $method = 'handle';

  public function __construct(Application $container = null)
  {
    $this->container = $container;
  }

  public function send($passable)
  {
    $this->passable = $passable;

    return $this;
  }

  public function through($pipes)
  {
    $this->pipes = is_array($pipes) ? $pipes : func_get_args();

    return $this;
  }

  public function via($method)
  {
    $this->method = $method;

    return $this;
  }

  public function then(Closure $destination)
  {
    $pipeline = array_reduce(
      array_reverse($this->pipes), $this->carry(), $this->prepareDestination($destination)
    );
    return $pipeline($this->passable);
  }

  protected function prepareDestination(Closure $destination)
  {
    return function ($passable) use ($destination) {
      return $destination($passable);
    };
  }

  public function carry()
  {
    return function ($stack, $pipe) {
      return function ($passable) use ($stack, $pipe) {
        list($name, $parameters) = $this->parsePipeString($pipe);
        $pipe = $this->container->make($name);
        $parameters = array_merge([$passable, $stack], $parameters);
        return $pipe->{$this->method}(...$parameters);
      };
    };
  }
  protected function parsePipeString($pipe)
  {
    list($name, $parameters) = array_pad(explode(':', $pipe, 2), 2, []);

    if (is_string($parameters)) {
      $parameters = explode(',', $parameters);
    }

    return [$name, $parameters];
  }
}