<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * Login.php
 * 
 * @author     guodong5@leju.com
 * @version    $Id$
 */

class LogoutAction extends Base_Action
{
    protected $_rules = [];
    
    protected $_parameters = [];
    
    public function process()
    {
        setcookie('user_id', '', 0, '/');
        setcookie('user_name', '', 0, '/');
        setcookie('real_name', '', 0, '/');
        setcookie('user_sign', '', 0, '/');

        //Yaf_Session::getInstance()->set('user_id','');
        //Yaf_Session::getInstance()->set('user_name','');

        $this->redirect('/manager/user/login.html');
    }
}