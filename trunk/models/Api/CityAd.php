<?php

/**
 * 获取城市列表
 *用于广告展示
 */
class Api_CityAdModel
{
    private $_config = array(
        'api_base_url' => 'http://m.leju.com/api/v1/city/lists.json?appkey=2408231234',
    );

    private $_lib_http;

    public function __construct()
    {
        $this->_lib_http = new Http_Request();
    }

    /**
     * 获取开通城市
     * @param string $encoding
     * @param string $return_type
     * @param string $status
     *
     * @return Ambigous <mixed, string>
     */
    public function getAllCityForAd()
    {

        $city_list = $this->_lib_http->request($this->_config['api_base_url']);
        if (!$city_list)
        {
            return false;
        }
        $arr = $this->f_data(json_decode($city_list))['entry'];
        foreach ($arr as $k => $v)
        {
            $temp = substr($v['city_en'], 0, 1);
            $res[$v['city_en']] = $temp . ' ' . $v['city_cn'];
        }
        return $res;
    }

    private function f_data($obj)
    {
        $arr = is_object($obj) ? get_object_vars($obj) : $obj;
        $ret = array();

        foreach ($arr as $key => $value)
        {
            $value = (is_array($value) || is_object($value)) ? $this->f_data($value) : $value;
            $ret[$key] = $value;
        }
        return $ret;
    }
}