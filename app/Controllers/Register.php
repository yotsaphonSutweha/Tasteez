<?php

namespace Tasteez\Controllers;


class Register extends Controller
{
  function __invoke($request, $response) {
    return $this->container->view->render($response, 'register.twig');
  }

}
