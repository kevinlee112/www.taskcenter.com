<?php
/**
 * 任务进程处理
 * @author qingyuan2@leju.com
 *
 */
class ExecuteAction extends Base_Action
{
    protected $_parameters = [
        'id', 'action'
    ];

    protected $_rules = [
        'id' => ['required' => true, 'type' => 'number'],
        'action' => ['required' => true,'type' => 'string'],
    ];

    protected $_cron;

    public function process()
    {
        $params =  $this-> filterParams();
        $this->_cron = new Service_Manager_CronModel();
        $result = $this->_cron->cronCtrl($params['action'], $params['id']);

        if (false !== $result)
        {
            AppResponse::redirect('/manager/cron/index.html');
        }
        else
        {
            $this->response(Public_Error::FAIL, $result,$params,'/manager/cron/index.html' );
        }
    }
}