<?php

class DeleteAction extends Base_Action
{
    protected $_rules = [
        'controller_id' => ['required' => true, 'type' => 'string'],
    ];

    protected $_parameters = [
        'controller_id',
    ];

    protected $_controller_model;

    public function process()
    {
        $params = (object)$this->filterParams();
        $this->_controller_model = new Service_Manager_ControllerModel();

        // 判断ctl下有没有action，有执行所属action删除，没有直接删controller
        $past_methods_res = $this->_controller_model->getActionList($params->controller_id);

        if (!empty($past_methods_res))
        { //删除controller所属action
            $del_method_res = $this->_controller_model->controllerDeleteRelate($params->controller_id, 'controller_id');

            if ($del_method_res == '0')
            {
                //删除action失败
                $this->response(Public_Error::FAIL);
            }
        }

        //删除controller
        $del_ctl_res = $this->_controller_model->controllerDelete($params->controller_id);

        //提示
        if ($del_ctl_res == '1')
        {
            $this->response(Public_Error::SUCCESS);
        } else
        {
            $this->response(Public_Error::FAIL);
        }

        // 关闭自动渲染
        Yaf_Dispatcher::getInstance()->disableView();
    }
}