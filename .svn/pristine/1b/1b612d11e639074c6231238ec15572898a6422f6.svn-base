<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * Login.php
 * 
 * @author     guodong5@leju.com
 * @version    $Id$
 */

class UpdateAction extends Base_Action
{
    protected $_rules = [
        'id' => ['required' => true, 'type' => 'number'],
        'username' => ['required' => false, 'type' => 'string'],
        'realname' => ['required' => false, 'type' => 'string'],
        'role' => ['required' => false, 'type' => 'number'],
        'city' => ['required' => false, 'type' => 'string'],
        'status' => ['required' => false, 'type' => 'number'],
        'gender' => ['required' => false, 'type' => 'string'],
        'department' => ['required' => false, 'type' => 'string'],
        'position' => ['required' => false, 'type' => 'string'],
    ];
    
    protected $_parameters = [
        'id','username','realname','role','city',
        'status','status','gender','department','position'
    ];

    private $userModel;
    private $roleModel;
    private $cityModel;
    
    public function process()
    {
        $params = $this->filterParams();

        $this->userModel = new Service_Manager_UserModel();

        $this->roleModel = new Service_Manager_RoleModel();

        $this->cityModel = new Service_Manager_CityModel();

        $userInfo = $this->userModel->getUserInfoById($params['id']);

        if(empty($userInfo))
        {
            $this->response(Public_Error::ERR_INFO_NOT_EXISTS);
        }

        $userRole = $this->userModel->getRoleInfoByUid($params['id']); //编辑用户角色

        if(empty($userRole))
        {
            $this->response(Public_Error::ERR_INFO_NOT_EXISTS);
        }

        $operateId = $_COOKIE['user_id'];//Yaf_Session::getInstance()->get('user_id');

        $operatorInfo = $this->userModel->getUserInfoById($operateId);

        if(empty($operatorInfo))
        {
            $this->redirect('/manager/user/login.html');
        }

        $operateRole = $this->userModel->getRoleInfoByUid($operateId); //操作人

        if($operateRole['is_super'] != 1)
        {
            if((isset($operateRole['level']) && !empty($operateRole['level'])) && ($userRole['level'] <= $operateRole['level'])) //编辑用户的权限高于操作人权限
            {
                $this->response(Public_Error::ERR_USER_NO_PRIVILEGE);
            }
        }

        $roleList = $this->roleModel->getRoleOptions();

        $cityList = $this->cityModel->getCityOptions();

        if($this->getRequest()->ispost())
        {

            if(empty($params['username']) || empty($params['realname']) || empty($params['role']))
            {
                $this->response(Public_Error::ERR_PARAM);
            }

            $result = $this->userModel->updateUserInfo($params['id'],$params);

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

        $this->assign('userInfo', $userInfo);
        $this->assign('id', $params['id']);
        $this->assign('cityList', $cityList);
        $this->assign('roleList', $roleList);
        $this->assign('title', '用户修改');

    }
}