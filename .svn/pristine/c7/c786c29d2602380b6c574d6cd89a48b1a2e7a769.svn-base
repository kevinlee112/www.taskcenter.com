<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 *
 * app活动用户记录
 *
 */

class Service_App_RecordModel extends Base_Dao
{
    protected $_daoRecord;
    protected $_limit = DEFAULT_PAGE_LIMIT;

    /**
     * 构造方法
     */
    public function __construct()
    {
        $this->_daoRecord = new Dao_App_RecordModel();
    }

    /**
     * 获取用户任务记录总数
     * @param $id
     * @param $name
     * @param $activity_id
     *
     */
    public function getRecordTotal($mobile, $task_id, $starttime, $endtime)
    {
        return $this->_daoRecord->getRecordTotal($mobile, $task_id, $starttime, $endtime);
    }

    /**
     * 获取用户任务记录
     * @param $id
     * @param $name
     * @param $activity_id
     * @param $page
     */
    public function getRecordList($mobile, $task_id, $starttime, $endtime, $page)
    {
        return $this->_daoRecord->getRecordList($mobile, $task_id, $starttime, $endtime, $page);
    }

    /**
     * 删除用户任务记录
     * @param $id
     * @return bool
     */
    public function deleteRecord($id)
    {
        if(empty($id))
        {
            return false;
        }

        return $this->_daoRecord->deleteRecordInfo($id);
    }

    /**
     * 查询单条信息
     * @param $id
     * @return array|bool
     */
    public function getRecordInfoById($id)
    {
        if(empty($id))
        {
            return false;
        }

        return $this->_daoRecord->getInfoById($id);
    }





}