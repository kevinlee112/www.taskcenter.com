<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * 修改活动状态
 * 
 * @author     guodong5@leju.com
 * @version    $Id$
 */

class ChangestatusAction extends Base_Action
{
    protected $_rules = [
        'id' => ['required' => true, 'type' => 'number'],
        'status' => ['required' => false, 'type' => 'number'],
    ];
    
    protected $_parameters = [
        'id','status'
    ];

    private $awardModel;
    
    public function process()
    {
        $this->awardModel= new Service_App_AwardModel();

        if($this->getRequest()->isget())
        {
            $params = $this->filterParams();

            $result = $this->awardModel->getAwardInfoById($params['id']);

            if(empty($result))
            {
                $this->response(Public_Error::ERR_AWARD_NOT_EXIST);
            }

            if($params['status'] == 0)
            {
                if(empty($result['award_json']) || empty($result['config_json']))
                {
                    $this->response(Public_Error::ERR_AWARD_CONFIG_ERROR);
                }
            }

            $result = $this->awardModel->updateAwardInfo($params['id'],$params);

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
}