<?php

class Dao_App_ConfigModel extends Base_Dao
{

    protected $_db = 'default';

    protected $_pk = 'id';

    protected $_table = 'mf_app_config_';
    protected $_redis = null;


    /**
     * 构造方法
     */
    public function __construct($table)
    {
        $this->_redis = new Base_Redis('mf_redis');
        $this->_table .= $table;
    }

    public function getCount()
    {
        $result = $this->count($where= array(), $params = array(), $this->_table);
        return $result;
    }

    public function configDelete($id)
    {
        if (empty($id))
        {
            return false;
        }
        $result = $this->delete($id);
        return $result;
    }


    public function getList($page, $limit)
    {
        $opts = [
            'order' => $this->_pk . ' asc',
            'start' => ($page - 1) * $limit,
            'limit' => $limit,
        ];
        $result = $this->find($opts);

        return $result;
    }

    public function check_exist($check)
    {
        $condition = array();
        $params = array();
        foreach ($check as $field => $value)
        {
            if (!empty($field) && !empty($value))
            {
                ($condition[$field] = '?') && $params[$field] = $value;
            }
        }
        $where = $condition ? $this->where($condition) : '';
        $opts = [
            'where' => $where,
            'order' =>$this->_pk . ' asc',
        ];
        $result = $this->find($opts,$params);
        return $result;

    }


    /**
     * 导航配置
     */
    public function navAdd($orderid, $name, $image, $link)
    {
        $data = array();
        !empty($name) && $data['name'] = $name;
        !empty($image) && $data['pic'] = $image;
        !empty($link) && $data['link'] = $link;
        is_numeric($orderid) && $data['orderid'] = $orderid;
        $result = $this->insert($data);
        return $result;
    }

    public function navUpdate($id, $status = null, $orderid = null, $name = null, $image = null, $link = null)
    {
        $data = array();
        !empty($name) && $data['name'] = $name;
        !empty($image) && $data['pic'] = $image;
        !empty($link) && $data['link'] = $link;
        is_numeric($status) && $data['status'] = $status;
        is_numeric($orderid) && $data['orderid'] = $orderid;
        $result = $this->update($id, $data);
        return $result;
    }

    /**
     * 版本更新配置
     */

    public function upAdd($device, $title, $latest_version, $website,$web_url, $app_url, $force = 0, $new_function)
    {
        $data = array();
        !empty($device) && $data['device'] = $device;
        !empty($title) && $data['title'] = $title;
        !empty($latest_version) && $data['latest_version'] = $latest_version;
        !empty($website) && $data['website'] = $website;
        !empty($app_url) && $data['web_url'] = $web_url;
        !empty($app_url) && $data['app_url'] = $app_url;
        is_numeric($force) && $data['force'] = $force;
        !empty($new_function) && $data['new_function'] = $new_function;
        $result = $this->insert($data);
        return $result;
    }

    public function upUpdate($id, $device = null, $title = null, $latest_version = null, $website = null,$web_url = null, $app_url = null, $force = 0, $new_function = null)
    {
        $data = array();
        !empty($device) && $data['device'] = $device;
        !empty($title) && $data['title'] = $title;
        !empty($latest_version) && $data['latest_version'] = $latest_version;
        !empty($website) && $data['website'] = $website;
        !empty($app_url) && $data['web_url'] = $web_url;
        !empty($app_url) && $data['app_url'] = $app_url;
        is_numeric($force) && $data['force'] = $force;
        !empty($new_function) && $data['new_function'] = $new_function;

        $result = $this->update($id, $data);
        return $result;
    }

    public function getVersionList($device)
    {
        $condition = array();
        $params = array();
        (!empty($device) && $condition['device'] = '?') && $params['latest_version'] = $device;
        $where = $condition ? $this->where($condition) : '';
        $opts = [
            'where' => $where,
            'order' => 'latest_version desc, id desc',
            'start' => 0,
            'limit' => 1,
        ];
        $result = $this->find($opts,$params);
        return isset($result[0]) ? $result[0] : array();

    }

    /**
     * 缓存版本控制
     */
    public function cacheAdd($module, $cache_version)
    {
        $data = array();
        !empty($module) && $data['module'] = $module;
        !empty($cache_version) && $data['cache_version'] = $cache_version;
        $result = $this->insert($data);
        return $result;
    }

    public function cacheUpdate($id, $module = null, $cache_version = null)
    {
        $data = array();
        !empty($id) && $data['id'] = $id;
        !empty($module) && $data['module'] = $module;
        !empty($cache_version) && $data['cache_version'] = $cache_version;
        $result = $this->update($id, $data);
        return $result;
    }


    /**
     * 新年活动祝福语
     */
    public function wishTotal()
    {
        $result = $this->_redis->redisOtherMethods()->redisOtherMethods()->llen('mf_app_activity_wish_queue');
        return $result;
    }
    public function wishList($l_rang = 0, $r_rang = -1)
    {
        $result = $this->_redis->lranges('mf_app_activity_wish_queue', $l_rang, $r_rang);
        $this->redis_push('mf_app_activity_wish_queue', urlencode(json_encode($result)));
        return $result;
    }

    public function wishAdd($wish)
    {
        $result = $this->_redis->rpush('mf_app_activity_wish_queue', $wish);
        return $result;
    }

    public function wishUpdate($key, $wish)
    {
        $result = $this->_redis->redisOtherMethods()->redisOtherMethods()->lset('mf_app_activity_wish_queue',$key, $wish);
        return $result;
    }

    public function wishDelete($key)
    {
        $wish = $this->_redis->redisOtherMethods()->redisOtherMethods()->lindex('mf_app_activity_wish_queue',$key);
        $result = $this->_redis->redisOtherMethods()->redisOtherMethods()->lrem('mf_app_activity_wish_queue',$wish, 1);
        return $result;
    }
    private function redis_push($key, $value)
    {
        $api_url = "http://14.29.93.227/v41/activity/redis_push.json";
        $data = array(
            'debug_crypt' => 911,
            'key' => $key,
            'value' => $value
        );
        $lib_http = new Http_Request();
        $lib_http->setHeader('mf.leju.com');
        $lib_http ->request($api_url, array(), $data);
    }

    /**
     * 活动开关
     */
    public function setSwitch($switch)
    {
        $result = $this->_redis->set('mf_app_activity_switch',$switch);
        return $result;
    }

    public function getSwitch()
    {
        $result = $this->_redis->get('mf_app_activity_switch');
        $this->redis_push('mf_app_activity_switch', $result);
        return $result;
    }

}