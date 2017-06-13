<?php
/**
 * 获取城市列表
 *
 */
class Api_CityModel
{
    private $_config = array(
                'api_base_url' => 'http://data.house.sina.com.cn/api/',
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
    public function getAllCity($encoding = 'utf8', $return_type = 'json', $status = 1)
    {
        $options = array('encoding' => $encoding, 'return_type' => $return_type, 'order' => 'city_py');
        $res = $this->_lib_http->request($this->_config['api_base_url'].'get_all_city.php',$options);

        //替换城市名称
        //贵州（贵阳）、广西（南宁）、海南（海口）、四川（成都）、西藏（拉萨）、新疆（乌鲁木齐）
        $replace_citys = array(
            'guizhou' => array('city_cn' => '贵阳','city_py' => 'guiyang'),
            'gx' => array('city_cn' => '南宁','city_py' => 'nanning'),
            'han' => array('city_cn' => '海口','city_py' => 'haikou'),
            'sc' => array('city_cn' => '成都','city_py' => 'chengdou'),
            'xi' => array('city_cn' => '拉萨','city_py' => 'lasa'),
            'xj' => array('city_cn' => '乌鲁木齐','city_py' => 'wulumuqi'),
        );

        $res = json_decode($res,true);

        if($res && $status == 1)
        {
            $ret = array();
            foreach ($res as $k => $v)
            {
                if($v['status'] == 1) $ret[$k] = $v;
            }

            //replace city
            foreach ($replace_citys as $k => $v)
            {
                $ret[$k]['city_cn'] = $v['city_cn'];
                $ret[$k]['city_py'] = $v['city_py'];
            }
            $res = $ret;
        }
        unset($ret);
        $ret = array();
        foreach($res as $k=>$v)
        {
            $tmp[$k] = $v['city_py'];
        }
        asort($tmp);
        foreach ($tmp as $k=>$v)
        {
            $ret[$k] = $res[$k];
        }
        $res = $ret;
        return $res;
    }
}