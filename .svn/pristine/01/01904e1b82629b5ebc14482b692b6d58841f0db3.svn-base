<?php
/**
 * 队列任务
 * @author qingyuan21@leju.com
 *
 */

class Dao_Manager_CronModel extends Base_Dao
{
    protected $_db = 'default';

    protected $_table = 'mf_manager_cron';


    /**
     * 获取任务数量
     * @return integer
     */
    public function getCount($condition = [])
    {
        $where = !empty($condition) ? $this->where($condition) : '';
        $result = $this->count($where, $params = array(), $this->_table);
        return $result;
    }

    /**
     * 获取任务列表
     * @return integer
     */
    public function getList($condition = [], $page = 1, $limit = 0, $order = '')
    {
        $params = [];
        $where = $condition ? $this->where($condition) : '';
        $opts = [
            'where' => $where,
            'order' => $order ? $order : $this->_pk . ' asc',
        ];
        $limit != 0 && $opts['start'] = ($page - 1) * $limit;
        $limit != 0 && $opts['limit'] = $limit;

        $result = $this->find($opts, $params);
        return $result;
    }

    /**
     * 根据id获取任务
     * @return integer
     */
    public function getCronById($id)
    {
        if (empty($id))
        {
            return false;
        }
        $condition = [];
        $params=[];
        (!empty( $id) && $condition['id'] = '?') && $params['id'] = $id;
        $where = $condition ? $this->where($condition) : '';
        $opts = [
            'where' => $where,
        ];
        $result = $this->find($opts,$params);

        return $result;
    }

    /**
     * 添加任务
     * @return bool
     *
     */
    public function cronInsert($data)
    {
        if (empty($data))
        {
            return false;
        }

        return $this->insert($data);
    }

    /**
     * 添加删除
     * @return bool
     *
     */
    public function cronDelete($id)
    {
        if (empty($id))
        {
            return false;
        }
        $result = $this->delete($id);
        return $result;
    }

    /**
     * 更新队列设置
     * @return bool
     *
     */
    public function cronUpdate($id, $data)
    {
        if (empty($id))
        {
            return false;
        }
        $result = $this->update($id, $data);
        return $result;
    }

}