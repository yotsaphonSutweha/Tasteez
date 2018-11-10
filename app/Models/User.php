<?php

namespace Tasteez\Models;
use PDO;
class User extends Model
{

  public $db;
  public $username;
  public $email;
  public $password;

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

  public function createNew($username, $email, $password) {
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

  public function verifyPassword($oldPassword, $id) {
    $user = $this->findById($id);
    return password_verify($oldPassword, $user['password']);
  }

    public function isLoggedIn() {
      return isset($_COOKIE['cookie']) && $this->validateCookie();
    }

    public function getID() {
      if (isset($_COOKIE['cookie']) && $this->validateCookie()) {
        $cookie = json_decode($_COOKIE['cookie'], true);
        return $cookie["id"];
      }
      return false;
    }

    public function getUsername() {
      if (isset($_COOKIE['cookie']) && $this->validateCookie()) {
        $cookie = json_decode($_COOKIE['cookie'], true);
        return $cookie["username"];
      }
      return false;
    }
    
    public function verifyEmail($oldEmail, $id) {
      $user = $this->findById($id);
      return $oldEmail === $user['email'];
    }

    public function updateEmail($oldEmail, $email, $id)
    {
      if($this->exists(null, $email)) {
        return array("message" => "Account with email already exists");
      } else if($this->verifyEmail($oldEmail, $id)) {
        $query = "UPDATE users set email = :email WHERE id = :id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return array("message" => "email successfully updated!");
      } else {
        return array("message" => "Wrong email entered!",
                      "Old email" => $oldEmail,
                      "New email" => $newEmail,
                      "id" => $id);
      }
    }

    public function updatePassword($oldPassword, $password, $id)
    {
      if($this->verifyPassword($oldPassword, $id)) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $query = "UPDATE users set password = :password WHERE id = :id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':password', $hash);
        $stmt->execute();
        $user = $this->findById($id);
        return array("message" => "password successfully updated!");
      } else {
        return array("message" => "Wrong password entered!");
      }
    }

    public function deleteUser($userId) {
      $query = "DELETE FROM users WHERE id = :user_id";
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(':user_id', $userId);
      return $stmt->execute();
    }
}
