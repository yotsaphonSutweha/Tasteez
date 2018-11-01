<?php

namespace Tasteez\Controllers;


class Home extends Controller
{

  // public function index($request, $response) {
  //   return $this->container->view->render($response, 'home.twig', ["foo" => "bar"]);
  // }

  function __invoke($request, $response) {
    $meal = new \Tasteez\Models\Meal($this->container->db);
    $meals = $meal->findAll();
    return $this->container->view->render($response, 'home.twig', ["meals" => $meals]);
  }

}
