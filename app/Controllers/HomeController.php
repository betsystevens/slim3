<?php
namespace App\Controllers;

use Monolog\Logger as Logger;
use Slim\Views\Twig as View;

class HomeController {

    protected $logger;
    protected $view;

    public function __construct(Logger $logger, View $view)
    {
        $this->logger = $logger;
        $this->view = $view;
    }

    public function list($request, $response)
    {
        $this->logger->addInfo("HomeController list");

        $myfile = fopen("../data/card.json", "r") or die("Unable to open file!");
        $arr =  fread($myfile,filesize("../data/card.json"));
        fclose($myfile);
        $data = json_decode($arr, true);
        $response = $this->view->render
            (
                $response, 
                "layout.html.twig",
                ['data' => $data]
            );
        return $response;
    }

    public function contact($request, $response)
    {
        $this->logger->addInfo("contact");
        $response = $this->view->render (
            $response,
            "contact.html.twig",
            [
                "title" => "About"
            ]
        );
        return $response;
    }

    public function contactSubmit($request, $response)
    {
        $this->logger->addInfo("submit: getting post data");
        $data = $request->getParsedBody();
        $name = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $message = filter_var($data['message'], FILTER_SANITIZE_STRING);
        $email = filter_var($data['email'], FILTER_SANITIZE_STRING);

        $this->logger->addInfo("submit: filling in email");
        $subject = "Message from: $name, $email";
        $to = "betsystevens5@gmail.com";

        $this->logger->addInfo("submit: sending mail");
        $return = mail($to, $subject, $message);
        $this->logger->addInfo("mail return: $return");
        return $response->withRedirect('/thankYou');   
    }

    public function thankYou($request, $response)
    {
        $response = $this->view->render (
            $response,
            "thankYou.html.twig",
            [
                "title" => "Thank You"
            ]
        );
        return $response;
    }
}