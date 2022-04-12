<?php
/**
 * 添加广告
 * @param array $data 待添加数据
 * @return int 自增ID
 */
function adsenseSave($data=[]){
    //数据验证
    if(!$data){
        return 0; 
    }
    //数据处理
    //$data['info_type']   = 'code';//广告类型code/text/image
    //广告内容写入info_content字段
    $data['info_content']   = serialize(['web'=>$data['web'],'mobile'=>$data['mobile']]);
    unset($data['web']);
    unset($data['mobile']);
    //别名附加条件
    config('common.where_slug_unique',['info_module'=>['eq','adsense']]);
    //验证规则
    config('common.validate_name','adsense/Adsense');
    //验证场景
    config('common.validate_scene','save');
    //扩展字段
    config('custom_fields.info_meta',[]);
    //添加至数据库
    $info_id = \daicuo\Info::save($data);
    //返回数据
    if($info_id < 1){
        return 0;
    }
    return $info_id;
}

/**
 * 删除广告
 * @param array $ids ID列表
 * @return array
 */
function adsenseDelete($ids=[]){
    return \daicuo\Info::delete_all(['info_id'=>['in',$ids]]);
}

/**
 * 修改广告
 * @param array $data 待修改数据
 * @return null|array 修改后的数据
 */
function adsenseUpdate($data=[]){
    //数据验证
    if(!$data){
        return null; 
    }
    //广告内容写入info_content字段
    $data['info_content']   = serialize(['web'=>$data['web'],'mobile'=>$data['mobile']]);
    unset($data['web']);
    unset($data['mobile']);
    //别名附加条件
    config('common.where_slug_unique',['info_module'=>['eq','adsense']]);
    //验证规则
    config('common.validate_name','adsense/Adsense');
    //验证场景
    config('common.validate_scene','update');
    //扩展字段
    config('custom_fields.info_meta',[]);
    //修改数据
    $info = \daicuo\Info::update_id($data['info_id'], $data);
    if(is_null($info)){
        return null;
    }
    return DcArrayResult($info);
}

/**
 * 通过ID获取内容模型
 * @param init $value ID值
 * @param bool $cache 是否缓存
 * @return obj|null
 */
function adsenseGetId($value='', $cache=true){
    if($value){
        return adsenseInfo(\daicuo\Info::get_id($value, $cache));
    }
    return null;
}

/**
 * 通过唯一名获取内容模型
 * @param $metaKey key值
 * @param $metaValue value值
 * @return obj|null
 */
function adsenseGetSlug($value='', $cache=true){
    if ( !$value ) {
        return null;
    }
    $args = [];
    $args['cache']  = $cache;
    $args['module'] = ['eq', 'adsense'];
    $args['slug']   = ['eq', $value];
    return adsenseInfo( model('common/Info','loglic')->get($args) );
}

/**
 * 通过参数获取内容模型列表
 * @since 1.0.1
 * @param array $query {
 *     @type bool $cache 可选;是否缓存;默认：true
 *     @type int $limit 可选;分页大小;默认：0
 *     @type int $page 可选;当前分页;默认：0
 *     @type string $field 可选;查询字段;默认：*
 *     @type string $status 可选;显示状态（normal|hidden）;默认：空
 *     @type string $sort 可选;排序字段名(info_id|info_order|info_views|info_hits|meta_value_num);默认：info_id
 *     @type string $order 可选;排序方式(asc|desc);默认：asc
 *     @type string $search 可选;搜索关键词（info_name|info_slug|info_excerpt）;默认：空
 *     @type mixed $id 可选;内容ID限制条件(int|array);默认：空
 *     @type mixed $title 可选;标题限制条件(stirng|array);默认：空
 *     @type mixed $name 可选;名称限制条件(stirng|array);默认：空
 *     @type mixed $slug 可选;别名限制条件(stirng|array);默认：空
 *     @type string $result 可选;返回结果类型(array|obj);默认：array
 * }
 * @return obj|null 无数据时返回null
 */
function adsenseAll($args)
{
    $args = DcArrayArgs($args,[
        'cache'    => 'true',
        'module'   => 'adsense',
        'result'   => 'array',
    ]);
    $list = model('common/Info','loglic')->select($args);
    if($list['data']){
        foreach($list['data'] as $key=>$value){
            $list['data'][$key] = adsenseInfo($value);
        }
    }else{
        foreach($list as $key=>$value){
            $list[$key] = adsenseInfo($value);
        }
    }
    return $list;
}

/**
 * 内容模型数据处理
 * @param array $data 待处理的值
 * @return array
 */
function adsenseInfo($data=[]){
    if(is_null($data)){
        return null;
    }
    //Content处理
    if($data['info_content']){
        $content = unserialize($data['info_content']);
        $data['web'] = $content['web'];
        $data['mobile'] = $content['mobile'];
    }
    //广告类型
    $data['info_action_text'] = adsenseInfoActionText($data['info_action']);
    //链接处理
    $data['info_link'] = adsenseInfoLink($data);
    //调用代码
    $data['info_show'] = adsenseShowTpl($data['info_slug']);
    //返回格式化后的数据
    return $data;
}

/**
 * 广告类型文本
 * @param string $field 字段
 * @return string;
 */
function adsenseInfoActionText($field){
    $array = [];
    $array['image'] = '图片广告';
    $array['text']  = '文字广告';
    $array['code']  = '广告代码';
    return DcEmpty($array[$field], '未知广告');
}

/**
 * 内容模型内部链接
 * @param array $data 内容数据
 * @param string $tyle 链接方式(slug|read)
 * @return obj|null
 */
function adsenseInfoLink($data=[],$type='slug'){
    if($type == 'slug'){
        $url = DcUrl('adsense/index/slug',['id'=>$data['info_slug']],'');
    }else{
        $url = DcUrl('adsense/index/read',['id'=>$data['info_id']],'');
    }
    return str_replace(request()->baseFile(),'',$url);
}

/**
 * 展示广告内容
 * @param array $info 广告数据
 * @param string $platForm 来源平台(auto|web|mobile)
 * @return string 广告代码
 */
function adsenseInfoContent($info=[], $platForm='auto'){
    if(!$info){
        return '';
    }
    //是否展示
    if($info['info_status'] != 'normal'){
        return '';
    }
    //展示平台
    if($platForm == 'auto'){
        if(request()->isMobile()){
            $platForm = 'mobile';
        }else{
            $platForm = 'web';
        }
    }
    //广告类型处理
    if($info['info_action'] == 'image'){
        $style = [];
        if($info[$platForm]['image']['width']){
            $style['width'] = 'width: '.$info[$platForm]['image']['width'];
        }
        if($info[$platForm]['image']['height']){
            $style['height'] = 'height: '.$info[$platForm]['image']['height'];
        }
        $string = '<a href="'.$info[$platForm]['image']['link'].'" target="_blank"><img class="'.$info[$platForm]['image']['class'].'" src="'.DcUrlAttachment($info[$platForm]['image']['src']).'" data-id="'.$info['info_id'].'" data-toggle="adsense" alt="'.$info[$platForm]['image']['alt'].'" style="'.implode($style,';').'"/></a>';
    }elseif($info['info_action'] == 'text'){
        $style = [];
        if($info[$platForm]['text']['size']){
            $style['width'] = 'font-size: '.$info[$platForm]['text']['size'];
        }
        $string = '<a class="'.$info[$platForm]['text']['class'].'" href="'.$info[$platForm]['text']['link'].'" data-id="'.$info['info_id'].'" data-toggle="adsense" target="_blank" style="'.implode($style,';').'">'.$info[$platForm]['text']['title'].'</a>';
    }else{
        $string = '<span data-id="'.$info['info_id'].'" data-toggle="adsense">'.$info[$platForm]['code']['html'].'</span>';
    }
    //是否统计展示
    if($info['info_order']){
        adsenseInfoInc($info['info_id']);
    }
    //替换为呆错渠道ID
    if(config('common.site_id')){
        return str_replace('{SITEID}', config('common.site_id'), $string);
    }
    return $string;
}

/**
 * 调用广告展示函数
 * @param array $info 广告数据
 * @return int 自增ID
 */
function adsenseShow($infoSlug='', $platForm='web'){
    return adsenseInfoContent( adsenseGetSlug($infoSlug), $platForm);
}

/**
 * 内容模型计数增加
 * @param int $id ID值
 * @param string $field 字段值
 * @param int $num 步进值
 * @param int $time 是否延迟更新
 * @return int
 */
function adsenseInfoInc($id, $field='info_views', $num=1, $time=0){
    if(!$id){
        return 0;
    }
    return dbUpdateInc('common/Info', ['info_id'=>['eq',$id]], $field, $num, $time);
}

/**
 * 生成模板调用广告标签
 * @param string $module 模块
 * @param string $field 字段
 * @return string;
 */
function adsenseShowTpl($field){
    return DcHtml('{:adsenseShow("'.$field.'")}');
}

/**
 * 操作管理按钮
 * @param array $info 内容数据
 * @return string;
 */
function adsenseOperate($info){
    $operate = array();
    $operate['link'] = '<a class="btn btn-outline-secondary" href="'.$info['info_link'].'" target="_blank"><i class="fa fa-fw fa-link"></i></a>';
    $operate['edit'] = '<a class="btn btn-outline-secondary" href="?module=adsense&controll=admin&action=delete&id='.$info['info_id'].'" data-toggle="edit" data-modal-lg="true"><i class="fa fa-fw fa-pencil"></i></a>';
    $operate['delete'] = '<a class="btn btn-outline-secondary" href="?module=adsense&controll=admin&action=delete&id='.$info['info_id'].'" data-toggle="delete"><i class="fa fa-fw fa-trash-o"></i></a>';
    return '<div class="btn-group btn-group-sm">'.implode('',$operate).'</div>';
}