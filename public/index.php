<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require '../vendor/autoload.php';

use Leafo\ScssPhp\Compiler;

// Compile Sass
$scss = new Compiler();
$scss->setImportPaths('../app/sass/');
$css = $scss->compile(file_get_contents('../app/sass/index.scss'));
$css_file = './stylesheets/index.css';
$handle = fopen($css_file, 'w') or die('Cannot open file:  '.$css_file);
fwrite($handle, $css);

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$config['db']['host']   = getenv('DB_HOST');
$config['db']['user']   = getenv('DB_USER');
$config['db']['pass']   = getenv('DB_PASS');
$config['db']['dbname'] = getenv('DB_NAME');
$config['db']['key'] = getenv('KEY');

$dotenv = new Dotenv\Dotenv(__DIR__ . "/../");
$dotenv->load();

$app = new \Slim\App(['settings' => $config]);

$container = $app->getContainer();

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler('../logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
  $db = $c['settings']['db'];
  $pdo = new PDO('mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME'),getenv('DB_USER'),getenv('DB_PASS'));
  // $pdo = new PDO('mysql:host='.$db['host'].';dbname='.$db['dbname'],$db['user'],$db['pass']);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  return $pdo;
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('../app/views', [
        '../app/views/cache' => '../cache'
    ]);
    return $view;
};

// API Routes
//=============================

$container['MealsAPIController'] = function($container) {
  return new \Tasteez\Controllers\Api\Meals($container);
};

$app->group('/api', function() {

  $this->group('/meals', function() {
    $this->get('/all', 'MealsAPIController:all');
    $this->get('/popular', 'MealsAPIController:latest');
    $this->get('/{id}', 'MealsAPIController:getMealDetails');
  });

  $this->group('/user', function() {
    $this->get('/update-password', 'MealsAPIController:all');
    $this->get('/update-email', 'MealsAPIController:latest');
    $this->get('/delete-account', 'MealsAPIController:latest');
  });

});


// View Routes
//=============================

$container['HomeController'] = function($container) {
  return new \Tasteez\Controllers\Home($container);
};

$container['DiscoverController'] = function($container) {
  return new \Tasteez\Controllers\Discover($container);
};

$container['RecipeController'] = function($container) {
  return new \Tasteez\Controllers\Recipe($container);
};

$container['RecommendedController'] = function($container) {
  return new \Tasteez\Controllers\Recommended($container);
};

$container['CategoriesController'] = function($container) {
  return new \Tasteez\Controllers\Categories($container);
};

$container['MostPopularController'] = function($container) {
  return new \Tasteez\Controllers\MostPopular($container);
};

$container['CategoryController'] = function($container) {
  return new \Tasteez\Controllers\Category($container);
};

$container['PrivacyPolicyController'] = function($container) {
  return new \Tasteez\Controllers\PrivacyPolicy($container);
};

$container['AccountController'] = function($container) {
  return new \Tasteez\Controllers\Account($container);
};

$container['FavouriteController'] = function($container) {
  return new \Tasteez\Controllers\Favourites($container);
};

$container['ContactController'] = function($container) {
  return new \Tasteez\Controllers\Contact($container);
};

$container['SearchController'] = function($container) {
  return new \Tasteez\Controllers\Search($container);
};


$app->get('/', 'HomeController');
$app->get('/discover', 'DiscoverController');
$app->get('/recipe', 'RecipeController');
$app->get('/recommended', 'RecommendedController');
$app->get('/categories', 'CategoriesController');
$app->get('/most-popular', 'MostPopularController');
$app->get('/category', 'CategoryController');
$app->get('/privacy-policy', 'PrivacyPolicyController');
$app->get('/account', 'AccountController');
$app->get('/favourites', 'FavouriteController');
$app->get('/contact', 'ContactController');
$app->get('/search', 'SearchController');
$app->run();
