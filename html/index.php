<?php 

/*
 *  developement and testing 
 *  setup to run ~/slim3/html/index.php
 * 
 *  in cli
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

// file to manage dependencies
require '../vendor/autoload.php';

// use this in developer mode for error messages
$config['displayErrorDetails'] = true;

// it all starts here with Slim's App object
$app = new \Slim\App(['settings' => $config]);

$container = $app->getContainer();

// using Monolog's logger for php applications
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('demoApp');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

// load Twig for views
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('../templates', [
        'debug' => true,
        'cache' => '../cache'
    ]);
    return $view;
};

// load controllers
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

// Routes

// for testing stuff
$app->get('/test', 'TestController:helloTest' );

// demo home page - show demo cards
$app->get('/demo', 'HomeController:list');

// contact and about page
$app->get('/contact', 'HomeController:contact');

// contact form submitted    
$app->post ('/contact/submit', 'HomeController:contactSubmit');
  
// thank you for submitting contact
$app->get ('/thankYou', 'HomeController:thankYou');

// panels enlarged on mouse clicks
$app->get('/demo/panels', 'DemosController:panels' );

// vanGogh thumbnails and enlarged images
$app->get('/demo/vanGogh', 'DemosController:vanGogh' );

// tiles that spinout
$app->get('/demo/tiles', 'DemosController:tiles');
    
// keyCode - keyboard codes are displayed
$app->get('/demo/keyCode', 'DemosController:keyCode');
    
$app->run();
