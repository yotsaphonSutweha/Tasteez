<?php

// =============================================================================
// API routes
// =============================================================================

$app->group('/api', function() {

  $this->group('/meals', function() {
    $this->get('/all', 'MealsAPIController:all');
    $this->get('/popular', 'MealsAPIController:popular');
    $this->get('/recommended', 'MealsAPIController:recommended');
    $this->get('/categories', 'MealsAPIController:categories');
    $this->get('/categories/{id}', 'MealsAPIController:category');
    $this->get('/search/{searchTerm}', 'MealsAPIController:search');
  });

  $this->group('/meal/{id}', function() {
    $this->get('', 'MealAPIController:getMealDetails');
    $this->post('/add-favourite', 'MealAPIController:favourites');
    $this->post('/add-comment', 'MealAPIController:addComment');
    $this->delete('/delete-comment', 'MealAPIController:deleteComment');
    // $this->get('/comments', 'MealAPIController:removeComment');
    $this->post('/like', 'MealAPIController:likeMeal');
    $this->delete('/dislike', 'MealAPIController:dislikeMeal');
  });

  $this->group('/auth', function() {
    $this->post('/login', 'AuthAPIController:login');
    $this->post('/logout', 'AuthAPIController:logout');
    $this->post('/register', 'AuthAPIController:register');
  });

  $this->group('/user', function() {
    $this->get('/favorites', 'UserAPIController:getFavorites');
    $this->put('/update-password', 'UserAPIController:updatePassword');
    $this->put('/update-email', 'UserAPIController:updateEmail');
    $this->delete('/delete-account/{userId}', 'UserAPIController:deleteUser');
  });

  $this->group('/contact', function() {
    $this->post('', 'ContactApiController:sendEmail');
  });

});

// =============================================================================
// View Routes
// =============================================================================

$app->get('/', 'HomeController');
$app->get('/contact', 'ContactController');
$app->get('/privacy-policy', 'PrivacyPolicyController');
$app->get('/search', 'SearchController');

$app->group('/auth', function() {
  $this->get('/register', 'AuthController:getRegister');
  $this->post('/register', 'AuthController:postRegister');
  $this->get('/login', 'AuthController:getLogin');
  $this->post('/login', 'AuthController:postLogin');
  $this->get('/logout', 'AuthController:logout');
});
//
// $app->get('/auth/register', 'AuthAPIController:getRegister');

$app->group('/meals', function() {
  $this->get('/most-popular', 'MealsController:mostPopular');
  $this->get('/discover', 'MealsController:discover');
  $this->get('/favourites', 'MealsController:favourites');
  $this->get('/recommended', 'MealsController:recommended');
  $this->get('/search', 'MealsController:search');
  $this->get('/categories', 'MealsController:categories');
  $this->get('/category/{name}', 'MealsController:category');
  $this->get('/{id}', 'MealsController:meal');
});

$app->group('/meal/{id}', function() {
  // NOTE: HTML forms only support the http methods GET and POST
  $this->get('' , 'MealController:meal');
  $this->post('/add-comment' , 'MealController:addComment');
  $this->post('/delete-comment' , 'MealController:deleteComment');
  $this->post('/like' , 'MealController:likeMeal');
  $this->post('/dislike' , 'MealController:dislikeMeal');
  $this->post('/add-favourite' , 'MealController:addToFavourites');
  $this->post('/delete-favourite' , 'MealController:removeFromFavourites');
});

$app->group('/user', function() {
  $this->get('/account', 'AccountController:getAccount');
  $this->post('/delete-account/{userId}', 'AccountController:postDeleteAccount');
});