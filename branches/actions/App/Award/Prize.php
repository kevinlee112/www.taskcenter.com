<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * 奖品及设置
 * 
 * @author     guodong5@leju.com
 * @version    $Id$
 */

class PrizeAction extends Base_Action
{
    protected $_rules = [
        'id' => ['required' => true, 'type' => 'number'],
    ];

    protected $_rule = [
        'award_list' => ['required' => true, 'type' => 'string'], //奖品列表数据
        'award_list_title' => ['required' => true, 'type' => 'string'], //奖品列表文字
        'award_list_title_color' => ['required' => true, 'type' => 'string'], //奖品列表文字颜色
        'task_title' => ['required' => true, 'type' => 'string'], //日常任务文字
        'task_title_color' => ['required' => true, 'type' => 'string'], //日常任务文字颜色
        'ad_provider' => ['required' => true, 'type' => 'string'], //赞助商
    ];
    
    protected $_parameters = [
        'id','award_list','award_list_title','award_list_title_color','task_title','task_title_color',
        'ad_provider'
    ];

    private $awardModel;
    
    public function process()
    {
        $params = $this->filterParams();

        $this->awardModel= new Service_App_AwardModel();

        $awardInfo = $this->awardModel->getAwardInfoById($params['id']);

        if(empty($awardInfo))
        {
            $this->response(Public_Error::ERR_AWARD_NOT_EXIST);
        }

        $configJson = json_decode($awardInfo['config_json'],true);
        $awardJson = $awardInfo['award_json'];

        if($this->getRequest()->ispost())
        {
            $params = $this->filterParams();

            $checkRes = Validate::check($params,$this->_rule,true);

            if(!empty($checkRes))
            {
                $this->response(Public_Error::ERR_PARAM);
            }

            $checkExists = $this->awardModel->getAwardInfoById($params['id']);

            if(empty($checkExists))
            {
                $this->response(Public_Error::ERR_AWARD_NOT_EXISTED);
            }

            $result = $this->awardModel->updatePrizeInfo($params['id'],$params);

            if($result)
            {
                $this->redirect('/app/award/index.html');
            }
            else
            {
                $this->response(Public_Error::FAIL);
            }
            exit;
        }

        $this->assign('awardInfo', $awardInfo);
        $this->assign('prizeinfo', $awardJson);
        $this->assign('info', $configJson);
        $this->assign('id', $params['id']);
        $this->assign('title', "活动奖品");

    }
}