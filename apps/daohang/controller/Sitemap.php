<?php
namespace app\daohang\controller;

use app\common\controller\Front;

class Sitemap extends Front
{

    public function _initialize()
    {
        parent::_initialize();
    }
    
    public function index()
    {
        //数据查询参数
        $args = [];
        $args['cache']    = true;
        $args['status']   = 'normal';
        $args['field']    = 'info_id,info_slug,info_name,info_status,info_update_time';
        $args['with']     = 'term';
        $args['limit']    = daohangLimit(config('daohang.limit_sitemap'));
        $args['page']     = $this->site['page'];
        $args['sort']     = 'info_update_time';
        $args['order']    = 'desc';
        //数据查询
        $list = daohangSelect($args);
        //拼装结果
        $result = [];
        foreach($list['data'] as $key=>$value){
            array_push($result,$this->site['domain'].daohangUrlInfo([
                'info_id'       => $value['info_id'],
                'info_slug'     => $value['info_slug'],
                'info_name'     => $value['info_name'],
                'category_id'   => $value['category_id'],
                'category_slug' => $value['category_slug'],
                'category_name' => $value['category_name'],
            ]));
        }
        unset($list);
        return implode("\n",$result);
    }
    
}