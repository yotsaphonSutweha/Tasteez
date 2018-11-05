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

  public function isLoggedIn() {
    return isset($_COOKIE['cookie']) && $this->validateCookie();
  }

  public function verifyPassword($oldPassword, $id) {
    $user = $this->findById($id);
    return password_verify($oldPassword, $user['password']);
  }

  public function favorite($recipeId, $userId) {
    $query = "INSERT INTO favorites (user_id, recipe_id) VALUES (:user_id, :recipe_id)";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':recipe_id', $recipeId);
    return $stmt->execute();
  }

  public function isFavorited($recipeId, $userId) {
    $query = "DELETE FROM favorites WHERE recipe_id = :recipe_id AND user_id = :user_id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':recipe_id', $recipeId);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    return $stmt->rowCount();
  }

  public function getFavorites($userId) {
    $query = "SELECT * FROM favorites INNER JOIN meals ON  meals.id = favorites.recipe_id WHERE user_id = :user_id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    return $stmt->fetchAll();
}
  public function favoriteRecipe($recipeId, $userId) {
    if(!$this->isFavorited($recipeId, $userId)) {
      $this->favorite($recipeId, $userId);
      return array("Message" => "favorited $recipeId");
    }
      return array("Message" => "unfavorited $recipeId");
    }

    public function like($recipeId, $likeValue, $userId) {
      $query = "INSERT INTO likes (user_id, like_value, recipe_id) VALUES (:user_id, :like_value, :recipe_id)";
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(':user_id', $userId);
      $stmt->bindParam(':like_value', $likeValue);
      $stmt->bindParam(':recipe_id', $recipeId);
      return $stmt->execute();
    }

    public function isLiked($recipeId, $userId) {
      $query = "DELETE FROM likes WHERE recipe_id = :recipe_id AND user_id = :user_id";
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(':recipe_id', $recipeId);
      $stmt->bindParam(':user_id', $userId);
      $stmt->execute();
      return $stmt->rowCount();
    }

    public function likeRecipe($recipeId, $like, $userId) {
      $likeValue = ('like' === $like ? 1 : -1);
  
      if(!$this->isLiked($recipeId, $userId)) {
        $this->like($recipeId, $likeValue, $userId);
        return array("Message" => "like status updated on recipe $recipeId");
      }
  
      return array("Message" => "undone like status updated on recipe $recipeId");
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
  
}
