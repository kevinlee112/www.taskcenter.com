<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * 相册数据输出类
 * 
 * @author     guodong5@leju.com
 * @version    $Id$
 */

class ListAction extends Base_Action
{
    protected $_rules = [
        'id' => ['required' => true, 'type' => 'number'],
        'page' => ['required' => false, 'type' => 'number'],
    ];
    
    protected $_parameters = [
        'id','page'
    ];

    public $imageModel;
    public $albumModel;
    
    public function process()
    {
        if($this->getRequest()->ispost())
        {
            $params = $this->filterParams();

            $this->albumModel = new Service_Manager_AlbumModel();

            $this->imageModel = new Service_Manager_ImagesModel();

            if(empty($params['page']))
            {
                $params['page'] = 1;
            }

            $path = $this->albumModel->getAlbumPath($params['id']); //路径导航

            $albums = $this->albumModel->getAlbumByPid($params['id']); //子目录

            $picTotal = $this->imageModel->getPicTotal($params['id']); //目录下的图片总数

            $list = $this->imageModel->getPicList($params['id'],$params['page']); //列表数据

            Yaf_Loader::import(PATH_FW_TOOLS . 'Page.php');

            $page = new Tools_page($picTotal,$params['page']);

            $data = array(
                'path' => array_reverse($path),
                'albums'=>$albums,
                'list' => $list,
                'page_html' => $page->get_ajax_html(),
            );

            $this->response(Public_Error::SUCCESS,$data);
        }
    }
}