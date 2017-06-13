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
        'db_name','table_name','page'

    ];
    protected $_rules = [

    ];

    protected $_rule = [
        'db_name' => ['required' => true, 'type' => 'string', 'max' => 20],
        'page' => ['required' => false, 'type' => 'number', 'max' => 20],

    ];

    protected $_ruleSelect = [
        'db_name' => ['required' => true, 'type' => 'string', 'max' => 20],
        'table_name' => ['required' => true, 'type' => 'string', 'max' => 20],
    ];

     protected $_db;
     protected $_table;
     protected $_dboperate;
     protected $_dboperatepermission;

    public function process()
    {
        $params =  $this-> filterParams();

        $this->_dboperate = new Service_Manager_DboperateModel();
        $this->_dboperatepermission = new Service_Manager_ExecsqlpermissModel();
        if($this->_dboperatepermission->checkExecPermission( $_COOKIE['user_id']))
        {
            $this->assign('excuse', '执行');
        }

        if(empty($params['page']))
        {
            $params['page'] = 1;
        }

        $db_names = $this->_dboperate->getDbName();

        if (false !== $db_names)
        {
            $this->assign('db_names', $db_names);
        }
        else
        {
            $this->response(Public_Error::ERR_SQL_NOT_EXISTS, $db_names,$params,'/manager/index/index.html' );
        }

        $result_select = Validate::check($params, $this->_ruleSelect);
        $result_rule = Validate::check($params, $this->_rule);

        if($this->getRequest()->isGet() && empty($result_select) && in_array($params['db_name'], $db_names))
        {
            $this->_db = $params['db_name'];
            $this->_table = $params['table_name'];
            $tables_status = $this->_dboperate->getTableStatusSelect($params['db_name'], $params['table_name'], $params['page'], $limit= 10);
            $this->assign('table', $this->_table);
        }
        elseif ($this->getRequest()->isGet() && empty($result_rule) && in_array($params['db_name'], $db_names))
        {
            $this->_db = $params['db_name'];
            $this->_table = '';
            $tables_status = $this->_dboperate->getTableStatus($params['db_name'], $params['page'], $limit= 10);
        }
        else
        {
            $this->_db = Yaf_Session::getInstance()->get('db');
            $this->_table = Yaf_Session::getInstance()->get('tables');

            if (!empty($this->_table) && !empty($this->_db))
            {
                $tables_status = $this->_dboperate->getTableStatusSelect($this->_db, $this->_table, $params['page'], $limit= 10);
                $this->assign('table', $this->_table);
            }
            else
            {
                if (empty($this->_db))
                {
                    $this->_db = $db_names[1];
                }

                $tables_status = $this->_dboperate->getTableStatus($this->_db, $params['page'], $limit= 10);
            }

        }
        Yaf_Session::getInstance()->set('db', $this->_db);
        Yaf_Session::getInstance()->set('tables', $this->_table);

        Yaf_Loader::import(PATH_FW_TOOLS . 'Page.php');
        $total = $tables_status['count'];
        $page = new Tools_page($total,$params['page']);

        if (false !== $tables_status)
        {
            $this->assign('page_html', $page->get_html());
            $this->assign('page', $params['page']);
            $this->assign('tables', $tables_status['table_status']);
            $this->assign('db', $this->_db);
        }
        else
        {
            Yaf_Session::getInstance()->set('db', '');
            Yaf_Session::getInstance()->set('tables', '');
            $this->response(Public_Error::ERR_SQL_NOT_EXISTS, $tables_status,$params,'index.html');
        }

    }
}