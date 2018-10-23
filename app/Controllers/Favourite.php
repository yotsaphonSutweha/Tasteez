<?php

namespace Tasteez\Controllers;


class Home extends Controller
{
  function __invoke($request, $response) {
    $meal = new \Tasteez\Models\Meal($this->container->db);
    $meals = $meal->findAll();
    return $this->container->view->render($response, 'home.twig', ["meals" => $meals]);
  }
}
