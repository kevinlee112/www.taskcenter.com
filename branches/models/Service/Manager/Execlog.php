<?php

/**
 * Desc:exec sql的log
 * User: tb
 * Date: 2016/9/12
 * Time: 10:04
 */
class Service_Manager_ExeclogModel
{

    private $_exec_log_Model;
    private $_user_model;

    public function __construct()
    {
        $this->_exec_log_Model = new Dao_Manager_ExeclogModel();
        $this->_user_model = new Service_Manager_UserModel();
    }


    /**
     * @param $user_id 用户id
     * @param $op 操作类型
     * @param $exec_result 操作返回结果
     */
    public function insertLog($op, $sql, $result)
    {
        $user_id = $_COOKIE['user_id'];//Yaf_Session::getInstance()->get('user_id');
        $user_info = $this->_user_model->getUserInfoById($user_id);

        $content = sprintf("用户【%s】执行了【%s】操作,SQL语句为【%s】", $user_info['user_name'], $op, $sql);

        $data['uid'] = $user_id;
        $data['content'] = $content;
        $data['result'] = $result;
        $data['time'] = time();
        $data['operate'] = $op;

        return $this->_exec_log_Model->insertLog($data);
    }

    /**
     * 返回所有log信息
     */
    public function getLogList($uid, $op, $page)
    {
        if (empty($uid) || empty($op))
        {
            return false;
        }
        return $this->_exec_log_Model->getLogList($uid, $op, $page);
    }

    public function getLogTotal($uid, $op)
    {
        return $this->_exec_log_Model->getLogTotal($uid, $op);
    }

}