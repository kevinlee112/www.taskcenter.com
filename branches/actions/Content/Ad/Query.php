<?php

/**
 * Desc:Ad筛选查询展示
 * User: tb
 * Date: 2016/9/18
 * Time: 16:52
 */
class QueryAction extends Base_Action
{
    protected $_rules = [
        'city' => ['required' => false, 'type' => 'string'],
        'position' => ['required' => false, 'type' => 'string'],
    ];

    protected $_parameters = [
        'city', 'position'
    ];


    public function process()
    {
        $params = $this->filterParams();

        $city_code = $params['city'];
        $page = $params['position'];//页面
        //$city_model = new Api_CityAdModel();
        $ad_model = new Service_Content_AdModel();
        //$city_list = $city_model->getAllCityForAd();
        $city_list = $ad_model->getCityList();
        $page_config = Config::get('adpage');
        $this->assign('city', $city_code);
        $this->assign('position', $page);

        //if ($this->getRequest()->isPost())
        {
            if ($params['city'] == '' || $params['position'] == '')
            {
                {
                    //$this->response(Public_Error::FAIL);
                }
            }

            if (!empty($params) && isset($page_config[$page]) && $position_arr = $page_config[$page])
            {
                // 页面id eg:PG_53996BF7BB74B8
                $page_id = $position_arr['page'];

                // 如果是首页,包括信息流和轮播图
                if ($page == 'index')
                {
                    //信息流
                    $news_flow_area = $position_arr['news_flow']['area'];
                    $news_flow_pos = explode(',', $position_arr['news_flow']['pos']);

                    $news_flow_ad_info = $ad_model->search_ad($city_code, $page_id, $news_flow_area, $news_flow_pos);
                    //此处信息流目前分【-3 -9】条
                    if (!empty($news_flow_ad_info))
                    {
                        foreach ($news_flow_ad_info as $key => $val)
                        {
                            $ad_info_detail['news_flow']['area'] = $news_flow_area;
                            $ad_info_detail['news_flow']['pos'][$val['pos']] = json_decode($news_flow_ad_info[$key]['json'], true);
                            $ad_info_detail['news_flow']['pos'][$val['pos']]['show_url'] = isset($news_flow_ad_info[$key]['show_url']) ? $news_flow_ad_info[$key]['show_url'] : '';
                        }
                    } else
                    {
                        $ad_info_detail['news_flow'] = [];
                    }

                    //轮播焦点图,目前只有一个区域和一个位置,一条广告,如多条可参考上面循环
                    $focus_map_area = $position_arr['focus_map']['area'];

                    if (isset($position_arr['focus_map']['pos']))
                    {
                        $focus_map_pos = explode(',', $position_arr['focus_map']['pos']);
                    } else
                    {
                        $focus_map_pos = '';
                    }

                    $focus_map_ad_info = $ad_model->search_ad($city_code, $page_id, $focus_map_area, $focus_map_pos);
                    if (isset($focus_map_ad_info[0]['json']))
                    {
                        $ad_info_detail['focus_map_ad_info']['area'] = $focus_map_area;
                        $ad_info_detail['focus_map_ad_info']['pos'][0] = json_decode($focus_map_ad_info[0]['json'], true);
                        $ad_info_detail['focus_map_ad_info']['pos'][0]['show_url'] = isset($focus_map_ad_info[0]['show_url']) ? $focus_map_ad_info[0]['show_url'] : '';
                    } else
                    {
                        $ad_info_detail['focus_map_ad_info'] = [];
                    }

                } else
                {
                    //其他广告页面暂时没有区域和位置，置空
                    $area = '';
                    $pos = [];
                    $ad_info = $ad_model->search_ad($city_code, $page_id, $area, $pos);
                    //其他页面正常只有一条广告
                    if (isset($ad_info[0]['json']))
                    {
                        $ad_info_detail = json_decode($ad_info[0]['json'], true);
                        $ad_info_detail['show_url'] = isset($ad_info[0]['show_url']) ? $ad_info[0]['show_url'] : '';
                        $ad_info_detail['city'] = $city_code;
                    } else
                    {
                        $ad_info_detail = [];
                    }
                }

                //增加首页焦点图和信息流都为空，将整个ad_info_detail置空

                if ((isset($ad_info_detail['focus_map_ad_info']) && $ad_info_detail['focus_map_ad_info'] == []) && (isset($ad_info_detail['news_flow']) && $ad_info_detail['news_flow'] == []))
                {
                    $ad_info_detail = [];
                }
                $tpl = new Smarty_Adapter(null, Yaf_Registry::get("config")->get("smarty"));
                $tpl->assign('ad_info_detail', $ad_info_detail);
                $tpl->assign('city', $params['city']);

                if ($page == 'bootstrap')
                {
                    $tpl_html = $tpl->render("content/ad/tpl/bootstrap.html");
                } elseif ($page == 'index')
                {
                    $tpl_html = $tpl->render("content/ad/tpl/index.html");

                } elseif ($page == 'house_list')
                {
                    $tpl_html = $tpl->render("content/ad/tpl/house_list.html");
                } else
                {
                    $tpl_html = '';
                }
                $this->assign('tpl_html', $tpl_html);

                $this->assign('ad_info_detail', $ad_info_detail);

            } else
            {
                //$this->response(Public_Error::FAIL);
            }
        }


        $this->assign('page_position', $page_config);//页面位置列表
        $this->assign('city_list', $city_list);//城市列表
        //exit;
        //$this->display('content/ad/query.html');
    }

}