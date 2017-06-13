<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * Login.php
 * 
 * @author     guodong5@leju.com
 * @version    $Id$
 */

class DelAction extends Base_Action
{
    protected $_rules = [
        'id' => ['required' => true, 'type' => 'number'],
    ];
    
    protected $_parameters = [
        'id'
    ];

    private $userModel;

    public function process()
    {
        $param = $this->filterParams();

        $this->userModel = new Service_Manager_UserModel();

        $userInfo = $this->userModel->getUserInfoById($param['id']);

        if(empty($userInfo))
        {
            $this->response(Public_Error::ERR_INFO_NOT_EXISTS);
        }

        $result = $this->userModel->deleteUser($param['id']);

        if($result)
        {
            $this->redirect('/manager/user/list.html');
            //$this->response(Public_Error::SUCCESS);
        }
        else
        {
            $this->response(Public_Error::FAIL);
        }
    }
}