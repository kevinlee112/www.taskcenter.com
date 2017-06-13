<?php
/**
 * 定时任务
 * @author qingyuan21@leju.com
 *
 */

class Service_Manager_CronModel
{
    protected $_daoCron;
    protected $_period_type = array(
        6 => '年',
        5 => '周',
        4 => '日',
        3 => '天',
        2 => '时',
        1 => '分'
    );

    /**
     * 构造方法
     */
    public function __construct()
    {
        $this->_daoCron = new Dao_Manager_CronModel();
    }


    /**
     *获取任务数量
     * @return integer
     */
    public function getTotal($condition = array())
    {
        $result = $this->_daoCron->getCount($condition);
        return $result;
    }


    /**
     * 获取任务列表
     */

    public function getList($condition = array(), $page = DEFAULT_PAGE, $limit = DEFAULT_PAGE_LIMIT, $order = 'id')
    {
        $cronList = $this->_daoCron->getList($condition, $page, $limit,$order);
        $result = array();
        foreach ($cronList as $cron)
        {
            $cron['pre_time'] = empty($cron['pre_time']) ? "--------" : date("Y-m-d H:i:s", $cron['pre_time']);
            $cron['nxt_time'] = date("Y-m-d H:i:s", $cron['nxt_time']);
            $cron['period_interval'] = empty($cron['period_interval']) ? "---" : $cron['period_interval'];
            $cron['period_type'] = empty($this->_period_type[$cron['period_type']]) ? "---" : $this->_period_type[$cron['period_type']];
            $cron['last_modify_time'] = date("Y-m-d H:i:s", $cron['last_modify_time']);
            $result[] = $cron;
        }
        return $result;
    }

    /**
     * 根据id获取任务
     */

    public function getCronById($id)
    {
        if(empty($id))
        {
            return false;
        }
        $cron = $this->_daoCron->getCronById($id);

        if(empty($cron))
        {
            return false;
        }
        $cron[0]['nxt_time'] = date('Y-m-d H:m:s', $cron[0]['nxt_time']);
        $cron[0]['period_type'] = empty($this->_period_type[$cron[0]['period_type']]) ? "---" : $this->_period_type[$cron[0]['period_type']];

        return  $cron[0];
    }


    /**
     * 获取任务添加
     */

    public function cronAdd($param)
    {
        $data = [];
        !empty($param['exec_mod']) && $data['exec_mod'] = $param['exec_mod'];
        !empty($param['exec_act']) && $data['exec_act'] = $param['exec_act'];
        !empty($param['is_valid']) && $data['is_valid'] = $param['is_valid'];
        !empty($param['name']) && $data['name'] = $param['name'];
        !empty($param['type']) && $data['type'] = $param['type'];
        !empty($param['description']) && $data['description'] = $param['description'];
        $data['last_modify_time'] = time();
        $data['last_mender'] = $_COOKIE['user_name'];

        if ($data['type'] == 1)
        {
            $data['period_type'] = '';
            $data['period_interval'] = '';
        }
        else
        {
            if(empty( $param['period_type']) || empty($param['period_interval']))
            {
                return false;
            }
            $data['period_interval'] = $param['period_interval'];
            $data['period_type'] = $param['period_type'];
        }
        $data['nxt_time'] = $this->nxtTimeHandler(strtotime($param['nxt_time']), $param['period_type'] , $param['period_interval']);
        $res = $this->_daoCron->cronInsert($data);

        return $res;
    }

    /**
     *任务修改配置
     */
    public function cronUpdate($id, $param)
    {
        !empty($param['exec_mod']) && $data['exec_mod'] = $param['exec_mod'];
        !empty($param['exec_act']) && $data['exec_act'] = $param['exec_act'];
        !empty($param['is_valid']) && $data['is_valid'] = $param['is_valid'];
        !empty($param['name']) && $data['name'] = $param['name'];
        !empty($param['type']) && $data['type'] = $param['type'];
        !empty($param['description']) && $data['description'] = $param['description'];
        $data['last_modify_time'] = time();
        $data['last_mender'] = $_COOKIE['user_name'];
        if ($data['type'] == 1)
        {
            $data['period_type'] = '';
            $data['period_interval'] = '';
        }
        else
        {
            if(empty( $param['period_type']) || empty($param['period_interval']))
            {
                return false;
            }
            $data['period_interval'] = $param['period_interval'];
            $data['period_type'] = $param['period_type'];
        }
        $data['nxt_time'] = $this->nxtTimeHandler(strtotime($param['nxt_time']), $param['period_type'] , $param['period_interval']);
        $result = $this->_daoCron->cronUpdate($id, $data);

        return $result;
    }

    /**
     *任务删除
     * @param int $id
     * @return array
     */
    public function cronDelete($id)
    {
        if(empty($id))
        {
            return false;
        }
        $result = $this->_daoCron->cronDelete($id);

        return $result;
    }

    /**
     *任务启用禁用
     * @param int $id
     ** @param string $is_valid
     * @return array
     */
    public function cronDisable($id, $is_valid)
    {
        if(empty($id) || !is_numeric($is_valid))
        {
            return false;
        }
        $result = $this->_daoCron->cronUpdate($id, array('is_valid' => $is_valid));

        return $result;
    }

    /**
     *任务控制
     * @param int $id
     ** @param string $is_valid
     * @return array
     */
    public function cronCtrl($act, $id)
    {
        if(empty($act) || empty($id))
        {
            return false;
        }

        $param = $this->getCronById($id);
        if ($param['is_valid'] !== '1')
        {
            return false;
        }
        !empty($param['id']) && $data['id'] = $param['id'];
        !empty($param['exec_mod']) && $data['exec_mod'] = $param['exec_mod'];
        !empty($param['exec_act']) && $data['exec_act'] = $param['exec_act'];
        !empty($param['name']) && $data['name'] = $param['name'];
        !empty($param['description']) && $data['description'] = $param['description'];
        $data['type'] = '2';
        !empty($param['pre_time']) && $data['pre_time'] = $param['pre_time'];
        $redis = new Base_Redis('redis');
        return $redis->lpush('mf_cron_execute_queue', serialize($data));
    }


    /**
     *更新任务执行信息
     * @param int $id
     ** @param int $id
     * @return boolean
     */
    public function updateCronExecInfo($id)
    {
        if(empty($id))
        {
            return false;
        }
        $data['pre_time'] = time();
        $data['nxt_time'] = time();
        $data['pid'] = getmypid();
        $data['status'] = time();

        $result = $this->_daoCron->cronUpdate($id, $data);
        return $result;
    }


    /**
     * 计算下次执行任务时间
     */
    public function nxtTimeHandler($nxt_time, $period_type, $period_interval)
    {
        switch ($period_type)
        {
            case 1:
                $nxt_time += $period_interval*60;
                break;
            case 2:
                $nxt_time += $period_interval*3600;
                break;
            case 3:
                $nxt_time += $period_interval*86400;
                break;
            case 4:
                $nxt_time += $period_interval*604800;
                break;
            case 5:
                $date=getdate($nxt_time);
                $nxt_time = mktime($date['hours'], $date['minutes'], $date['seconds'], $date['mon'] + $period_interval, $date['mday'], $date['year']);
                break;
            case 6:
                $date=getdate($nxt_time);
                $nxt_time = mktime($date['hours'], $date['minutes'], $date['seconds'], $date['mon'], $date['mday'], $date['year'] + $period_interval);
                break;
        }
        return $nxt_time;
    }
    
    /**
     * 根据任务脚本名称更改状态 
     * @param unknown $taskName
     * @param number $status
     * @param string $time
     * @return Ambigous <multitype:, boolean, unknown>
     */
    public function updateStatusByTaskName($taskName, $status = 3, $time = '')
    {
        $slice = explode('_', $taskName);
        $mod = array_shift($slice);
        $act = implode('_', $slice);
        $time = empty($time) ? time() : $time;
        return $this->_daoCron->updateStatusByTaskName($mod, $act, $status, $time);
    }
}