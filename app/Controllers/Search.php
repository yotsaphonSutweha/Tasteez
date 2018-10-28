<?php

namespace Tasteez\Controllers;


class Search extends Controller
{

  function __invoke($request, $response) {
    return $this->container->view->render($response, 'search.twig');
  }

}
