<?php

/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2016/8/12
 * Time: 17:16
 */
class Dao_Manager_DboperateModel extends Base_Dao
{

    /**
     * 获取数据库名称
     * @return array
     */

    public function getDbName()
    {
        $sql = "SHOW DATABASES";
        $result = $this->sql($sql);
        return $result;
    }


    /**
     * 获取数据库表名称
     * @param string $db_name
     * @return boolean array
     */
    public function getTables($db_name)
    {
        $sql = "SHOW TABLES FROM ".$db_name;
        $result = $this->sql($sql);
        return $result;
    }


    /**
     * 获取表信息
     * @param string $db_name
     * @return array
     */
    public function getTableStatus($db_name)
    {
        $condition['TABLE_SCHEMA'] = $db_name;
        $condition = $this->parseWhere($condition);
        $condition = !empty($condition) ? " WHERE {$condition} " : '';
        $sql = "SELECT * FROM `information_schema`.`TABLES` {$condition}";
        $result = $this->sql($sql);

        return $result;
    }


    /**
     * 获取表结构1
     * @param string $db_name
     * @param string $table_name
     * @return array
     */
    public function getTableInfo($db_name, $table_name)
    {
        $sql = "SHOW CREATE TABLE {$db_name}.{$table_name}";
        $result = $this->sql($sql);

        return $result;
    }

    /**
     * 获取表结构2
     * @param string $db_name
     * @param string $table_name
     * @return array
     */
    public function getTableColumn($db_name, $table_name)
    {
        $condition['TABLE_SCHEMA'] = $db_name;
        $condition['TABLE_NAME'] = $table_name;
        $condition = $this->parseWhere($condition);
        $condition = !empty($condition) ? " WHERE {$condition} " : '';
        $sql = "SELECT * FROM `information_schema`.`columns` {$condition}";
        $result = $this->sql($sql);

        return $result;
    }

    /**
     * 获取表内容
     * @param string $db_name
     * @param string $table_name
     * @return array
     */
    public function getTableContent($db_name, $table_name)
    {
        $sql = "SELECT * FROM {$db_name}.{$table_name}";
        $result = $this->sql($sql);
        return $result;
    }

    /**
     * 获取表字段
     * @param $dbname
     * @param $tablename
     *
     */
    public function getTableFields($dbname, $tablename)
    {
        $sql = "SHOW COLUMNS FROM " . $dbname . "." . $tablename;

        $result = $this->sql($sql);

        if (empty($result))
        {
            return array();
        }

        $field_options = array();

        foreach ($result as $k => $v)
        {
            $field_options[] = $v['Field'];
        }

        return $field_options;
    }


    /**
     * 通过sql 获取结果集
     * @param $sql
     * @param $params
     *
     */
    public function getSqlList($sql, $params)
    {
        $result = $this->sql($sql, $params);

        if($result)
        {
            return $result;
        }
        else
        {
            return $this->error;
        }

    }


    public function execute($sql)
    {
        return $this->sql($sql);
    }
}