<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2016/8/16
 * Time: 9:19
 */

class AddAction extends Base_Action
{
    protected $_rule = [
        'en_name' => ['required' => true,'type' => 'string'],
        'cn_name' => ['required' => true,'type' => 'string'],
        'orderid' => ['required' => true,'type' => 'number'],
        'is_show' => ['required' => true,'type' => 'string', 'in' => array('Y', 'N')],
    ];

    protected $_parameters = [
       'en_name', 'cn_name','orderid', 'is_show'
    ];

    protected $_composer;

    public function process()
    {
        $params = $this->filterParams();
        $this->_composer = new Service_Manager_ComposerModel();

        if ($this->getRequest()->isPost())
        {
            if (array() !== ($info = Validate::check($params, $this->_rule)))
            {
                $this->response(Public_Error::ERR_PARAM, $info, $params, 'add.html' );
            }
            if ($checkExist = $this->_composer->checkExist(null, $params['en_name'], $params['cn_name'], 'or'))
            {
                $this->response(Public_Error::ERR_COMPOSER_HAS_EXISTED, $checkExist, $params, 'add.html' );
            }
            $result = $this->_composer->composerAdd($params['en_name'], $params['cn_name'], $params['orderid'], $params['is_show']);
            if (false !== $result)
            {
                AppResponse::redirect('/manager/composer/index.html');
            }
            else
            {
                $this->response(Public_Error::FAIL, $result,$params,'/manager/composer/add.html' );
            }
        }
    }
}