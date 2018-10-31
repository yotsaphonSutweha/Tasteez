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

  public function popular() {
    $query = "SELECT *,
      CASE 
      WHEN (SELECT sum(like_value) from likes WHERE recipe_id = meals.id) IS NULL THEN 0
      ELSE (SELECT sum(like_value) from likes WHERE recipe_id = meals.id)
      END AS LikesAmount FROM meals
      ORDER BY LikesAmount DESC
    ";
    return $this->query($query);
  }


}
