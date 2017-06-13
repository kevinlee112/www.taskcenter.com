<?php

class Dao_App_RecordModel extends Base_Dao
{

    protected $_db = 'default';

    protected $_pk = 'id';

    protected $_table = 'mf_app_task_record';

    protected $limit = DEFAULT_PAGE_LIMIT;

    /**
     * 获取总数
     * @param $id
     * @param $name
     * @param $activity
     *
     */
    public  function getRecordTotal($mobile, $task_id, $starttime, $endtime)
    {
        $condition = $param = array();
        !empty($mobile) && ($condition['mobile'] = $mobile) && ($param['mobile'] = "?");
        !empty($task_id) && ($condition['task_id'] = $task_id) && ($param['task_id'] = "?");
        !empty($starttime) && ($condition['finish_time'] = $starttime) && ($param['finish_time'] = array('egt', "?"));
        !empty($endtime) && ($condition['finish_time'] = $endtime) && ($param['finish_time'] = array('elt', "?"));

        $total = $this->count($param,$condition);

        return $total;
    }


    /**
     * 获取列表
     * @param $id
     * @param $name
     * @param $activity
     */
    public function getRecordList($mobile, $task_id, $starttime, $endtime, $page = 1)
    {
        $condition = $param = array();

        !empty($mobile) && ($condition['mobile'] = $mobile) && ($param['mobile'] = "?");
        !empty($task_id) && ($condition['task_id'] = $task_id) && ($param['task_id'] = "?");
        //!empty($starttime) && ($condition['finish_time'] = 1) && ($param['finish_time'] = array('EGT',"?"));
        //!empty($endtime) && ($condition['finish_time'] = 2) && ($param['finish_time'] = array('ELT',"?"));

        if(!empty($starttime) && !empty($endtime))
        {
            $condition[] = $starttime;
            $condition[] = $endtime;

            $param['finish_time'] = array(
                array('EGT',"?"),
                array('ELT',"?")
            );
        }

        //
        $where = !empty($param) ? $this->where($param) : '';

        $opt = array(
            'where' => $where,
            'order' => $this->_pk . " desc",
            'start' => ($page - 1) * $this->limit,
            'limit' => $this->limit,
        );

        return $this->find($opt, $condition);
    }

    /**
     * 删除活动信息
     * @param $id
     */
    public function deleteRecordInfo($id)
    {
        return $this->delete($id);
    }

    /**
     * 获取信息
     * @param $id
     * @return array
     */
    public function getInfoById($id)
    {
        $condition = $param = array();
        !empty($id) && ($param['id'] = $id) && ($condition['id'] = "?");

        $where = !empty($condition) ? $this->where($condition) : '';

        $opt = array(
            'where' => $where,
            'limit' => 1,
            'order' => $this->_pk . " desc",
        );

        $result = $this->find($opt, $param);

        return $result ? $result[0] : array();
    }

}