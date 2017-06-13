<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * Lists.php
 * 
 * @author     yulong8@leju.com
 * @version    $Id$
 */

class ListsAction extends Base_Action
{
    protected $_rules = [
        'cid' => ['required' => false, 'type' => 'string'],
        'ctrid' => ['required' => false, 'type' => 'string'],
        'type' => ['required' => false, 'type' => 'string'],
    ];
    
    protected $_parameters = [
        'cid', 'ctrid', 'type'
    ];
    
    public function process()
    {
        $params = (object) $this->filterParams();
        
        
        switch ($params->type)
        {
            case 'phpinfo':
                echo phpinfo();
                exit;
                
            case 'db':
                $test = new Service_TestModel();
                $result = $test->getTestList($params->cid, $params->ctrid);
                var_dump($result);exit;
                $result = [];
                if (false !== $result)
                {
                    $this->response(Public_Error::SUCCESS, $result);
                }
                else
                {
                    $this->response(Public_Error::FAIL);
                }
            default:
                
        }
        
        if (APP_ENVRION == 'develop')
        {
            $ip = '127_0_0_1';
        }
        else 
        {
            $ip = '58_83_214_106';
        }
        
        $date = date('Ymd');
        //var_dump(PATH_APP_LOG . "/{$date}/ERROR/taskcenter/framework_library_error_{$ip}_20160927_log.txt");exit;
        //echo "/{$date}/ERROR/taskcenter/framework_library_error_{$ip}_{$date}_log.txt<br/>";
        if ($dirhandle = opendir(PATH_APP_LOG . "/{$date}/ERROR/taskcenter"))
        {
            while (false !== ($file = readdir($dirhandle)))
            {
                if ($file != "." && $file != "..")
                {
                    echo "{$file}<br/><br/><br/>";
                    
                    $handle = @fopen(PATH_APP_LOG . "/{$date}/ERROR/taskcenter/$file", "r");
                    if ($handle) {
                        while (!feof($handle)) {
                            $buffer = fgets($handle, 4096);
                            echo $buffer . '<br/>';
                        }
                        fclose($handle);
                    }
                    else
                    {
                        echo "$file没有日志.<br/>";
                    }
                    echo "<br/>";
                }
            }
            closedir($dirhandle);
        }
        
        
        
        exit;
        
        
    }
    
}