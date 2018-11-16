<?php

namespace Tasteez\Controllers;

use \Tasteez\Models\Meal as MealModel;
use Tasteez\Models\User;

class Meal extends Controller {
  protected $meal;
  protected $view;
  private $user;
  private $mealDetails;

  function __construct($container) {
    $this->container = $container;
    $this->meal = new MealModel($container->db);
    $this->view = $container->view;
    $this->user = new User($container->db);
  }

  public function getMealDetails($response, $request, $args) {
    return $this->meal->getMeal($args['id'], $this->user->getID());
  }

  public function meal($request, $response, $args) {

    return $this->view->render($response, 'meal.twig', [
      "meal" => $this->getMealDetails($request, $response, $args),
      "loggedIn" => $this->user->isLoggedIn(),
    ]);
  }
}
