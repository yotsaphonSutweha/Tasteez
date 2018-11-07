<?php

namespace Tasteez\Controllers\Api;
use Tasteez\Models\User;
use Slim\Exception\MethodNotAllowedException;

class Meals extends Controller {

  protected $user;
  protected $container;

  function __construct($container) {
    $this->user = new User($container->db);
    $this->container = $container;
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

  public function updatePassword($request, $response) {
    $body = $request->getParsedBody();
    $oldPassword = $body['oldPassword'];
    $password = $body['password'];
    $user = new \Tasteez\Models\User($this->container->db);
    if ($user->isLoggedIn()) {
        $id = json_decode($_COOKIE['cookie'], true)['id'];
        return $response->withJson($user->updatePassword($oldPassword, $password, $id));
    } else {
        return $response->withJson(array("Message" => "User not logged in!"));
    }
   }

   public function deleteUser($request, $response, $args) {
    $userId = $args['userId'];
    $user = new \Tasteez\Models\User($this->container->db);
    if ($user->isLoggedIn() && $user->validateCookie() && json_decode($_COOKIE['cookie'], true)['id'] === $userId) {
      $user->deleteUser($userId);
      unset($_COOKIE['cookie']);
      return $response->withJson(array("Message" => "Successfully deleted user!"));
    } else {
      return $response->withJson(array("Message" => "User not logged in!"));
    }
  }


}
