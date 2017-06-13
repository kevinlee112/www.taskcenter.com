<?php


class Dao_Manager_ExeclogModel extends Base_Dao
{

    protected $_db = 'default';

    protected $_pk = 'uid';

    protected $_table = 'mf_manager_exec_log';


    /**
     * 添加log
     * @return bool
     *
     */
    public function insertLog($data)
    {
        if (empty($data))
        {
            return false;
        }

        return $this->insert($data);
    }


    /**
     * 删除log
     *
     */
    public function deleteLog($id)
    {
        if (empty($id))
        {
            return false;
        }

        return $this->delete(intval($id));
    }

    /**log 列表展示
     * @param string $condition
     * @return array
     */
    public function getLogList($uid, $op, $page = DEFAULT_PAGE, $limit = '10', $order = 'id')
    {
        !empty($uid) && ($param['uid'] = $uid) && ($condition['uid'] = "?");
        !empty($op) && ($param['operate'] = $op) && ($condition['operate'] = "?");
        if ($uid == 'all')
        {
            unset($condition['uid']);
            unset($param['uid']);
        }
        if ($op == 'all')
        {
            unset($condition['operate']);
            unset($param['operate']);
        }

        $where = !empty($condition) ? $this->where($condition) : '';

        $opts = [
            'where' => $where,
            'order' => $order ? $order : $this->_pk . ' asc',
            'start' => ($page - 1) * $limit,
            'limit' => $limit,
        ];

        $result = $this->find($opts, $param);

        return $result;
    }

    public function getLogTotal($uid, $op)
    {
        $opt = array();
        $param = array();

        !empty($uid) && ($param['uid'] = $uid) && ($opt['uid'] = "?");
        !empty($op) && ($param['operate'] = $op) && ($opt['operate'] = "?");
        if ($uid == 'all')
        {
            unset($opt['uid']);
            unset($param['uid']);
        }
        if ($op == 'all')
        {
            unset($opt['operate']);
            unset($param['operate']);
        }

        $result = $this->count($opt, $param);

        return $result;
    }

}
