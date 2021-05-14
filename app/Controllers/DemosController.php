<?php
namespace App\Controllers;

use Monolog\Logger as Logger;
use Slim\Views\Twig as View;

class DemosController {

  /**
   * Monolog logger
   */
  protected $logger;

  /**
   * Twig for viewing
   */
  protected $view;

  /**
   * Data file containing information about each demo 
   * Contains demo title, template file name, routes, 
   *  content text, etc. for each demo
   *  
   *  Add test line 
   */
  protected $data;

  public function __construct(Logger $logger, View $view)
  {
    $this->logger = $logger;
    $this->view = $view;
    $this->data = $this->loadData();
  }

  /**
   *  Read the demos data file
   */
  private function loadData() {
    $demoDataFile = fopen("../data/demoCard.json", "r") or die("Unable to open file");
    $demoData = fread($demoDataFile, filesize("../data/demoCard.json"));
    fclose($demoDataFile);
    $data = json_decode($demoData, true);
    return $data;
  }

  /**
   * Get data and view for selected demo 
   * Return in response
   * 
   * @param object    $request    request object for current HTTP request 
   * @param object    $response   current HTTP response to be returned to client
   * @param array     $args       contains which demo to display
   * 
   * @return object   $response   current HTTP response
   */
  public function getDemo($request, $response, $args)
  {
    $this->logger->addInfo("Demos cards");
    $whichDemo = $args['whichDemo'];
    $this->logger->addInfo($whichDemo);
    $title = $this->data[$whichDemo]['title'];

    $route = $request->getAttribute('route'); 
    $name = $route->getName();

    $response = $this->view->render
        (
            $response, 
            $this->data[$whichDemo]['cardTemplate'],
            [
                'title' => $title
            ]
        );
    return $response;
 } 
}