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

class Service_Manager_UserModel extends Base_Dao
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new Dao_Manager_UserModel();
    }

    /**
     * 获取用户总数
     *
     */
    public function getUserTotal($username, $realname, $role)
    {

        $total = $this->userModel->getUserTotal($username, $realname, $role);

        return $total;
    }


    /**
     * 获取用户列表
     *
     */
    public function getUserList($username, $realname, $role, $page = 1)
    {

        $result = $this->userModel->getUserList($username, $realname, $role, $page);

        if(!empty($result))
        {
            $roleModel = new Dao_Manager_RoleModel();
            foreach($result as $k=>$v)
            {
                $roleInfo = $roleModel->getRoleInfoById($v['role']);
                $result[$k]['rolename'] = $roleInfo ? $roleInfo['name'] : '';
            }
        }

        return $result;
    }

    /**
     * 添加用户
     * @return bool
     *
     */
    public function insertUserInfo($param)
    {
        $data = array();

        isset($param['username']) && !empty($param['username']) && $data['user_name'] = trim($param['username']);
        isset($param['password']) && !empty($param['password']) && $data['password'] = md5($param['password']);
        isset($param['realname']) && !empty($param['realname']) && $data['real_name'] = trim($param['realname']);
        isset($param['city']) && !empty($param['city']) && $data['city'] = $param['city'];
        isset($param['role']) && !empty($param['role']) && $data['role'] = intval($param['role']);
        isset($param['status']) && !empty($param['status']) && $data['status'] = intval($param['status']);
        isset($param['gender']) && !empty($param['gender']) && $data['gender'] = $param['gender'];
        isset($param['department']) && !empty($param['department']) && $data['department'] = $param['department'];
        isset($param['position']) && !empty($param['position']) && $data['position'] = $param['position'];

        $data['createtime'] = time();

        $result = $this->userModel->insertUserInfo($data);

        return $result;
    }

    /**
     * 修改用户信息
     *
     */
    public function updateUserInfo($id, $param)
    {
        if(!isset($id) || empty($id))
        {
            return false;
        }

        $data = array();

        isset($param['username']) && !empty($param['username']) && $data['user_name'] = trim($param['username']);
        isset($param['password']) && !empty($param['password']) && $data['password'] = md5($param['password']);
        isset($param['realname']) && !empty($param['realname']) && $data['real_name'] = trim($param['realname']);
        isset($param['city']) && !empty($param['city']) && $data['city'] = $param['city'];
        isset($param['role']) && !empty($param['role']) && $data['role'] = intval($param['role']);
        isset($param['status']) && !empty($param['status']) && $data['status'] = intval($param['status']);
        isset($param['gender']) && !empty($param['gender']) && $data['gender'] = $param['gender'];
        isset($param['department']) && !empty($param['department']) && $data['department'] = $param['department'];
        isset($param['position']) && !empty($param['position']) && $data['position'] = $param['position'];
        isset($param['special_rights']) && $data['special_rights'] = $param['special_rights'];

        $data['updatetime'] = time();

        $result = $this->userModel->updateUserInfo(intval($id), $data);

        return $result;
    }

    /**
     * 删除用户信息
     *
     */
    public function deleteUser($id)
    {
        if(empty($id))
        {
            return false;
        }

        $result = $this->userModel->deleteUser(intval($id));

        return $result;
    }

    /**
     * 根据用户名获取用户信息
     *
     */
    public function getUserInfoById($id)
    {
        if(empty($id))
        {
            return false;
        }

        $result  = $this->userModel->getUserInfoById($id);

        return $result;

    }

    /**根据role_id获取用户信息
     * 用于数据库管理操作
     * @param $role_id
     * @return array|bool
     */
    public function getUserListByRoleId($role=array(),$page=DEFAULT_PAGE)
    {
        $result  = $this->userModel->getUserListByRoleId($role,$page);

        return $result;

    }

    /**
     * 根据用户名获取用户信息
     *
     */
    public function getUserInfoByName($username)
    {
        if(empty($username))
        {
            return false;
        }

        $result  = $this->userModel->getUserInfoByName($username);

        return $result;

    }

    /**
     * 修改用户密码
     *
     */
    public function updateUserPwd($userid, $newpasswd)
    {
        if(empty($userid))
        {
            return false;
        }

        $data = array();
        $data['password'] = md5($newpasswd);

        return $this->userModel->update(intval($userid),$data);
    }

    /**
     * 更新登录时间
     *
     */
    public function updateLoginTime($userid)
    {
        if(empty($userid))
        {
            return false;
        }

        $data = array();
        $data['last_login'] = date('Y-m-d H:i:s',time());

        return $this->userModel->update(intval($userid),$data);
    }

    /**
     * 获取错误次数
     *
     */
    public function getUserErrorTimes( $name )
    {
        $redis = new Base_Redis('redis');

        $cache_key = md5("data_user_login_key_v1.0_{$name}");

        $error_times = $redis->get($cache_key);

        return $error_times;
    }

    /**
     * 获取错误次数
     *
     */
    public function setUserErrorTimes( $name )
    {
        $redis = new Base_Redis('redis');

        $cache_key = md5("data_user_login_key_v1.0_{$name}");

        $error_times = intval($redis->get($cache_key));

        if(empty($error_times))
        {
            $redis->set($cache_key,1,7200);
        }
        else
        {
            $redis->set($cache_key,$error_times++,7200);
        }

        return true;
    }

    /**
     * 验证是否登录
     * @return Ambigous <multitype:, multitype:mixed string >
     */
    public function is_login()
    {
        $user_sign = isset($_COOKIE['user_sign']) && !empty($_COOKIE['user_sign']) ? $_COOKIE['user_sign'] : '';

        $userInfo = array();

        if($user_sign)
        {
            $userInfo['user_id'] = $_COOKIE['user_id'];
            $userInfo['user_name'] = $_COOKIE['user_name'];
            $userInfo['real_name'] = $_COOKIE['real_name'];
            $userInfo['user_sign'] = $user_sign;

            return $userInfo;
        }
        else
        {
            return false;
        }

    }


    /**
     * 获取用户权限
     *
     */
    public function getUserRights($userid)
    {
        if(empty($userid))
        {
            return false;
        }

        $roleModel = new Dao_Manager_RoleModel();

        $userInfo = $this->userModel->getUserInfoById($userid);

        $rights = '';

        if(!empty($userInfo))
        {
            $rights .= $userInfo['special_rights'] ? $userInfo['special_rights'] : '';

            $roleRights = $roleModel->getRoleInfoById($userInfo['role']);

            if(!empty($roleRights))
            {
                if($rights)
                {
                    $rights .= $roleRights['rights'] ? ','.$roleRights['rights'] : '';
                }
                else
                {
                    $rights .= $roleRights['rights'] ? $roleRights['rights'] : '';
                }
            }
        }

        if($rights)
        {
            $rightsArr = explode(',',$rights);

            return $rightsArr;
        }

         return array();
    }

    /**
     * 获取权限树结构
     *
     */
    public function getRightsTree()
    {
        //$redis = new Base_Redis('redis');

        $key = md5("rights_tree_data_v1.0");

        $cache_data = null;//$redis->get($key);

        if(!empty($cache_data))
        {
            return json_decode($cache_data,true);
        }

        $composerModel = new Service_Manager_ComposerModel();

        $controllerModel = new Service_Manager_ControllerModel();

        $composerList = $composerModel->getComposerLists("", 50,'id');  //组件列表

        $rightsTree = array();

        if(!empty($composerList))
        {
            foreach($composerList as $k=>$v)
            {
                $rightsTree[$k]['id'] = $v['id'];
                $rightsTree[$k]['name'] = $v['cn_name'];
            }

            if(!empty($rightsTree))
            {
                foreach($rightsTree as $k=>$v)
                {
                    $ctlTree =  $controllerModel->getListByComposeId($v['id'],'','order_id');//控制器列表

                    if(empty($ctlTree))
                    {
                        continue;
                    }

                    foreach($ctlTree as $key=>$val)
                    {
                        isset($val['id']) && !empty($val['id']) && $rightsTree[$k]['controller'][$key]['id'] = $val['id'] ;
                        isset($val['func_name_cn']) && !empty($val['func_name_cn']) && $rightsTree[$k]['controller'][$key]['name'] = $val['func_name_cn'] ;

                        $actionTree = $controllerModel->getActionList($val['id'],'','','',100); //方法列表

                        if(!empty($actionTree))
                        {
                            foreach($actionTree as $aKey=>$aVal)
                            {
                                isset($aVal['id']) && !empty($aVal['id']) && $rightsTree[$k]['controller'][$key]['action'][$aKey]['id'] = $aVal['id'] ;
                                isset($aVal['func_name_cn']) && !empty($aVal['func_name_cn']) && $rightsTree[$k]['controller'][$key]['action'][$aKey]['name'] = $aVal['func_name_cn'] ;

                            }
                        }
                    }
                }
            }
        }

        //$redis->set($key,json_encode($rightsTree),600);

        return $rightsTree;
    }

    /**
     * 获取用户权限导航
     *
     */
    public function getMenu()
    {
        $userId = $_COOKIE['user_id'];//Yaf_Session::getInstance()->get('user_id');

        if(empty($userId))
        {
            return array();
        }

        $redis = new Base_Redis('redis');

        $cache_key = md5("data_main_menu_list_{$userId}_v1.0");

        $cache_data = $redis->get($cache_key);

//        if($cache_data)
//        {
//            return json_decode($cache_data,true);
//        }

        $ctlModel = new Dao_Manager_ControllerModel();

        $userRights = $this->getUserRights($userId); //用户权限

        $roleInfo = $this->getRoleInfoByUid($userId);

        $ctlList = $ctlModel->getCtlList(); //获得所有controller列表

        $composerModel = new Dao_Manager_ComposerModel();

        if(empty($ctlList))
        {
            return array();
        }

        $menuList = array();

        $ctlListNew = array();

        if (($roleInfo['is_super'] != 1)) //超管不过滤
        {
            if(!empty($roleInfo) && !empty($userRights))
            {
                foreach($ctlList as $key=>$val)
                {
                    if (in_array($val['id'], $userRights))  //去掉没有权限的controller
                    {
                        $ctlListNew[] = $val;
                    }
                }
            }
            else
            {
                return array();
            }
        }
        else
        {
            $ctlListNew  = $ctlList;
        }

        foreach($ctlListNew as $key=>$val)
        {
            //获取controller对应的组件id
            $composerInfo = $composerModel->getComposerById($val['compose_id'], 'Y');

            if($composerInfo)
            {
                isset($composerInfo[0]['orderid']) && !empty($composerInfo[0]['orderid']) && $menuList[$composerInfo[0]['orderid'].$composerInfo[0]['id']]['orderid'] = $composerInfo[0]['orderid']; //orderid
                isset($composerInfo[0]['en_name']) && !empty($composerInfo[0]['en_name']) && $menuList[$composerInfo[0]['orderid'].$composerInfo[0]['id']]['en_name'] = $composerInfo[0]['en_name']; //中文名称
                isset($composerInfo[0]['cn_name']) && !empty($composerInfo[0]['cn_name']) && $menuList[$composerInfo[0]['orderid'].$composerInfo[0]['id']]['cn_name'] = $composerInfo[0]['cn_name']; //英文名称

                $menuList[$composerInfo[0]['orderid'].$composerInfo[0]['id']]['controllers'][$val['order_id'].$val['id']] = $val;
                $actionList = $ctlModel->getActionList($val['id'],'1');
                if($actionList)
                {
                    foreach($actionList as $k=>$v)
                    {
                        if(strpos($v['func_name_cn'],'列表') !== false)
                        {
                            $menuList[$composerInfo[0]['orderid'].$composerInfo[0]['id']]['controllers'][$val['order_id'].$val['id']]['actions'][] = $v;
                        }
                    }
                }
                if (isset($menuList[$composerInfo[0]['orderid'].$composerInfo[0]['id']]['controllers'][$val['order_id'].$val['id']]['actions']))
                {
                    $menuList[$composerInfo[0]['orderid'].$composerInfo[0]['id']]['controllers'][$val['order_id'].$val['id']]['url'] = str_replace('_', '/', $val['func_name']).'/'.$menuList[$composerInfo[0]['orderid'].$composerInfo[0]['id']]['controllers'][$val['order_id'].$val['id']]['actions'][0]['func_name'].'.html';
                }
                elseif(isset($actionList['index'])) {
                    $menuList[$composerInfo[0]['orderid'].$composerInfo[0]['id']]['controllers'][$val['order_id'].$val['id']]['url'] = str_replace('_', '/', $val['func_name']).'/index.html';
                }
                else
                {
                    $action = array_shift($actionList);
                    $menuList[$composerInfo[0]['orderid'].$composerInfo[0]['id']]['controllers'][$val['order_id'].$val['id']]['url'] = str_replace('_', '/', $val['func_name']).'/'.$action['func_name'];
                }
            }
        }

        $redis->set($cache_key,json_encode($menuList),600);

        return $menuList;
    }

    /**
     * 获取用户权限导航
     *
     */
    public function getActionMenu($controller)
    {
        $userId = $_COOKIE['user_id'];//Yaf_Session::getInstance()->get('user_id');

        $redis = new Base_Redis('redis');

        $cache_key = md5("data_action_menu_list_v1.0_{$controller}_{$userId}");

        $cache_data = $redis->get($cache_key);

        if($cache_data)
        {
            return json_decode($cache_data,true);
        }
        $ctlModel = new Dao_Manager_ControllerModel();

        $userRights = $this->getUserRights($userId); //用户权限

        $roleInfo = $this->getRoleInfoByUid($userId);

        $ctlInfo = $ctlModel->fetchOne(array("func_name"=>$controller));

        if(empty($ctlInfo))
        {
            return array();
        }
        //1 代表is_menu
        $actionList = $ctlModel->getActionList($ctlInfo['id'],'1',"order_id desc"); //获得controller下action


        if(empty($actionList))
        {
            return array();
        }

        $menu = array();

        if($roleInfo['is_super'] != 1)
        {
            foreach ($actionList as $key => $val)
            {
                if (!empty($roleInfo))
                {
                    if (in_array($val['id'], $userRights))  //去掉没有权限的controller
                    {
                        $menu[] = $val;
                    }
                }
                else
                {
                    return array();
                }
            }
        }
        else
        {
            $menu = $actionList;
        }

        $redis->set($cache_key,json_encode($menu),600);

        return $menu;
    }


    /**
     * 验证用户权限
     *
     */
    public function checkRights($controllerId, $actionId)
    {
        if(empty($controllerId) || empty($actionId))
        {
            return false;
        }

        $user_id = $_COOKIE['user_id'];//Yaf_Session::getInstance()->get('user_id');

        $userRights = $this->getUserRights($user_id);

        $userInfo = $this->getUserInfoById($user_id);

        if(empty($userInfo))
        {
            return false;
        }

        $roleInfo = $this->getRoleInfoByUid($user_id);

        if(empty($roleInfo))
        {
            return false;
        }

        if($roleInfo['is_super'] == 1) //超管无需验证权限
        {
            return true;
        }

        if(in_array($actionId,$userRights))
        {
            return true;
        }

        return false;
    }

    /**
     * 根据用户id获取角色相关信息
     *
     */
    public function getRoleInfoByUid($userid)
    {
        if(empty($userid))
        {
            return false;
        }

        $userInfo = $this->getUserInfoById($userid);

        if(empty($userid))
        {
            return false;
        }

        $roleModel = new Dao_Manager_RoleModel();

        if(isset($userInfo['role']))
        {
            $roleInfo = $roleModel->getRoleInfoById($userInfo['role']);

            if(empty($roleInfo))
            {
                return false;
            }
            else
            {
                return $roleInfo;
            }
        }

    }


}
