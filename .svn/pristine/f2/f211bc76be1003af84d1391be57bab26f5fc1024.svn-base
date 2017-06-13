<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2016/8/12
 * Time: 17:16
 */

class AddeleteAction extends Base_Action
{
    protected $_parameters = [
        'ad_id', 'city','page','area','pos','status'
    ];
    protected $_rules = [
        'city' => ['required' => true, 'type' => 'string'],
        'page' => ['required' => true, 'type' => 'string'],
        'area' => ['required' => false, 'type' => 'string'],
        'pos' => ['required' => false, 'type' => 'string'],
        'ad_id' => ['required' => true, 'type' => 'string'],
    ];

    protected $_ad;

    public function process()
    {
        $params =  $this-> filterParams();
        $this->_ad = new Service_Content_AdModel();
        $result = $this->_ad->deleteAd($params['ad_id']);
        if (!empty($result))
        {
            $this->response(Public_Error::SUCCESS);
        }
        else
        {
            $this->response(Public_Error::FAIL, $result,$params,"/content/ad/adlist.html?city={$params['city']}&page={$params['page']}&area{$params['area']}&pos={$params['pos']}");
        }
    }
}