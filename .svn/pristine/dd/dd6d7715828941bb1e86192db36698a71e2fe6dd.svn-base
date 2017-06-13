<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 *
 * 创建相册
 *
 * @author     guodong5@leju.com
 * @version    $Id$
 */

class MakealbumAction extends Base_Action
{
    protected $_rules = [
        'pid' => ['required' => true, 'type' => 'number'],
        'path_name' => ['required' => false, 'type' => 'string'],
    ];

    protected $_parameters = [
        'pid','path_name'
    ];

    public $albumModel;

    public function process()
    {
        if($this->getRequest()->ispost())
        {
            $params = $this->filterParams();

            $this->albumModel = new Service_Manager_AlbumModel();

            //同一目录下检查相册是否重名
            $checkExists = $this->albumModel->checkAlbum($params['pid'],$params['path_name']);

            if(!empty($checkExists))
            {
                $this->response(Public_Error::FAIL);exit;
            }

            $res = $this->albumModel->makeAlbum($params['pid'],$params['path_name']);

            if($res)
            {
                $this->response(Public_Error::SUCCESS,$res);
            }
            else
            {
                $this->response(Public_Error::FAIL,$res);
            }
        }
    }
}