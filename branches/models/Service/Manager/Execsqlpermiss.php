<?php

/**
 * 处理用户是否有数据库管理中的exec sql权限
 * Class Service_Manager_ExecsqlpermissModel
 */
class Service_Manager_ExecsqlpermissModel extends Base_Dao
{
    private $_exec_sqlModel;

    public function __construct()
    {
        $this->_exec_sqlModel = new Dao_Manager_ExecsqlpermissModel();
    }


    /**
     * 添加可执行sql的用户
     * @return bool
     *
     */
    public function insertUser($param)
    {
        $data = array();

        isset($param['user_id']) && !empty($param['user_id']) && $data['uid'] = trim($param['user_id']);
        isset($param['is_open']) && !empty($param['is_open']) && $data['execute_sql_permission'] = ($param['is_open']);

        $result = $this->_exec_sqlModel->insertUser($data);

        return $result;
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

        $result = $this->_exec_sqlModel->deleteUser(intval($id));

        return $result;
    }

    public function getUserList()
    {
        $result = $this->_exec_sqlModel->getUserList();

        return $result;
    }

    /**根据用户id判断是否有数据库Sql执行权限
     * @param string $uid
     * @return bool
     */
    public function checkExecPermission($uid = '')
    {

        if (empty($uid) || !is_numeric($uid))
        {
            return false;
        }

        $condition = [];
        $params = [];
        (!empty($uid) && $condition['uid'] = '?') && $params['uid'] = $uid;

        $where = $condition ? $this->where($condition) : '';
        $opts = [
            'where' => $where,
        ];
        $result = $this->_exec_sqlModel->find($opts, $params);

        return $result == false ? false : true;

    }

}
