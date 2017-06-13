<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 *
 * 图片上传
 *
 * @author     guodong5@leju.com
 * @version    $Id$
 */

class UploadAction extends Base_Action
{
    protected $_rules = [
        'path_id' => ['required' => true, 'type' => 'string'],
    ];

    protected $_parameters = [
        'path_id'
    ];

    public function process()
    {

        if ($this->getRequest()->ispost())
        {
            $imageModel = new Service_Manager_ImagesModel();

            $params = $this->filterParams();

            Yaf_Loader::import(PATH_FW_TOOLS . 'Uploads.php');

            $uploadModel = new Tools_Uploads(PHOTO_PKEY, PHOTO_MKEY);

            $result = $uploadModel->upload_pic($_FILES);

            if($result['result'])
            {
                //图片入库
                $data = array();
                $data['name'] = $_FILES['Filedata']['name'];
                $data['url'] = $result['info']['furl'];
                $data['path'] = $params['path_id'];

                $imageModel->insertImage($data);
            }
            $result['info']['pic_name'] = $_FILES['Filedata']['name'];
            echo json_encode($result);
            exit;

        }

        Yaf_Registry::set(Base_Constants::WHETHER_LOAD_LAYOUT, true);
    }
}