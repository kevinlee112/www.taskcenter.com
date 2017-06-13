<?php
/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * Cache.php
 */

class Dao_Manager_CacheModel extends Base_Dao
{
    protected $_db = 'default';

    protected $_mc;
    protected $_redis;

    protected     $_table = 'mf_manager_cache';

    /**
     *构造方法
     */
    function __construct($redis)
    {
        $this->_mc = new Memcache;
        $this->_redis = new Base_Redis($redis);
    }

    public function getCount()
    {
        $result = $this->count($where= array(), $params = array(), $this->_table);
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

    public function cacheAdd($source, $type, $key)
    {
        $data = array();
        !empty($source) && $data['source'] = $source;
        !empty($type) && $data['type'] = $type;
        !empty($key) && $data['key'] = $key;
        $result = $this->insert($data);
        return $result;
    }

    public function cacheDelete($id)
    {
        if (empty($id))
        {
            return false;
        }
        $result = $this->delete($id);
        return $result;
    }

    /**
     *RedisString搜索
     * @param string $key
     * @return string
     */
    public function searchRedisKey($key)
    {
        return $this->_redis-> get($key);
    }
    /**
     *RedisList搜索
     * @param string $key
     * @return array
     */
    public function searchRedisList($key, $limit = DEFAULT_PAGE_LIMIT)
    {
        return $this->_redis->lranges ( $key , 0 , $limit);
    }


    /**
     *RedisHash搜索
     * @param string $tableName
     * @param string $field
     * @return array
     */
    public function searchRedisHash($tableName)
    {
        return $this->_redis->redisOtherMethods()->redisOtherMethods()->hgetall($tableName);
    }


    /**
     *RedisSet搜索
     * @param string $name
     */
    public function searchRedisSet($name)
    {
        return $this->_redis-> smembers($name);
    }

    /**
     *RedisZSet搜索
     * @param string $name
     */
    public function searchRedisZSet($name)
    {
        return $this->_redis->redisOtherMethods()->redisOtherMethods()-> zrange($name, 0, -1);
    }



    /**
     *Redis数据库存储键搜索
     * @param int $limit
     * @return array
     */
    public function showRedisKey()
    {
        $condition = [];
        $condition['source'] = '?';
        $where = $this->where($condition);
        $opts = [
            'where' => $where,
            'order' => $this->_pk . ' desc',
        ];
        $result = $this->find($opts,['redis']);
        return $result;
    }
    /**
     *Memcache数据库存储键搜索
     * @param int $limit
     * @return array
     */
    public function showMemcacheCache($limit = 100)
    {
        $condition = [];
        $condition['source'] = 'memcache';
        $where = $condition ? $this->where($condition) : '';
        $opts = [
            'where' => $where,
            'start' => 0,
            'limit' => $limit,
            'order' => $this->_pk . ' desc',
        ];
        $result = $this->find($opts);
        return $result;
    }




}