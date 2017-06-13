<?php


/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2016/8/12
 * Time: 17:16
 */
class Service_Manager_DboperateModel
{
    protected $_daoDb;

    /**
     * 构造方法
     */
    public function __construct()
    {
        $this->_daoDb = new Dao_Manager_DboperateModel();
    }


    /**
     * 获取数据库名称
     * @return array
     */
    public function getDbName()
    {
        $database = $this->_daoDb->getDbName();
        if (empty($database))
        {
            return false;
        }
        $result = [];
        foreach ($database as $val)
        {
            $result[] = $val['Database'];
        }
        unset($result[0]);
        return $result;
    }

    /**
     * 获取数据库表名
     * @param string $db_name
     * @return array
     */
    public function getTables($db_name)
    {
        if (empty($db_name))
        {
            return false;
        }
        $tables = $this->_daoDb->getTables($db_name);
        if (empty($tables))
        {
            return false;
        }
        $result = [];
        foreach ($tables as $val)
        {
            foreach ($val as $table)
            {
                $result[] = $table;
            }
        }
        return $result;
    }


    /**
     * 获取表信息
     * @param string $db_name
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getTableStatus($db_name, $page = DEFAULT_PAGE, $limit = -1)
    {
        $redis = new Base_Redis('redis');
        $cache_key = md5("data_db_table_list_{$db_name}_v1.0");
        // $cache_data = $redis->get($cache_key);
        if ($cache_data = null)
        {
            $table_status = json_decode($cache_data, true);
        }
        else
        {
            $table_status = $this->_daoDb->getTableStatus($db_name);
            $redis->set($cache_key, json_encode($table_status), 600);
        }
        $count = count($table_status);
        $start = ($page - 1) * $limit;
        $table_status = array_slice($table_status, $start, $limit);
        if (empty($table_status))
        {
            return false;
        }
        return [
            'table_status' => $table_status,
            'count' => $count
        ];
    }

    /**
     * 获取搜索表信息
     * @param string $db_name
     * @param string $table_name
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getTableStatusSelect($db_name, $table_name, $page, $limit = 10)
    {
        if (empty($db_name) || empty($table_name))
        {
            return false;
        }

        $table_status = $this->getTableStatus($db_name);
        foreach ($table_status['table_status'] as $key => $val)
        {
            if (false === strpos($val['TABLE_NAME'], $table_name))
            {
                unset($table_status['table_status'][$key]);
            }
        }
        $count = count($table_status['table_status']);
        $start = ($page - 1) * $limit;
        $table_status = array_slice($table_status['table_status'], $start, $limit);
        if (empty($table_status))
        {
            return false;
        }
        return [
            'table_status' => $table_status,
            'count' => $count
        ];
    }

    /**
     * 获取表结构
     * @param string $db_name
     * @param string $table_name
     * @return array
     */
    public function getTableInfo($db_name, $table_name)
    {
        if (!$this->checkExists($db_name, $table_name))
        {
            return false;
        }
        $tables_info = $this->_daoDb->getTableInfo($db_name, $table_name);
        $table_column = $this->_daoDb->getTableColumn($db_name, $table_name);
        $table_info = [];
        foreach ($tables_info as $val)
        {
            $table_info[$val['Table']] = $val['Create Table'];
        }
        return [
            'table_info' => $table_info,
            'table_column' => $table_column
        ];
    }

    /**
     * 获取表的字段
     * @param $dbname
     * @param $tablename
     * @return bool
     *
     */
    public function getTableFields($dbname, $tablename)
    {
        if (empty($dbname) || empty($tablename))
        {
            return false;
        }

        $fields = $this->_daoDb->getTableFields($dbname, $tablename);

        return $fields;
    }

    /**
     * 获取简单操作列表
     * @return array
     */
    public function getOpereate()
    {
        return array(
            'eq' => '=', 'neq' => '<>', 'gt' => '>', 'egt' => '>=',
            'lt' => '<', 'elt' => '<=', 'notlike' => 'NOT LIKE',
            'like' => 'LIKE', 'in' => 'IN', 'notin' => 'NOT IN',
        );
    }

    /**
     * 获取查询条数
     *
     */
    public function getLimits()
    {
        return array(
            '10', '20', '30', '50', '100', '200', '500'
        );
    }


    /**
     * 拼接sql
     *
     */
    public function getLists($db_name, $table_name, $field, $value, $operate, $limit = 10, $order = 'id desc')
    {
        $condition = array();

        $param = array();

        if ($field && $operate)
        {
            $param[$field] = $value;

            switch ($operate) {
                case "in":
                    $condition[$field] = array(
                        "IN", array_fill(0, count(explode(',', $value)), "?")
                    );
                    $param = explode(',', $value);
                    break;
                case "notin":
                    $condition[$field] = array(
                        "NOT IN", array_fill(0, count(explode(',', $value)), "?")
                    );
                    $param = explode(',', $value);
                    break;
                case "like":
                    $condition[$field] = array(
                        "LIKE", "?"
                    );
                    break;
                case "notlike":
                    $condition[$field] = array(
                        "NOTLIKE", "?"
                    );
                    break;
                default:
                    $condition[$field] = array($operate, "?");
                    break;
            }
        }

        $where = !empty($condition) ? $this->_daoDb->where($condition) : '' ;

        $opts = array(
            'table' => $db_name . "." . $table_name,
            'where' => $where,
            'order' => $order,
            'start' => 0,
            'limit' => $limit
        );

        $result = $this->_daoDb->find($opts, $param);

        return $result;

    }

    /**
     *
     * 通过sql 查询结果
     * @param $sql
     *
     */
    public function getSqlList($sql, $params)
    {
        if (empty($sql) || empty($params))
        {
            return false;
        }

        $result = $this->_daoDb->getSqlList($sql, $params);

        return $result;
    }

    /**
     * 检查数据库，数据表是否存在
     * @param $dbname
     * @param $tablename
     * @return bool
     *
     */
    public function checkExists($dbname, $tablename)
    {
        if (empty($dbname) || empty($tablename))
        {
            return false;
        }

        $dbs = $this->getDbName();

        if (empty($dbs))
        {
            return false;
        }

        if (!in_array($dbname, $dbs))
        {
            return false;
        }

        $tables = $this->getTables($dbname);

        if (empty($tables))
        {
            return false;
        }

        if (!in_array($tablename, $tables))
        {
            return false;
        }

        return true;
    }

    public function makeExecSql($db_name, $table_name, $sql)
    {
        if (empty($db_name) || empty($table_name) || empty($sql))
        {
            return false;
        }

        return trim(str_replace($table_name, $db_name . '.' . $table_name, $sql));
    }

    public function sql($sql)
    {
        return $this->_daoDb->sql($sql);
    }

    public function getError()
    {
        return $this->_daoDb->error;
    }

}