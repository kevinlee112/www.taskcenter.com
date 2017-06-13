<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 *
 * Test.php
 *
 */

class Service_Manager_CacheModel
{
    protected $_daoCache;
    protected $_redis;

    /**
     * 构造方法
     */
    public function __construct($redis = 'redis')
    {
        $this->_daoCache = new Dao_Manager_CacheModel($redis);
        $this->_redis = new Base_Redis($redis);
    }

    public function getTotal()
    {
        $result = $this->_daoCache->getCount();
        return $result;

    }

    public function getLists($page =DEFAULT_PAGE, $limit = 10)
    {
        $result = $this->_daoCache->getList($page, $limit);
        return $result;
    }

    public function cacheAdd($source, $type, $key)
    {
        if (empty($source) || empty($type) || empty($key))
        {
            return false;
        }
        $result = $this->_daoCache->cacheAdd($source, $type, $key);

        return  $result;
    }

    public function cacheDelete($id)
    {
        if (empty($id))
        {
            return false;
        }
        $result = $this->_daoCache->cacheDelete($id);

        return  $result;
    }

    /**
     *Redis搜索
     * @param string $key
     * @return array
     */
    public function searchRedis($key)
    {
        $keys = $this->_redis->redisOtherMethods()->redisOtherMethods()->keys('*'.$key.'*');
        if (empty($keys))
        {
            return false;
        }
        foreach ($keys as $key) {
            $type = $this->_redis->dataType($key);
            switch ($type)
            {
                case '3':
                    $result['list'][$key] = print_r($this->unCode($this->_daoCache->searchRedisList($key)), 1);
                    $result['count']['list'][$key] =$this->_redis->redisOtherMethods()->redisOtherMethods()->lsize($key);
                    break;
                case '2':
                    $result['set'][$key] = print_r($this->unCode($this->_daoCache->searchRedisSet($key)), 1);
                    $result['count']['set'][$key] =$this->_redis->redisOtherMethods()->redisOtherMethods()->scard($key);
                    break;
                case '4':
                    $result['zset'][$key] = print_r($this->unCode($this->_daoCache->searchRedisZSet($key)), 1);
                    $result['count']['zset'][$key] =$this->_redis->redisOtherMethods()->redisOtherMethods()->zcard($key);
                    break;
                case '5':
                    $result['hash'][$key] = $this->_daoCache->searchRedisHash($key);
                    foreach ($result['hash'][$key] as $field => $val)
                    {
                        $result['hash'][$key][$field] = print_r($this->unCode($val), 1);
                    }
                    $result['count']['hash'][$key] =count($result['hash'][$key]) ;
                    break;
                case '1':
                    $key = substr($key, 0, 120);
                    $result['key'][$key] = $this->unCode($this->_daoCache->searchRedisKey($key));
                    break;
                default:
                    break;
            }
        }
        return $result;
    }

    /**
     *Memcache搜索
     * @param string $key
     * @return array
     */
    public function searchMemcache($key)
    {
      //@TODO;
    }

    /**
     *返回RedisCache显示数组
     * @return array
     */
    public function showRedisCache()
    {

        $cache =$this->_daoCache->showRedisKey();
        $result=[];
        if (empty($cache))
        {
            return false;
        }
        foreach ( $cache as $cacheKey)
        {
            $exist =$this->_redis->exists($cacheKey['key']);
            if (empty($exist))
            {
              continue;
            }
            switch ($cacheKey['type'])
            {
                case 'list':
                    $result['list'][$cacheKey['key']] =print_r( $this->unCode($this->_daoCache->searchRedisList($cacheKey['key'])), 1);
                    $result['count']['list'][$cacheKey['key']] =$this->_redis->redisOtherMethods()->redisOtherMethods()->lsize($cacheKey['key']);
                    break;
                case 'set':
                    $result['set'][$cacheKey['key']] = $this->unCode($this->_daoCache->searchRedisSet($cacheKey['key']));
                    $result['count']['set'][$cacheKey['key']] =$this->_redis->redisOtherMethods()->redisOtherMethods()->scard($cacheKey['key']);
                    break;
                case 'zset':
                    $result['zset'][$cacheKey['key']] = print_r($this->unCode($this->_daoCache->searchRedisZSet($cacheKey['key'])), 1);
                    $result['count']['zset'][$cacheKey['key']] =$this->_redis->redisOtherMethods()->redisOtherMethods()->zcard($cacheKey['key']);
                    break;
                case 'hash':
                    $result['hash'][$cacheKey['key']] = $this->_daoCache->searchRedisHash($cacheKey['key']);
                    foreach ($result['hash'][$cacheKey['key']] as $field => $val)
                    {
                        $result['hash'][$cacheKey['key']][$field] = print_r($this->unCode($val), 1);
                    }
                    $result['count']['hash'][$cacheKey['key']] =count($result['hash'][$cacheKey['key']]) ;
                    break;
                case 'string':
                    $result['key'][$cacheKey['key']] = $this->unCode($this->_daoCache->searchRedisKey($cacheKey['key']));
                    break;
                default:
                    break;
            }
        }
        return $result;
    }


    /**
     * @param string $data
     *返回反序列化或jsonDecode结果
     * @return array
     */
    public function unCode($data)
    {
        $result = '';
        if (is_array($data))
        {
            foreach ($data as $key => $val)
            {
                if ($this->is_json($val))
                {
                    $result[$key] = print_r(json_decode($val), 1);
                }
                elseif($this->is_serialized($val))
                {
                    $result[$key] = print_r(unserialize($val), 1);
                }
                else
                {
                    $result[$key] = print_r($val, 1);
                }
            }
        }
        else
        {
            if ($this->is_json($data))
            {
                $result= print_r(json_decode($data), 1);
            }
            elseif($this->is_serialized($data))
            {
                $result = print_r(unserialize($data), 1);
            }
            else
            {
                $result = print_r($data, 1);
            }
        }

        return $result;
    }

    /**
     * @param string $data
     *判断是否是json数据
     * @return bool
     */
    function is_json($data)
    {
        $data = trim( $data );
        json_decode($data);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     *@param string $data
     *判断是否是序列化数据
     * @return bool
     */
    function is_serialized( $data ) {
        $data = trim( $data );
        if ( 'N;' == $data )
            return true;
        if ( !preg_match( '/^([adObis]):/', $data, $badions ) )
            return false;
        switch ( $badions[1] ) {
            case 'a' :
            case 'O' :
            case 's' :
                if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) )
                    return true;
                break;
            case 'b' :
            case 'i' :
            case 'd' :
                if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) )
                    return true;
                break;
        }
        return false;
    }
}