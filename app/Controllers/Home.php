<?php

namespace Tasteez\Controllers;
use Tasteez\Models\Meal;
use Tasteez\Models\User;
use Tasteez\Models\Category;
class Home extends Controller
{
  function __invoke($request, $response) {
    $meal = new Meal($this->container->db);
    $user = new User($this->container->db);

    $mostPopularMeals = $meal->popular(0, 8);
    $recommended = $meal->findAll(0, 8); // To be changed
    return $this->container->view->render($response, 'home.twig', [
      "mostPopularMeals" => $mostPopularMeals,
      "recommended" => $recommended,
      "loggedIn" => $user->isLoggedIn()
      ]);
  }

}
