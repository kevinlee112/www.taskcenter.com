<?php

class HiddenAction extends Base_Action
{
    protected $_rules = [
        'controller_id' => ['required' => true, 'type' => 'string'],
        'is_show' => ['required' => true, 'type' => 'string'],
        'compose_id' => ['required' => true, 'type' => 'string'],
    ];

    protected $_parameters = [
        'controller_id', 'is_show', 'compose_id'
    ];

    public function process()
    {
        $this->serviceManager = new Service_Manager_ControllerModel();
        $params = (object)$this->filterParams();
        $controller_id = $params->controller_id;
        $is_show = $params->is_show;
        $is_show = $is_show == 'Y' ? 'Y' : 'N';

        $res = $this->serviceManager->controllerUpdate($controller_id, array('is_show' => $is_show));

        $controller_id = $params->controller_id;
        $controller_info_res = $this->serviceManager->getControllerInfoById($controller_id);

        if (empty($controller_info_res))
        {
            $this->response(Public_Error::ERR_NOT_EXIST_CTL);
        }

        if ($res == '1')
        {
            //有更改后 清除菜单缓存
            $redis = new Base_Redis('redis');

            $userId = $_COOKIE['user_id'];//Yaf_Session::getInstance()->get('user_id');

            $cache_key = md5("data_main_menu_list_{$userId}_v1.0");

            $redis->del($cache_key);

            $this->response(Public_Error::SUCCESS,'','','/Manager/Controller/index.html');
        } else
        {
            $this->response(Public_Error::FAIL);
        }
        Yaf_Dispatcher::getInstance()->disableView();

    }
}