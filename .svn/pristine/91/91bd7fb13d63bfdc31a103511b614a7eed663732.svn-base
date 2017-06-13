<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * Test.php
 * @auther: yulong8@leju.com
 * @date:${date}
 * @create Time: ${time}
 * @version ${Id}
 * @last modify time: ${LastChangedDate}
 */




class Dao_TestModel extends Base_Dao
{

    protected $_db = 'default';
    
    protected $_pk = 'id';
    
    protected $_table = 'mf_manager_controller';
    


    
    public function getTestLists($cid, $ctrid, $name = null)
    {
        $cid = explode(',', $cid);
        $parmas = [];
        $parmas = $cid;
        $parmas[] = $ctrid;
        
        $in_str = implode(',', array_fill(0, count($cid), '?'));
        
        $condition = [
            'compose_id' => ['in', $in_str],
            'controller_id' => '?',
        ];
        
        !empty($name) && $condition['name'] = '?' && $parmas[] = $name;
        
        $where = $condition ? $this->where($condition) : '';
        $opts = [
            'where' => $where,
            'order' => $this->_pk . ' asc',
            'start' => (1 - 1) * 50,
            'limit' => 50,
        ];
        $result = $this->find($opts, $parmas);
        return $result;
    }
    
    
    /**
     * 
     * @param unknown $cid
     * @param unknown $ctrid
     * @param string $name
     * @return Ambigous <number, boolean, unknown>
     */
    public function total($cid, $ctrid, $name = null)
    {
        !empty($cid) && ($parmas['compose_id'] = $cid) && ($where['compose_id'] = "?");
        !empty($ctrid) && ($parmas['controller_id'] = $ctrid) && ($where['controller_id'] = "?");
        !empty($name) && ($parmas['name'] = $name) && ($where['name'] = "?");

        $result = $this->count($where, $parmas);

        return $result;
    }
    
    

}
