<?php

/**
 * Desc:
 * User: tb
 * Date: 2016/8/23
 * Time: 10:06
 */
class Service_Manager_ControllerModel
{
    protected $daoController;

    /**
     * 构造方法
     */
    public function __construct()
    {
        $this->daoController = new Dao_Manager_ControllerModel();
    }

    /**
     * 获取指定条件总数，用于分页，返回二维数组
     * @param array $condition
     * @return array
     */
    public function getCount($compose_id = null, $ctl_id = '0')
    {
        $compose_id = isset($compose_id) ? $compose_id : null;
        $ctl_id = isset($ctl_id) ? $ctl_id : '0';

        $res = $this->daoController->getCount($compose_id, $ctl_id);

        return $res;
    }


    /**
     * 根据controller id 获取controller 信息
     * @param $id
     * @return array
     */
    public function getControllerInfo($id, $name = '', $pid = 0)
    {
        if (!is_numeric($id) && empty($name))
        {
            return false;
        }
        $condition = array();
        isset($id) && !empty($id) && $condition['id'] = $id;
        isset($pid) && !empty($pid) && $condition['controller_id'] = intval($pid);
        isset($name) && !empty($name) && $condition['func_name'] = trim($name);

        $res = $this->daoController->fetchOne($condition);
        return $res;

    }

    public function getControllerInfoById($id)
    {
        if (!is_numeric($id))
        {
            return false;
        }
        $res = $this->daoController->getControllerInfoById($id);
        return $res[0];

    }

    /**依据组件id获取ctl列表
     * @param string $condition
     * @param string $order
     * @param string $limit
     * @return array
     */
    public function getListByComposeId($compose_id, $is_show, $order = 'id', $page = DEFAULT_PAGE, $limit = DEFAULT_PAGE_LIMIT)
    {
        $result = $this->daoController->getListByComposeId($compose_id, $is_show, $order, $page, $limit);
        return $result;
    }

    public function getCtlList($compose_id, $is_show, $order = 'id', $page = DEFAULT_PAGE, $limit = DEFAULT_PAGE_LIMIT)
    {
        $result = $this->daoController->getCtlList($compose_id, $is_show, $order, $page, $limit);
        return $result;
    }

    /**根据ctlid获取action
     * @param $ctl_id
     * @param bool $is_menu
     * @param string $order
     * @param int $page
     * @param int $limit
     * @return array
     */

    public function getActionList($ctl_id, $is_menu = false, $order = 'id', $page = DEFAULT_PAGE, $limit = DEFAULT_PAGE_LIMIT)
    {
        $result = $this->daoController->getActionList($ctl_id, $is_menu, $order, $page, $limit);
        return $result;
    }

    /**
     * 添加controller
     * @param $data
     */
    public function controllerAdd($param)
    {
        $data = [];
        isset($param['compose_id']) && !empty($param['compose_id']) && $data['compose_id'] = $param['compose_id'];
        isset($param['func_name']) && !empty($param['func_name']) && $data['func_name'] = $param['func_name'];
        isset($param['func_name_cn']) && !empty($param['func_name_cn']) && $data['func_name_cn'] = trim($param['func_name_cn']);
        isset($param['is_menu']) && !empty($param['is_menu']) && $data['is_menu'] = trim($param['is_menu']);
        isset($param['is_right']) && !empty($param['is_right']) && $data['is_right'] = trim($param['is_right']);
        isset($param['controller_id']) && !empty($param['controller_id']) && $data['controller_id'] = trim($param['controller_id']);
        $data['order_id'] = isset($param['order_id']) ? (int)$param['order_id'] : 0;
        isset($param['is_show']) && !empty($param['is_show']) && $data['is_show'] = "Y";

        $res = $this->daoController->insert($data);

        return $res;

    }

    /**
     * 更新controller 信息
     * @param $id controlelr  id
     * @param $data
     * @return bool
     */
    public function controllerUpdate($id, $data)
    {

        $id = intval($id);
        if ($id <= 0 || !is_array($data) || count($data) == 0)
        {
            return false;
        }


        $res = $this->daoController->update($id, $data);

        return $res;

    }

    /**
     * 删除和controller 相关的action
     * @param $id
     * @param string $col
     * @return bool
     */

    public function controllerDelete($id)
    {
        if (empty($id) || !is_numeric($id))
        {
            return false;
        }
        $res = $this->daoController->delete($id);

        return $res;

    }

    /**删除ctl前先删除ctl表中该ctl对应的action
     * @param $id
     * @param string $col
     * @return bool
     */
    public function controllerDeleteRelate($id, $col = 'controller_id')
    {
        if (empty($id) || !is_numeric($id))
        {
            return false;
        }
        $res = $this->daoController->delete($id, $col);

        return $res;

    }


}
