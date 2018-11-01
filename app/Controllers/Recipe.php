<?php

namespace Tasteez\Controllers;


class Recipe extends Controller
{
  function __invoke($request, $response) {
    return $this->container->view->render($response, 'recipe.twig');
  }
}
