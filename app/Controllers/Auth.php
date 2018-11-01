<?php

namespace Tasteez\Controllers;

class Auth extends Controller
{

  protected $db;
  protected $view;

  function __construct($container)
  {
    $this->db = $container->db;
    $this->view = $container->view;
  }

  public function getRegister($request, $response) {
    return $this->view->render($response, 'register.twig');
  }

  
  public function postRegister($request, $response) {
    $data = $request->getParsedBody();
    $errors = array();
    $username = trim($data['username']);
    $email = trim($data['email']);
    $password =trim($data['password']);
    $confirmPassword = trim($data['confirm_password']);

    if ($username == "" || $email == "" || $password == "" || $confirmPassword == "") {
      array_push($errors, "Some required fileds have been left blank");
    }

    if (strlen($username) < 4 || strlen($username) > 10) {
      array_push($errors, "");
    }

    if ($password !== $confirmPassword) {
      array_push($errors, "Passwords do not match");
    }

    if (count($errors) > 0) {
      return $this->view->render($response, 'register.twig', ["errors" => $errors]);
    }

    $user = new \Tasteez\Models\User($this->db);

    if ($user->exists($username, $email)) {
      array_push($errors, "User with that name already existsts");
    }

    if (count($errors) > 0) {
      return $this->view->render($response, 'register.twig', ["errors" => $errors]);

    } else {
      $hash = password_hash($password, PASSWORD_BCRYPT);
      $user->createNew($username, $email, $hash);
      return $this->view->render($response, 'register.twig', ["registered" => true]);
    }

  }
}
