<?php

namespace Tasteez\Controllers;


class MostPopular extends Controller
{

  // public function index($request, $response) {
  //   return $this->container->view->render($response, 'home.twig', ["foo" => "bar"]);
  // }

  function __invoke($request, $response) {
    $meal = new \Tasteez\Models\Meal($this->container->db);
    $meals = $meal->findAll();
    return $this->container->view->render($response, 'mostpopular.twig', ["mostPopularMeals" => $meals]);
  }

}
