<?php

namespace App\Controllers;

use App\Core\Controller;

class SiteController extends Controller 
{
    
    public function error404Action() 
    {        
        $this->view->set([
            'title' => '404: Page not found',
        ]);
        $this->view->render('error404');
    }      
    
}
