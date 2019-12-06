<?php

namespace App\Core;

use App\Core\Registry;
use App\Core\Router;
use App\Adapter\RedBeanAdapter;
use Symfony\Component\HttpFoundation\Response;

class Application
{
    /**
     *
     * @var Registry
     */
    public $config;  

    /**
     *
     * @param array $config
     */
    public function run($config = [])
    {    
        $this->config = new Registry($config);      
        $this->response = new Response();
        $this->router = new Router($this->config->routes);        
        RedBeanAdapter::setup($this->config->db);
        $this->execute();
    }

    public function execute()
    {
        $controllerName = $this->router->getControllerName();
        try {
            $controllerClass = '\\App\Controllers\\' . $controllerName . 'Controller';
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass;
                if ($controller instanceof Controller) {
                    $controller->setApplication($this)->run();
                }
            } else {
                throw new \Exception('Controller "' . $controllerName . '" not exists: ' . $_SERVER["REQUEST_URI"]);
            }
        } catch (\Exception $e) {
            $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
            $this->router->error404();
            $this->execute();
            exit();
        }

        $this->response->send();
    }  
    
}
