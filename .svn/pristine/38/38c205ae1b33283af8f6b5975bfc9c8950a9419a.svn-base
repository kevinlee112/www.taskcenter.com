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
        'id' => ['required' => false, 'type' => 'number'],
        'name' => ['required' => false, 'type' => 'string'],
        'code' => ['required' => false, 'type' => 'string'],
        'page' => ['required' => false, 'type' => 'number']
    ];
    
    protected $_parameters = [
        'id','name','code','page'
    ];

    private $userModel;
    
    public function process()
    {
        $params = $this->filterParams();

        if(empty($params['page']))
        {
            $params['page'] = 1;
        }

        $this->roleModel = new Service_Manager_RoleModel();

        $total = $this->roleModel->getRoleTotal($params['id'], $params['name']);

        $list = $this->roleModel->getRoleList($params['id'], $params['name'],$params['page']);

        Yaf_Loader::import(PATH_FW_TOOLS . 'Page.php');
        $page = new Tools_page($total,$params['page']);

        $this->assign('list', $list);
        $this->assign('name', $params['name']);
        $this->assign('id', $params['id']);
        $this->assign('code', $params['code']);
        $this->assign('page_html', $page->get_html());
        $this->assign('title', "角色列表");
    }
}