<?php

/**
 *
 * 执行数据库操作【更新 删除等】
 */
class ExecuteAction extends Base_Action
{

    protected $_rules = [
        'sql' => ['required' => false, 'msg' => 'err sql'],
        'db_name' => ['required' => true, 'type' => 'string', 'msg' => 'db name is missing.'],
        'table_name' => ['required' => true, 'type' => 'string', 'msg' => 'table name is missing.'],
    ];
    protected $_rule = [
        'sql' => ['required' => true, 'msg' => 'err sql'],
        'db_name' => ['required' => true, 'type' => 'string', 'msg' => 'db name is missing.'],
        'table_name' => ['required' => true, 'type' => 'string', 'msg' => 'table name is missing.'],
    ];


    protected $_parameters = [
        'sql', 'db_name', 'table_name', 'exec'
    ];

    private $dbModel;
    private $_exec_log_model;
    private $_exec_permission_model;


    public function process()
    {

        //先判断一下权限
        $user_id = $_COOKIE['user_id'];//Yaf_Session::getInstance()->get('user_id');
        $this->_exec_permission_model = new Service_Manager_ExecsqlpermissModel();
        if (!$this->_exec_permission_model->checkExecPermission($user_id))
        {
            //没有sql执行权限
            $this->response(Public_Error::ERR_EXEC_SQL_OUT, '', '', '/Manager/Dboperate/index.html');
        }

        $params = $this->filterParams();
        $this->dbModel = new Service_Manager_DboperateModel();
        $this->_exec_log_model = new Service_Manager_ExeclogModel();


        if ($this->getRequest()->ispost() && ($this->getRequest()->getPost("exec") == 'exec'))
        {
            if (array() !== ($info = Validate::check($params, $this->_rule)))
            {
                $this->response(Public_Error::ERR_PARAM, $info);
            }

            if (!preg_match('/(update|delete|explain|insert)/i', strtolower($params['sql']), $match))
            {

                $this->response(Public_Error::ERR_EXEC_SQL_OUT, '', '', '/Manager/Dboperate/index.html');
            }

            if (!strstr($params['sql'], $params['db_name'] . '.' . $params['table_name']))
            {

                $sql = $this->dbModel->makeExecSql($params['db_name'], $params['table_name'], $params['sql']);
                $this->assign('sql', trim(str_replace($params['db_name'] . ".", '', $sql)));
            } else
            {
                $sql = $params['sql'];
                $this->assign('sql', trim(str_replace($params['db_name'] . ".", '', $sql)));
            }

            $result = $this->dbModel->sql($sql);

            $err_info = $this->dbModel->getError();


            // 如果为false说明sql语句不对,给view层增加一个警示
            if ($result === false)
            {
                $sql_err_info = isset($err_info['msg']) ? $err_info['msg'] : '1';
                $this->assign('sql_err', $sql_err_info);
                $this->assign('is_post', 0);
            }

                        // 写入log
            $op = isset($match[0]) ? $match[0] : '非法操作';
            if ($result !== false)
            {
                //代表sql语句执行成功
                $log_result = '1';
            } else
            {
                $log_result = '0';
            }

            $insert_log_res = $this->_exec_log_model->insertLog($op, $sql, $log_result);

            if ($insert_log_res <= 0)
            {
                //写入日志失败
                $this->response(Public_Error::ERR_EXEC_LOG_INSERT);
            }


            $this->assign('is_post', 1);
            if (strpos($sql, 'explain') === (int)0)
            {
                $this->assign('explain_table', '1');
            } else
            {
                //展示insert update delete的view
                $this->assign('explain_table', '0');
            }
            $this->assign('result', $result);
        }
    }
}