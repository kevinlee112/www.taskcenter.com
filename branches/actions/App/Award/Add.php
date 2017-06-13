<?php
<?php
class AliyunTester implements ITester
{

    private $_secretId;
    private $_secretKey;

    public function __construct($conf)
    {
        $this->_secretId = $conf['AccessKeyID'];
        $this->_secretKey = $conf['AccessKeySecret'];
    }

    public function test()
    {
        $host = 'http://ecs.aliyuncs.com?';
        // UTC时间
        date_default_timezone_set("UTC");
        $dateTimeFormat = 'Y-m-d\TH:i:s\Z'; // ISO8601规范
        $data = array(
            // 公共参数
            'Format' => 'JSON',
            'Version' => '2014-05-26',
            'AccessKeyId' => $this->_secretId,
            'SignatureVersion' => '1.0',
            'SignatureMethod' => 'HMAC-SHA1',
            'SignatureNonce'=> rand(10000, 99999),
            'Timestamp' => date($dateTimeFormat),
            // 接口参数
            'Action' => 'DescribeInstanceStatus',
            'RegionId' => 'cn-guangzhou'
        );
        // 计算签名并把签名结果加入请求参数
        //echo $data['Version']."<br>";
        //echo $data['Timestamp']."<br>";
        $data['Signature'] = $this->computeSignature($data, $this->_secretKey);
        $url = $host.http_build_query($data);
        $resp = @file_get_contents($url, false, stream_context_create(array(
            "ssl"=>array (
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        )));
        return $resp != false;

    }

    private function computeSignature($parameters, $accessKeySecret)
    {
        // 将参数Key按字典顺序排序
        ksort($parameters);
        // 生成规范化请求字符串
        $canonicalizedQueryString = '';
        foreach($parameters as $key => $value)
        {
            $canonicalizedQueryString .= '&' . self::percentEncode($key)
                . '=' . self::percentEncode($value);
        }
        // 生成用于计算签名的字符串 stringToSign
        $stringToSign = 'GET&%2F&' . self::percentencode(substr($canonicalizedQueryString, 1));
        // 计算签名
        $signature = base64_encode(hash_hmac('sha1', $stringToSign,$accessKeySecret . '&', true));
        //echo "<br>".$signature."<br>";
        return $signature;
    }


    private static function percentEncode($str)
    {
        // 使用urlencode编码后，将"+","*","%7E"做替换即满足ECS API规定的编码规范
        $res = urlencode($str);
        $res = preg_replace('/\+/', '%20', $res);
        $res = preg_replace('/\*/', '%2A', $res);
        $res = preg_replace('/%7E/', '~', $res);
        return $res;
    }
}











/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * 活动添加
 * 
 * @author     guodong5@leju.com
 * @version    $Id$
 */

class AddAction extends Base_Action
{
    protected $_rules = [

    ];

    protected $_rule = [
        'name' => ['required' => true, 'type' => 'string'],
        'rule_text' => ['required' => true, 'type' => 'string'], //活动规则
        'project_id' => ['required' => true, 'type' => 'number'],
        'activity_id' => ['required' => true, 'type' => 'number'],
    ];
    
    protected $_parameters = [
        'name','rule_text','project_id','activity_id'
    ];

    private $awardModel;
    
    public function process()
    {
        $this->awardModel= new Service_App_AwardModel();

        if($this->getRequest()->ispost())
        {
            $params = $this->filterParams();

            $checkRes = Validate::check($params,$this->_rule,true);

            if(!empty($checkRes))
            {
                $this->response(Public_Error::ERR_PARAM);
            }

            $checkExist  = $this->awardModel->getAwardInfoByActivityid($params['project_id'],$params['activity_id']);

            if(!empty($checkExist))
            {
                $this->response(Public_Error::ERR_AWARD_HAS_EXIST);
            }

            $images = $this->getParam('image');  //数组元素单独接受

            $image_data = array(
                'image1'=>$images[0],
                'image2'=>$images[1],
                'image3'=>$images[2],
                'image4'=>$images[3],
                'image5'=>$images[4],
                'image6'=>$images[5],
            );

            $params['image_json'] = json_encode($image_data);

            //$checkExists = $this->awardModel->getAwardInfoByName($params['name']);

            //if(!empty($checkExists))
            //{
            //    $this->response(Public_Error::ERR_AWARD_HAS_EXISTED);
            //}

            $result = $this->awardModel->insertAwardInfo($params);

            if($result)
            {
                $this->redirect('/app/award/index.html');
            }
            else
            {
                $this->response(Public_Error::FAIL);
            }
            exit;
        }

        $this->assign('title', "添加活动");

    }
}