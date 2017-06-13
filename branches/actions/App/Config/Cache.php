<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 *
 * APP配置
 *
 * @author     qingyuan2@leju.com
 * @version    $Id$
 */
class CacheAction extends Base_Action
{
    protected $_parameters = [
        'page', 'module','cache_version','update', 'delete'
    ];
    protected $_rules = [
        'page' => ['required' => false,'type' => 'string'],
    ];

    protected $_rule = [
        'module' => ['required' => true,'type' => 'string'],
        'cache_version' => ['required' => true,'type' => 'string']
    ];

    protected $_config;

    public function process()
    {
        $params =  $this-> filterParams();
        $this->_config = new Service_App_ConfigModel('cache');
//        $info = Validate::check($params, $this->_rule);
        if ($this->getRequest()->isPost() && (array() == ($info = Validate::check($params, $this->_rule))))
        {
            if (!empty($params['update']))
            {
                $result = $this->_config->cacheUpdate($params['update'], $params['module'], $params['cache_version']);
            }
            else
            {
                $result = $this->_config->cacheAdd($params['module'], $params['cache_version']);
            }
            if (false !== $result)
            {
                AppResponse::redirect('/app/config/cache.html');
            }
            else
            {
                $this->response(Public_Error::FAIL, $result,$params,'/app/config/cache.html' );
            }
        }
        elseif($this->getRequest()->isGet())
        {
            if(!empty($params['delete']))
            {
                $this->_config->configDelete($params['delete']);
                AppResponse::redirect('/app/config/cache.html');
            }

        }

        if(empty($params['page']))
        {
            $params['page'] = 1;
        }

        $cacheList =  $this->_config->getLists($params['page']);
        $total = $this->_config->getTotal();
        Yaf_Loader::import(PATH_FW_TOOLS . 'Page.php');
        $page = new Tools_page($total,$params['page']);
        $this->assign('page_html', $page->get_html());
        $this->assign( 'cache_list',$cacheList);
    }

}