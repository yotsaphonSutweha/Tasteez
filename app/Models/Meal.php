<?php
namespace Tasteez\Models;
use PDO;
use Tasteez\Models\User;
use DateTime;

class Meal extends Model
{
  
  public function getMealDetails($mealId) {
    // TODO:
    // get meal ingredients and likes
    // find out if meal is a favourite or is liked
    return array("meal" => $mealId);
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

  public function category($categoryName) {
    var_dump($categoryName);
    $query = "SELECT meals.id, thumbnail, name
    FROM meals
    INNER JOIN categories
    ON meals.cat = categories.category
    WHERE meals.cat = '${categoryName}'";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(":categoryName", $categoryName);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function search($searchTerm) {
    $searchTerm = strtolower("%".$searchTerm."%");
    $query = "SELECT * FROM meals WHERE name LIKE :searchTerm";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":searchTerm", $searchTerm);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

}
