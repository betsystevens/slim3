<?php 

/** 
 * 
 *  developement and testing setup
 *    to run ~/slim3/html/index.php
 * 
 *  .htaccess rewrite conditions are in 
 *   /etc/apache2/httpd.conf
 *  to run from localhost, in browser
 *   localhost/slim3/html
 *   localhost/slim3/html/
 *   localhost/slim3/html/demo/panels
 * 
 *  to use php builtin server
 *  from command line: 
 *   ~/slim3/html $ php -S localhost:8080
 * 
 *  in browser
 *   localhost:8080/demo
 *   localhost:8080/demo/vanGogh
 *   localhost:8080/demo/tiles 
 * 
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * file to manage dependencies
 */
require '../vendor/autoload.php';

/**
 * use this in developer mode for error messages
 */
$config['displayErrorDetails'] = true;

/**
 * It all starts here with Slim's App object
 */
$app = new \Slim\App(['settings' => $config]);
$container = $app->getContainer();

/**
 * using Monolog's logger for php applications
 */
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('demoApp');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

/**
 * load Twig for views
 */
$container['view'] = function ($c) {
    // $view = new \Slim\Views\Twig('../templates', [
    $view = new \Slim\Views\Twig('templates', [
        'debug' => true,
        // 3/2020 error when writing cache directory
        // try to fix, later....
        // 'cache' => '../cache'
    ]);
    return $view;
};

/**
 * load controllers
 */
$container['HomeController'] = function ($c) {
    return new \App\Controllers\HomeController (
        $c->logger,
        $c->view
    );
};
$container['DemosController'] = function ($c) {
    return new \App\Controllers\DemosController(
        $c->logger,
        $c->view
    );
};
$container['TestController'] = function ($c) {
    return new \App\Controllers\TestController(
        $c->logger,
        $c->view
    );
};


/**
 *  Routes
 */

 /**
  * route for testing stuff
  */
// $app->get('/test/{demo}', 'TestController:test');

/**
 * demo home page - show demo cards
 */
$app->get('/', 'HomeController:list');
// $app->get('/demo/', 'HomeController:list');
$app->get('/demo', 'HomeController:list');

/**
 * display  a demo that was selected from demo home page
 */
$app->get('/demo/{whichDemo}', 'DemosController:getDemo' );

/**
 *  contact and about page
 */
$app->get('/contact', 'HomeController:contact');

/**
 * contact form submitted    
 */
$app->post ('/contact/submit', 'HomeController:contactSubmit');
 
/**
 *  thank you for submitting contact
 */
$app->get ('/thankYou', 'HomeController:thankYou');

$app->run();
