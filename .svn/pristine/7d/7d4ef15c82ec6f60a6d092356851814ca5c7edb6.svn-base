<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * 综合查询
 * 
 * @author     guodong5@leju.com
 * @version    1.0
 */

class MultiselectAction extends Base_Action
{
    protected $_rules = [
        'sql' => [ 'required' => false,'msg' => 'no sql input'],
        'db_name' => [ 'required' => true, 'type' => 'string'],
        'explain' => [ 'required' => false, 'type' => 'number'],
    ];
    
    protected $_parameters = [
        'sql','explain','db_name'
    ];

    private $dbModel;
    
    public function process()
    {
        $params = $this->filterParams();

        $this->dbModel = new Service_Manager_DboperateModel();

        $list =  $fields = '';

        if($this->getRequest()->ispost())
        {
            if(!isset($params['sql']) || empty($params['sql']))
            {
                $this->response(Public_Error::ERR_PARAM);
            }

            if(strpos($params['sql'],'select') === false && strpos($params['sql'],'SELECT') === false)
            {
                $this->response(Public_Error::ERR_SQL_NO_SELECT);
            }

            //$checkExists = $this->dbModel->checkExists($params['db_name'],$table_name);

            //if(!$checkExists)
            //{
            //    $this->response(Public_Error::ERR_SQL_NOT_EXISTS);
            //}

            $sql = $params['sql'];

            if($params['explain'])
            {
                $sql = "EXPLAIN ".$params['sql']; //explain 语句
            }

            if(!$params['explain'] && strpos($params['sql'],'limit') === false) //如果没有limit限制 默认取50条
            {
                $sql .= " limit 50";
            }

            $this->dbModel = new Service_Manager_DboperateModel();

            $list = $this->dbModel->getSqlList($sql,$params);

            $fields  = !isset($list['code']) ? array_keys($list[0]) : array_keys($list);

            if($params['explain'])
            {
                $this->response(Public_Error::SUCCESS,$list);
                exit;
            }
        }

        $this->assign('db_name',$params['db_name']);
        $this->assign('sql', $params['sql']);
        $this->assign('fields',$fields);
        $this->assign('list', $list);
        $this->assign('title','综合查询');
    }
}