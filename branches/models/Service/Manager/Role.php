<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * Test.php
 * @auther: guodong5@leju.com
 * @date:2016-08-16
 * @version ${Id}
 * @last modify time: ${LastChangedDate}
 */

class Service_Manager_RoleModel extends Base_Dao
{

    private $limit = DEFAULT_PAGE_LIMIT;
    public $roleModel;

    public function __construct()
    {
        $this->roleModel = new Dao_Manager_RoleModel();
    }

    /**
     * 获取角色总数
     * @param
     *
     */
    public function getRoleTotal($id, $name)
    {
        $total = $this->roleModel->getRoleTotal($id, $name);

        return $total;
    }

    /**
     * 获取角色总数
     * @param
     *
     */
    public function getRoleList($id, $name = null, $page = 1)
    {

        $list = $this->roleModel->getRoleList($id, $name, $page);

        return $list;
    }

    /**
     * 通过角色信息获取角色信息
     * @param $id
     *
     */
    public function getRoleInfoById($id)
    {
        if(empty($id))
        {
            return false;
        }

        $result = $this->roleModel->getRoleInfoById($id);

        return $result;

    }

    /**
     * 通过角色信息获取角色信息
     * @param $id
     *
     */
    public function getRoleInfoByName($name)
    {
        if(empty($name))
        {
            return false;
        }

        $result = $this->roleModel->getRoleInfoByName($name);

        return $result;

    }

    /**
     * 添加角色
     *
     */
    public function addRole($param)
    {
        if(empty($param))
        {
            return false;
        }

        $data = array();
        $data['name'] = isset($param['name']) ? $param['name'] : '';
        $data['code'] = isset($param['code']) ? $param['code'] : '';
        $data['is_super'] = isset($param['is_super']) ? $param['is_super'] : 2;
        $data['level'] = isset($param['level']) ? $param['level'] : 3;
        $data['addtime'] = time();

        $result = $this->roleModel->addRole($data);

        return $result;
    }

    /**
     * 编辑角色
     *
     */
    public function updateRole($id, $param)
    {
        if(empty($id) || empty($param))
        {
            return false;
        }

        $data = array();
        isset($param['name']) &&!empty($param['name']) && $data['name'] = trim($param['name']);
        isset($param['code']) &&!empty($param['code']) && $data['code'] = trim($param['code']);
        isset($param['is_super']) &&!empty($param['is_super']) && $data['is_super'] = intval($param['is_super']);
        isset($param['level']) &&!empty($param['level']) && $data['level'] = intval($param['level']);
        isset($param['rights']) &&!empty($param['rights']) && $data['rights'] = trim($param['rights']);
        $data['edittime'] = time();

        $result = $this->roleModel->updateRole(intval($id),$data);

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

        $result = $this->roleModel->delete(intval($id));

        if($result)
        {
            $userModel = new Dao_Manager_UserModel();

            $res = $userModel->update(array('role'=>$id),array('role'=>0),false); //角色删除解绑用户

            if($res)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    /**
     * 获取角色下拉列表
     *
     */
    public function getRoleOptions()
    {
        $roleList = $this->roleModel->getRoleList();

        if(empty($roleList))
        {
            return false;
        }

        $list = array();

        foreach($roleList as $k=>$v)
        {
            $list[$v['id']] = $v['name'];
        }

        return $list ? $list : array();
    }
    

}
