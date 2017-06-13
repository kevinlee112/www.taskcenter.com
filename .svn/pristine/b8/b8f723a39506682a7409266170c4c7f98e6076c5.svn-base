<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 相册图片管理
 * @auther: yulong8@leju.com
 * @last modify time: ${LastChangedDate}
 */ 

class Service_Manager_ImagesModel extends Base_Dao
{
    private $imageModel;

    public function __construct()
    {
        $this->imageModel = new Dao_Manager_ImagesModel();
    }

    /**
     * 获取图片总数
     *
     */
    public function getPicTotal($path_id)
    {
        $total = $this->imageModel->getPicTotalByPath($path_id);

        return $total;
    }


    /**
     * 获取用户列表
     *
     */
    public function getPicList($path_id, $page = 1)
    {

        $result = $this->imageModel->getPicListByPath($path_id,$page);

        return $result;
    }

    /**
     * 添加用户
     * @return bool
     *
     */
    public function insertImage($param)
    {
        $data = array();

        isset($param['name']) && !empty($param['name']) && $data['name'] = trim($param['name']);
        isset($param['url']) && !empty($param['url']) && $data['url'] = $param['url'];
        isset($param['path']) && !empty($param['path']) && $data['path'] = trim($param['path']);

        $data['createtime'] = time();

        $result = $this->imageModel->insertImages($data);

        return $result;
    }

    /**
     * 删除用户信息
     *
     */
    public function deleteImage($id)
    {
        if(empty($id))
        {
            return false;
        }

        $result = $this->imageModel->deleteImages(intval($id));

        return $result;
    }


}
