<?php

/**
 * 所有控制器列表
 * Class IndexAction
 */
class IndexAction extends Base_Action
{
    protected $_rules = [
        'compose_id' => ['required' => false, 'type' => 'string'],
        'page' => ['required' => false, 'type' => 'string'],
    ];

    protected $_parameters = [
        'compose_id', 'page'
    ];

    protected $_compose_model;
    protected $_controller_model;

    public function process()
    {

        $this->_compose_model = new Service_Manager_ComposerModel();
        $this->_controller_model = new Service_Manager_ControllerModel();
        $params = (object)$this->filterParams();


        //  组件列表
        $compose_list = $this->_compose_model->getComposerLists();


        $compose_list_arr = array();

        if (count($compose_list) > 0)
        {
            foreach ($compose_list as $value)
            {
                $compose_list_arr[$value['id']] = $value['cn_name'];

            }
        }


        $this->assign('compose_list', $compose_list_arr);


        //获取controller 总数
        $controller_count_res = $this->_controller_model->getCount($params->compose_id);

        if ($controller_count_res === FALSE)
        {
            // 数据库取数失败
            $this->response(Public_Error::FAIL, null, ['info' => 'database false']);
        } else
        {
            $controller_count = $controller_count_res;
        }


        Yaf_Loader::import(PATH_FW_TOOLS . 'Page.php');
        $page = isset($params->page) ? (int)$params->page : 1;

        $pager = new Tools_page($controller_count, $page);
        $controller_list_res = $this->_controller_model->getListByComposeId($params->compose_id, '', 'id DESC', $pager->get_current_page());

        $this->assign('controller_list', $controller_list_res);

        $this->assign('total', $controller_count);

        $this->assign('pager_html', $pager->get_html());

    }
}