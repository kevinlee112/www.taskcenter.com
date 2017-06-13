<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * Test.php
 * @auther: guodong5@leju.com
 * @date:2016-08-18
 * @create Time: ${time}
 * @version ${Id}
 * @last modify time: ${LastChangedDate}
 */

class Service_Manager_CityModel extends Base_Dao
{

    /**
     * 获取城市下拉列表
     *
     */
    public function getCityOptions()
    {
        $options = array();

        $city_list_res = $this->getAllCity();

        if($city_list_res)
        {
            foreach($city_list_res as $v)
            {
                $options[$v['city_en']] = strtoupper($v['first']) . '-' . $v['city_cn'];
            }

            asort($options);

            return $options;
        }

        return false;
    }

    /**
     * 获取所有开通城市
     * @return Ambigous <multitype:, multitype:mixed string >
     */
    public function getAllCity()
    {
        $redis = new Base_Redis('redis');

        $cache_key = md5("data_city_list_v1.0");

        $cache_data = $redis->get($cache_key);

        if($cache_data)
        {
            return json_decode($cache_data,true);
        }

        $apiCity =  new Api_CityModel();
        //接口取数据
        $api_res = $apiCity->getAllCity();

        if($api_res)
        {
            //设置缓存
            $api_data = $this->getListByKeys($api_res, array('city_en', 'city_cn', 'city_py' ,'city_pub'));

            foreach($api_data as $k => $v)
            {
                $v['first'] = strtolower(substr($v['city_py'], 0, 1));

                $api_data[$k] = $v;
            }

            $redis->set($cache_key,json_encode($api_data),600);

            return $api_data;
        }

        return false;
    }

    /**
     * 根据指定字段获取列表数据
     * @param array $source
     * @param array $keys
     * @param string $action intersect|diff
     * @return multitype:multitype:
     */
    public function getListByKeys($source, $keys, $action='intersect')
    {
        if(!is_array($source) || !is_array($keys) || count($source) == 0)
        {
            return false;
        }

        $keys = array_fill_keys($keys, '');

        $result = array();

        foreach($source as $key => $value)
        {
            if($action == 'intersect')
            {
                $result[$key] = array_intersect_key($value, $keys);
            }
            else
            {
                $result[$key] = array_diff_key($value, $keys);
            }
        }

        return $result;
    }

    

}
