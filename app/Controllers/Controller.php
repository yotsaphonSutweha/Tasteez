<?php

namespace Tasteez\Controllers;

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
