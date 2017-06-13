<?php

/**
 * 处理数据库执行权限的增加和删除
 * 针对mf_manager_execute_sql_permission表的增删操作
 * Class DopermissionAction
 */
class DopermissionAction extends Base_Action
{
    protected $_rules = [
        'user_id' => ['required' => true, 'type' => 'number'],
        'is_open' => ['required' => true, 'type' => 'string'],
    ];

    protected $_parameters = [
        'user_id', 'is_open',
    ];

    protected $_exec_permission_model;

    public function process()
    {
        $params = $this->filterParams();

        $user_id = $params['user_id'];
        $is_open = $params['is_open'];
        $is_open = $is_open == 'Y' ? 'Y' : 'N';


        $this->_exec_permission_model = new Service_Manager_ExecsqlpermissModel();

        if ($is_open === 'Y')
        {
            $res = $this->_exec_permission_model->insertUser($params);
        } elseif ($is_open === 'N')
        {
            $res = $this->_exec_permission_model->deleteUser($user_id);

        } else
        {
            echo json_encode(array('code' => '-1', 'msg' => 'param error'));
        }

        if ($res == '1')
        {
            echo json_encode(array('code' => '0', 'msg' => 'ok'));
        } else
        {
            echo json_encode(array('code' => '-1', 'msg' => 'fail'));
        }
        Yaf_Dispatcher::getInstance()->disableView();

    }
}