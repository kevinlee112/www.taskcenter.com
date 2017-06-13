<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * Index.php
 * 
 * @author     yulong8@leju.com
 * @version    $Id$
 */

class IndexAction extends Base_Action
{
    protected $_rules = [
        //'abc' => ['required' => true, 'type' => 'string'],
    ];
    
    protected $_parameters = [
        //'abc'
    ];
    
    public function process()
    {
        $params = (object) $this->filterParams();
        
        //$Redis = new Base_Redis('redis');
        //$Redis->set('abc', '1232');
        //$Redis->get('abc');
        Yaf_Loader::import(PATH_FW_TOOLS . 'Test.php');
        $tools_test = new Tools_test();


        //$config = Config::get('test.abc.ddd');var_dump($config);exit;
        /*$config = Yaf_Registry::get('config')->get('test');
        $local = $config ? array_map('ucfirst', array_filter(explode(',', $config))) : null;
        var_dump($local);exit;*/
        $ctl = 'Manager_User_Index';
        $val = 'List';
        $ctl_tmp = $ctl = "{$ctl}_{$val}";
        //framework_library_error_58_83_214_106_20160927_log.txt
        //framework_library_appresponse_58_83_214_106_20160927_log.txt
        /*if ($handle = opendir(PATH_APP_LOG . '/20160927/ERROR/taskcenter')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    echo "$file<br/>";
                }
            }
            closedir($handle);
        }*/
        
        //$handle = @fopen(PATH_APP_LOG . '/20160927/ERROR/taskcenter/framework_library_error_58_83_214_106_20160927_log.txt', "r");
        
        //var_dump($ctl_tmp, $ctl);
        //$this->response(Public_Error::ERR_PARAM);
        //$this->display('manager/index/index.html');
        //echo '测试 不渲染smarty';exit;
    }

}
