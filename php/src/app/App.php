<?php

namespace App;

class App {

    public function handle(array $routes)
    {
        $uri = $_SERVER['PATH_INFO'] ?? $_SERVER['REQUEST_URI'];
        foreach ($routes as $path => $controllerMethod) {
            if ($uri === $path) {
                list($conroller, $method) = explode('@', $controllerMethod);
                //try{
                    echo (new $conroller)->{$method}();
                //} catch (\Exception $e) {
                   // echo $e->getMessage();
                //}
                return;
            }
        }

        header("HTTP/1.0 404 Not Found");
        exit();
    }

}
