<?php

/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2016/8/16
 * Time: 9:19
 */

class DeleteAction extends Base_Action
{
    protected $_rules = [
        'id' => ['required' => true, 'type' => 'string'],
    ];
    protected $_parameters = [
        'id'
    ];
    protected $_cron;

    public function process()
    {
        $params = $this->filterParams();
        $this->_cron = new Service_Manager_CronModel();
        $result = $this->_cron->cronDelete($params['id']);
        if (false !== $result)
        {
            $this->redirect('/manager/cron/index.html');
        }
        else
        {
            $this->response(Public_Error::FAIL, $result,$params,'/manager/cron/index.html' );
        }
    }
}