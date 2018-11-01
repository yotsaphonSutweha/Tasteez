<?php

namespace Tasteez\Controllers;


class LogIn extends Controller
{
  function __invoke($request, $response) {
    return $this->container->view->render($response, 'login.twig');
  }

}
