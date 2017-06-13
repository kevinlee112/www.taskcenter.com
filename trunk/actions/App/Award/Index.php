<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 *
 * 砸蛋活动
 *
 * @author     guodong5@leju.com
 * @version    $Id$
 */
class IndexAction extends Base_Action
{
    protected $_rules = [
        'id' => ['required' => false, 'type' => 'string'],
        'name' => ['required' => false, 'type' => 'string'],
        'activity_id' => ['required' => false, 'type' => 'string'],
        'page' => ['required' => false, 'type' => 'string'],
    ];

    protected $_parameters = [
        'id', 'name', 'activity_id','page'
    ];

    private  $awardModel;

    public function process()
    {
        $params = $this->filterParams();

        $this->awardModel = new Service_App_AwardModel();

        if(empty($params['page']))
        {
            $params['page'] = 1;
        }

        $total = $this->awardModel->getAwardTotal($params['id'],$params['name'],$params['activity_id']);

        $list = $this->awardModel->getAwardList($params['id'],$params['name'],$params['activity_id'], $params['page']);

        Yaf_Loader::import(PATH_FW_TOOLS . 'Page.php');

        $page = new Tools_page($total,$params['page']);

        $this->assign('awardList', $list);
        $this->assign('page_html', $page->get_html());  //分页
        $this->assign('page', $params['page']);
        $this->assign('id', $params['id']);
        $this->assign('name', $params['name']);
        $this->assign('activity_id', $params['activity_id']);
        $this->assign('title','用户列表');

    }

}