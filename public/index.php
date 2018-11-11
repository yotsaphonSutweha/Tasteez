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

require '../app/middleware.php';
require '../app/controllers.php';
require '../app/routes.php';

$app->run();
