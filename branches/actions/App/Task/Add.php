<?php

/**
 * Desc:App任务增加
 * User: tb
 */
class AddAction extends Base_Action
{
    protected $_rule = [
        'task_name' => ['required' => true, 'type' => 'string'],
        'task_desc' => ['required' => true, 'type' => 'string'],
        'task_image' => ['required' => true, 'type' => 'string'],
        'task_period' => ['required' => true, 'type' => 'string'],
        'award_time' => ['required' => true, 'type' => 'number'],
        'task_version' => ['required' => true, 'type' => 'number'],
        'task_type' => ['required' => true, 'type' => 'string'],
        'status' => ['required' => false, 'type' => 'string'],
        'ad_link' => ['required' => false, 'type' => 'string'],
        'time_line' => ['required' => false, 'type' => 'number'],
        'share_title' => ['required' => false, 'type' => 'string'],
        'share_content' => ['required' => false, 'type' => 'string'],
        'share_link' => ['required' => false, 'type' => 'string'],
        'image_name' => ['required' => false, 'type' => 'string'],
        'act' => ['required' => false, 'type' => 'string'],//看是否为删除图片动作
    ];

    protected $_parameters = [
        'task_name', 'task_desc', 'task_image', 'award_time', 'task_version', 'task_type', 'status', 'ad_link', 'time_line', 'share_title', 'share_content', 'image_name', 'act', 'task_period','share_link'
    ];


    private $_task_model;

    public function process()
    {
        Yaf_Loader::import(PATH_FW_TOOLS . 'Upload.php');

        $this->_task_model = new Service_App_TaskModel();

        $this->assign('type_list', $this->_task_model->GetTaskType());
        $this->assign('type_period_list', $this->_task_model->GetTaskPeriod());

        $params = $this->filterParams();
        $action = $params['act'];
        if ($action == 'del_img')
        {
            $filename = $params['image_name'];
            if (!empty($filename))
            {
                @unlink(APP_PATH . "public/" . $filename);
                @unlink(APP_PATH . "public/" . str_replace('task/', 'task/s_', $filename));
                @unlink(APP_PATH . "public/" . str_replace('task/', 'task/m_', $filename));
                echo 'del_suc';
            } else
            {
                echo 'del_error.';
            }
        } else
        {
            if ($_FILES && $this->getRequest()->isXmlHttpRequest())
            {
                $upload = new tools_upload();
                //设置上传文件大小
                $upload->maxSize = 3292200;
                //设置上传文件类型
                $upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
                //设置附件上传目录
                $upload->savePath = APP_PATH . "public/img/upload/task/";
                //设置需要生成缩略图，仅对图像文件有效
                $upload->thumb = true;
                //设置需要生成缩略图的文件后缀
                $upload->thumbPrefix = 'm_,s_';  //生产2张缩略图
                //设置缩略图最大宽度
                $upload->thumbMaxWidth = '400,100';
                //设置缩略图最大高度
                $upload->thumbMaxHeight = '400,100';
                //设置上传文件规则
                $upload->saveRule = 'uniqid';
                //删除原图
                $upload->thumbRemoveOrigin = false;

                if (!$upload->upload())
                {
                    //捕获上传异常
                    echo $upload->getErrorMsg();
                } else
                {
                    //取得成功上传的文件信息
                    $uploadList = $upload->getUploadFileInfo();

                    $pics = $uploadList[0]['savename'];
                    $arr = array(
                        'pic' => $pics,
                        'url' => "/img/upload/task/" . $pics,//入库字段
                    );
                    echo json_encode($arr);
                }
            }
            //if ($_FILES && $this->getRequest()->isXmlHttpRequest())
            //{
            //    $pic_name = $_FILES['task_image']['name'];
            //    $pic_size = $_FILES['task_image']['size'];
            //    if ($pic_name != "")
            //    {
            //        if ($pic_size > 1024000)
            //        {
            //            echo '图片大小不能超过1M';
            //            exit;
            //        }
            //        $type = strstr($pic_name, '.');
            //        if ($type != ".gif" && $type != ".jpg")
            //        {
            //            echo '图片格式不对！';
            //            exit;
            //        }
            //        $rand = rand(100, 999);
            //        $pics = date("YmdHis") . $rand . $type;
            //        //上传路径
            //        $pic_path = APP_PATH . "public/img/upload/task/" . $pics;
            //        move_uploaded_file($_FILES['task_image']['tmp_name'], $pic_path);
            //    }
            //    $size = round($pic_size / 1024, 2);
            //    $arr = array(
            //        'name' => $pic_name,
            //        'pic' => $pics,
            //        'size' => $size,
            //        'url' => "/img/upload/task/" . $pics,//入库字段
            //    );
            //    echo json_encode($arr);
            //}

            if ($action == 'form' && $this->getRequest()->isPost())
            {
                if (array() !== ($info = Validate::check($params, $this->_rule)))
                {
                    $this->response(Public_Error::ERR_PARAM, $info);
                }

                if (true !== ($err = $this->_task_model->taskFieldValidate($params)))
                {
                    $this->response(Public_Error::ERR_PARAM, $err);
                }

                $add_res = $this->_task_model->TaskAdd($params);
                if ($add_res > 0)
                {
                    $this->response(Public_Error::SUCCESS, '', '', '/App/Task/index.html');
                } else
                {
                    $this->response(Public_Error::FAIL);
                }
            }
        }
    }
}