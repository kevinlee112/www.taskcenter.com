<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2016/8/12
 * Time: 17:16
 */

class IndexAction extends Base_Action
{
    protected $_parameters = [
        'page'
    ];

    protected $_rules = [
        'page' => ['required' => false, 'type' => 'number'],
    ];

    protected $_cron;

    public function process()
    {
        $params =  $this-> filterParams();
        $this->_cron = new Service_Manager_CronModel();
        if(empty($params['page']))
        {
            $params['page'] = 1;
        }
        $list =  $this->_cron->getList($params['page']);
        $total = $this->_cron->getTotal();
        Yaf_Loader::import(PATH_FW_TOOLS . 'Page.php');
        $page = new Tools_page($total,$params['page']);

        $this->assign('page_html', $page->get_html());
        $this->assign( 'list',$list);


    }
}