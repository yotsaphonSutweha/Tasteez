<?php

namespace Tasteez\Controllers;


class Account extends Controller
{
  private $user;
  public function getAccount($request, $response) {
    $this->user = new \Tasteez\Models\User($this->container->db);
    if ($this->user->isLoggedIn()) {
      $this->user = new \Tasteez\Models\User($this->container->db);
      $userId = $this->user->getID();
      return $this->container->view->render($response, 'account.twig', 
        [
          "loggedIn" => $this->user->isLoggedIn(), 
          "userId" => $userId
        ]
      );
    } else {
      return $response->withRedirect('/auth/login');
    } 
  }
}
