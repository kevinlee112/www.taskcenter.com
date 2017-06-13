<?php

/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2016/8/16
 * Time: 9:19
 */

class DisableAction extends Base_Action
{
    protected $_parameters = [
        'id', 'is_valid'
    ];

    protected $_rules = [
        'id' => ['required' => true, 'type' => 'number'],
        'is_valid' => ['required' => true, 'type' => 'string']
    ];

    protected $_cron;

    public function process()
    {
        $params =  $this-> filterParams();
        $this->_cron = new Service_Manager_CronModel();
        $params['is_valid'] =  $params['is_valid'] == '1' ? '0' : '1';

        $result = $this->_cron-> cronDisable($params['id'], $params['is_valid']);

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