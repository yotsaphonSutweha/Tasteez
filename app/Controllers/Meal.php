<?php

namespace Tasteez\Controllers;

use \Tasteez\Models\Meal as MealModel;
use Tasteez\Models\User;

class Meal extends Controller {
  protected $meal;
  protected $view;
  private $user;

  function __construct($container) {
    $this->container = $container;
    $this->meal = new MealModel($container->db);
    $this->view = $container->view;
    $this->user = new User($container->db);
  }

  public function mostPopular($request, $response, $args) {
    $meals = $this->meal->popular();
    return $this->view->render($response, 'mostpopular.twig', [
      "mostPopularMeals" => $meals,
    ]);
  }


  public function discover($request, $response) {
    return $this->view->render($response, 'discover.twig');
  }

  public function favourites($request, $response) {
    $meals = [];
    return $this->view->render($response, 'favourites.twig', [
      "meals" => $meals
    ]);

  }

  public function recommended($request, $response) {
    return $response->write("<h1> 🚧  👷 Under Construction 👷 🚧 </h1>");
  }

  public function category($request, $response, $args) {
    $meals = $this->meal->findAll();
    return $this->view->render($response, 'category.twig', [
      "meals" => $meals
    ]);
  }

  public function categories($request, $response, $args) {
    $categories = $this->meal->categories();
    return $this->view->render($response, 'categories.twig', [
      "categories" => $categories
    ]);
  }

  public function search($request, $response) {
    return $this->view->render($response, 'search.twig');
  }


}
