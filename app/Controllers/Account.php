<?php

namespace Tasteez\Controllers;


class Account extends Controller
{
  function __invoke($request, $response) {
    return $this->container->view->render($response, 'account.twig');
  }
}
