<?php

class UpdateAction extends Base_Action
{
    protected $_rule = [
        'compose_id' => ['required' => true, 'type' => 'number'],
        'func_name' => ['required' => true, 'type' => 'string'],
        'func_name_cn' => ['required' => true, 'type' => 'string'],
        'order_id' => ['required' => true, 'type' => 'number'],
    ];

    protected $_parameters = [
        'compose_id', 'func_name', 'func_name_cn', 'id', 'order_id',
    ];
    protected $_compose_model;
    protected $_controller_model;

    public function process()
    {
        $this->_compose_model = new Service_Manager_ComposerModel();
        $this->_controller_model = new Service_Manager_ControllerModel();
        $params = $this->filterParams();


        if ($this->getRequest()->isPost())
        {
            if (array() !== ($info = Validate::check($params, $this->_rule)))
            {
                // 再此做参数正确性提示
                $this->response(Public_Error::ERR_PARAM);
            }
            //判断有没有重名的英文controller 名字

            //根据id获取到库中func_name
            $exist_ctl_info = $this->_controller_model->getControllerInfoById($params['id']);
            if ($exist_ctl_info['func_name'] !== $params['func_name'])
            {
                $filter_repeat = $this->_controller_model->getControllerInfo('', $params['func_name']);
                

                if (!empty($filter_repeat))
                {
                    $this->response(Public_Error::ERR_HAVE_REPEAT_CTL_NAME);
                }
            }


            $update_res = $this->_controller_model->controllerUpdate($params['id'], $params);


            if ($update_res == '1')
            {
                $this->response(Public_Error::SUCCESS, '', '', '/manager/controller/index');
            } elseif ($update_res == 0)
            {

                $this->response(Public_Error::NOT_MODIFY);
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

        // 单个controller 信息
        $controller_res = $this->_controller_model->getControllerInfo($params['id']);
        $this->assign('controller_info', $controller_res);
        $this->assign('compose_list', $compose_list_arr);
    }
}