<?php

class Dao_Content_AdModel extends Base_Dao
{

    protected $_db = 'nansha';

    protected $_pk = 'id';

    protected $_table = 'mf_ad';

    protected $limit = DEFAULT_PAGE_LIMIT;


    public function getAd($city_code, $page, $area = '', $pos = [])

    {
        $params = [];
        $condition=[];

        (!empty($city_code) && $condition['city_code'] = '?') && $params['city_code'] = $city_code;
        (!empty($page) && $condition['page'] = '?') && $params['page'] = $page;
        (!empty($area) && $condition['area'] = '?') && $params['area'] = $area;
        $condition['is_del'] = '0';

        $condition['start_time'] = array('lt', time(), '_multi');
        $condition['end_time'] = array('gt', time(), '_multi');
        if(count($pos)>0)$condition['pos'] = array('in', $pos);

        $condition['type'] = '0';
        $where = $condition ? $this->where($condition) : '';

        $opts = [
            'where' => $where,
            'order' => 'level desc,id asc',
        ];


        $result = $this->find($opts, $params);
        return $result;
    }

    /**
     *获取广告个数
     * @param string $city
     * @param string $page
     * @param string $area
     * @param string $pos
     * @param string $status
     * @return array
     */
    public function total($city, $page, $area, $pos, $status)
    {
        $params = [];
        (!empty( $city) && $condition['city_code'] = '?') && $params['city'] = $city;
        (!empty( $page) && $condition['page'] = '?') && $params['page'] = $page;
        (!empty( $area) && $condition['area'] = '?') && $params['area'] = $area;
        (!empty( $pos) && $condition['pos'] = '?') && $params['pos'] = $pos;

        if ($status == 'expired')
        {
            $condition['end_time'] = array('lt', time());
        }
        else
        {
            $condition['push_time'] = array('gt', time());
        }

        $condition['is_del'] = '0';

        $where = !empty($condition) ? $this->where($condition) : '';

        $result = $this->count($where, $params);

        return $result;
    }
    /**
     *获取过期广告列表
     * @param string $city
     * @param string $page
     * @param string $area
     * @param string $pos
     * @param string $pages
     * @return array
     */
    public function getExpAd($city, $page, $area, $pos, $pages)
    {
        $params = [];
        $this->_pk = 'end_time';
        (!empty( $city) && $condition['city_code'] = '?') && $params['city'] = $city;
        (!empty( $page) && $condition['page'] = '?') && $params['page'] = $page;
        (!empty( $area) && $condition['area'] = '?') && $params['area'] = $area;
        (!empty( $pos) && $condition['pos'] = '?') && $params['pos'] = $pos;

        $condition['end_time'] = array('lt', time());
        $condition['is_del'] = '0';

        $where = !empty($condition) ? $this->where($condition) : '';
        $opt = array(
            'where' => $where,
            'order' => $this->_pk . " desc",
            'start' => ($pages - 1) * $this->limit,
            'limit' => $this->limit,
        );
        $result = $this->find($opt, $params);
        return $result;
    }

    /**
     *获取将要展示广告
     * @param string $city
     * @param string $page
     * @param string $area
     * @param string $pos
     * @param string $pages
     * @return array
     */
    public function getUseAd($city, $page, $area, $pos, $pages)
    {
        $params = [];
        $this->_pk = 'push_time';
        (!empty( $city) && $condition['city_code'] = '?') && $params['city'] = $city;
        (!empty( $page) && $condition['page'] = '?') && $params['page'] = $page;
        (!empty( $area) && $condition['area'] = '?') && $params['area'] = $area;
        (!empty( $pos) && $condition['pos'] = '?') && $params['pos'] = $pos;

        $condition['end_time'] = array('gt', time());
        $condition['is_del'] = '0';

        $where = !empty($condition) ? $this->where($condition) : '';
        $opt = array(
            'where' => $where,
            'order' => $this->_pk . " desc",
            'start' => ($pages - 1) * $this->limit,
            'limit' => $this->limit,
        );
        $result = $this->find($opt, $params);
        return $result;
    }

    /**
     *获取已推送广告
     * @param string $city
     * @param string $page
     * @param string $area
     * @param string $pos
     * @param string $pages
     * @return array
     */
    public function getDisplayAd($city, $page, $area, $pos, $pages)
    {
        $params = [];
        (!empty( $city) && $condition['city_code'] = '?') && $params['city'] = $city;
        (!empty( $page) && $condition['page'] = '?') && $params['page'] = $page;
        (!empty( $area) && $condition['area'] = '?') && $params['area'] = $area;
        (!empty( $pos) && $condition['pos'] = '?') && $params['pos'] = $pos;

        $condition['push_time'] = array('lt', time(), '_multi');
        $condition['end_time'] = array('gt', time(), '_multi');
        $condition['is_del'] = '0';

        $where = !empty($condition) ? $this->where($condition) : '';
        $opt = array(
            'where' => $where,
            'order' =>'level desc,id desc',
            'start' => ($pages - 1) * $this->limit,
            'limit' => $this->limit,
        );
        $result = $this->find($opt, $params);
        return $result;
    }

    /**
     *获取广告城市
     * @return array
     */
    public function getCityList()
    {
        $opt = array(
            'where' => '',
            'fields' => 'city_code,city_name',
            'order' => 'city_code asc',
            'group' => 'city_code',
        );
        $result = $this->find($opt);
        return $result;
    }


    /**
     *删除广告
     * @return array
     */
    public function deleteAd($ad_id)
    {
        $data['is_del'] = '1';
        $result = $this->update($ad_id, $data);
        return $result;
    }

}
