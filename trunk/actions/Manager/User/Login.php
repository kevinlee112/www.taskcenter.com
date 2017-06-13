<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * Login.php
 * 
 * @author     yulong8@leju.com
 * @version    $Id$
 */

class LoginAction extends Base_Action
{
    protected $_rules = [
        'username' => ['required' => false, 'type' => 'string'],
        'password' => ['required' => false, 'type' => 'string'],
    ];

    protected $_rule = [
        'username' => ['required' => true, 'type' => 'string'],
        'password' => ['required' => true, 'type' => 'string','regex'=> '/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\\\|\!\@\#\$\%\^\&\*\(\)\_\+\{\}\[\]\,\.\;\:\/\?\`\~\<\>\'\"\=\-]).{8,16}$/'],
    ];
    
    protected $_parameters = [
        'username', 'password'
    ];

    private $userModel;

    public function process()
    {
        Yaf_Registry::set(Base_Constants::WHETHER_LOAD_LAYOUT, true);

        $this->userModel = new Service_Manager_UserModel();

        if($this->userModel->is_login())
        {
            AppResponse::redirect('/manager/index/index.html');
        }

        if($this->getRequest()->ispost())
        {
            $params = $this->filterParams();

            $result = Validate::check($params, $this->_rule, true);

            if(!empty($result))
            {
                $this->response(Public_Error::ERR_PASSWORD_FORMAT_ERROR);
            }

            $this->userModel = new Service_Manager_UserModel();

            $loginErrorTimes = $this->userModel->getUserErrorTimes($params['username']);

            if($loginErrorTimes > 5) //错误五次用户锁定2小时
            {
                $this->response(Public_Error::ERR_USER_TIMES_OUT);
            }

            $userInfo = $this->userModel->getUserInfoByName($params['username']);

            if(empty($userInfo))
            {
                $this->response(Public_Error::ERR_USER_NOT_EXISTED);
            }

            if($userInfo['status'] == 2)
            {
                $this->response(Public_Error::ERR_USER_DISABLED);
            }

            if($userInfo['password'] != md5($params['password']))
            {
                $this->userModel->setUserErrorTimes($userInfo['id']);
                $this->response(Public_Error::ERR_USER_WRONG_PASSWORD);
            }

            //更新登录时间
            if($this->userModel->updateLoginTime($userInfo['id']))
            {
                //Yaf_Session::getInstance()->set('user_name', $userInfo['user_name']);
                //Yaf_Session::getInstance()->set('user_id', $userInfo['id']);

                $user_sign = md5($userInfo['id']."_".$userInfo['user_name']."_".$userInfo['real_name']);
                setcookie('user_name', $userInfo['user_name'], 0, '/');
                setcookie('user_id', $userInfo['id'], 0, '/');
                setcookie('real_name', $userInfo['real_name'], 0, '/');
                setcookie('user_sign', $user_sign, 0, '/');
            }

            $this->redirect('/manager/index/index.html');
            exit;
        }
        
    }
}