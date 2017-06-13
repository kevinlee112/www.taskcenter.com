<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * 查询
 * 
 * @author     guodong5@leju.com
 * @version    1.0
 */

class SelectAction extends Base_Action
{
    protected $_rules = [
        'db_name' => [ 'required' => true, 'type' => 'string', 'msg' => 'db name is missing.' ],
        'table_name' => [ 'required' => true, 'type' => 'string', 'msg' => 'table name is missing.' ],
    ];

    protected  $_rule = [
        'field' => [ 'required' => true, 'type' => 'string', 'msg' => 'field is missing.' ],
        'operate' => [ 'required' => true, 'type' => 'string', 'msg' => 'opereate is missing.' ],
        'value' => [ 'required' => true, 'type' => 'string', 'msg' => 'value is missing.' ],
        'limit' => ['required' => true, 'type' => 'number'],
    ];
    
    protected $_parameters = [
        'db_name','table_name','field','operate','value','limit'
    ];

    public $dbModel;

    public function process()
    {
        $params = $this->filterParams();

        $this->dbModel = new Service_Manager_DboperateModel();

        $fields = $this->dbModel->getTableFields($params['db_name'],$params['table_name']);

        $operate = $this->dbModel->getOpereate(); //操作符

        $limits = $this->dbModel->getLimits(); //查询条数

        $list = array();

        if($this->getRequest()->ispost())
        {
            $checkRes = $this->dbModel->checkExists($params['db_name'],$params['table_name']);

            if(!$checkRes)
            {
                $this->response(Public_Error::ERR_SQL_NOT_EXISTS);
            }

            $list = $this->dbModel->getLists($params['db_name'],$params['table_name'],$params['field'],$params['value'],$params['operate'],$params['limit']);
        }

        $this->assign('list', $list);
        $this->assign('field', $params['field']);
        $this->assign('operate', $params['operate']);
        $this->assign('value', $params['value']);
        $this->assign('limit', $params['limit']);
        $this->assign('fields', $fields);
        $this->assign('operates', $operate);
        $this->assign('db_name', $params['db_name']);
        $this->assign('table_name', $params['table_name']);
        $this->assign('limits', $limits);
        $this->assign('title',"数据库管理");
    }
}