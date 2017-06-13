<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * Login.php
 * 
 * @author     guodong5@leju.com
 * @version    $Id$
 */

class ListAction extends Base_Action
{
    protected $_rules = [
        'username' => ['required' => false, 'type' => 'string'],
        'realname' => ['required' => false, 'type' => 'string'],
        'role' => ['required' => false, 'type' => 'string'],
        'page' => ['required' => false, 'type' => 'number'],
    ];
    
    protected $_parameters = [
        'username','realname','role','page'
    ];

    private $userModel;
    private $cityModel;
    private $roleModel;
    
    public function process()
    {
        $params = $this->filterParams();

        $this->userModel = new Service_Manager_UserModel();

        $this->cityModel =  new Service_Manager_CityModel();

        $cityList = $this->cityModel->getCityOptions();

        $this->roleModel = new Service_Manager_RoleModel();

        $roleList = $this->roleModel->getRoleOptions();

        if(empty($params['page']))
        {
            $params['page'] = 1;
        }

        $total = $this->userModel->getUserTotal($params['username'],$params['realname'],$params['role']);

        $list = $this->userModel->getUserList($params['username'],$params['realname'],$params['role'], $params['page']);

        Yaf_Loader::import(PATH_FW_TOOLS . 'Page.php');

        $page = new Tools_page($total,$params['page']);

        $this->assign('userList', $list);
        $this->assign('page_html', $page->get_html());  //分页
        $this->assign('page', $params['page']);
        $this->assign('cityList', $cityList);
        $this->assign('roleOption', $roleList);
        $this->assign('username', $params['username']);
        $this->assign('role', $params['role']);
        $this->assign('realname', $params['realname']);
        $this->assign('title','用户列表');
    }
}