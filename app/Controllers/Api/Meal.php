<?php

namespace Tasteez\Controllers\Api;

use \Tasteez\Models\Meal as MealModel;
use Tasteez\Models\User;
use Tasteez\Models\Favourite;

class Meal extends Controller
{
    protected $meal;
    protected $view;
    private $user;
    private $mealDetails;
    private $favourite;
   
    function __construct($container) {
        $this->container = $container;
        $this->meal = new MealModel($container->db);
        $this->view = $container->view;
        $this->user = new User($container->db);
        $this->favourite = new Favourite($container->db);
      }
    
    public function getFavorites($request, $response, $args) {
        $user = new \Tasteez\Models\User($this->container->db);
    
        if ($user->isLoggedIn()) {
            $userDetails = json_decode($_COOKIE['cookie'], true);
            $userId = $userDetails['id'];
            return $response->withJson($user->getFavorites($userId));
        } else {
            return $response->withJson(array("Message" => "User not logged in!"));
        }
      }
}
