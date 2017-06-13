<?php

/**更新任务详情
 * Class UpdateAction
 */
class UpdateAction extends Base_Action
{
    protected $_rule = [
        'task_name' => ['required' => true, 'type' => 'string'],
        'task_desc' => ['required' => true, 'type' => 'string'],
        'task_image' => ['required' => true, 'type' => 'string'],
        'award_time' => ['required' => true, 'type' => 'number'],
        'task_version' => ['required' => true, 'type' => 'number'],
        'task_period' => ['required' => true, 'type' => 'string'],
        'task_type' => ['required' => false, 'type' => 'string'],
        'status' => ['required' => false, 'type' => 'string'],
        'ad_link' => ['required' => false, 'type' => 'string'],
        'time_line' => ['required' => false, 'type' => 'number'],
        'share_title' => ['required' => false, 'type' => 'string'],
        'share_content' => ['required' => false, 'type' => 'string'],
        'share_link' => ['required' => false, 'type' => 'url'],
        'act' => ['required' => false, 'type' => 'string'],
        'id' => ['required' => true, 'type' => 'string'],
    ];

    protected $_parameters = [
        'task_name', 'task_desc', 'task_image', 'award_time', 'task_version', 'task_type', 'status', 'ad_link', 'time_line', 'share_title', 'share_content', 'act', 'id', 'task_period', 'share_link'
    ];
    protected $_task_model;

    public function process()
    {
        $this->_task_model = new Service_App_TaskModel();
        $this->assign('type_list', $this->_task_model->GetTaskType());
        $this->assign('type_period_list', $this->_task_model->GetTaskPeriod());

        $this->_task_model = new Service_App_TaskModel();

        $params = $this->filterParams();

        $task_info = $this->_task_model->getTaskInfoById($params['id']);

        if ($task_info && !empty($task_info['json']))
        {
            $task_info_extra = json_decode($task_info['json'], true);
            $this->assign('task_info_extra', $task_info_extra);
        }

        $this->assign('task_info', $task_info);
        if ($this->getRequest()->isPost())
        {
            if (array() !== ($info = Validate::check($params, $this->_rule)))
            {
                // 再此做参数正确性提示
                $this->response(Public_Error::ERR_PARAM, $info);
            }

            if ($params['task_type'] != $task_info['type'])
            {
                //不允许对类型进行修改
                $this->response(Public_Error::ERR_NOT_PERMISSION_MODIFY_TYPE);
            }

            $update_res = $this->_task_model->taskUpdate($params['id'], $params);

            if ($update_res == '1')
            {
                $this->response(Public_Error::SUCCESS, '', '', '/App/Task/index');
            } elseif ($update_res == 0)
            {
                $this->response(Public_Error::NOT_MODIFY);
            } else
            {
                $this->response(Public_Error::FAIL);
            }
        }
    }
}