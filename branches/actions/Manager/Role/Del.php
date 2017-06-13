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

        $result = $this->roleModel->deleteRole($params['id']);

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
}