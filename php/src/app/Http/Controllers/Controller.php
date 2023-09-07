<?php

namespace App\Http\Controllers;

class Controller {

    protected function view($view, array $params = array()) {
        ob_start();
        extract($params);
        include_once VIEW_PATH . '/' . $view . '.php';
        $html = ob_get_clean();
        return $html;
    }
}
