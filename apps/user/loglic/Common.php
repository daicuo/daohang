<?php
namespace app\user\loglic;

class Common
{
    /**
     * 拼装回跳地址与临时码
     * @param array $user 当前用户信息
     * @param string $bakUrl 回跳网址
     * @param string $state 自定义参数
     * @return mixed string|null
     */
    public function callBack($user=[], $bakUrl='', $state=''){
        if(!$user || !$bakUrl){
            return null;
        }
        if(!config('user.callback_domains')){
            return null;
        }
        //白名单域名
        if( !in_array(DcDomain($bakUrl), explode(',',config('user.callback_domains'))) ){
            return null;
        }
        //增加时间参数
        $user['code_time'] = time();
        //回跳网址拼装
        $query = [];
        $query['code']     = DcDesEncode(implode(',',$user), config('user.callback_secret'));//加密生成临时码CODE
        $query['state']    = DcHtml($state);//自定义回跳参数
        return $bakUrl.'?'.http_build_query($query);
    }
    
}