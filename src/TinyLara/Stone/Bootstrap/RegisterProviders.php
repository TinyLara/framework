<?php

namespace TinyLara\Stone\Bootstrap;

use TinyLara\Stone\Application;

/**
* \LoadConfiguration
*/
class RegisterProviders
{
  public function bootstrap(Application $app)
  {
    \TinyLara\Support\Facades\Facade::setFacadeApplication($app);

    $config = require BASE_PATH.'/config/config.php';
    foreach ($config['aliases'] as $className => $facadeName) {
        class_alias($facadeName, $className);
    }
  }
}