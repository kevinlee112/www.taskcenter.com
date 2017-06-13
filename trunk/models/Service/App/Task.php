<?php

class Service_App_TaskModel
{
    protected $_daoTask;
    protected $_limit = DEFAULT_PAGE_LIMIT;
    private $_type_list = [
        '1' => '版本升级任务',
        '2' => '广告分享',
        '3' => '时长累计',
        '4' => '楼盘订阅',
        '5' => '发表评论',
        '6' => '专车看房',
        '7' => 'app分享',
    ];
    private $_type_period_list = [
        'once' => '仅一次',
        'day' => '日',
        'week' => '周',
        'month' => '月',

    ];

    /**
     * 构造方法
     */
    public function __construct()
    {
        $this->_daoTask = new Dao_App_TaskModel();
    }

    public function GetTaskType()
    {
        return $this->_type_list;
    }

    public function GetTaskPeriod()
    {
        return $this->_type_period_list;
    }

    public function TaskAdd($param)
    {
        $data = [];
        isset($param['task_name']) && !empty($param['task_name']) && $data['name'] = $param['task_name'];
        isset($param['task_desc']) && !empty($param['task_desc']) && $data['desc'] = $param['task_desc'];
        isset($param['status']) && !empty($param['status']) && $data['status'] = trim($param['status']);
        isset($param['task_type']) && !empty($param['task_type']) && $data['type'] = trim($param['task_type']);
        isset($param['task_period']) && !empty($param['task_period']) && $data['period'] = trim($param['task_period']);
        isset($param['award_time']) && !empty($param['award_time']) && $data['price_times'] = trim($param['award_time']);
        isset($param['task_version']) && !empty($param['task_version']) && $data['version'] = trim($param['task_version']);
        isset($param['task_image']) && !empty($param['task_image']) && $data['image'] = trim($param['task_image']);
        //json 字段
        isset($param['ad_link']) && !empty($param['ad_link']) && $json['ad_link'] = trim($param['ad_link']);
        isset($param['time_line']) && !empty($param['time_line']) && $json['time_line'] = trim($param['time_line']);
        isset($param['share_title']) && !empty($param['share_title']) && $json['share_title'] = trim($param['share_title']);
        isset($param['share_content']) && !empty($param['share_content']) && $json['share_content'] = trim($param['share_content']);
        isset($param['share_link']) && !empty($param['share_link']) && $json['share_link'] = trim($param['share_link']);

        $data['begin_time'] = time();

        if (!empty($json))
        {
            $data['json'] = json_encode($json);
        }
        $res = $this->_daoTask->insert($data);
        return $res;
    }

    /**获取task总数量
     * @param $task_type
     * @return int
     */

    public function getCount($task_type)
    {
        $task_type = isset($task_type) ? $task_type : '0';

        $res = $this->_daoTask->getCount($task_type);

        return $res;
    }

    /**根据type类型获取task列表，type可为空
     * @param $type
     * @param string $order
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getListByTaskType($type, $is_active, $order = 'id', $page = DEFAULT_PAGE, $limit = DEFAULT_PAGE_LIMIT)
    {
        $result = $this->_daoTask->getListByTaskType($type, $is_active, $order, $page, $limit);
        return $result;
    }

    public function getTaskInfoById($id)
    {
        if (!is_numeric($id))
        {
            return false;
        }
        $res = $this->_daoTask->getTaskInfoById($id);
        return $res[0];

    }

    public function taskUpdate($id, $param)
    {

        $id = intval($id);
        if ($id <= 0 || !is_array($param) || count($param) == 0)
        {
            return false;
        }
        isset($param['task_name']) && !empty($param['task_name']) && $data['name'] = $param['task_name'];
        isset($param['task_desc']) && !empty($param['task_desc']) && $data['desc'] = $param['task_desc'];
        isset($param['status']) && !empty($param['status']) && $data['status'] = trim($param['status']);
        isset($param['task_type']) && !empty($param['task_type']) && $data['type'] = trim($param['task_type']);
        isset($param['task_period']) && !empty($param['task_period']) && $data['period'] = trim($param['task_period']);
        isset($param['award_time']) && !empty($param['award_time']) && $data['price_times'] = trim($param['award_time']);
        isset($param['task_version']) && !empty($param['task_version']) && $data['version'] = trim($param['task_version']);
        isset($param['task_image']) && !empty($param['task_image']) && $data['image'] = trim($param['task_image']);
        //json 字段
        isset($param['ad_link']) && !empty($param['ad_link']) && $json['ad_link'] = trim($param['ad_link']);
        isset($param['time_line']) && !empty($param['time_line']) && $json['time_line'] = trim($param['time_line']);
        isset($param['share_title']) && !empty($param['share_title']) && $json['share_title'] = trim($param['share_title']);
        isset($param['share_content']) && !empty($param['share_content']) && $json['share_content'] = trim($param['share_content']);
        isset($param['share_link']) && !empty($param['share_link']) && $json['share_link'] = trim($param['share_link']);

        if (!empty($json))
        {
            $data['json'] = json_encode($json);
        }

        $res = $this->_daoTask->update($id, $data);

        return $res;
    }

    public function taskUpdateStatus($task_id, $is_show)
    {
        $id = intval($task_id);
        if ($id <= 0 || !isset($is_show))
        {
            return false;
        }

        $data['status'] = trim($is_show);
        $res = $this->_daoTask->update($id, $data);

        return $res;
    }

    public function taskFieldValidate($params)
    {
        if (($params['task_type'] == '2') && empty($params['ad_link']))
        {
            return array('错误', '广告链接不能为空');

        } elseif ($params['task_type'] == '3' && empty($params['time_line']))
        {
            return array('错误', '时长不能为空');
        } elseif ($params['task_type'] == '7' && (empty($params['share_title']) || empty($params['share_content']) || empty($params['share_link'])))
        {
            return array('错误', 'app分享字段填写不完整');
        } else
        {
            return true;
        }
    }


}