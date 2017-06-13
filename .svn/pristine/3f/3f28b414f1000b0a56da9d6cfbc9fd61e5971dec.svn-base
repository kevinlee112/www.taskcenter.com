<?php
/**
 * 获取城市列表
 *
 */
class Api_ActivityModel
{
    private $_config = array(
        'api_base_url' => 'http://weixin.bch.leju.com/api/',
    );
    private $token = '26214078';
    private $appkey = '2408231234';

    private $_lib_http;

    public function __construct()
    {
        $this->_lib_http = new Http_Request();
    }

    /**
     * 获取活动信息
     * @param $project_id
     * @param $activity_id
     */
    public function getActivityInfo($project_id, $activity_id, $activity_type = 'standard')
    {
        $api_url =  $this->_config['api_base_url']."activity/get_info.htm?appkey=".$this->appkey;

        $data = array(
            'weixin_house_id'=>$project_id,
            'activity_id'=>$activity_id,
            'activity_type' => $activity_type,
            'module' => 'prize_list',
            'timestamp'=>time()
        );

        $data['sign'] = $this->create_sign($data);

        return $this->_lib_http->request($api_url,array(),$data);
    }

    /**
     * 加密方法
     *
     */
    private function create_sign($data)
    {
        if(empty($data) || empty($data['timestamp']))
        {
            return false;
        }

        ksort($data);

        $tmpstr = http_build_query($data);

        $sign = md5($tmpstr . $this->token);

        return $sign;
    }
}