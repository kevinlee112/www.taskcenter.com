<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * Login.php
 * 
 * @author     guodong5@leju.com
 * @version    $Id$
 */

class ChangepwdAction extends Base_Action
{
    protected $_rules = [
        'id' => ['required' => true, 'type' => 'number'],
        'oldpasswd' => ['required' => false, 'type' => 'string','regex'=>'/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\\\|\!\@\#\$\%\^\&\*\(\)\_\+\{\}\[\]\,\.\;\:\/\?\`\~\<\>\'\"\=\-]).{8,16}$/'],
        'newpasswd' => ['required' => false, 'type' => 'string','regex'=>'/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\\\|\!\@\#\$\%\^\&\*\(\)\_\+\{\}\[\]\,\.\;\:\/\?\`\~\<\>\'\"\=\-]).{8,16}$/'],
    ];
    
    protected $_parameters = [
        'id','oldpasswd','newpasswd'
    ];

    private $userModel;

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

        if($this->getRequest()->ispost())
        {

            if(empty($params['oldpasswd']) || empty($params['newpasswd']))
            {
                $this->response(Public_Error::ERR_PARAM);
            }

            if($params['oldpasswd'] == $params['newpasswd'])
            {
                $this->response(Public_Error::ERR_PASSWORD_SAME);
            }

            if(md5($params['oldpasswd']) != $userInfo['password'])
            {
                $this->response(Public_Error::ERR_USER_WRONG_PASSWORD);
            }

            $result = $this->userModel->updateUserPwd($params['id'],$params['newpasswd']);

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

        $this->assign('id', $params['id']);
        $this->assign('title', '修改用户密码');

    }
}