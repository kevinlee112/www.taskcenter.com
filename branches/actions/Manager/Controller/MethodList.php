<?php

/**
 * 控制器方法列表
 * Class MethodListAction
 */
class MethodListAction extends Base_Action
{
    private $serviceManager;
    protected $_rules = [
        'controller_id' => ['required' => true, 'type' => 'number'],
    ];

    protected $_parameters = [
        'controller_id'
    ];

    public function process()
    {
        $this->serviceManager = new Service_Manager_ControllerModel();
        $params = (object)$this->filterParams();

        $controller_id = $params->controller_id;
        $controller_info_res = $this->serviceManager->getControllerInfoById($controller_id);


        if (empty($controller_info_res))
        {
            $this->response(Public_Error::ERR_NOT_EXIST_CTL);
        }

        //拼接组件-模块-action路径
        $actionPath = APP_PATH . 'actions' . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $controller_info_res['func_name']);

        //拼接ctl路径
        $ctlPath = APP_PATH . 'controllers' . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $controller_info_res['func_name']) . '.php';

        //获取ctl目录文件中的的action方法
        $actions_in_ctl = Public_Comm::load_class($ctlPath);

        //获取action目录下的action方法
        $actions = Public_Comm::treeDirectory($actionPath);


        if ($actions_in_ctl !== false && count($actions_in_ctl > 0))
        {
            foreach ($actions_in_ctl as $v)
            {
                $actions[] = $v;
            }
        }

        // 获取数据库中已经记录该控制器方法,第二个参数为is_menu,不做限制
        $past_methods_res = $this->serviceManager->getActionList($controller_id, '', 'id ASC');

        // 组装func_name 为key
        if (!empty($past_methods_res))
        {
            foreach ($past_methods_res as $rights)

            {
                $past_methods[$rights['func_name']] = $rights;
            }

        } else
        {
            $past_methods = array();
        }


        // 获取当前控制器文件目录所有方法
        $new_methods = $current_methods = array();
        foreach ($actions as $method)
        {
            if (isset($past_methods[$method]))
            {
                $current_methods[$method] = $past_methods[$method];
                // past_methods实际为数据库中有，但目录文件中已经移除的方法
                unset($past_methods[$method]);
            } else
            {
                $new_methods[$method] = $method;
            }
        }
        if (empty($new_methods) && empty($current_methods) && empty($past_methods))
        {
            $this->response(Public_Error::ERR_HAVE_NO_ACTIONS_IN_CTL);
        }

        if ($this->getRequest()->isPost())
        {

            // 添加新的方法
            $add_func_name_cn = AppRequest::instance()->getParam('add_func_name_cn');
            $add_is_menu = AppRequest::instance()->getParam('add_is_menu');
            $add_is_right = AppRequest::instance()->getParam('add_is_right');


            if (!empty($add_func_name_cn))
            {
                foreach ($add_func_name_cn as $key => $value)
                {
                    if (empty($value)) continue;
                    $add_data = array('func_name' => $key, 'func_name_cn' => $value);
                    $add_data['is_menu'] = $add_is_menu[$key];
                    $add_data['is_right'] = $add_is_right[$key];
                    $add_data['controller_id'] = $controller_id;
                    $this->serviceManager->controllerAdd($add_data);
                }
            }
           
            //更新已经存在的方法
            $update_func_name_cn = AppRequest::instance()->getParam('update_func_name_cn');
            $update_is_menu = AppRequest::instance()->getParam('update_is_menu');
            $update_is_right = AppRequest::instance()->getParam('update_is_right');
            if (!empty($update_func_name_cn))
            {
                foreach ($update_func_name_cn as $key => $value)
                {
                    $update_data = array('func_name_cn' => $value);
                    $update_data['is_menu'] = $update_is_menu[$key];
                    $update_data['is_right'] = $update_is_right[$key];
                    $this->serviceManager->controllerUpdate($key, $update_data);
                }
            }

            $redis = new Base_Redis('redis');

            $userId = $_COOKIE['user_id'];//Yaf_Session::getInstance()->get('user_id');

            $cache_key = md5("data_action_menu_list_v1.0_{$controller_info_res['func_name']}_{$userId}");

            $redis->del($cache_key);

            $this->response(Public_Error::SUCCESS, '', '', '/manager/controller/index');

        }

        $this->assign('current_methods', $current_methods);
        $this->assign('current_methods_num', count($current_methods));
        $this->assign('new_methods', $new_methods);
        $this->assign('new_methods_num', count($new_methods));
        $this->assign('past_methods', $past_methods);
        $this->assign('past_methods_num', count($past_methods));
        $this->assign('controller_id', $controller_id);
        $this->assign('controller_name', $controller_info_res['func_name_cn']);

    }
}