<?php

class IndexController extends Yaf_Controller_Abstract
{
    public function indexAction()
    {
        $this->getView()->assign('content', 'Hello, Yaf');
        //echo 'Hello, Yaf';
        $this->getView()->display('index.html');
        exit;
    }
    
    public function testAction()
    {
        echo 'hello test.';
        $demo='123';
        $this->getView()->assign('content', 'Hello, Yaf');
        $this->getView()->assign('demo', $demo);
        //$this->getView()->display('index.html');
        $this->getView()->display('Content/Ad/start_map.html');

    }
}
