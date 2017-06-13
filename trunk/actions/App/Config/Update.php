<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 *
 * APP配置
 *
 * @author     qingyuan2@leju.com
 * @version    $Id$
 */
class UpdateAction extends Base_Action
{
    protected $_parameters = [
          'device', 'title', 'latest_version', 'website', 'web_url', 'app_url', 'force', 'new_function' , 'update', 'delete'
    ];
    protected $_rules = [
        'update' => ['required' => false,'type' => 'string'],
        'delete' => ['required' => false,'type' => 'string'],

    ];

    protected $_rule = [
        'device' => ['required' => true,'type' => 'string'],
        'title' => ['required' => true,'type' => 'string'],
        'latest_version' => ['required' => true,'type' => 'string'],
        'website' => ['required' => true,'type' => 'string'],
        'app_url' => ['required' => true,'type' => 'string'],
        'force' => ['required' => true,'type' => 'string'],
        'new_function' => ['required' => true,'type' => 'string'],

    ];

    protected $_config;

    public function process()
    {
        $params =  $this-> filterParams();
        $this->_config = new Service_App_ConfigModel('update');
        if ($this->getRequest()->isPost() && (array() == ($info = Validate::check($params, $this->_rule))))
        {
            if (!empty($params['update']))
            {
//                $check_exist = $this->_config->check_exist(array('latest_version' => $params['latest_version']));
//                if ($check_exist == false)
//                {
//                    $this->response(Public_Error::ERR_NOT_CONFIG_HAS_EXISTED, $check_exist,$params['latest_version'],'/app/config/update.html' );
//                }
                $result = $this->_config->upUpdate($params['update'], $params['device'], $params['title'], $params['latest_version'], $params['website'], $params['web_url'], $params['app_url'], $params['force'], $params['new_function']);
            }
            else
            {
                $check_exist = $this->_config->check_exist(array('latest_version' => $params['latest_version'], 'device' => $params['device'] ));
                if ($check_exist == false)
                {
                    $this->response(Public_Error::ERR_NOT_CONFIG_HAS_EXISTED, $check_exist,$params['latest_version'],'/app/config/update.html' );
                }
                $result = $this->_config->upAdd($params['device'], $params['title'], $params['latest_version'], $params['website'], $params['web_url'], $params['app_url'], $params['force'], $params['new_function']);
            }
            if (false !== $result)
            {
                AppResponse::redirect('/app/config/update.html');
            }
            else
            {
                $this->response(Public_Error::FAIL, $result,$params,'/app/config/update.html' );
            }
        }

        $updateList =  $this->_config->getVersionList();
        $this->assign( 'update',$updateList);
    }

}