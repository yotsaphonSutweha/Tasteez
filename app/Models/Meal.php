<?php
namespace Tasteez\Models;
use PDO;
use Tasteez\Models\User;
use Tasteez\Models\Favourite;
use Tasteez\Models\Ingredients;
use Tasteez\Models\Liked;
use Tasteez\Models\Comment;
use DateTime;

class Meal extends Model
{
  public function getMeal($mealID, $userID) {
    $db = $this->db;

    $favouriteModel = new Favourite($db);
    $ingredientModel = new Ingredient($db);
    $likedModel = new Liked($db);
    $commentModel = new Comment($db);

    $meal = $this->findById($mealID);

    $meal["ingredients"] = $ingredientModel->getMealIngredients($mealID);
    $meal["isFavourite"] = $favouriteModel->isFavourite($userID, $mealID);
    $meal["likes"] = $likedModel->getMealLikes($mealID, $userID);
    $meal["userID"] = $userID;

    return $meal;
  }

  public function popular($offset = null, $limit = null) {
    $query = "SELECT *,
      CASE 
      WHEN (SELECT sum(like_value) from likes WHERE recipe_id = meals.id) IS NULL THEN 0
      ELSE (SELECT sum(like_value) from likes WHERE recipe_id = meals.id)
      END AS LikesAmount FROM meals
      ORDER BY LikesAmount DESC
    ";

    if (isset($offset) && isset($limit)) {
      $query .= " LIMIT ${offset}, ${limit}";
    }

    return $this->query($query);
  }

  public function categories() {
    $query = "SELECT id, category, image FROM categories";
    return $this->query($query);
  }

  public function getMealsByCategory($categoryName) {
    $query = "SELECT meals.id, thumbnail, name
      FROM meals
      INNER JOIN categories
      ON meals.cat = categories.category
      WHERE meals.cat = '${categoryName}'";

      if (isset($offset) && isset($limit)) {
          $query .= " LIMIT ${offset}, ${limit}";
      }

      return $this->db->query($query)->fetchAll();
  }

  public function search($searchTerm, $offset = null, $limit = null ) {
    $searchTerm = strtolower("'%".$searchTerm."%'");
    $query = "SELECT * FROM meals WHERE name LIKE ${searchTerm}";

    if (isset($offset) && isset($limit)) {
        $query .= " LIMIT ${offset}, ${limit}";
    }
    return $this->db->query($query)->fetchAll();
  }

  public function likeMeal($mealID, $userID = 0) {
    if ($userID) {
      $liked = new Liked($this->db);

      if ($liked->userLikesMeal($userID, $mealID)) {
        $liked->removeLike($userID, $mealID);

      } else if ($liked->userDislikesMeal($userID, $mealID)) {
        $liked->updateLike(1, $mealID, $userID);

      } else {
        $liked->addLike(1, $mealID, $userID);
      }
    }
  }

  public function dislikeMeal($mealID, $userID) {
    if ($userID) {
      $liked = new Liked($this->db);

      if ($liked->userDislikesMeal($userID, $mealID)) {
        $liked->removeLike($userID, $mealID);

      } else if ($liked->userLikesMeal($userID, $mealID)) {
        $liked->updateLike(-1, $mealID, $userID);

      } else {
        $liked->addLike(-1, $mealID, $userID);

      }
    }
  }
  
  public function addToFavourites($userID, $mealID) {
    if ($userID) {
      $favourite = new Favourite($this->db);
      if ($favourite->isFavourite($userID, $mealID)) {
        $favourite->removeFavourite($userID, $mealID);
      } else {
        $favourite->addFavourite($userID, $mealID);
      }
    }
  }

  public function removeFromFavourites($userID, $mealID) {
    if ($userID) {
      $favourite = new Favourite($this->db);
      $favourite->removeFavourite($userID, $mealID);
    }
  }

  public function getFavorites($userID) {
    $query = "SELECT * FROM favorites INNER JOIN meals ON  meals.id = favorites.recipe_id WHERE user_id = :user_id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':user_id', $userID);
    $stmt->execute();
    return $stmt->fetchAll();
  }


  public function addComment($comment, $mealID, $userID) {
    $commentModel = new Comment($this->db);
    $commentModel->addComment($comment, $mealID, $userID);
  }

  public function deleteComment($mealID, $userID) {
    $commentModel = new Comment($this->db);
    $commentModel->deleteComment($mealID, $userID);
  }

}
