<?php

/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2016/8/16
 * Time: 9:19
 */

class UpdateAction extends Base_Action
{

    protected $_rules = [
        'id' => ['required' => true, 'type' => 'number'],
    ];

    protected $_rule = [
        'id' => ['required' => true, 'type' => 'number'],
        'is_valid' => ['required' => true,'type' => 'string'],
        'type' => ['required' => true, 'type' => 'number'],
        'nxt_time' => ['required' => true,'type' => 'string'],
        'period_interval' => ['required' => false,'type' => 'string'],
        'period_type' => ['required' => false,'type' => 'string'],
        'exec_mod' => ['required' => true,'type' => 'string'],
        'exec_act' => ['required' => true,'type' => 'string'],
        'name' => ['required' => true,'type' => 'string'],
        'description' => ['required' => false,'type' => 'string'],
    ];

    protected $_parameters = [
        'id', 'type', 'is_valid', 'nxt_time', 'period_interval', 'period_type', 'exec_mod', 'exec_act', 'name', 'description',
    ];

    protected $_cron;

    public function process()
    {
        $params =  $this-> filterParams();
        $this->_cron = new Service_Manager_CronModel();

        $cron =  $this->_cron-> getCronById($params['id']);
        if ($this->getRequest()->isPost())
        {
            if (array() !== ($info = Validate::check($params, $this->_rule)))
            {
                $this->response(Public_Error::ERR_PARAM, $info);
            }
            $result =  $this->_cron-> cronUpdate($params['id'], $params);
            if (false !== $result)
            {
                AppResponse::redirect('/manager/cron/index.html');
            }
            else
            {
                $this->response(Public_Error::FAIL, $result,$params,'update.html?id='.$params['id'] );
            }
        }
        $this->assign('cron', $cron);
    }
}