<?php

namespace Tasteez\Controllers;


class Discover extends Controller
{

  function __invoke($request, $response) {
    return $this->container->view->render($response, 'discover.twig');
  }

}
