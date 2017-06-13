<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * 删除活动
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

    private $awardModel;

    public function process()
    {
        $param = $this->filterParams();

        $this->awardModel = new Service_App_AwardModel();

        $awardInfo = $this->awardModel->getAwardInfoById($param['id']);

        if(empty($awardInfo))
        {
            $this->response(Public_Error::ERR_INFO_NOT_EXISTS);
        }

        $result = $this->awardModel->deleteAward($param['id']);

        if($result)
        {
            $this->redirect('/app/award/index.html');
        }
        else
        {
            $this->response(Public_Error::FAIL);
        }
    }
}