<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 相册目录
 * @auther: guodong5@leju.com
 * @last modify time: ${LastChangedDate}
 */ 
class Dao_Manager_AlbumModel extends Base_Dao
{

    protected $_db = 'default';

    protected $_pk = 'id';

    protected $_table = 'mf_album_path';

    private $limit = 10;//DEFAULT_PAGE_LIMIT;

    /**
     * 通过pid获取相册目录
     * @param $id
     *
     */
    public function getInfoByPid($pid)
    {
        $condition = [];
        $param = [];
        $param['pid'] = $pid;
        $condition['pid'] = "?";

        $where = !empty($condition) ? $this->where($condition) : '';

        $opt = array(
            'where' => $where,
            'order' => $this->_pk . " asc",
        );

        $result = $this->find($opt, $param);

        return $result ? $result : array();
    }

    /**
     * 通过相册id获取信息
     * @param $id
     * @return array
     */
    public function getInfoById($id)
    {
        $condition = [];
        $param = [];
        $param['id'] = $id;
        $condition['id'] = "?";

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
     * 通过用户id获取用户信息
     * @param $id
     *
     */
    public function getInfoByName($path_name)
    {
        $condition = [];
        $param = [];
        !empty($path_name) && ($param['path_name'] = $path_name) && ($condition['path_name'] = "?");

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
     * 检查同一相册下是否有同名子相册
     * @param $id
     *
     */
    public function checkAlbumByName($pid,$path_name)
    {
        $condition = [];
        $param = [];
        !empty($pid) && ($param['pid'] = $pid) && ($condition['pid'] = "?");
        !empty($path_name) && ($param['path_name'] = $path_name) && ($condition['path_name'] = "?");

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
     * 添加相册
     * @return bool
     *
     */
    public function insertInfo($data)
    {
        if (empty($data))
        {
            return false;
        }

        return $this->insert($data);
    }

    /**
     * 删除相册
     * @param $id
     * @return bool
     */
    public function deleteInfo($id)
    {
        if(empty($id))
        {
            return false;
        }

        return $this->delete($id);
    }



}
