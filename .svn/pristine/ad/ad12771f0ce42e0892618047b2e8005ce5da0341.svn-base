<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 *
 * app配置
 *
 */

class Service_App_ConfigModel extends Base_Dao
{
    protected $_daoConfig;
    protected $_table;
    protected $_limit = DEFAULT_PAGE_LIMIT;

    /**
     * 构造方法
     */
    public function __construct($table = '')
    {
        $this->_table = $table;
        $this->_daoConfig = new Dao_App_ConfigModel( $this->_table);
    }

    /**
     * 获取总条数
     */
    public function getTotal()
    {
        $result = $this->_daoConfig->getCount();
        return $result;

    }

    /**
     * 删除配置项
     */

    public function configDelete($id)
    {
        if(empty($id))
        {
            return false;
        }
        $result = $this->_daoConfig->configDelete($id);

        return $result;
    }

    /**
     * 删除配置项
     */

    public function check_exist($check)
    {
        if(!is_array($check) || empty($check))
        {
            return false;
        }
        $result = $this->_daoConfig->check_exist($check);

        return empty($result) ? true:false;
    }

    /**
     *获取配置项列表
     */
    public function getLists($page =DEFAULT_PAGE, $limit = 10)
    {
        $result = $this->_daoConfig->getList($page, $limit);
        return $result;
    }

    /**
     * 导航配置
     */

     public function navAdd($orderid, $name, $image, $link)
     {
         if (empty($name) || !(is_numeric($orderid)) || empty($image) || empty($link))
         {
             return false;
         }
         $result = $this->_daoConfig->navAdd($orderid, $name, $image, $link);

         return  $result;
     }

    public function navUpdate($id, $orderid,  $name, $image, $link, $status)
    {
        if (empty($id) || empty($name) || !(is_numeric($orderid)) || empty($image) || empty($link) || !is_numeric($status))
        {
            return false;
        }
        $result = $this->_daoConfig->navUpdate($id, $status, $orderid, $name, $image, $link);
        return  $result;
    }

    public function navHidden($id, $status)
    {
        if(empty($id) || !(is_numeric($status)))
        {
            return false;
        }
        $result = $this->_daoConfig->navUpdate($id, $status);

        return $result;
    }

    /**
     * 升级信息配置
     */

    public function upAdd($device, $title, $latest_version, $website,$web_url, $app_url, $force, $new_function)
    {
        if (empty($device) || empty($title) || empty($latest_version) || empty($website) || empty($app_url) || empty($new_function))
        {
            return false;
        }
        $result = $this->_daoConfig->upAdd($device, $title, $latest_version, $website,$web_url, $app_url, $force, $new_function);

        return  $result;
    }

    public function upUpdate($id, $device, $title, $latest_version, $website,$web_url, $app_url, $force, $new_function)
    {
        if (empty($id) || empty($device) || empty($title) || empty($latest_version) || empty($website) || empty($app_url) || empty($new_function))
        {
            return false;
        }
        $result = $this->_daoConfig->upUpdate($id, $device, $title, $latest_version, $website,$web_url, $app_url, $force, $new_function);
        return  $result;
    }

    public function getVersionList()
    {
        $result['iphone'] = $this->_daoConfig->getVersionList($device = 'iphone');
        $result['android'] = $this->_daoConfig->getVersionList($device = 'android');
        return  $result;
    }

    /**
     * 缓存版本控制配置
     */
    public function cacheAdd($module, $cache_version)
    {
        if (empty($module) || empty($cache_version))
        {
            return false;
        }
        $result = $this->_daoConfig->cacheAdd($module, $cache_version);

        return  $result;
    }

    public function cacheUpdate($id, $module, $cache_version)
    {
        if (empty($id) || empty($module) || empty($cache_version))
        {
            return false;
        }
        $result = $this->_daoConfig->cacheUpdate($id, $module, $cache_version);
        return  $result;
    }


    /**
     * 新年活动祝福语配置
     */

    public function getWishTotal()
    {
        $result = $this->_daoConfig->wishTotal();

        return  $result;
    }
    public function wishList()
    {
        $result = $this->_daoConfig->wishList();

        return  $result;
    }

    public function wishAdd($wish)
    {
        if (empty($wish))
        {
            return false;
        }
        $result = $this->_daoConfig->wishAdd($wish);

        return  $result;
    }

    public function wishUpdate($key, $wish)
    {
        if (!is_numeric($key) || empty($wish))
        {
            return false;
        }
        $result = $this->_daoConfig->wishUpdate($key, $wish);
        return  $result;
    }

    public function wishDelete($key)
    {
        if (!is_numeric($key))
        {
            return false;
        }
        $result = $this->_daoConfig->wishDelete($key);
        return  $result;
    }


    /**
     * 活动开关
     */
    public function setSwitch($switch)
    {
        $result = $this->_daoConfig->setSwitch($switch);
        return  $result;
    }

    public function getSwitch()
    {
        $result = $this->_daoConfig->getSwitch();
        return  $result;
    }

}