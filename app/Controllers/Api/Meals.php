<?php

namespace Tasteez\Controllers\Api;

class Meals extends Controller
{

  public function all($request, $response) {
    $meal = new \Tasteez\Models\Meal($this->container->db);
    return $response->withJson($meal->findAll());
  }

  public function popular($request, $response) {
    $meal = new \Tasteez\Models\Meal($this->container->db);
    return $response->withJson($meal->popular());
  }

  public function search($request, $response, $args) {
    $meal = new \Tasteez\Models\Meal($this->container->db);
    $searchTerm = $args['searchTerm'];
    return $response->withJson($meal->search($searchTerm));
  }

  public function categories($request, $response) {
    $meal = new \Tasteez\Models\Meal($this->container->db);
    return $response->withJson($meal->categories());
  }

  public function category($request, $response, $args) {
    $meal = new \Tasteez\Models\Meal($this->container->db);
    $category = $args['name'];
    return $response->withJson($meal->getMealsByCategory($category));
  }

  public function recommended($request, $response) {
    $meal = new \Tasteez\Models\Meal($this->container->db);
    $user = new \Tasteez\Models\User($this->container->db);
      if ($this->user->isLoggedIn()) {
          $id = json_decode($_COOKIE['cookie'], true)['id'];
          return $response->withJson($meal->recommended($id));
      } else {
          return $response->withJson(array("Message" => "User not logged in!"));
      }

    
  }
}
