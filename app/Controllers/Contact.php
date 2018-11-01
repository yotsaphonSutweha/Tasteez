<?php

namespace Tasteez\Controllers;


class Contact extends Controller
{

  function __invoke($request, $response) {
    return $this->container->view->render($response, 'contact.twig');
  }

}
