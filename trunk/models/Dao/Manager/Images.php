<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 相册图片管理
 * @auther: guodong5@leju.com
 * @last modify time: ${LastChangedDate}
 */ 
class Dao_Manager_ImagesModel extends Base_Dao
{

    protected $_db = 'default';

    protected $_pk = 'id';

    protected $_table = 'mf_album_pics';

    private $limit = 12;//DEFAULT_PAGE_LIMIT;

    /**
     * 获取相册下的图片总数
     *
     */
    public function getPicTotalByPath($path_id)
    {
        $param['status'] = 0;
        $opt['status'] = "?";

        !empty($path_id) && ($param['path'] = $path_id) && ($opt['path'] = "?");

        $result = $this->count($opt, $param);

        return $result;
    }


    /**
     * 获取相册下的图片列表
     *
     */
    public function getPicListByPath($path_id, $page = 1)
    {
        $param['status'] = 0;
        $condition['status'] = "?";

        !empty($path_id) && ($param['path'] = $path_id) && ($condition['path'] = "?");

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
     * 添加图片
     * @param $data
     * @return bool
     */
    public function insertImages($data)
    {
        if(empty($data))
        {
            return false;
        }

        return $this->insert($data);
    }

    /**
     * 删除图片
     * @param $id
     * @return bool
     *
     */
    public function deleteImages($id)
    {
        if(empty($id))
        {
            return false;
        }

        return $this->update($id,array('status'=>1));
    }


}
