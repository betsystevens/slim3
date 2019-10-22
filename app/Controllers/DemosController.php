<?php
namespace App\Controllers;

use Monolog\Logger as Logger;
use Slim\Views\Twig as View;

class DemosController {

  protected $logger;
  protected $view;

  public function __construct(Logger $logger, View $view)
  {
    $this->logger = $logger;
    $this->view = $view;
  }

  public function panels($request, $response)
  {
    $this->logger->addInfo("Demos panels");
    $response = $this->view->render
        (
            $response, 
            'panels.html.twig', 
            [
                'title' => 'Flex Panels'
            ]
        );
    return $response;
  }

  public function vanGogh($request, $response)
  {
    $this->logger->addInfo("demo vanGogh");
    $response = $this->view->render
        (
            $response, 
            'vanGogh.html.twig', 
            [
                "title" => "Van Gogh"
            ]
        );
    return $response;
  }
  public function tiles($request, $response)
  {
    $this->logger->addInfo("demo tiles");
    $response = $this->view->render
        (
            $response, 
            "tiles.html.twig", 
            [
                "title" => "Tiles"
            ]
        );
    return $response;
  }
  public function keyCode($request, $response)
  {
    $this->logger->addInfo("demo keyCode");
    $response = $this->view->render
        (
            $response, 
            "keyCode.html.twig", 
            [
                "title" => "Key Codes"
            ]
        );
    return $response;
  }
}