<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * Test.php
 * @auther: guodong5@leju.com
 * @date:${date}
 * @create Time: ${time}
 * @version ${Id}
 * @last modify time: ${LastChangedDate}
 */ 
class Dao_Manager_UserModel extends Base_Dao
{

    protected $_db = 'default';

    protected $_pk = 'id';

    protected $_table = 'mf_manager_users';

    private $limit = 10;//DEFAULT_PAGE_LIMIT;


    /**
     * 获取用户总数
     *
     */
    public function getUserTotal($username, $realname, $role)
    {
        $opt = array();

        ($param['status'] = 1) && ($opt['status'] = "?");
        !empty($username) && ($param['user_name'] = $username) && ($opt['user_name'] = "?");
        !empty($realname) && ($param['real_name'] = $realname) && ($opt['real_name'] = "?");
        !empty($role) && ($param['role'] = $role) && ($opt['role'] = "?");

        $result = $this->count($opt, $param);

        return $result;
    }


    /**
     * 获取用户列表
     *
     */
    public function getUserList($username, $realname, $role, $page = 1)
    {
        ($param['status'] = 1) && ($condition['status'] = "?");
        !empty($username) && ($param['user_name'] = $username) && ($condition['user_name'] = "?");
        !empty($realname) && ($param['real_name'] = $realname) && ($condition['real_name'] = "?");
        !empty($role) && ($param['role'] = $role) && ($condition['role'] = "?");

        $where = !empty($condition) ? $this->where($condition) : '';

        $opt = array(
            'where' => $where,
            'order' => $this->_pk . " desc",
            'start' => ($page - 1) * $this->limit,
            'limit' => $this->limit,
        );

        $result = $this->find($opt, $param);

        return $result;
    }

    /**
     * 通过用户id获取用户信息
     * @param $id
     *
     */
    public function getUserInfoById($id)
    {
        ($param['status'] = 1) && ($condition['status'] = "?");
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

    /**根据用户角色返回有效用户列表
     * @param array $role
     * @param int $page
     * @param string $order
     * @param string $limit
     * @return array
     */
    public function getUserListByRoleId($role = array(), $page = DEFAULT_PAGE, $order = 'id', $limit = '-1')
    {
        $condition = [];
        $params = [];

        !empty($role) && ($params = $role) && ($condition['role'] = array("IN", array('?', '?')));
        ($params['status'] = 1) && ($condition['status'] = "?");

        $where = $condition ? $this->where($condition) : '';

        $opts = [
            'where' => $where,
            'order' => $order ? $order : $this->_pk . ' asc',
            'start' => ($page - 1) * $limit,
            'limit' => $limit,
        ];

        $result = $this->find($opts, $params);

        return $result ? $result : array();
    }

    /**
     * 通过用户id获取用户信息
     * @param $id
     *
     */
    public function getUserInfoByName($username)
    {
        ($param['status'] = 1) && ($condition['status'] = "?");
        !empty($username) && ($param['user_name'] = $username) && ($condition['user_name'] = "?");

        $where = !empty($condition) ? $this->where($condition) : '';

        $opt = array(
            'where' => $where,
            'limit' => 1,
            'order' => $this->_pk . " desc",
        );

        $result = $this->find($opt, $param);

        return $result ? $result[0] : array();
    }


    /**
     * 添加用户
     * @return bool
     *
     */
    public function insertUserInfo($data)
    {
        if (empty($data))
        {
            return false;
        }

        return $this->insert($data);
    }

    /**
     * 修改用户信息
     *
     */
    public function updateUserInfo($id, $data)
    {
        if (empty($id) || empty($data))
        {
            return false;
        }

        $result = $this->update(intval($id), $data);

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

        $data = array();

        $data['status'] = 2;

        return $this->update(intval($id), $data);
    }

}
