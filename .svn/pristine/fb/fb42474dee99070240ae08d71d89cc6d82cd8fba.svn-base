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
        'name' => ['required' => false, 'type' => 'string'],
        'code' => ['required' => false, 'type' => 'string'],
        'is_super' => ['required' => false, 'type' => 'number'],
        'level' => ['required' => false, 'type' => 'number'],
    ];
    
    protected $_parameters = [
        'id','name','code','is_super','level'
    ];

    private $roleModel;
    
    public function process()
    {
        $params = $this->filterParams();

        $this->roleModel = new Service_Manager_RoleModel();

        $roleInfo = $this->roleModel->getRoleInfoById($params['id']);

        if(empty($roleInfo))
        {
            $this->response(Public_Error::ERR_ROLE_NOT_EXISTED);
        }

        if($this->getRequest()->ispost())
        {

            if(empty($params['name']) || empty($params['code']))
            {
                $this->response(Public_Error::ERR_PARAM);
            }

            $result = $this->roleModel->updateRole($params['id'], $params);

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

        $this->assign('roleInfo', $roleInfo);
        $this->assign('id', $params['id']);
        $this->assign('title', '角色编辑');

    }
}
