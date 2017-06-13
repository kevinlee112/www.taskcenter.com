<?php

class Dao_App_AwardModel extends Base_Dao
{

    protected $_db = 'default';

    protected $_pk = 'id';

    protected $_table = 'mf_app_award';

    protected $limit = DEFAULT_PAGE_LIMIT;

    /**
     * 获取活动总数
     * @param $id
     * @param $name
     * @param $activity
     *
     */
    public  function getAwardTotal($id, $name, $activity_id)
    {
        $condition = $param = array();
        !empty($id) && ($condition['id'] = $id) && ($param['id'] = "?");
        !empty($name) && ($condition['name'] = $name) && ($param['name'] = "?");
        !empty($activity_id) && ($condition['activity_id'] = intval($activity_id)) && ($param['activity_id'] = "?");

        $where = empty($param) ? '' : $this->where($param);

        $opt = array(
            'where' => $where,
        );

        $total = $this->count($opt,$condition);

        return $total;
    }


    /**
     * 获取活动列表
     * @param $id
     * @param $name
     * @param $activity
     */
    public function getAwardList($id, $name, $activity_id, $page = 1)
    {
        $condition = $param = array();
        !empty($id) && ($condition['id'] = $id) && ($param['id'] = "?");
        !empty($name) && ($condition['name'] = $name) && ($param['name'] = "?");
        !empty($activity_id) && ($condition['activity_id'] = intval($activity_id)) && ($param['activity_id'] = "?");

        $where = !empty($condition) ? $this->where($param) : '';

        $opt = array(
            'where' => $where,
            'order' => $this->_pk . " desc",
            'start' => ($page - 1) * $this->limit,
            'limit' => $this->limit,
        );

        return $this->find($opt, $condition);
    }

    /**
     * 根据活动名称获取活动信息
     * @param $name
     */
    public function getAwardInfoByName($name)
    {
        $condition['status'] = 0;
        $param['status'] = "?";
        !empty($name) && ($condition['name'] = trim($name)) && ($param['name'] = "?");

        $where = empty($param) ? "" : $this->where($param);

        $opt = array(
            'where' => $where,
            'limit' => 1
        );

        $result = $this->find($opt, $condition);

        return empty($result) ? array() : $result[0];
    }


    /**
     * 根据活动id获取活动信息
     * @param $name
     */
    public function getAwardInfoById($id)
    {
        $condition = $param = array();
        !empty($id) && ($condition['id'] = intval($id)) && ($param['id'] = "?");

        $where = empty($param) ? "" : $this->where($param);

        $opt = array(
            'where' => $where,
            'limit' => 1
        );

        $result = $this->find($opt, $condition);

        return empty($result) ? array() : $result[0];
    }


    /**
     * 根据关联活动id获取活动信息
     * @param $name
     */
    public function getAwardInfoByActivityid($project_id, $activity_id)
    {
        $condition = $param = array();
        !empty($project_id) && ($condition['project_id'] = intval($project_id)) && ($param['project_id'] = "?");
        !empty($activity_id) && ($condition['activity_id'] = intval($activity_id)) && ($param['activity_id'] = "?");

        $where = empty($param) ? "" : $this->where($param);

        $opt = array(
            'where' => $where,
            'limit' => 1
        );

        $result = $this->find($opt, $condition);

        return empty($result) ? array() : $result[0];
    }

    /**
     * 添加活动信息
     * @param $data
     * @return bool
     */
    public function insertAwardInfo($data)
    {
        return $this->insert($data);
    }


    /**
     * 修改活动信息
     * @param $data
     * @return bool
     */
    public function updateAwardInfo($id, $data)
    {
        if(empty($id) || empty($data))
        {
            return false;
        }

        return $this->update($id,$data);
    }

    /**
     * 删除活动信息
     * @param $id
     */
    public function deleteAwardInfo($id)
    {
        if(empty($id))
        {
            return false;
        }

        return $this->delete($id);
    }

}