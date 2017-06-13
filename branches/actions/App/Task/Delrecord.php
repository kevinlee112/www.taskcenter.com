<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * 删除用户任务记录
 * 
 * @author     guodong5@leju.com
 * @version    $Id$
 */

class DelrecordAction extends Base_Action
{
    protected $_rules = [
        'id' => ['required' => true, 'type' => 'number'],
    ];
    
    protected $_parameters = [
        'id'
    ];

    private $recordModel;

    public function process()
    {
        $param = $this->filterParams();

        $this->recordModel = new Service_App_RecordModel();

        $recordInfo = $this->recordModel->getRecordInfoById($param['id']);

        if(empty($recordInfo))
        {
            $this->response(Public_Error::ERR_INFO_NOT_EXISTS);
        }

        $result = $this->recordModel->deleteRecord($param['id']);

        if($result)
        {
            $this->redirect('/app/task/record.html');
        }
        else
        {
            $this->response(Public_Error::FAIL);
        }
    }
}