<?php

/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2016/8/16
 * Time: 9:19
 */

class UpdateAction extends Base_Action
{

    protected $_rules = [
        'id' => ['required' => true, 'type' => 'number'],
    ];

    protected $_rule = [
        'id' => ['required' => true, 'type' => 'number'],
        'en_name' => ['required' => true, 'type' => 'string'],
        'cn_name' => ['required' => true, 'type' => 'string'],
        'orderid' => ['required' => true, 'type' => 'number'],
        'is_show' => ['required' => true, 'type' => 'string'],
    ];

    protected $_parameters = [
        'id', 'en_name', 'cn_name','orderid', 'is_show'
    ];

    protected $_composer;

    public function process()
    {
        $params =  $this-> filterParams();
        $this->_composer = new Service_Manager_ComposerModel();

        $composer =  $this->_composer-> getComposerById($params['id']);
        if ($this->getRequest()->isPost())
        {
            if (array() !== ($info = Validate::check($params, $this->_rule)))
            {
                $this->response(Public_Error::ERR_PARAM, $info);
            }

            if ($checkExist = $this->_composer->checkExist($params['id'], $params['en_name'], $params['cn_name'], 'or'))
            {
                $this->response(Public_Error::ERR_COMPOSER_HAS_EXISTED, $checkExist, $params, 'update.html?id='.$params['id'] );
            }

            $result =  $this->_composer-> composerUpdate($params['id'], $params['is_show'], $params['en_name'], $params['cn_name'], $params['orderid']);
            if (false !== $result)
            {
                $userId = $_COOKIE['user_id'];//Yaf_Session::getInstance()->get('user_id');
                $redis = new Base_Redis('redis');
                $cache_key = md5("data_main_menu_list_{$userId}_v1.0");
                $redis->set($cache_key, '');

                AppResponse::redirect('/manager/composer/index.html');
            }
            else
            {
                $this->response(Public_Error::FAIL, $result,$params,'update.html' );
            }
        }
        $this->assign('composer', $composer);




    }
}