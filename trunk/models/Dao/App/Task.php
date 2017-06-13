<?php

class Dao_App_TaskModel extends Base_Dao
{

    protected $_db = 'default';

    protected $_pk = 'id';

    protected $_table = 'mf_app_task';


    /**
     * 根据condition 获取count总数
     */
    public function getCount($task_type)
    {
        $param = $opt = array();
        $param['type'] = $task_type;

        if ($task_type == 0)
        {
            $opt['type'] = array('neq', '', '_multi');
        } else
        {
            $opt['type'] = "?";
        }
        //$opt['status'] = 1;//1正常 0停止
        $result = $this->count($opt, $param);

        return $result;
    }

    /**根据task 类型获取task列表，task_type 可以为空，代表全部
     * @param $task_type
     * @param string $order
     * @param int $page
     * @param string $limit
     * @return array
     */
    public function getListByTaskType($task_type, $is_active = 0, $order = 'id', $page = DEFAULT_PAGE, $limit = '-1')
    {
        $condition = [];
        $params = [];
        if (!$task_type)
        {
            $condition['type'] = array('neq', '', '_multi');
        } else
        {
            $condition['type'] = "?";
            $params['type'] = $task_type;
        }

        //是否只是查询状态为1可用的任务
        (!empty($is_active) && $condition['status'] = '?') && $params['status'] = $is_active;

        $where = $condition ? $this->where($condition) : '';
        $opts = [
            'where' => $where,
            'order' => $order ? $order : $this->_pk . ' asc',
            'start' => ($page - 1) * $limit,
            'limit' => $limit,
        ];

        $result = $this->find($opts, $params);
        return $result;
    }

    /**根据任务id获取任务详情
     * @param $id
     * @return array|bool
     */
    public function getTaskInfoById($id)
    {
        if (empty($id))
        {
            return false;
        }
        $condition = [];
        $params = [];
        (!empty($id) && $condition['id'] = '?') && $params['id'] = $id;

        $where = $condition ? $this->where($condition) : '';
        $opts = [
            'where' => $where,
        ];
        $result = $this->find($opts, $params);

        return $result;
    }

}
