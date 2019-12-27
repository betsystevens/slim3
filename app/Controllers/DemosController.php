<?php
namespace App\Controllers;

use Monolog\Logger as Logger;
use Slim\Views\Twig as View;

class DemosController {

  protected $logger;
  protected $view;
  protected $data;

  public function __construct(Logger $logger, View $view)
  {
    $this->logger = $logger;
    $this->view = $view;
    $this->data = $this->loadData();
  }

  private function loadData() {
    $demoDataFile = fopen("../data/demoCard.json", "r") or die("Unable to open file");
    $demoData = fread($demoDataFile, filesize("../data/demoCard.json"));
    fclose($demoDataFile);
    $data = json_decode($demoData, true);
    return $data;
  }

  public function getDemo($request, $response, $args)
  {
    $this->logger->addInfo("Demos cards");
    $whichDemo = $args['whichDemo'];
    $title = $this->data[$whichDemo]['title'];
     
    $response = $this->view->render
        (
            $response, 
            $this->data[$whichDemo]['cardTemplate'],
            [
                'title' => $title
            ]
        );
    // die("here");
    return $response;
 } 
}