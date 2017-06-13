<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 相册管理
 * @auther: guodong5@leju.com
 * @last modify time: ${LastChangedDate}
 */ 

class Service_Manager_AlbumModel extends Base_Dao
{
    private $albumModel;
    public $pathData = array();

    public function __construct()
    {
        $this->albumModel = new Dao_Manager_AlbumModel();
    }

    /**
     * 根据pid获取目录列表
     *
     */
    public function getAlbumByPid($pid)
    {
        if(!isset($pid))
        {
            return false;
        }

        $list = $this->albumModel->getInfoByPid($pid);

        return $list;
    }

    /**
     * 根据id获取目录列表
     * @param $id
     * @return array|bool
     */
    public function getAlbumById($id)
    {
        if(empty($id))
        {
            return false;
        }

        $list = $this->albumModel->getInfoById($id);

        return $list;
    }

    /**
     * 获取相册路径
     * @param $pid
     * @return array
     */
    public function getAlbumPath($id)
    {

        $pathInfo = $this->getAlbumById($id);

        if($pathInfo)
        {
            $this->pathData[] = $pathInfo;

            if($pathInfo['pid'] != 0)
            {
                $this->getAlbumPath($pathInfo['pid']);
            }
        }

        return $this->pathData;
    }

    /**
     * 检查同一目录下是否有重名相册
     *
     */
    public function checkAlbum($pid,$path_name)
    {
        if(empty($pid) || empty($path_name))
        {
            return false;
        }

        return $this->albumModel->checkAlbumByName($pid,$path_name);
    }

    /**
     * 创建相册
     *
     */
    public function makeAlbum($pid,$path_name)
    {
        if(empty($pid) || empty($path_name))
        {
            return false;
        }

        $data = array();
        $data['pid'] = $pid;
        $data['path_name'] = $path_name;
        $data['createtime'] = time();

        return $this->albumModel->insertInfo($data);
    }





}
