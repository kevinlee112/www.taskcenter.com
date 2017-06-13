<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * Login.php
 * 
 * @author     guodong5@leju.com
 * @version    $Id$
 */

class AddAction extends Base_Action
{
    protected $_rules = [
        'username' => ['required' => false, 'type' => 'string'],
        'password' => ['required' => false, 'type' => 'string','regex'=>'/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\\\|\!\@\#\$\%\^\&\*\(\)\_\+\{\}\[\]\,\.\;\:\/\?\`\~\<\>\'\"\=\-]).{8,16}$/'],
        'realname' => ['required' => false, 'type' => 'string'],
        'role' => ['required' => false, 'type' => 'number'],
        'city' => ['required' => false, 'type' => 'string'],
        'status' => ['required' => false, 'type' => 'number'],
        'gender' => ['required' => false, 'type' => 'number'],
        'department' => ['required' => false, 'type' => 'string'],
        'position' => ['required' => false, 'type' => 'string'],
    ];
    
    protected $_parameters = [
        'username','password','realname','role','city','status',
        'gender','department','position'
    ];

    private $roleModel;
    private $cityModel;
    private $userModel;
    
    public function process()
    {
        $this->cityModel = new Service_Manager_CityModel();

        $cityList = $this->cityModel->getCityOptions();

        $this->roleModel = new Service_Manager_RoleModel();

        $roleList = $this->roleModel->getRoleOptions();

        if($this->getRequest()->ispost())
        {
            $params = $this->filterParams();

            if(empty($params['username']) || empty($params['password']) || empty($params['realname']) || empty($params['role']))
            {
                $this->response(Public_Error::ERR_PARAM);
            }

            $this->userModel = new Service_Manager_UserModel();

            $checkExists = $this->userModel->getUserInfoByName($params['username']);

            if(!empty($checkExists))
            {
                $this->response(Public_Error::ERR_USER_HAS_EXISTED);
            }

            $result = $this->userModel->insertUserInfo($params);

            if($result)
            {
                $this->redirect('/manager/user/list.html');
                //$this->response(Public_Error::SUCCESS);
            }
            else
            {
                $this->response(Public_Error::FAIL);
            }
            exit;
        }

        $this->assign('cityList', $cityList);
        $this->assign('roleList', $roleList);
        $this->assign('title', "添加用户");

    }
}