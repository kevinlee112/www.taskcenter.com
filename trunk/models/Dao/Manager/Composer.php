<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2016/8/12
 * Time: 17:16
 */


class Dao_Manager_ComposerModel extends Base_Dao
{
    protected $_db = 'default';

    protected $_table = 'mf_manager_composer';

    /**
     * 获取组件数量
     * @return integer
     */
    public function getCount()
    {
        $condition = [];
        $where = !empty($condition) ? $this->where($condition) : '';
        $result = $this->count($where, $params = array(), $this->_table);
        return $result;
    }

    /**
     * 获取组件列表
     * @param integer $is_show
     * @param integer $page
     * @param string $order
     * @param integer $limit
     * @return Ambigous <multitype:, multitype:mixed string >
     */
    public function getComposerList($page, $limit, $is_show = null, $order)
    {
        $condition = array();
        $params = array();
        (!empty( $is_show) && $condition['is_show'] = '?') && $params['is_show'] = $is_show;
        $where = $condition ? $this->where($condition) : '';
        $opts = [
            'where' => $where,
            'order' => $order . ' asc',
            'start' => ($page - 1) * $limit,
            'limit' => $limit,
        ];
        $result = $this->find($opts,$params);

        return $result;
    }

    /**
     * 根据id获取组件
     * @param integer $id
     * @param integer $is_show
     * @return Ambigous <multitype:, multitype:mixed string >
     */
    public function getComposerById($id, $is_show = null)
    {
        if (empty($id))
        {
            return false;
        }
        $condition = [];
        $params=[];
        (!empty( $id) && $condition['id'] = '?') && $params['id'] = $id;
        (!empty( $is_show) && $condition['is_show'] = '?') && $params['is_show'] = $is_show;
        $where = $condition ? $this->where($condition) : '';
        $opts = [
            'where' => $where,
        ];
        $result = $this->find($opts,$params);

        return $result;
    }

    /**
     * 根据name获取组件
     * @param string $en_name
     * @param string $cn_name
     * @param string $logic
     * @return Ambigous <multitype:, multitype:mixed string >
     */
    public function getComposerByName($en_name = null, $cn_name = null, $logic)
    {
        if (empty($cn_name) && empty($en_name))
        {
            return false;
        }
        $condition = array();
        $params = array();
        (!empty( $en_name) && $condition['en_name'] = '?') && $params['en_name'] = $en_name;
        !empty( $logic) && $condition['_logic'] =  $logic;
        (!empty( $cn_name) && $condition['cn_name'] = '?') && $params['cn_name'] = $cn_name;
        $where = $condition ? $this->where($condition) : '';
        $opts = [
            'where' => $where,
        ];
        $result = $this->find($opts,$params);
        return $result;
    }


    /**
     * 添加组件
     * @param string $en_name
     * @param string $cn_name
     * @param string $orderid
     * @param string $is_show
     * @return Ambigous <multitype:, multitype:mixed string >
     */
    public function composerAdd($en_name, $cn_name, $orderid, $is_show )
    {
        !empty($cn_name) && $data['cn_name'] = $cn_name;
        !empty($en_name) && $data['en_name'] = $en_name;
        is_numeric($orderid) && $data['orderid'] = $orderid;
        !empty($is_show) && $data['is_show'] = $is_show;
        $result = $this->insert($data);
        return $result;
    }

    /**
     * 组件修改
     * @param int $id
     * @param string $en_name
     * @param string $cn_name
     * @param string $orderid
     * @param string $is_show
     * @return Ambigous <multitype:, multitype:mixed string >
     */
    public function composerUpdate($id, $is_show = null, $en_name = null, $cn_name = null, $orderid = null)
    {
        if (empty($id))
        {
            return false;
        }
        $data = array();
        !empty($is_show) && $data['is_show'] = $is_show;
        !empty($cn_name) && $data['cn_name'] = $cn_name;
        !empty($en_name) && $data['en_name'] = $en_name;
        is_numeric($orderid) && $data['orderid'] = $orderid;
        $result = $this->update($id, $data);
        return $result;
    }

    /**
     * 根据组件id删除组件
     * @param int $id
     * @return array
     */
    public function composerDelete($id)
    {
        if (empty($id))
        {
            return false;
        }
        $result = $this->delete($id);
        return $result;
    }

}