<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2016/8/12
 * Time: 17:16
 */

class AdlistAction extends Base_Action
{
    protected $_parameters = [
        'city','page','area','pos','status', 'pages'
    ];

    protected $_rules = [
        'city' => ['required' => true, 'type' => 'string'],
        'page' => ['required' => true, 'type' => 'string'],
        'area' => ['required' => false, 'type' => 'string'],
        'pos' => ['required' => false, 'type' => 'string'],
        'pages' => ['required' => false, 'type' => 'number'],
    ];
    protected $_rule = [
        'status' => ['required' => true, 'type' => 'string'],
    ];

    protected $_ad;

    public function process()
    {
        $params =  $this-> filterParams();
        $this->_ad = new Service_Content_AdModel();
        if(empty($params['pages']))
        {
            $params['pages'] = 1;
        }
        $info = Validate::check($params, $this->_rule);
        if (($this->getRequest()->isGet() && empty($info)) && $params['status'] == "expired")
        {
            $result =  $this->_ad->getAdLists( $params['city'], $params['page'], $params['area'], $params['pos'], $params['pages'], $params['status']);
            $this->assign( 'expired',$result['ad_list']['expired']);
        }
        else
        {
            $result =  $this->_ad->getAdLists( $params['city'], $params['page'], $params['area'], $params['pos'], $params['pages']);
            $this->assign( 'use',$result['ad_list']['use']);

        }

        //分页
        $total = $result['count'];
        Yaf_Loader::import(PATH_FW_TOOLS . 'Page.php');
        $page = new Tools_page($total,$params['pages']);
        $this->assign('page_html', $page->get_html());
        if (!empty($result['ad_list']['display'][0]))
        {
            $this->assign( 'displaying',$result['ad_list']['display'][0]);
        }
        $this->assign( 'param',$params);
        $this->assign( 'city',$result['city']);
        $this->assign( 'page_name',$result['page']);
        $this->assign( 'area',$result['area']);
        $this->assign( 'ae',$result['ae']);

    }
}