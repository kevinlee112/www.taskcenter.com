<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2016/8/16
 * Time: 9:19
 */
class RediscacheAction extends Base_Action
{
    protected $_parameters = [
        'limit', 'key', 'name'
    ];

    protected $_rules = [
        'limit' => ['type' => 'string', 'max' => 100],
        'name' => ['required' => false, 'type' => 'string']
    ];

    protected $_rule = [
        'key' => ['required' => true, 'type' => 'string'],
    ];
    protected $_cache;

    public function process()
    {
        $params = $this->filterParams();
        if (empty($params['name']))
        {
            $params['name'] = 'redis';
        }

        $this->assign('name', $params['name']);

        $this->_cache = new Service_Manager_CacheModel($params['name']);

        $info = Validate::check($params, $this->_rule);
        if ($this->getRequest()->isGet() && empty($info))
        {
            $searchList = $this->_cache->searchRedis($params['key']);
            if (false !== $searchList)
            {
                $this->assign('searchName', $params['key']);
                $this->assign('searchList', $searchList);
            }
            else
            {
                $this->response(Public_Error::ERR_CACHE_KEY_NOT_EXISTED, $searchList, $params,"rediscache.html?name={$params['name']}" );
            }
        } else
        {
            $redisList = $this->_cache->showRedisCache();
            if (false !== $redisList)
            {
                $this->assign('redisList', $redisList);
            }
            else
            {
                $this->response(Public_Error::FAIL, $redisList,$params, "rediscache.html?name={$params['name']}");
            }
        }

    }
}