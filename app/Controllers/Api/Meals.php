<?php

namespace Tasteez\Controllers\Api;

class Meals extends Controller
{

  public function all($request, $response) {
    $meal = new \Tasteez\Models\Meal($this->container->db);
    return $response->withJson($meal->findAll());
  }

  public function latest($request, $response) {
    return $response->write('latest meals');
  }

  public function getMealDetails($request, $response, $args) {
    $mealId = $args['id'];
    $meal = new \Tasteez\Models\Meal($this->container->db);
    return $response->withJson($meal->getMealDetails($mealId));
  }

  public function popular($request, $response) {
    $meal = new \Tasteez\Models\Meal($this->container->db);
    return $response->withJson($meal->popular());
  }

}
