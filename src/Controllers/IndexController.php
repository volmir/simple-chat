<?php

namespace App\Controllers;

use App\Core\Controller;
use RedBeanPHP\R as RedBean;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller {

    public function indexAction() {        
        $this->view->set([
            'title' => 'Chat'
        ]);

        $this->view->render('index');
    }

    public function addAction() {
        $request = Request::createFromGlobals();
        
        $messageText = $request->request->get('mess');
        $username = $request->request->get('username');
        if (!empty($messageText)) {
            $message = RedBean::dispense('messages');
            $message->username = $username;
            $message->message = $messageText; 
            RedBean::store($message);
        }
    }
    
    public function getAction() {
        $sql = "SELECT * FROM messages 
                ORDER BY date_created DESC
                LIMIT 10";
        $messages = RedBean::getAll($sql);
        
        $messages = array_reverse($messages);
      
        $response = new Response();
        $response->setContent(json_encode($messages));
        $response->headers->set('Content-Type', 'application/json');        
        $response->send();
    }   
    
}
