<?php

namespace Tasteez\Controllers;


class Home extends Controller
{

  // public function index($request, $response) {
  //   return $this->container->view->render($response, 'home.twig', ["foo" => "bar"]);
  // }

  function __invoke($request, $response) {
    $meal = new \Tasteez\Models\Meal($this->container->db);
    $mostPopularMeals = $meal->popular();
    $recommended = $meal->findAll(); // To be changed
    return $this->container->view->render($response, 'home.twig', [
      "mostPopularMeals" => $mostPopularMeals,
      "recommended" => $recommended
      ]);
  }

}
