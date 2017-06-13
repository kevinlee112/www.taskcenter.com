<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 *
 * Test.php
 *
 */

class Service_Content_AdModel
{
    protected $_daoAd;
    protected $_limit = DEFAULT_PAGE_LIMIT;

    /**
     * 构造方法
     */
    public function __construct()
    {
        $this->_daoAd = new Dao_Content_AdModel;
    }


    public function search_ad($city_code, $page, $area, $pos)
    {
        $result = $this->_daoAd->getAd($city_code, $page, $area, $pos);
        return $result;
    }


     /**
     *广告删除
     * @param string $id
     * @return array
     */
    public function deleteAd($ad_id)
    {
        if (empty($ad_id))
        {
            return false;
        }
        $result = $this->_daoAd->deleteAd($ad_id);
        return $result;
    }


    /**
     *获取广告列表
     * @param string $city
     * @param string $page
     * @param string $area
     * @param int $pos
     * @param string $pages
     * @param string $status
     * @return array
     */
    public function getAdLists($city, $page, $area, $pos, $pages, $status = 'use')
    {
        $position_params = Config::get('adpage.'.$page);
        if (empty($position_params))
        {
            return false;
        }
        $area_name = '';
        $ae = '';
        if (isset($position_params[$area]))
        {
            $area_name = $position_params[$area]['name'];
            if (!empty($pos))
            {
                $area_name = $position_params[$area]['name']."-第{$pos}条";
            }
            $area = $position_params[$area]['area'];
        }

        if ($status == 'use')
        {
            $ad_list['use'] = $this->_daoAd->getUseAd($city, $position_params['page'], $area, $pos, $pages);
        }
        else
        {
            $ad_list['expired'] = $this->_daoAd->getExpAd($city, $position_params['page'], $area, $pos, $pages);
        }
        $ad_list['display'] = $this->_daoAd->getDisplayAd($city, $position_params['page'], $area, $pos, $pages);
        $count = $this->_daoAd-> total($city, $position_params['page'], $area, $pos, $status);
        //数据格式转换
        foreach ($ad_list as $key => $val)
        {
            foreach ($val as $k => $v)
            {
                if (!empty($v))
                {
                    $ae = $v['position'];
                    $city = $v['city_name'];
                    $v['param'] = $this->jsonDecode($v['param']);
                    $v['json'] = $this->jsonDecode($v['json']);
                    $v['push_time'] =date('Y-m-d H:i:s', $v['push_time']);
                    $v['start_time'] =date('Y-m-d H:i:s', $v['start_time']);
                    $v['end_time'] =date('Y-m-d H:i:s', $v['end_time']);
                    $ad_list[$key][$k] =  $v;
                }
            }
        }
        return [
            'city' => $city,
            'page' => $position_params['name'],
            'area' =>$area_name,
            'ae' => $ae,
            'ad_list' => $ad_list,
            'count' => $count
        ];
    }



    /**
     *解析广告中json
     * @param string $json
     * @return array
     */
    public function jsonDecode($json)
    {
        $json = json_decode($json, 1);
        if (isset($json['link']))
        {
            $json['link'] = urldecode( $json['link']);
            $result['link'] =  $json['link'];
        }
        $result['content'] = print_r($json, 1);
        return $result;
    }

    /**
     * 获取推送广告城市列表
     *
     */
    public function getCityList()
    {
        $cityList = $this->_daoAd->getCityList();

        $cityOption = array();

        if($cityList)
        {
            foreach($cityList as $k=>$v)
            {
                $cityOption[$v['city_code']] = strtoupper(substr($v['city_code'],0,1)).' - '.$v['city_name'];
            }
        }

        return $cityOption;
    }


}