<?php

class AddAction extends Base_Action
{
    protected $_rule = [
        'compose_id' => ['required' => true, 'type' => 'number'],
        'func_name' => ['required' => true, 'type' => 'string'],
        'func_name_cn' => ['required' => true, 'type' => 'string'],
        'order_id' => ['required' => false, 'type' => 'string'],
        'is_show' => ['required' => false, 'type' => 'string'],
    ];

    protected $_parameters = [
        'compose_id', 'func_name', 'func_name_cn', 'order_id', 'is_show'
    ];

    protected $_compose_model;
    protected $_ctl_model;


    public function process()
    {
        $this->_compose_model = new Service_Manager_ComposerModel();
        $this->_ctl_model = new Service_Manager_ControllerModel();

        $params = $this->filterParams();

        if ($this->getRequest()->isPost())
        {

            if (array() !== ($info = Validate::check($params, $this->_rule)))
            {
                $this->response(Public_Error::ERR_PARAM);
            }

            //判断有没有重名的英文controller 名字,此处列名大小写没有验证。
            $filter_repeat = $this->_ctl_model->getControllerInfo('', $params['func_name']);

            if (!empty($filter_repeat))
            {
                $this->response(Public_Error::ERR_HAVE_REPEAT_CTL_NAME);
            }

            //拼接组件-模块-action路径,判断Actino路径下是否有对应文件
            $actionPath = APP_PATH . 'actions' . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $params['func_name']);
            $actions = Public_Comm::treeDirectory($actionPath);

            //拼接ctl路径
            $ctlPath = APP_PATH . 'controllers' . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $params['func_name']) . '.php';

            //获取ctl文件中的的action方法
            $actions_in_ctl = Public_Comm::load_class($ctlPath);

            //如果对应action下以及ctl下都没有对应action，抛出错误
            if (empty($actions) && empty($actions_in_ctl))
            {
                $this->response(Public_Error::ERR_HAVE_NO_ACTIONS_IN_CTL);
            }

            $add_res = $this->_ctl_model->controllerAdd($params);

            if ($add_res > 0)
            {
                $this->response(Public_Error::SUCCESS, '', '', '/Manager/Controller/index.html');
            } else
            {
                $this->response(Public_Error::FAIL);
            }
        }

        // 所有组件信息
        $compose_list = $this->_compose_model->getComposerLists();

        if (count($compose_list) > 0)
        {
            foreach ($compose_list as $value)
            {
                $compose_list_arr[$value['id']] = $value['cn_name'];
            }
        }
        $compose_id = AppRequest::instance()->getParam('compose_id', 0);

        $this->assign('controller_info', array('compose_id' => $compose_id));
        $this->assign('compose_list', $compose_list_arr);

    }
}