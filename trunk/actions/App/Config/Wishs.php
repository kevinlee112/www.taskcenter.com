<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 *
 * APP配置
 *
 * @author     qingyuan2@leju.com
 * @version    $Id$
 */
class WishsAction extends Base_Action
{
    protected $_parameters = [
        'wish', 'update', 'delete', 'hidden'
    ];
    protected $_rules = [
        'update' => ['required' => false, 'type' => 'string'],
        'delete' => ['required' => false, 'type' => 'string'],
        'hidden' => ['required' => false, 'type' => 'string'],
    ];

    protected $_rule = [
        'wish' => ['required' => true,'type' => 'string'],
    ];

    protected $_config;

    public function process()
    {
        $params =  $this-> filterParams();
        $this->_config = new Service_App_ConfigModel();
        if ($this->getRequest()->isPost() && (array() == ($info = Validate::check($params, $this->_rule))))
        {
            if (isset($params['update']))
            {
                $result = $this->_config->wishUpdate($params['update'], $params['wish']);
            }
            else
            {
                $result = $this->_config->wishAdd($params['wish']);
            }
            if (false !== $result)
            {
                AppResponse::redirect('/app/config/wishs.html');
            }
            else
            {
                $this->response(Public_Error::FAIL, $result,$params,'/app/config/wishs.html' );
            }
        }
        elseif($this->getRequest()->isGet())
        {
            if(isset($params['delete']))
            {
                $this->_config->wishDelete($params['delete']);
                AppResponse::redirect('/app/config/wishs.html');
            }
        }

        $wishList =  $this->_config->wishList();
        $this->assign( 'wish_list',$wishList);
    }

}