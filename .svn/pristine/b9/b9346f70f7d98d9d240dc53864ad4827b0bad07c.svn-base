<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * 检查活动是否 存在
 * 
 * @author     guodong5@leju.com
 * @version    $Id$
 */

class CheckactivityAction extends Base_Action
{
    protected $_rules = [
        'project_id' => ['required' => true, 'type' => 'number'],
        'activity_id' => ['required' => true, 'type' => 'number'],
        'type' => ['required' => true, 'type' => 'string'],
    ];
    
    protected $_parameters = [
        'project_id','activity_id','type'
    ];

    private $awardModel;
    
    public function process()
    {
        $this->awardModel= new Service_App_AwardModel();

        if($this->getRequest()->ispost())
        {
            $params = $this->filterParams();

           /* if($params['type'] == 'info')
            {
                $checkExist  = $this->awardModel->getAwardInfoByActivityid($params['project_id'],$params['activity_id']);

                if(!empty($checkExist))
                {
                    $this->response(Public_Error::ERR_AWARD_HAS_EXIST);
                }
            }*/

            $activity_type = "standarddraw";

            $result = $this->awardModel->getActivityInfo($params['project_id'], $params['activity_id'],$activity_type);//343  127  fission

            if(empty($result))
            {
                $this->response(Public_Error::FAIL);
            }

            $res = json_decode($result,true);
            //print_r($res);exit;
            if($params['type'] == 'prize')
            {
                if(!empty($res['entry']['info']['prize_list']))
                {
                    $prizeData = $res['entry']['info']['prize_list'];

                    $this->response(0,json_encode($prizeData));
                }
            }

            if($params['type'] == 'info')
            {
                if($res['entry']['info']['activity_info']['activity_type_name'] != '')
                {
                    $this->response(0,$res['entry']['info']);
                }
            }

            $this->response(1,Public_Error::FAIL);

            exit;
        }

    }
}
