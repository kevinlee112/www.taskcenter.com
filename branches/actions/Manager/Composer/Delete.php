<?php

/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2016/8/16
 * Time: 9:19
 */

class DeleteAction extends Base_Action
{
    protected $_rules = [
        'id' => ['required' => true, 'type' => 'string'],
    ];
    protected $_parameters = [
        'id'
    ];
    protected $_composer;
    protected $_controller;

    public function process()
    {
        $params = $this->filterParams();
        $this->_composer = new Service_Manager_ComposerModel();
        $this->_controller = new Service_Manager_ControllerModel();
       if($ctlCheck = $this->_controller->getListByComposeId($params['id'], 'Y'))
       {
           $this->response(Public_Error::ERR_COMPOSER_HAS_CONTROLLER, $ctlCheck,'','/manager/composer/index.html' );
       }
        $result = $this->_composer->composerDelete($params['id']);
        if (false !== $result)
        {
            $this->redirect('/manager/composer/index.html');
        }
        else
        {
            $this->response(Public_Error::FAIL, $result,$params,'/manager/composer/index.html' );
        }


    }
}