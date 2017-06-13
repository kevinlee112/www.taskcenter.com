<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * Test.php
 * @auther: guodong5@leju.com
 * @date:2016-08-16
 * @version ${Id}
 * @last modify time: ${LastChangedDate}
 */

class Dao_Manager_RoleModel extends Base_Dao
{

    protected $_db = 'default';
    
    protected $_pk = 'id';
    
    protected $_table = 'mf_manager_roles';

    private $limit = 10;//DEFAULT_PAGE_LIMIT;


    /**
     * 获取角色总数
     * @param
     *
     */
    public function getRoleTotal( $id = '', $name = '')
    {
        $param = $opt = array();

        !empty($id) && ($param['id'] = $id) && ($opt['id'] = "?");
        !empty($name) && ($param['name'] = $name) && ($opt['name'] = "?");

        $result = $this->count($opt,$param);

        return $result;
    }


    /**
     * 获取角色列表
     * @param
     *
     */
    public function getRoleList($id = '', $name = '', $page = 1)
    {
        $param = $opt = array();

        !empty($id) && ($param['id'] = $id) && ($condition['id'] = "?");
        !empty($name) && ($param['name'] = $name) && ($condition['name'] = "?");

        $where = !empty($condition) ? $this->where($condition) : '';

        $opt = array(
            'where' => $where,
            'start' => ($page - 1) * $this->limit,
            'limit' => $this->limit,
            'order' => $this->_pk." desc",
        );

        $result = $this->find($opt, $param);

        return $result;
    }

    /**
     * 通过角色id获取角色信息
     * @param $id
     *
     */
    public function getRoleInfoById($id)
    {
        !empty($id) && ($param['id'] = $id) && ($condition['id'] = "?");

        $where = !empty($condition) ? $this->where($condition) : '';

        $opt = array(
            'where' => $where,
            'limit' => 1,
            'order' => $this->_pk." desc",
        );

        $result = $this->find($opt, $param);

        return $result ? $result[0] : array();
    }

    /**
     * 通过角色名称获取角色信息
     * @param $name
     *
     */
    public function getRoleInfoByName($name)
    {
        !empty($name) && ($param['name'] = $name) && ($condition['name'] = "?");

        $where = !empty($condition) ? $this->where($condition) : '';

        $opt = array(
            'where' => $where,
            'limit' => 1,
            'order' => $this->_pk." desc",
        );

        $result = $this->find($opt, $param);

        return $result ? $result[0] : array();
    }

    /**
     * 添加角色
     *
     */
    public function addRole($data)
    {
        if(empty($data))
        {
            return false;
        }

        $result = $this->insert($data);

        return $result;
    }

    /**
     * 编辑角色
     *
     */
    public function updateRole($id, $data)
    {
        if(empty($id) || empty($data))
        {
            return false;
        }

        $result = $this->update(intval($id),$data);

        return $result;
    }


    /**
     * 删除角色
     *
     */
    public function deleteRole($id)
    {
        if(empty($id))
        {
            return false;
        }

        $data = array();
        $data['status'] = 1;

        $result = $this->update(intval($id),$data);

        return $result;
    }
    

}
