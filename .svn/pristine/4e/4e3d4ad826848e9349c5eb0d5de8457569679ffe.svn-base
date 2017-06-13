<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 *
 * APP配置
 *
 * @author     qingyuan2@leju.com
 * @version    $Id$
 */
class SwitchsAction extends Base_Action
{
    protected $_parameters = [
        'switch',
    ];

    protected $_rule = [
        'switch' => ['required' => true,'type' => 'number'],
    ];

    protected $_config;

    public function process()
    {
        $params =  $this-> filterParams();
        $this->_config = new Service_App_ConfigModel();

        if($this->getRequest()->isGet() && (array() == ($info = Validate::check($params, $this->_rule))))
        {
            if(isset($params['switch']))
            {
                $this->_config->setSwitch($params['switch']);
                AppResponse::redirect('/app/config/switchs.html');
            }
        }
        $switch =  $this->_config->getSwitch();
        $this->assign('switch',$switch);
    }

}