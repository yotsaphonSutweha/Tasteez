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
    $category = new Category($this->container->db);

    $mostPopularMeals = $meal->popular(0, 8);
    // $recommended = $meal->findAll(0, 8); // To be changed
    $categories = $category->getAll(0, 8);
    return $this->container->view->render($response, 'home.twig', [
      "mostPopularMeals" => $mostPopularMeals,
      "categories" => $categories,
      "loggedIn" => $user->isLoggedIn()
      ]);
  }

}
