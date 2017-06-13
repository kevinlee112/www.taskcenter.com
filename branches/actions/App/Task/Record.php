<?php

/**
 * 用户做任务记录
 * Class IndexAction
 */
class RecordAction extends Base_Action
{
    protected $_rules = [
        'mobile' => ['required' => false, 'type' => 'string'],
        'task_id' => ['required' => false, 'type' => 'string'],
        'starttime' => ['required' => false, 'type' => 'string'],
        'endtime' => ['required' => false, 'type' => 'string'],
        'page' => ['required' => false, 'type' => 'string'],
    ];

    protected $_parameters = [
        'mobile','task_id','starttime','endtime', 'page'
    ];

    protected $recordModel;

    public function process()
    {
        $params = $this->filterParams();

        $this->recordModel = new Service_App_RecordModel();

        if(!empty($params['starttime']) && empty($params['endtime']))
        {
            $params['endtime'] = date('Y-m-d H:i:s',time());
        }

        if(($params['starttime'] > $params['endtime']))
        {
            $this->response(Public_Error::ERR_SEARCH_TIME_ERROR);
        }

        $total = $this->recordModel->getRecordTotal($params['mobile'],$params['task_id'],$params['starttime'],$params['endtime']);

        $list = $this->recordModel->getRecordList($params['mobile'],$params['task_id'],$params['starttime'],$params['endtime'], $params['page']);

        Yaf_Loader::import(PATH_FW_TOOLS . 'Page.php');

        $page = new Tools_page($total,$params['page']);

        $this->assign('mobile', $params['mobile']);
        $this->assign('task_id', $params['task_id']);
        $this->assign('starttime', $params['starttime']);
        $this->assign('endtime', $params['endtime']);
        $this->assign('list', $list);
        $this->assign('pager_html', $page->get_html());

    }
}