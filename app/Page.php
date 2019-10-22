<?php
namespace App;

class Page {
    public function loadTemplate($templateFileName, $variables = [])
    {
        extract($variables);
        ob_start();
        include __DIR__ . '/../templates/' . $templateFileName;
        return ob_get_clean();
    }
}