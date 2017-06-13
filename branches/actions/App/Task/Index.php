<?php

/**
 * 所有任务列表
 * Class IndexAction
 */
class IndexAction extends Base_Action
{
    protected $_rules = [
        'task_type' => ['required' => false, 'type' => 'string'],
        'page' => ['required' => false, 'type' => 'string'],
    ];

    protected $_parameters = [
        'task_type', 'page'
    ];

    protected $_compose_model;
    protected $_controller_model;

    public function process()
    {
        //任务类型列表
        $this->_task_model = new Service_App_TaskModel();

        $this->assign('type_list', $this->_task_model->GetTaskType());
        $this->assign('type_period_list', $this->_task_model->GetTaskPeriod());
        $params = (object)$this->filterParams();

        $task_type = $params->task_type ? $params->task_type : '';
        $this->assign('task_type', $task_type);

        //获取任务总数
        $task_count_res = $this->_task_model->getCount($params->task_type);

        if ($task_count_res === FALSE)
        {
            // 数据库取数失败
            $this->response(Public_Error::FAIL, null, ['info' => 'database false']);
        } else
        {
            $task_count = $task_count_res;
        }

        Yaf_Loader::import(PATH_FW_TOOLS . 'Page.php');
        $page = isset($params->page) ? (int)$params->page : 1;

        $pager = new Tools_page($task_count, $page);
        $task_list_res = $this->_task_model->getListByTaskType($params->task_type, '0','id DESC', $pager->get_current_page());

        $this->assign('task_list', $task_list_res);

        $this->assign('total', $task_count);

        $this->assign('pager_html', $pager->get_html());

    }
}