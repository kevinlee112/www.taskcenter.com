<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 *
 * Just Test.php
 *
 */




class Service_TestModel
{
    
    protected $Dao_TestModel;
    
    public function __construct()
    {
        $this->Dao_TestModel = new Dao_TestModel();
    }
    
    
    /**
     * 获取列表 （接口分页）
     * @param unknown $cid
     * @param unknown $ctrid
     * @param string $name
     * @param string $page
     * @return multitype:string unknown Ambigous <multitype:, boolean, unknown> 
     */
    public function getTestLists($cid, $ctrid, $name = null, $page = DEFAULT_PAGE)
    {
        
        $total = $this->Dao_TestModel->total($cid, $ctrid, $name);
        
        if ($total && ((ceil($total / DEFAULT_PAGE_LIMIT) >= $page)))
        {
            
        } else {
            $result = [];
        }
        return [
            'result' => $result,
            'cur_page' => $page,
            'total' => $total,
        ];
    }


    
    public function getTestList($cid, $ctrid, $name = null, $page = DEFAULT_PAGE)
    {
        $result = $this->Dao_TestModel->getTestLists($cid, $ctrid, $name);
        return $result;
    }
    
    
    public function total($cid, $ctrid, $name = null)
    {
        $total = $this->Dao_TestModel->total($cid, $ctrid, $name);
        return $total;
    }


}
