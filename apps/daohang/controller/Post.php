<?php
namespace app\daohang\controller;

use app\common\controller\Front;

class Post extends Front
{
    public function _initialize()
    {
		parent::_initialize();
    }
    
    public function index()
    {
        //必需设置密码
        if(!config('daohang.post_pwd')){
            return json(['code'=>0,'msg'=>lang('dh_post_config')]);
        }
        //获取表单数据
        $post = input('post.');
        //入库密码字段
        if(!$post['post_pwd']){
            return json(['code'=>0,'msg'=>lang('dh_post_empty')]);
        }
        //密码验证
        if($post['post_pwd'] != config('daohang.post_pwd')){
            return json(['code'=>0,'msg'=>lang('dh_post_wrong')]);
        }
        //保存数据
        if( !$id=daohangSave($post, true) ){
            return json(['code'=>0,'msg'=>\daicuo\Info::getError()]);
        }
        //添加成功
        return json(['code'=>1,'data'=>$id]);
    }
}