<?php
namespace app\daohang\controller;

use app\common\controller\Api;

class Data extends Api
{
    protected $auth = [
         'check'       => true,
         'none_login'  => ['daohang/data/login'],
         'none_right'  => ['daohang/data/category','daohang/data/detail'],
         'error_login' => 'daohang/data/login',
         'error_right' => 'user/center/index',
    ];
    
    public function _initialize()
    {
		parent::_initialize();
    }
    
    //login
    public function login()
    {
        $this->error(lang('empty'));
    }
    
    //分类列表接口
    public function category()
    {
        $item = daohangCategorySelect([
            'cache'    => true,
            'status'   => 'normal',
            'result'   => 'array',
            'limit'    => 0,
            'page'     => 0,
            'sort'     => 'term_id',
            'order'    => 'asc',
            'with'     => '',
            'field'    => 'term_id,term_name,term_slug,term_module,term_controll,term_action',
            'action'   => 'index',
        ]);
        foreach($item as $key=>$value){
            unset($item[$key]['term_status_text']);
        }
        $this->success(lang('success'),$item);
    }
    
    //内容列表接口
    //detail?termId=1&pageNumber=1
    public function detail()
    {
        //初始参数
        $args = [
            'cache'      => true,
            'status'     => 'normal',
            'sort'       => 'info_update_time',
            'order'      => daohangSortOrder(input('request.sortOrder/s','asc')),
            'limit'      => 10,
            'page'       => input('request.pageNumber/d',1),
            'with'       => '',//info_meta,term
            'field'      => 'info_id,info_name,info_slug,info_excerpt,info_order,info_type,info_views,info_hits',
        ];
        //分类限制
        if($this->query['termId']){
            $args['term_id'] = intval($this->query['termId']);
            $args['field']   = 'info.info_id,info_name,info_slug,info_excerpt,info_update_time,info_type,info_views,info_hits';
        }
        //时间限制
        if($this->query['time']){
            $args['where']['info_update_time'] = ['> time',$this->query['time']];
        }
        //数据查询
        if(!$item = daohangSelect($args)){
            $this->error(lang('empty'));
        }
        //重新组合数据
        $json = [];
        $json['total']        = $item['total'];
        $json['per_page']     = $item['per_page'];
        $json['current_page'] = $item['current_page'];
        $json['last_page']    = $item['last_page'];
        $json['list']         = [];
        //拼装数据
        foreach($item['data'] as $key=>$value){
            $json['list'][$key] = $this->detailValue($value);
            $json['list'][$key]['info_unique'] = md5($this->site['domain'].'/daohang/'.$value['info_id']);
        }
        unset($item);
        //返回数据
        $this->success(lang('success'),$json);
    }
    
    //单个内容详情接口
    public function index()
    {
        $id = input('request.id/f',1);
        $info = daohangGet([
            'cache'      => true,
            'status'     => 'normal',
            'id'         => ['eq',$id],
            'sort'       => 'info_id',
            'order'      => 'asc',
            'with'       => 'info_meta,term',
            'field'      => 'info_id,info_name,info_slug,info_module,info_controll,info_action,info_excerpt,info_content,info_create_time,info_update_time,info_order,info_type,info_views,info_hits',
        ]);
        if(!$info){
            $this->error(lang('empty'));
        }
        $this->success(lang('success'),$this->detailValue($info));
    }
    
    //内容详情格式化
    private function detailValue($value=[])
    {
        unset($value['category']);
        unset($value['category_slug']);
        unset($value['tag']);
        unset($value['tag_slug']);
        unset($value['info_keywords']);
        unset($value['info_description']);
        unset($value['info_status_text']);
        //图标
        if(isset($value['image_ico'])){
            $value['image_ico']   = daohangUrlImage($value['image_ico']);
        }
        //封面
        if(isset($value['image_level'])){
            $value['image_level'] = daohangUrlImage($value['image_level']);
        }
        //二维码
        if(isset($value['image_qrcode'])){
            $value['image_qrcode'] = daohangUrlImage($value['image_qrcode']);
        }
        //截图
        if(isset($value['image_screen'])){
            $value['image_screen'] = explode(';',$value['image_screen']);
            foreach($value['image_screen'] as $key2=>$screen ){
                $value['image_screen'][$key2] = daohangUrlImage($screen);
            }
        }
        //来源处理
        $value['info_unique'] = md5($this->site['domain'].'/daohang/'.$value['info_id']);
        //拼装数据
        return $value;
    }
}