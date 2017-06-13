<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * 活动添加
 * 
 * @author     guodong5@leju.com
 * @version    $Id$
 */

class AddAction extends Base_Action
{
    protected $_rules = [

    ];

    protected $_rule = [
        'name' => ['required' => true, 'type' => 'string'],
        'rule_text' => ['required' => true, 'type' => 'string'], //活动规则
        'project_id' => ['required' => true, 'type' => 'number'],
        'activity_id' => ['required' => true, 'type' => 'number'],
    ];
    
    protected $_parameters = [
        'name','rule_text','project_id','activity_id'
    ];

    private $awardModel;
    
    public function process()
    {
        $this->awardModel= new Service_App_AwardModel();

        if($this->getRequest()->ispost())
        {
            $params = $this->filterParams();

            $checkRes = Validate::check($params,$this->_rule,true);

            if(!empty($checkRes))
            {
                $this->response(Public_Error::ERR_PARAM);
            }

            $checkExist  = $this->awardModel->getAwardInfoByActivityid($params['project_id'],$params['activity_id']);

            if(!empty($checkExist))
            {
                $this->response(Public_Error::ERR_AWARD_HAS_EXIST);
            }

            $images = $this->getParam('image');  //数组元素单独接受

            $image_data = array(
                'image1'=>$images[0],
                'image2'=>$images[1],
                'image3'=>$images[2],
                'image4'=>$images[3],
                'image5'=>$images[4],
                'image6'=>$images[5],
            );

            $params['image_json'] = json_encode($image_data);

            //$checkExists = $this->awardModel->getAwardInfoByName($params['name']);

            //if(!empty($checkExists))
            //{
            //    $this->response(Public_Error::ERR_AWARD_HAS_EXISTED);
            //}

            $result = $this->awardModel->insertAwardInfo($params);

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

        $this->assign('title', "添加活动");

    }
}