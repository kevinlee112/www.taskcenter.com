<?php

/**
 * db sql语句权限分配展示
 * 针对超管和数据库管理员角色的人员
 * 给予（取消）数据库执行权限
 */
class PermissionAction extends Base_Action
{
    protected $_parameters = [
        'compose_id', 'page'
    ];
    private $_user_model;//用户表
    private $_role_model;//角色表
    private $_exec_sqlModel;//执行权限对应用户表

    public function process()
    {
        $this->_user_model = new Service_Manager_UserModel();
        $this->_role_model = new Service_Manager_RoleModel();
        $this->_exec_sqlModel = new Service_Manager_ExecsqlpermissModel();

        $params = (object)$this->filterParams();

        // 获取所有角色,以对应列表角色名称
        $role_list = $this->_role_model->getRoleList('');

        if (!empty($role_list))
        {
            foreach ($role_list as $key => $value)
            {
                $role_list_new[$value['id']] = $value;
            }
        } else
        {
            $role_list_new = array();
        }


        Yaf_Loader::import(PATH_FW_TOOLS . 'Page.php');
        $page = isset($params->page) ? (int)$params->page : 1;

        // 获取数据库管理员[开发]角色列表 人数总数 role_id =15
        $total_develop = $this->_user_model->getUserTotal('', '', '15');

        $total_super_admin = $this->_user_model->getUserTotal('', '', '8');

        $total = $total_develop + $total_super_admin;

        $pager = new Tools_page($total, $page);

        //获取用户表中role为数据库管理员角色的用户 15为开发权限，8为超管
        $role = [15, 8];

        $db_manager_user = $this->_user_model->getUserListByRoleId($role, $pager->get_current_page());

        // 获取权限表中所有用户
        $permission_list = $this->_exec_sqlModel->getUserList();

        if (!empty($permission_list))
        {
            foreach ($permission_list as $key => $value)
            {
                $permission_list_new[$value['uid']] = $value;
            }
        } else
        {
            $permission_list_new = array();
        }

        $this->assign('pager_html', $pager->get_html());
        $this->assign('db_user_list', $db_manager_user);
        $this->assign('permission_list', $permission_list_new);
        $this->assign('role_list', $role_list_new);
        $this->assign('total', $total);

    }
}