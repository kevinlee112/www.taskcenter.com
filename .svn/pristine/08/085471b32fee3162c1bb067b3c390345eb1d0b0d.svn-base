<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2016/8/16
 * Time: 9:19
 */

class CachekeyAction extends Base_Action
{
    protected $_rule = [
        'source' => ['required' => true,'type' => 'string'],
        'type' => ['required' => true,'type' => 'string'],
        'key' => ['required' => true,'type' => 'string'],
        'delete' => ['required' => false,'type' => 'string'],
    ];

    protected $_parameters = [
        'source', 'type','key', 'page', 'delete'
    ];

    protected $_cache;

    public function process()
    {
        $params = $this->filterParams();
        if (empty($params['name']))
        {
            $params['name'] = 'redis';
        }
        $this->_cache = new Service_Manager_CacheModel($params['name']);

        if(empty($params['page']))
        {
            $params['page'] = 1;
        }

        $cacheList =  $this->_cache->getLists($params['page']);
        $total = $this->_cache->getTotal();
        Yaf_Loader::import(PATH_FW_TOOLS . 'Page.php');
        $page = new Tools_page($total,$params['page']);
        $this->assign('page_html', $page->get_html());
        $this->assign( 'cache_list',$cacheList);


        if ($this->getRequest()->isPost())
        {
            if (array() !== ($info = Validate::check($params, $this->_rule)))
            {
                $this->response(Public_Error::ERR_PARAM, $info, $params, 'cachekey.html' );
            }
            $result = $this->_cache->cacheAdd($params['source'], $params['type'], $params['key']);
            if (false !== $result)
            {
                AppResponse::redirect('/manager/cache/cachekey.html');
            }
            else
            {
                $this->response(Public_Error::FAIL, $result,$params,'/manager/cache/cachekey.html');
            }
        }
        elseif($this->getRequest()->isGet())
        {
            if(!empty($params['delete']))
            {
                $this->_cache->cacheDelete($params['delete']);
                AppResponse::redirect('/manager/cache/cachekey.html');
            }

        }
    }
}