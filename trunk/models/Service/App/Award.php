<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 *
 * app活动
 *
 */

class Service_App_AwardModel extends Base_Dao
{
    protected $_daoAward;
    protected $_limit = DEFAULT_PAGE_LIMIT;

    /**
     * 构造方法
     */
    public function __construct()
    {
        $this->_daoAward = new Dao_App_AwardModel();
    }

    /**
     * 获取活动总数
     * @param $id
     * @param $name
     * @param $activity_id
     *
     */
    public function getAwardTotal($id, $name, $activity_id)
    {
        return $this->_daoAward->getAwardTotal($id, $name, $activity_id);
    }

    /**
     * 获取活动列表
     * @param $id
     * @param $name
     * @param $activity_id
     * @param $page
     */
    public function getAwardList($id, $name, $activity_id, $page)
    {
        return $this->_daoAward->getAwardList($id, $name, $activity_id, $page);
    }


    /**
     * 根据活动名称获取活动信息
     * @param $name
     */
    public function getAwardInfoByName($name)
    {
        if(empty($name))
        {
            return false;
        }

        return $this->_daoAward->getAwardInfoByName($name);
    }


    /**
     * 根据活动id获取活动信息
     * @param $name
     */
    public function getAwardInfoById($id)
    {
        if(empty($id))
        {
            return false;
        }

        return $this->_daoAward->getAwardInfoById($id);
    }

    /**
     * 根据活动id获取活动信息
     * @param $name
     */
    public function getAwardInfoByActivityid($project_id, $activity_id)
    {
        if(empty($project_id) || empty($activity_id))
        {
            return false;
        }

        return $this->_daoAward->getAwardInfoByActivityid($project_id, $activity_id);
    }

    /**
     * 添加活动信息
     * @param $data
     */
    public function insertAwardInfo($param)
    {
        $data = array();

        isset($param['name']) && !empty($param['name']) && $data['name'] = trim($param['name']);
        isset($param['image_json']) && !empty($param['image_json']) && $data['image_json'] = trim($param['image_json']);
        isset($param['rule_text']) && !empty($param['rule_text']) && $data['rule_text'] = trim($param['rule_text']);
        isset($param['project_id']) && !empty($param['project_id']) && $data['project_id'] = intval($param['project_id']);
        isset($param['activity_id']) && !empty($param['activity_id']) && $data['activity_id'] = $param['activity_id'];

        $data['addtime'] = date('Y-m-d H:i:s',time());
        $data['operator'] = $_COOKIE['user_name'];//Yaf_Session::getInstance()->get('user_name');

        return $this->_daoAward->insertAwardInfo($data);
    }

    /**
     * 添加活动信息
     * @param $data
     */
    public function updateAwardInfo($id, $param)
    {
        if(empty($id) || empty($param))
        {
            return false;
        }

        $data = array();

        isset($param['name']) && !empty($param['name']) && $data['name'] = trim($param['name']);
        isset($param['image_json']) && !empty($param['image_json']) && $data['image_json'] = trim($param['image_json']);
        isset($param['rule_text']) && !empty($param['rule_text']) && $data['rule_text'] = trim($param['rule_text']);
        isset($param['project_id']) && !empty($param['project_id']) && $data['project_id'] = intval($param['project_id']);
        isset($param['activity_id']) && !empty($param['activity_id']) && $data['activity_id'] = $param['activity_id'];
        isset($param['status']) && $data['status'] = intval($param['status']);

        $data['updatetime'] = date('Y-m-d H:i:s',time());;
        $data['operator'] = $_COOKIE['user_name'];//Yaf_Session::getInstance()->get('user_name');

        return $this->_daoAward->updateAwardInfo($id,$data);
    }

    /**
     * 添加活动奖品及设置
     * @param $data
     */
    public function updatePrizeInfo($id, $param)
    {
        if(empty($id) || empty($param))
        {
            return false;
        }

        $configData = array();

        $configData['award_list_title'] = $param['award_list_title']; //奖品列表文字

        if(strpos($param['award_list_title_color'],'#') === false)  //奖品列表文字颜色
        {
            $configData['award_list_title_color'] = '#'.$param['award_list_title_color'];
        }
        else
        {
            $configData['award_list_title_color'] = $param['award_list_title_color'];
        }

        $configData['task_title'] = $param['task_title'];  //日常任务文字

        if(strpos($param['task_title_color'],'#') === false)  //日常任务文字颜色
        {
            $configData['task_title_color'] = '#'.$param['task_title_color'];
        }
        else
        {
            $configData['task_title_color'] = $param['task_title_color'];
        }

        $configData['ad_provider'] = $param['ad_provider']; //赞助商

        $data = array();

        if(!empty($param['award_list']))
        {

            $data['award_json'] = $param['award_list'];
        }

        if(!empty($configData))
        {
            $data['config_json'] = json_encode($configData);
        }

        if(empty($data))
        {
            return false;
        }

        $data['updatetime'] = date('Y-m-d H:i:s',time());
        return $this->_daoAward->updateAwardInfo($id, $data);
    }

    /**
     * 获得活动信息
     * @param $project_id
     * @param $activity_id
     * @return bool
     */
    public function getActivityInfo($project_id, $activity_id, $activity_type)
    {
        if(empty($project_id) || empty($activity_id) || empty($activity_type))
        {
            return false;
        }

        $apiModel = new Api_ActivityModel();

        $result = $apiModel->getActivityInfo($project_id, $activity_id, $activity_type);

        return $result;
    }

    /**
     * 删除活动
     * @param $id
     */
    public function deleteAward($id)
    {
        if(empty($id))
        {
            return false;
        }

        return $this->_daoAward->deleteAwardInfo($id);
    }




}