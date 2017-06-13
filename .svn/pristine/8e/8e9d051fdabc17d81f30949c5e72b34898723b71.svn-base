<?php
/**
 * 计划任务添加
 * @author qingyuan21@leju.com
 *
 */

class AddAction extends Base_Action
{
    protected $_rule = [
        'is_valid' => ['required' => true,'type' => 'string'],
        'type' => ['require' => true, 'type' => 'number'],
        'nxt_time' => ['required' => true,'type' => 'string'],
        'period_interval' => ['required' => false,'type' => 'string'],
        'period_type' => ['required' => false,'type' => 'string'],
        'exec_mod' => ['required' => true,'type' => 'string'],
        'exec_act' => ['required' => true,'type' => 'string'],
        'name' => ['required' => true,'type' => 'string'],
        'description' => ['required' => true,'type' => 'string'],
    ];

    protected $_parameters = [
        'is_valid', 'type', 'nxt_time', 'period_interval', 'period_type', 'exec_mod', 'exec_act', 'name', 'description',
    ];

    protected $_cron;

    public function process()
    {
        $params = $this->filterParams();
        $this->_cron = new Service_Manager_CronModel();

        if ($this->getRequest()->isPost())
        {
            if (array() !== ($info = Validate::check($params, $this->_rule)))
            {
                $this->response(Public_Error::ERR_PARAM, $info, $params, 'add.html' );
            }
            $result = $this->_cron->cronAdd($params);
            if (false !== $result)
            {
                AppResponse::redirect('/manager/cron/index.html');
            }
            else
            {
                $this->response(Public_Error::FAIL, $result,$params,'/manager/cron/add.html' );
            }
        }
    }
}