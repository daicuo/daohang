<?php
namespace app\daohang\controller;

use app\common\controller\Front;

class Fast extends Front
{
    private $isVip = false;
    
    protected $auth = [
         'check'       => true,
         'none_login'  => ['daohang/fast/index'],
         'none_right'  => '*',
         'error_login' => 'user/center/login',
         'error_right' => '',
    ];
    
    public function _initialize()
    {
        $this->request->filter('trim,strip_tags,htmlspecialchars');
        
        if( !daohangRequestCheck($this->request->ip(),$this->request->header('user-agent')) ){
            $this->error(lang('dh_error_rest'), 'daohang/index/index');
        }
        
        parent::_initialize();
    }
    
    //快速收录
    public function index()
    {
        $this->assign([
            'seoTitle'       => daohangSeo(config('daohang.fast_title')),
            'seoKeywords'    => daohangSeo(config('daohang.fast_keywords')),
            'seoDescription' => daohangSeo(config('daohang.fast_description')),
            'scoreFast'      => intval(config('daohang.score_fast')),//扣除积分
            'scoreRecharge'  => intval(config('user.score_recharge')),//充值比例
            'fields'         => DcFormItems(model('daohang/Info','loglic')->fastFields()),
        ]);
        return $this->fetch();
    }
    
    //免审发布网站
    public function save()
    {
        //用户组与积分处理
        $this->authFast(config('daohang.score_fast'));
        
        //保存至数据库
        if( !DcArrayResult(daohangSave($this->post(),false)) ){
		    $this->error(\daicuo\Info::getError());
        }
        
        //普通用户扣除积分
        if($this->isVip == false && config('daohang.score_fast')){
            //积分扣除
            $result = userScoreDec($this->site['user']['user_id'], config('daohang.score_fast'));
            //积分日志
            if($result){
                $this->logSave(config('daohang.score_fast')*-1);
            }
        }
        
        //返回结果
        $this->success(lang('success'));
    }
    
    //接收POST数据
    private function post()
    {
        $data = [];
        $data['info_name']        = input('post.info_name/s');
        $data['info_referer']     = input('post.info_referer/s');
        $data['image_level']      = input('post.image_level/s');
        $data['image_qrcode']     = input('post.image_qrcode/s');
        $data['info_excerpt']     = input('post.info_excerpt/s');
        $data['info_content']     = input('post.info_content/s','网站简介未填写');
        $data['category_id']      = input('post.category_id/a');
        $data['tag_name']         = input('post.tag_name/s');
        //必填字段
        if(!$data['info_name']){
            $this->error( lang('dh_error_name_require') );
        }
        if(!$data['category_id']){
            $this->error( lang('dh_error_category_require') );
        }
        //默认属性
        $data['info_views']       = rand(99,999);
        $data['info_hits']        = rand(9,99);
        $data['info_up']          = rand(99,999);
        $data['info_down']        = rand(9,99);
        $data['info_user_id']     = $this->site['user']['user_id'];
        $data['info_module']      = 'daohang';
        $data['info_controll']    = 'detail';
        $data['info_action']      = 'index';
        $data['info_type']        = 'fast';
        $data['info_status']      = 'normal';
        return $data;
    }
    
    //手动验证快审发布权限与积分处理权限
    private function authFast($scoreConfig=0)
    {
        //验证规则
        $this->auth['rule'] = 'daohang/fast/save';
        //VIP用户组
        if ( \daicuo\Auth::check($this->auth['rule'], $this->site['user']['user_capabilities'], $this->site['user']['user_caps']) ) {
            $this->isVip = true;
            return true;
        }
        //积分扣除配置（小于1不启用积分发布功能，只可以VIP用户组发布）
        if( $scoreConfig < 1 ){
            $this->error( DcError(lang('dh_error_fast_vip')), 'daohang/publish/index');
        }
        //积分不足
        if($this->site['user']['user_score'] < $scoreConfig){
            $this->error( DcError(lang('dh_error_score_light')), 'user/center/index');
        }
    }
    
    //积分日志
    private function logSave($logValue=0)
    {
        $data = [];
        $data['log_name']     = '免审发布网站';
        $data['log_user_id']  = $this->site['user']['user_id'];
        $data['log_info_id']  = 0;
        $data['log_value']    = $logValue;
        $data['log_module']   = 'daohang';
        $data['log_controll'] = 'fast';
        $data['log_action']   = 'index';
        $data['log_type']     = 'userScore';
        $data['log_ip']       = $this->request->ip();
        //$data['log_query']  = http_build_query(input('get.'));
        $data['log_info']     = $this->request->header('user-agent');
        return model('common/Log','loglic')->save($data);
    }
}