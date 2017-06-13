<?php


class Dao_Manager_ExecsqlpermissModel extends Base_Dao
{

    protected $_db = 'default';

    protected $_pk = 'uid';

    protected $_table = 'mf_manager_execute_sql_permission';


    /**
     * 添加用户
     * @return bool
     *
     */
    public function insertUser($data)
    {
        if (empty($data))
        {
            return false;
        }

        return $this->insert($data);
    }


    /**
     * 删除用户信息
     *
     */
    public function deleteUser($id)
    {
        if (empty($id))
        {
            return false;
        }

        return $this->delete(intval($id));
    }

    public function getUserList($condition = '')
    {

        $where = !empty($condition) ? $this->where($condition) : '';
        $params = [];
        $opt = array(
            'where' => $where,
        );

        $result = $this->find($opt, $params);

        return $result;
    }

}
