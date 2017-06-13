<?php

/**
 *sql 语句执行 log展示页面
 * Class ExecLogAction
 */
class ExecLogListAction extends Base_Action
{
    protected $_rules = [
        'page' => ['required' => false, 'type' => 'string'],
        'uid' => ['required' => false, 'type' => 'string'],
        'op' => ['required' => false, 'type' => 'string'],
    ];

    protected $_parameters = [
        'page', 'uid', 'op'
    ];

    private $_exec_log_model;
    private $_exec_user_model;
    private $_user_model;


    public function process()
    {
        $params = $this->filterParams();

        $this->_exec_log_model = new Service_Manager_ExeclogModel();

        $this->_exec_user_model = new Service_Manager_ExecsqlpermissModel();
        $this->_user_model = new Service_Manager_UserModel();


        $page = isset($params['page']) ? $params['page'] : 1;

        $op_list = ['INSERT', 'UPDATE', 'DELETE', 'EXPLAIN'];

        if (isset($params['op']))
        {

            $params['op'] = $params['op'] == 'all' ? 'all' : $params['op'];
        } else
        {

            $params['op'] = 'all';
        }
        if (!isset($params['uid']))
        {
            $params['uid'] = 'all';
        }
       
        $total = $this->_exec_log_model->getLogTotal($params['uid'], $params['op']);

        Yaf_Loader::import(PATH_FW_TOOLS . 'Page.php');

        $pager = new Tools_page($total, $page);

        $log_list = $this->_exec_log_model->getLoglist($params['uid'], $params['op'], $pager->get_current_page());


        $permission_user_list = $this->_exec_user_model->getUserList();
        $user_list = $this->_user_model->getUserList('', '', '');

        if (is_array($user_list) && count($user_list) > 0)
            foreach ($user_list as $key => $value)
            {
                $new_user_list[$value['id']] = $value;
            }
        if (is_array($permission_user_list) && count($permission_user_list) > 0)
            foreach ($permission_user_list as $key => $value)
            {
                $new_permission_user_list[$value['uid']] = $value;
            }

        foreach ($new_user_list as $key => $value)
        {
            if (!isset($new_permission_user_list[$key]))
            {
                unset($new_user_list[$key]);
            }
        }


        $this->assign('op_list', $op_list);
        $this->assign('user_list', $new_user_list);
        $this->assign('log_list', $log_list);
        $this->assign('page_html', $pager->get_html());
        $this->assign('page', $page);
        $this->assign('total', $total);

    }
}
