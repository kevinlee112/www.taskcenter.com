<?php

/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2016/8/12
 * Time: 17:16
 */

class Service_Manager_ComposerModel
{
    protected $_daoCompose;

    /**
     * 构造方法
     */
    public function __construct()
    {
        $this->_daoCompose = new Dao_Manager_ComposerModel();
    }


    /**
     *获取组件数量
     * @return integer
     */
    public function getComposerTotal()
    {
        $result = $this->_daoCompose->getCount();
        return $result;
    }
    /**
     *获取组件列表
     *  @param int $page
     *  @param int $limit
     * @param string $order
     * @param array $is_show
     * @return array
     */
    public function getComposerLists($page =DEFAULT_PAGE, $limit = 10, $order = 'id', $is_show = null )
    {
        $result = $this->_daoCompose->getComposerList($page, $limit, $is_show, $order);

        return $result;

    }

    /**
     *根据id获取组件信息
     * @param int $id
     * @return array
     */
    public function getComposerById($id)
    {
        if(empty($id))
        {
            return false;
        }
        $result = $this->_daoCompose->getComposerById($id);
        if(empty($result))
        {
            return false;
        }

        return  $result[0];
    }
    /**
     *判断组件名是否存在
     * @param int $id
     * @param int $en_name
     * @param int $cn_name
     * @param string $logic
     * @return array
     */
    public function checkExist($id = null, $en_name = null, $cn_name = null, $logic = 'and')
    {
        if(empty($en_name) && empty($cn_name) )
        {
            return false;
        }
        $result = $this->_daoCompose->getComposerByName($en_name, $cn_name, $logic);
        foreach ($result as $key => $val)
        {
            if ($val['id'] == $id)
            {
                unset($result[$key]);
            }
        }
        return  $result;
    }

    /**
     *组件添加
     *  @param string $is_show
     *  @param string $en_name
     *  @param string  $cn_name
     *  @param integer  $orderid
     * @return array
     */
    public function composerAdd($en_name, $cn_name, $orderid, $is_show)
    {
       if (empty($en_name) || empty($cn_name) || !(is_numeric($orderid)) || empty($is_show))
       {
           return false;
       }
        $result = $this->_daoCompose->composerAdd($en_name, $cn_name, $orderid, $is_show);

        return  $result;
    }

    /**
     *组件删除
     * @param int $id
     * @return array
     */
    public function composerDelete($id)
    {
        if(empty($id))
        {
            return false;
        }
        $result = $this->_daoCompose->composerDelete($id);

        return $result;
    }
    /**
     *组件显示隐藏
     * @param int $id
     ** @param string $is_show
     * @return array
     */
    public function composerHidden($id, $is_show)
    {
        if(empty($id) || empty($is_show))
        {
            return false;
        }
        $result = $this->_daoCompose->composerUpdate($id, $is_show);

        return $result;
    }
    /**
     *组件修改
     * @param integer $id
     *  @param string $is_show
     *  @param string $en_name
     *  @param string  $cn_name
     *  @param integer  $orderid
     * @return array
     */
    public function composerUpdate($id, $is_show, $en_name, $cn_name, $orderid)
    {
        if(empty($id) || empty($is_show) || empty($en_name) || empty($cn_name) || !(is_numeric($orderid)))
        {
            return false;
        }
        $result = $this->_daoCompose->composerUpdate($id, $is_show, $en_name, $cn_name, $orderid);

        return $result;
    }

}
