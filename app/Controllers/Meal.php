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
  public function getMeal($mealID, $userID) {
    $db = $this->db;

    $favouriteModel = new Favourite($db);
    $ingredientModel = new Ingredient($db);
    $likedModel = new Liked($db);
    $commentModel = new Comment($db);

    $meal = $this->findById($mealID);

    $meal["ingredients"] = $ingredientModel->getMealIngredients($mealID);
    $meal["comments"] = $commentModel->getAll($mealID, $userID);
    $meal["isFavourite"] = $favouriteModel->isFavourite($userID, $mealID);
    $meal["likes"] = $likedModel->getMealLikes($mealID, $userID);

    return $meal;
  }

  public function mostPopular($request, $response, $args) {
    $meals = $this->meal->popular();
    return $this->view->render($response, 'mostpopular.twig', [
      "mostPopularMeals" => $meals,
      "loggedIn" => $this->user->isLoggedIn()
    ]);
  }


  public function discover($request, $response) {
    return $this->view->render($response, 'discover.twig');
  }

  public function favourites($request, $response) {
    $meals = [];
    return $this->view->render($response, 'favourites.twig', [
      "meals" => $meals,
      "loggedIn" => $this->user->isLoggedIn()
    ]);

  }

  public function recommended($request, $response) {
    return $response->write("<h1> 🚧  👷 Under Construction 👷 🚧 </h1>");
  }

  public function category($request, $response, $args) {
    $name = $args['name'];
    $meals = $this->meal->category($name);
    return $this->view->render($response, 'category.twig', [
      "category" => $meals,
      "name" => $name, 
      "loggedIn" => $this->user->isLoggedIn()
    ]);
  }

  public function categories($request, $response, $args) {
    $categories = $this->meal->categories();
    return $this->view->render($response, 'categories.twig', [
      "categories" => $categories,
      "loggedIn" => $this->user->isLoggedIn()
    ]);
  }

  public function search($request, $response) {
    return $this->view->render($response, 'search.twig');
  }


}
