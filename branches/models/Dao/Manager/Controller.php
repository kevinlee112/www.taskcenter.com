<?php

class Dao_Manager_ControllerModel extends Base_Dao
{

    protected $_db = 'default';

    protected $_pk = 'id';

    protected $_table = 'mf_manager_controller';


    /**
     * 根据condition 获取count总数
     */
    public function getCount($compose_id = null, $ctl_id = '0')
    {
        $param = $opt = array();
        !empty($compose_id) && ($param['id'] = $compose_id) && ($opt['compose_id'] = "?");
        $param['ctl_id'] = $ctl_id;
        $opt['controller_id'] = "?";
        $result = $this->count($opt, $param);

        return $result;
    }

    /**根据组件id取ctl列表
     * @param int $compose_id
     * @param string $order
     * @param int $page
     * @param string $limit
     * @return array
     */
    public function getListByComposeId($compose_id = 0, $is_show, $order = 'id', $page = DEFAULT_PAGE, $limit = '-1')
    {
        $condition = [];
        $params = [];
        (!empty($compose_id) && $condition['compose_id'] = '?') && $params['compose_id'] = $compose_id;

        (!empty($is_show) && $condition['is_show'] = '?') && $params['is_show'] = $is_show;
        $condition['controller_id'] = '0';
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

    /*
     * 根据ctl_id获取action
     */
    public function getActionList($ctl_id, $is_menu, $order = 'id', $page = DEFAULT_PAGE, $limit = '-1')
    {
        $condition = [];
        $params = [];
        (!empty($ctl_id) && $condition['controller_id'] = '?') && $params['controller_id'] = $ctl_id;
        (!empty($is_menu) && $condition['is_menu'] = '?') && $params['is_menu'] = $is_menu;

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

    public function getCtlList($is_show = 'Y', $order = 'id', $page = DEFAULT_PAGE, $limit = '-1')
    {
        $condition = [];
        $params = [];
        (!empty($is_show) && $condition['is_show'] = '?') && $params['is_show'] = $is_show;

        $condition['controller_id'] = '0';
        
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


    public function fetchOne($condition = '', $order = '', $limit = '1')
    {
        $condition = $this->parseWhere($condition);
        $condition = !empty($condition) ? " WHERE {$condition} " : '';
        $order = !empty($order) ? " ORDER BY {$order} " : '';
        $limit = !empty($limit) ? " LIMIT {$limit} " : '';
        $sql = "SELECT * FROM `{$this->_table}` {$condition} {$order} {$limit}";
        $res = $this->sql($sql);
        return $res ? $res[0] : false;
    }

    public function getControllerInfoById($id)
    {
        if (empty($id))
        {
            return false;
        }
        $condition = [];
        $params = [];
        (!empty($id) && $condition['id'] = '?') && $params['controller_id'] = $id;

        $where = $condition ? $this->where($condition) : '';
        $opts = [
            'where' => $where,
        ];
        $result = $this->find($opts, $params);

        return $result;
    }


}
