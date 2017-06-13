<?php

/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2016/8/16
 * Time: 9:19
 */

class HiddenAction extends Base_Action
{
    protected $_parameters = [
        'id', 'is_show'
    ];

    protected $_rules = [
        'id' => ['required' => true, 'type' => 'number'],
        'is_show' => ['required' => true, 'type' => 'string']
    ];

    protected $_composer;

    public function process()
    {
        $params =  $this-> filterParams();
        $this->_composer = new Service_Manager_ComposerModel();
        $params['is_show'] =  $params['is_show'] == 'Y' ? 'N' : 'Y';

        $result = $this->_composer-> composerHidden($params['id'], $params['is_show']);

        if (false !== $result)
        {
            $userId = $_COOKIE['user_id'];//Yaf_Session::getInstance()->get('user_id');
            $redis = new Base_Redis('redis');
            $cache_key = md5("data_main_menu_list_{$userId}_v1.0");
            $redis->set($cache_key, '');

            $this->redirect('/manager/composer/index.html');
        }
        else
        {
            $this->response(Public_Error::FAIL, $result,$params,'/manager/composer/index.html' );
        }


    }
}