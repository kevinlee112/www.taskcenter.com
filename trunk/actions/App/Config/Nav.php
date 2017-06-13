<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 *
 * APP配置
 *
 * @author     qingyuan2@leju.com
 * @version    $Id$
 */
class NavAction extends Base_Action
{
    protected $_parameters = [
        'page', 'orderid', 'name', 'image', 'link','status', 'update', 'delete', 'hidden'
    ];
    protected $_rules = [
        'page' => ['required' => false, 'type' => 'number'],
        'update' => ['required' => false, 'type' => 'string'],
        'delete' => ['required' => false, 'type' => 'string'],
        'hidden' => ['required' => false, 'type' => 'string'],
    ];

    protected $_rule = [
        'orderid' => ['required' => true,'type' => 'string'],
        'name' => ['required' => true,'type' => 'string'],
        'image' => ['required' => true,'type' => 'string'],
        'link' => ['required' => true,'type' => 'string'],
    ];

    protected $_config;

    public function process()
    {
        $params =  $this-> filterParams();
        $this->_config = new Service_App_ConfigModel('nav');
        if ($this->getRequest()->isPost() && (array() == ($info = Validate::check($params, $this->_rule))))
        {
            if (isset($params['update']))
            {
                $result = $this->_config->navUpdate($params['update'], $params['orderid'], $params['name'], $params['image'], $params['link'], $params['status']);
            }
            else
            {
                $result = $this->_config->navAdd($params['orderid'], $params['name'], $params['image'], $params['link']);
            }
            if (false !== $result)
            {
                AppResponse::redirect('/app/config/nav.html');
            }
            else
            {
                $this->response(Public_Error::FAIL, $result,$params,'/app/config/nav.html' );
            }
        }
        elseif($this->getRequest()->isGet())
        {
            if (isset($params['hidden']))
            {
                $this->_config->navHidden($params['hidden'], $params['status']);
                AppResponse::redirect('/app/config/nav.html');
            }
            elseif(!empty($params['delete']))
            {
               $this->_config->configDelete($params['delete']);
                AppResponse::redirect('/app/config/nav.html');
            }

        }



        if(empty($params['page']))
        {
            $params['page'] = 1;
        }
        $navList =  $this->_config->getLists($params['page']);
        $total = $this->_config->getTotal();
        Yaf_Loader::import(PATH_FW_TOOLS . 'Page.php');
        $page = new Tools_page($total,$params['page']);
        $this->assign('page_html', $page->get_html());
        $this->assign( 'nav_list',$navList);
    }

}