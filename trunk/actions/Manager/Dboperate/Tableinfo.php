<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2016/8/12
 * Time: 17:16
 */

class TableinfoAction extends Base_Action
{
    protected $_parameters = [
        'db_name', 'table_name'
    ];

    protected $_rules = [
        'db_name' => ['required' => true, 'type' => 'string'],
        'table_name' => ['required' => true, 'type' => 'string'],
    ];

    protected $_dboperate;

    public function process()
    {
        $params =  $this-> filterParams();
        $this->_dboperate = new Service_Manager_DboperateModel();
        $db_names = $this->_dboperate->getDbName();
        if (!empty($db_names) && in_array($params['db_name'], $db_names))
        {
            $tables = $this->_dboperate->getTables($params['db_name']);
            if (!empty($tables) && in_array($params['table_name'], $tables))
            {
                $table_info = $this->_dboperate->getTableInfo($params['db_name'], $params['table_name']);
                $this->assign('dbname',$params['db_name']);
                $this->assign('tableinfo', $table_info['table_info']);
                $this->assign('tablecolumn', $table_info['table_column']);

            }else
            {
                $this->response(Public_Error::ERR_SQL_NOT_EXISTS, '',$params,'index.html' );
            }
        }
       else
       {
           $this->response(Public_Error::ERR_SQL_NOT_EXISTS, '',$params,'index.html' );
       }



    }
}