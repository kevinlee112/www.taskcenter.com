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
        'name' => ['required' => false, 'type' => 'string'],
        'code' => ['required' => false, 'type' => 'string'],
        'is_super' => ['required' => false, 'type' => 'number'],
        'level' => ['required' => false, 'type' => 'number'],
    ];
    
    protected $_parameters = [
        'name','code','is_super','level'
    ];

    private $roleModel;
    
    public function process()
    {
        $params = $this->filterParams();

        if($this->getRequest()->ispost())
        {
            if(empty($params['name']) || empty($params['code']))
            {
                $this->response(Public_Error::ERR_PARAM);
            }

            $this->roleModel = new Service_Manager_RoleModel();

            $checkExist = $this->roleModel->getRoleInfoByName($params['name']);

            if(!empty($checkExist))
            {
                $this->response(Public_Error::ERR_ROLE_HAS_EXISTED);
            }

            $result = $this->roleModel->addRole($params);

            if($result)
            {
                $this->redirect('/manager/role/list.html');
                //$this->response(Public_Error::SUCCESS);
            }
            else
            {
                $this->response(Public_Error::FAIL);
            }
            exit;
        }

        $this->assign('title','角色添加');

    }
}
