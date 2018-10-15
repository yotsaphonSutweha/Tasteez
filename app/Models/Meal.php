<?php
namespace Tasteez\Models;

class Meal extends Model
{
  
  public function getMealDetails($mealId) {
    // TODO:
    // get meal ingredients and likes
    // find out if meal is a favourite or is liked
    return array("meal" => $mealId);
  }

}
