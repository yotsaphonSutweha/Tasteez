<?php

namespace Tasteez\Controllers\Api;

/**
 *
 */
class Controller
{
  protected $container;

  function __construct($container)
  {
    $this->container = $container;
  }

}
