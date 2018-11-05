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

  public function favoriteRecipe($request, $response, $args) {
    $recipeId = $args['id'];
    $user = new \Tasteez\Models\User($this->container->db);

    if ($this->user->isLoggedIn()) {
        $id = json_decode($_COOKIE['cookie'], true)['id'];
        return $response->withJson($user->favoriteRecipe($recipeId, $id));
    } else {
        return $response->withJson(array("Message" => "User not logged in!"));
    }
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

  public function likeMeal($request, $response, $args) {
    if (!$user->isLoggedIn()) {
      return $response->withJson([], 403);
    }
    $mealID = $args['id'];
    $user = new \Tasteez\Models\User($this->container->db);
    $user->likeRecipe($args['id'], 1, $user->getID());
    return $response->withJson([], 200);
  }

 

}
