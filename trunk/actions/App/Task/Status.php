<?php

/**更改任务状态
 * Class StatusAction
 */
class StatusAction extends Base_Action
{
    protected $_rules = [
        'task_id' => ['required' => true, 'type' => 'string'],
        'is_show' => ['required' => true, 'type' => 'string'],
    ];

    protected $_parameters = [
        'task_id', 'is_show',
    ];

    public function process()
    {
        $params = (object)$this->filterParams();
        $task_id = $params->task_id;
        $is_show = $params->is_show;
        $is_show = $is_show == 'Y' ? '1' : '0';

        $res = (new Service_App_TaskModel())->taskUpdateStatus($task_id,$is_show);

        if ($res == '1')
        {
            $this->response(Public_Error::SUCCESS);
        } else
        {
            $this->response(Public_Error::FAIL);
        }
        Yaf_Dispatcher::getInstance()->disableView();

    }
}