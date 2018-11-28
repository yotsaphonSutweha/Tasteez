<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Leafo\ScssPhp\Compiler;
require '../vendor/autoload.php';
require '../config.php';

// Uncommnet to compile Sass
// $scss = new Compiler();
// $scss->setImportPaths('../app/sass/');
// $css = $scss->compile(file_get_contents('../app/sass/index.scss'));
// $css_file = './stylesheets/index.css';
// $handle = fopen($css_file, 'w') or die('Cannot open file:  '.$css_file);
// fwrite($handle, $css);

$dotenv = new Dotenv\Dotenv(__DIR__ . "/../");
$dotenv->load();
error_reporting(0);

$app = new \Slim\App(['settings' => $config]);
// $app->add(new \Slim\HttpCache\Cache('public', 86400));
$container = $app->getContainer();


$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler('../logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
    $DB_HOST="db4free.net";
    $DB_USER="nciscript_test";
    $DB_PASS="letmein123";
    $DB_NAME="recipes_test";

    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME. ";charset=UTF8",$DB_USER,$DB_PASS);
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


require '../app/controllers.php';
require '../app/routes.php';

$app->run();

