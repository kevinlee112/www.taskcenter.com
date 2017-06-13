<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * Login.php
 * 
 * @author     guodong5@leju.com
 * @version    $Id$
 */

class UpdatepwdAction extends Base_Action
{
    protected $_rules = [
        'oldpasswd' => ['required' => false, 'type' => 'string','regex'=>'/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\\\|\!\@\#\$\%\^\&\*\(\)\_\+\{\}\[\]\,\.\;\:\/\?\`\~\<\>\'\"\=\-]).{8,16}$/'],
        'newpasswd' => ['required' => false, 'type' => 'string','regex'=>'/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\\\|\!\@\#\$\%\^\&\*\(\)\_\+\{\}\[\]\,\.\;\:\/\?\`\~\<\>\'\"\=\-]).{8,16}$/'],
    ];
    
    protected $_parameters = [
        'oldpasswd','newpasswd'
    ];

    private $userModel;

    public function process()
    {
        $params = $this->filterParams();

        $this->userModel = new Service_Manager_UserModel();

        $userInfo = $this->userModel->getUserInfoById($_COOKIE['user_id']);

        if(empty($userInfo))
        {
            $this->response(Public_Error::ERR_INFO_NOT_EXISTS);
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

            $result = $this->userModel->updateUserPwd($_COOKIE['user_id'],$params['newpasswd']);

            if($result)
            {
                $this->response(Public_Error::SUCCESS);
            }
            else
            {
                $this->response(Public_Error::FAIL);
            }

            exit;
        }

        $this->assign('title', '修改密码');

    }
}