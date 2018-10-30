<?php

namespace Tasteez\Models;

class User extends Model
{

  protected $db;
  public $username;
  public $email;
  public $password;

  // public function __construct(PDO $db)
  // {
  //     $this->db = $db;
  // }

  //findAll
  //findById
  //findByCol


  public function validate()
  {
    return true;
  }

  public function findByName($username, $email)
  {
    $query = "SELECT * FROM users WHERE :email = email OR username = :username;";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function exists($username, $email)
  {
    return $this->findByName($username, $email) > 1;
  }

    public function createNew($username, $email, $password)
  {
    $stmt = $this->db->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password);');
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    return $stmt->execute();
  }

    public function findById($id)
  {
    $query = "SELECT * FROM users WHERE id = :id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function validateCookie() {
    $userDetails = json_decode($_COOKIE['cookie'], true);
    $user = $this->findById($userDetails['id']);
    $token = $userDetails['token'];

    return password_verify($user['id'] . $user['username'], $token);
  }


}
