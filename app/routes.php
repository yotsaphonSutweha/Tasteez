<?php

// =============================================================================
// API routes
// =============================================================================

$app->group('/api', function() {

  $this->group('/meals', function() {
    $this->get('/all', 'MealsAPIController:all');
    $this->get('/popular', 'MealsAPIController:popular');
    $this->get('/categories', 'MealsAPIController:categories');
    $this->get('/categories/{id}', 'MealsAPIController:category');
    $this->get('/search/{searchTerm}', 'MealsAPIController:search');
    $this->post('/{id}/favorite', 'MealsAPIController:favoriteRecipe');
    $this->post('/{id}/like', 'MealsAPIController:likeRecipe');
    $this->post('/{id}/add-comment', 'MealsAPIController:addComment');
    $this->get('/{id}', 'MealsAPIController:getMealDetails');
  });

  $this->group('/user', function() {
    $this->get('/favorites', 'UserAPIController:getFavorites');
    $this->put('/update-password', 'UserAPIController:updatePassword');
    $this->put('/update-email', 'UserAPIController:updateEmail');
    $this->delete('/delete-account/{userId}', 'UserAPIController:deleteUser');
  });


});

// =============================================================================
// View Routes
// =============================================================================

$app->get('/', 'HomeController');
$app->get('/contact', 'ContactController');
$app->get('/account', 'AccountController');
$app->get('/privacy-policy', 'PrivacyPolicyController');
$app->get('/search', 'SearchController');

$app->group('/auth', function() {
  $this->get('/register', 'AuthController:getRegister');
  $this->post('/register', 'AuthController:postRegister');
});
//
// $app->get('/auth/register', 'AuthAPIController:getRegister');

$app->group('/meals', function() {
  $this->get('/most-popular', 'MealController:mostPopular');
  $this->get('/discover', 'MealController:discover');
  $this->get('/favourites', 'MealController:favourites');
  $this->get('/recommended', 'MealController:recommended');
  $this->get('/search', 'MealController:search');
  $this->get('/categories', 'MealController:categories');
  $this->get('/categories/{name}', 'MealController:category');
  $this->get('/{id}', 'MealController:meal');
});
