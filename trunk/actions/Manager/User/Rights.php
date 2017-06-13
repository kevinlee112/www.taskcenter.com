<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * 用户权限设置
 * 
 * @author     guodong5@leju.com
 * @version    $Id$
 */

class RightsAction extends Base_Action
{
    protected $_rules = [
        'id' => ['required' => true, 'type' => 'number'],
        'is_role' => ['required' => false, 'type' => 'number']
    ];
    
    protected $_parameters = [
        'id','is_role'
    ];

    private $userModel;
    private $roleModel;
    
    public function process()
    {
        $params = $this->filterParams();

        $this->userModel = new Service_Manager_UserModel();

        $this->roleModel = new Service_Manager_RoleModel();

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

        $operatorInfo = $this->userModel->getUserInfoById($_COOKIE['user_id']);

        if(empty($operatorInfo))
        {
            $this->redirect('/manager/user/login.html');
        }

        $operateRole = $this->userModel->getRoleInfoByUid($_COOKIE['user_id']); //操作人

        if($operateRole['is_super'] != 1)
        {
            if((isset($operateRole['level']) && !empty($operateRole['level'])) && ($userRole['level'] <= $operateRole['level'])) //编辑用户的权限高于操作人权限
            {
                $this->response(Public_Error::ERR_USER_NO_PRIVILEGE);
            }
        }

        $userRights = $this->userModel->getUserRights($params['id']); //编辑用户权限

        $rightsTree = $this->userModel->getRightsTree();

        if($this->getRequest()->ispost())
        {
            $rights = $this->getParam('rights');  //数组元素单独接受

            if(empty($rights))
            {
                $this->response(Public_Error::ERR_PARAM);
            }

            asort($rights);

            if($params['is_role'] == 1)  //给角色权限
            {

                $rights = implode(',', $rights);

                $data = array(
                    'rights' => $rights,
                );

                $res = $this->roleModel->updateRole($userInfo['role'],$data);
            }
            else  //给用户特殊权限
            {
                if(count($rights) > count($userRights)) //加权限
                {
                    $special_rights  = array_diff($rights,$userRights); //获得用户特殊权限

                    $special_rights = implode(',',$special_rights);
                }
                else
                {
                    if(!empty($userInfo['special_rights'])) //用户有特殊权限
                    {
                        $userSpecialRights = explode(',',$userInfo['special_rights']);

                        $dec_rights  = array_diff($userRights,$rights); //去掉的权限

                        $special_rights = array_diff($userSpecialRights,$dec_rights);

                        $special_rights = implode(',',$special_rights);
                    }
                    else  //用户没有特殊权限
                    {
                        $this->response(Public_Error::ERR_USER_HAVE_NO_SPECIAL_RIGHTS);
                    }
                }

                $data = array(
                    'special_rights' => $special_rights,
                );

                $res = $this->userModel->updateUserInfo($params['id'],$data);

                if($res)
                {
                    $userId = $params['id'];

                    $redis = new Base_Redis('redis');

                    $cache_key = md5("data_main_menu_list_{$userId}_v1.0");

                    $redis->del($cache_key);
                }

            }

            if($res)
            {
                $this->redirect('/manager/user/list.html');
                //$this->response(Public_Error::SUCCESS);
            }
            else
            {
                $this->response(Public_Error::FAIL);
            }
        }

        $this->assign('id', $params['id']);
        $this->assign('userInfo', $userInfo);
        $this->assign('userRights', $userRights);
        $this->assign('userRightsStr', implode(',',$userRights));
        $this->assign('rightsTree', $rightsTree);

    }
}
