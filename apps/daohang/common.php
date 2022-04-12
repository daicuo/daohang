<?php
/**
 * 添加一个导航数据
 * @version 1.3.1 优化
 * @version 1.0.0 首次引入
 * @param array $post 必需;数组格式,支持的字段列表请参考手册
 * @param bool $autoSave 可选;当分类与标签不存在时是否自动新增;默认:false
 * @return mixed 成功时返回obj,失败时null
 */
function daohangSave($post=[], $autoSave=false)
{
    $post = DcArrayArgs($post,[
        'info_module'   => 'daohang',
        'info_controll' => 'detail',
        'info_action'   => 'index',
        'info_staus'    => 'normal',
    ]);
    $post = daohangPostData($post, $autoSave);
    
    config('common.validate_name','daohang/Info');

    config('common.validate_scene','save');

    config('common.where_slug_unique',['info_module'=>['eq','daohang']]);
    
    config('custom_fields.info_meta',daohangMetaKeys('detail',NULL));

    return \daicuo\Info::save($post, 'info_meta,term_map');
}

/**
 * 按ID删除一条或多条导航数据
 * @version 1.0.0 首次引入
 * @param mixed $ids 必需;多个用逗号分隔或使用数组传入(array|string);默认：空 
 * @return array ID作为键名,键值为删除结果(bool)
 */
function daohangDelete($ids=[])
{
    return model('common/Info','loglic')->deleteIds($ids);
}

/**
 * 修改一条导航数据(需传入主键值作为更新条件)
 * @version 1.3.1 优化
 * @version 1.0.0 首次引入
 * @param array $post 必需;数组格式,支持的字段列表请参考手册 {
 *     @type int $info_id 必需;按ID修改导航;默认：空
 * }
 * @param bool $autoSave 可选;当分类与标签不存在时是否自动新增;默认:false
 * @return mixed 成功时返回obj,失败时null
 */
function daohangUpdate($post=[], $autoSave=false)
{
    $post = DcArrayArgs($post,[
        'info_module'   => 'daohang',
        'info_controll' => 'detail',
        'info_action'   => 'index',
        'info_tpl'      => 'index',
    ]);
    $post = daohangPostData($post, $autoSave);
    
    config('common.validate_name','daohang/Info');
        
    config('common.validate_scene','update');

    config('common.where_slug_unique',['info_module'=>['eq','daohang']]);
    
    config('custom_fields.info_meta',daohangMetaKeys('detail',NULL));
    
    return \daicuo\Info::update_id($post['info_id'], $post, 'info_meta,term_map');
}

/**
 * 按条件查询多个导航数据
 * @version 1.3.1 优化
 * @version 1.0.0 首次引入
 * @param array $args 必需;查询条件数组格式 {
 *     @type bool $cache 可选;是否缓存;默认：true
 *     @type string $limit 可选;分页大小;默认：0
 *     @type string $page 可选;当前分页;默认：0
 *     @type string $field 可选;查询字段;默认：*
 *     @type string $status 可选;显示状态（normal|hidden）;默认：空
 *     @type string $sort 可选;排序字段名(info_id|info_order|info_views|info_hits|meta_value_num);默认：info_id
 *     @type string $order 可选;排序方式(asc|desc);默认：asc
 *     @type string $search 可选;搜索关键词（info_name|info_slug|info_excerpt）;默认：空
 *     @type mixed $id 可选;内容ID限制条件(int|array);默认：空
 *     @type mixed $title 可选;标题限制条件(stirng|array);默认：空
 *     @type mixed $name 可选;名称限制条件(stirng|array);默认：空
 *     @type mixed $slug 可选;别名限制条件(stirng|array);默认：空
 *     @type mixde $action 可选;所属操作(web|mini|media);默认：空
 *     @type mixed $term_id 可选;分类法ID限制条件(string|array);默认：空
 *     @type array $meta_query 可选;自定义字段(二维数组[key=>['eq','key'],value=>['in','key']]);默认：空
 *     @type string $result 可选;返回结果类型(array|obj);默认：array
 *     @type array $with 可选;自定义高级查询条件;默认：空
 *     @type array $view 可选;自定义高级查询条件;默认：空
 *     @type array $where 可选;自定义高级查询条件;默认：空
 *     @type array $paginate 可选;自定义高级分页参数;默认：空
 * }
 * @return mixed 查询结果（array|null）
 */
function daohangSelect($args)
{
    $args = DcArrayArgs($args,[
        'cache'    => true,
        'result'   => 'array',
        'module'   => 'daohang',
    ]);
    return model('common/Info','loglic')->select($args);
}

/**
 * 按条件查询单个网址数据
 * @version 1.0.0 首次引入
 * @param array $args 必需;查询条件数组格式 {
 *     @type bool $cache 可选;是否缓存;默认：true
 *     @type string $status 可选;显示状态（normal|hidden）;默认：空
 *     @type mixed $id 可选;内容ID(stirng|array);默认：空
 *     @type mixed $name 可选;内容名称(stirng|array);默认：空
 *     @type mixed $slug 可选;内容别名(stirng|array);默认：空
 *     @type mixed $title 可选;内容别名(stirng|array);默认：空
 *     @type mixed $user_id 可选;用户ID(stirng|array);默认：空
 *     @type array $with 可选;自定义高级查询条件;默认：空
 *     @type array $view 可选;自定义高级查询条件;默认：空
 *     @type array $where 可选;自定义高级查询条件;默认：空
 * }
 * @return mixed 查询结果（array|null）
 */
function daohangGet($args)
{
    $args = DcArrayArgs($args,[
        'cache'    => true,
        'module'   => 'daohang',
    ]);
    return model('common/Info','loglic')->get($args);
}

/**
 * 按ID快速获取一条内容数据
 * @version 1.0.0 首次引入
 * @param int $value 必需;Id值；默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed 查询结果(obj|null)
 */
function daohangId($value='', $cache=true, $status='normal')
{
    if (!$value) {
        return null;
    }
    return daohangGet([
        'cache'  => $cache,
        'status' => $status,
        'id'     => $value,
    ]);
}

/**
 * 按SLUG快速获取一条内容数据
 * @version 1.0.0 首次引入
 * @param int $value 必需;Id值；默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed 查询结果(obj|null)
 */
function daohangSlug($value='', $cache=true, $status='normal')
{
    if (!$value) {
        return null;
    }
    return daohangGet([
        'cache'    => $cache,
        'status'   => $status,
        'slug'     => $value,
    ]);
}

/**
 * 按名称快速获取一条导航数据
 * @version 1.0.0 首次引入
 * @param int $value 必需;Id值；默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed 查询结果(obj|null)
 */
function daohangName($value='', $cache=true, $status='normal')
{
    if (!$value) {
        return null;
    }
    return daohangGet([
        'cache'    => $cache,
        'status'   => $status,
        'name'     => $value,
    ]);
}


/**
 * 按条件获取导航菜单列表
 * @version 1.2.0 首次引入
 * @param array $args 必需;查询条件数组格式 {
 *     @type bool $cache 可选;是否缓存;默认：true
 *     @type string $result 可选;返回状态(array|tree|level);默认：tree
 *     @type string $status 可选;显示状态（normal|hidden）;默认：空
 *     @type string $module 可选;模型名称;默认：空
 *     @type string $controll 可选;控制器名称;默认：空
 *     @type string $action 可选;操作名称(navbar|navs);默认：空
 *     @type int $limit 可选;分页大小;默认：0
 *     @type string $sort 可选;排序字段名;默认：op_order
 *     @type string $order 可选;排序方式(asc|desc);默认：asc
 *     @type array $where 可选;自定义高级查询条件;默认：空
 * }
 * @return mixed 查询结果array|null
 */
function daohangNavbar($args=[])
{
    return model('common/Navs','loglic')->select($args);
}

/**********************************************************************************************************/

/**
 * 按条件获取多个网站分类
 * @version 1.0.0 首次引入
 * @param array $args 必需;查询条件数组格式 {
 *     @type bool $cache 可选;是否缓存;默认：true
 *     @type int $limit 可选;分页大小;默认：0
 *     @type int $page 可选;当前分页;默认：0
 *     @type string $sort 可选;排序字段名;默认：op_order
 *     @type string $order 可选;排序方式(asc|desc);默认：asc
 *     @type string $status 可选;显示状态（normal|hidden）;默认：空
 *     @type string $module 可选;模型名称;默认：空
 *     @type string $result 可选;模型名称;默认：空
 *     @type array $where 可选;自定义高级查询条件;默认：空
 *     @type array $paginate 可选;自定义高级分页参数;默认：空
 * }
 * @return mixed 查询结果obj|null
 */
function daohangCategorySelect($args=[])
{
    return DcTermSelect( DcArrayArgs($args,[
        'cache'   => true,
        'controll'=> 'category',
        'module'  => 'daohang',
        'result'  => 'array',
    ]) );
}

/**
 * 按ID快速获取分类信息
 * @version 1.3.1 优化
 * @version 1.0.0 首次引入
 * @param int $value 必需;Id值；默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed 查询结果(array|null)
 */
function daohangCategoryId($value='', $cache=true, $status='normal')
{
    $args = [
        'module'  => 'daohang',
        'controll'=> 'category',
        'cache'   => $cache,
        'status'  => $status,
        'id'      => $value,
    ];
    return DcTermFind($args);
}

/**
 * 按别名快速获取分类信息
 * @version 1.3.1 优化
 * @version 1.0.0 首次引入
 * @param string $value 必需;别名值；默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed 查询结果(array|null)
 */
function daohangCategorySlug($value='', $cache=true, $status='normal')
{
    $args = [
        'module'   => 'daohang',
        'controll' => 'category',
        'cache'    => $cache,
        'status'   => $status,
        'slug'     => $value,
    ];
    return DcTermFind($args);
}

/**
 * 按分类名称快速获取分类信息
 * @version 1.3.1 优化
 * @version 1.0.0 首次引入
 * @param string $value 必需;分类名称；默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed 查询结果(array|null)
 */
function daohangCategoryName($value='', $cache=true, $status='normal')
{
    $args = [
        'module' => 'daohang',
        'type'   => 'category',
        'cache'  => $cache,
        'status' => $status,
        'name'   => $value,
    ];
    return DcTermFind($args);
}

/**
 * 通过分类名获取分类ID（每个应用）
 * @version 1.3.1 首次引入
 * @param mixed $tagName 必需;标签名;默认：空
 * @param bool $autoSave可选;是否自动新增;默认：false
 * @return array 查询结果
 */
function daohangCategoryAuto($name=[], $autoSave=false){
    return model('common/Term','loglic')->nameToId($name, 'daohang', 'category', $autoSave);
}

/**********************************************************************************************************/

/**
 * 按条件获取多个标签信息
 * @version 1.3.1 优化
 * @version 1.0.0 首次引入
 * @param array $args 必需;查询条件数组格式 {
 *     @type bool $cache 可选;是否缓存;默认：true
 *     @type int $limit 可选;分页大小;默认：0
 *     @type int $page 可选;当前分页;默认：0
 *     @type string $sort 可选;排序字段名;默认：op_order
 *     @type string $order 可选;排序方式(asc|desc);默认：asc
 *     @type string $status 可选;显示状态（normal|hidden）;默认：空
 *     @type string $module 可选;模型名称;默认：空
 *     @type string $result 可选;模型名称;默认：空
 *     @type array $where 可选;自定义高级查询条件;默认：空
 *     @type array $paginate 可选;自定义高级分页参数;默认：空
 * }
 * @return mixed 查询结果obj|null
 */
function daohangTagSelect($args=[])
{
    return DcTermSelect( DcArrayArgs($args,[
        'cache'    => true,
        'result'   => 'array',
        'module'   => 'daohang',
        'controll' => 'tag',
    ]) );
}

/**
 * 按ID快速获取标签信息
 * @version 1.3.1 优化
 * @version 1.0.0 首次引入
 * @param int $value 必需;Id值；默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed 查询结果(array|null)
 */
function daohangTagId($value='', $cache=true, $status='normal')
{
    $args = [
        'module'   => 'daohang',
        'controll' => 'tag',
        'cache'    => $cache,
        'status'   => $status,
        'id'       => $value,
    ];
    return DcTermFind($args);
}

/**
 * 按别名快速获取标签信息
 * @version 1.3.1 优化
 * @version 1.0.0 首次引入
 * @param string $value 必需;别名值；默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed 查询结果(array|null)
 */
function daohangTagSlug($value='', $cache=true, $status='normal')
{
    $args = [
        'module'   => 'daohang',
        'controll' => 'tag',
        'cache'    => $cache,
        'status'   => $status,
        'slug'     => $value,
    ];
    return DcTermFind($args);
}

/**
 * 按名称快速获取标签信息
 * @version 1.3.1 优化
 * @version 1.0.0 首次引入
 * @param string $value 必需;分类名称；默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed $mixed 查询结果(array|null)
 */
function daohangTagName($value='', $cache=true, $status='normal')
{
    $args = [
        'module'   => 'daohang',
        'controll' => 'category',
        'cache'    => $cache,
        'status'   => $status,
        'name'     => $value,
    ];
    return DcTermFind($args);
}

/**
 * 快速获取多个热门标签列表的某一个字段
 * @version 1.3.1 优化
 * @version 1.0.0 首次引入
 * @param int $limit 必需;数量限制；默认：10
 * @param string $field 可选;返回字段;默认：term_name
 * @return mixed 查询结果(array|null)
 */
function daohangTags($limit=10, $field='term_name')
{
    return array_column(daohangTagSelect([
        'status' => 'normal',
        'limit'  => DcEmpty($limit,5),
        'sort'   => 'term_count desc,term_id',
        'order'  => 'desc',
    ]), $field);
}

/**
 * 通过标签名获取标签ID(所有应用共用一个标签)
 * @version 1.3.1 首次引入
 * @param mixed $name 必需;标签名;默认：空
 * @param bool $autoSave可选;是否自动新增;默认：false
 * @return array 查询结果
 */
function daohangTagAuto($name=[], $autoSave=false){
    return model('common/Term','loglic')->nameToId($name, 'daohang', 'tag', $autoSave);
}

/*************************************************************************************/

/**
 * 根据对日期或时间进行格式化
 * @version 1.0.0 首次引入
 * @param string $format 必需;规定时间戳的格式;空
 * @param mixed $timestamp 可选;规定时间戳;空
 * @return string $string 格式化后的时间
 */
function daohangDate($format='Y-m-d', $timestamp='')
{
    if(!is_numeric($timestamp)){
        $timestamp = strtotime($timestamp);
    }
    return date($format, $timestamp);
}

/**
 * 根据对日期或时间进行格式化
 * @version 1.0.0 首次引入
 * @param string $color 必需;规定时间戳的格式;空
 * @param string $default 可选;默认颜色值;空
 * @return string $string 格式化后的时间
 */
function daohangColor($color, $default='text-dark')
{
    return DcEmpty($color, $default);
}

/**
 * 网址导航选项
 * @version 1.2.0 首次引入
 * @return array 处理后的数据
 */
function daohangTypeOption()
{
    //后台配置
    $types = json_decode(config('daohang.type_option'),true);
    //合并初始值
    return DcArrayArgs($types, [
        'index'     => lang('dh_type_index'),
        'fast'      => lang('dh_type_fast'),
        'recommend' => lang('dh_type_recommend'),
        'head'      => lang('dh_type_head'),
        'foot'      => lang('dh_type_foot'),
    ]);
}

/**
 * 内容模型计数增加
 * @param int $id 必需;ID值;默认:空
 * @param string $field 必需;字段值;默认:info_views
 * @param int $numb 可选;步进值;默认:1
 * @param int $time 可选;延迟更新;默认:0
 * @return int 最新值
 */
function daohangInfoInc($id, $field='info_views', $num=1, $time=0)
{
    if(!$id){
        return 0;
    }
    return dbUpdateInc('common/Info', ['info_id'=>['eq',$id]], $field, $num, $time);
}

/**
 * 表单数据处理
 * @version 1.0.0 首次引入
 * @param array $post 必需;数组格式,支持的字段列表请参考手册;默认:空
 * @param bool $autoSave 可选;当分类与标签不存在时是否自动新增;默认:false
 * @return array 处理后的数据
 */
function daohangPostData($post=[], $autoSave=false){
    //分类处理（category_name、category_id可自动合并）
    $post['term_id'] = [];
    if($post['category_id']){
        $post['term_id'] = DcArrayArgs($post['category_id'], $post['term_id']);
    }
    if($post['category_name']){
        $post['term_id'] = DcArrayArgs(daohangCategoryAuto($post['category_name'], $autoSave), $post['term_id']);
    }
    //标签处理（tag_name、tag_id可自动合并）
    if($post['tag_id']){
        $post['term_id'] = DcArrayArgs($post['tag_id'], $post['term_id']);
    }
    if($post['tag_name']){
        $post['term_id'] = DcArrayArgs(daohangTagAuto($post['tag_name'], $autoSave), $post['term_id']);
    }
    //摘要截取
    if(!$post['info_excerpt']){
       $post['info_excerpt'] = daohangSubstr($post['info_content'], 0, 140, true);
    }
    //别名处理
    if(config('daohang.slug_first') && !$post['info_slug']){
        $post['info_slug'] = \daicuo\Pinyin::get($post['info_name'], true);
    }
    //顶级域名处理
    if(!$post['info_domain']){
        $post['info_domain'] = daohangTopHost($post['info_referer']);
    }
    //去除不需要的字段
    unset($post['category_name']);
    unset($post['category_id']);
    unset($post['tag_name']);
    unset($post['tag_id']);
    //返回结果
    return DcArrayArgs($post, [
        'info_up'    => 0,
        'info_down'  => 0,
        'info_color' => 'text-dark',
    ]);
}

/**
 * 批量更新与新增导航应用的动态配置
 * @version 1.2.0 首次引入
 * @param array $post 必需;数组格式（通常为表单提交的POST）;默认：空
 * @return mixed 成功时返回obj,失败时null
 */
function daohangConfigSave($post=[])
{
    if(!$post){
        return null;
    }
    return \daicuo\Op::write($post,'daohang','config','system',0,'yes');
}

/**
 * 批量删除导航应用的动态配置
 * @param array $where 查询条件
 * @return int 影响条数
 */
function daohangConfigDelete($where=[])
{
    $where = DcArrayArgs($where,[
        'op_module'   => 'daohang',
        'op_controll' => 'config',
        //'op_action'   => 'system',
    ]);
    $status = \daicuo\Op::delete_all($where);
    if($status){
        DcCache('config_daohang', NULL);
    }
    return $status;
}

/**********************************************************************************************************/

/**
 * 生成站内链接
 * @version 1.1.0 首次引入
 * @param string $url 必需;调用地址
 * @param string|array $vars 可选;调用参数，支持字符串和数组;默认：空
 * @return string $string 站内链接
 */
function daohangUrl($url='', $vars=''){
    return DcUrl($url, $vars);
}

/**
 * 获取详情页链接(controll决定)
 * @version 1.0.0 首次引入
 * @param array $info 必需;[id,name,slug]；默认：空
 * @param string $controll 必需;控制器名；默认：web
 * @return string 生成的内部网址链接
 */
function daohangUrlInfo($info=[], $controll='web')
{
    $route = config('daohang.rewrite_detail');
    $args = [];
    //必要参数
    if( preg_match('/:slug|<slug/i',$route) ){
        $args['slug'] = $info['info_slug'];
    }elseif( preg_match('/:name|<name/i',$route) ){
        $args['name'] = $info['info_name'];
    }else{
        $args['id'] = $info['info_id'];
    }
    //分类参数
    if( preg_match('/:termSlug|<termSlug/i',$route) ){
        $args['termSlug'] = $info['category_slug'][0];
    }
    if( preg_match('/:termId|<termId/i',$route) ){
        $args['termId'] = $info['category_id'][0];
    }
    if( preg_match('/:termName|<termName/i',$route) ){
        $args['termName'] = $info['category_name'][0];
    }
    return daohangUrl('daohang/detail/index', $args);
}

/**
 * 生成网址跳转链接(直链或是跳转中间广告页)
 * @version 1.2.0 首次引入
 * @param int $infoId 必需;Id值；默认：空
 * @param string $infoType 必需;网址类型;默认:index
 * @param string $form 可选;收录网站平台;默认:web
 * @return string 生成的内部网址链接
 */
function daohangUrlJump($infoType='index', $jumpUrl='', $infoId=0){
    if( in_array($infoType, ['fast','friend','recommend','head','foot']) ){
        return daohangReferer($jumpUrl);
    }
    return daohangUrl('daohang/jump/index', ['id'=>$infoId]);
}

/**
 * 获取分类页链接
 * @version 1.0.0 首次引入
 * @param array $info 必需;[id,name,slug]；默认:空
 * @param mixed $pageNumber 可选;int|[PAGE];默认:空
 * @return string 生成的内部网址链接
 */
function daohangUrlCategory($info=[], $pageNumber='')
{
    $route = config('daohang.rewrite_category');
    $args = [];
    if( preg_match('/:slug|<slug/i',$route) ){
        $args['slug'] = $info['term_slug'];
    }elseif( preg_match('/:name|<name/i',$route) ){
        $args['name'] = $info['term_name'];
    }else{
        $args['id'] = $info['term_id'];
    }
    if($pageNumber){
        $args['pageNumber'] = $pageNumber;
    }
    return daohangUrl('daohang/category/index', $args);
}

/**
 * 获取标签链接
 * @version 1.0.0 首次引入
 * @param array $info 必需;[id,name,slug]；默认:空
 * @param mixed $pageNumber 可选;int|[PAGE];默认:空
 * @return string 生成的内部网址链接
 */
function daohangUrlTag($info=[], $pageNumber='')
{
    //伪静态规则
    $route = config('daohang.rewrite_tag');
    //URL链接参数
    $args  = [];
    if( preg_match('/:slug|<slug/i',$route) ){
        $args['slug'] = $info['term_slug'];
    }elseif( preg_match('/:name|<name/i',$route) ){
        $args['name'] = $info['term_name'];
    }else{
        $args['id'] = $info['term_id'];
    }
    //分页参数
    if($pageNumber){
        $args['pageNumber'] = $pageNumber;
    }
    return daohangUrl('daohang/tag/index', DcArrayEmpty($args));
}

/**
 * 获取搜索页链接
 * @version 1.0.0 首次引入
 * @param array $args 必需;['searchText','pageNumber','pageSize','sortName','sortOrder']；默认:空
 * @param string $action 可选;操作名;默认:index
 * @return string 生成的内部网址链接
 */
function daohangUrlSearch($action='index',$args=[])
{
    $args  = DcArrayFilter($args,['searchText','pageSize','pageNumber']);
    $route = config('daohang.rewrite_search');
    if( strpos($route,'pageSize') === false ){
        unset($args['pageSize']);
    }
    return daohangUrl('daohang/search/'.$action, $args);
}

/**
 * 获取筛选页链接
 * @version 1.0.0 首次引入
 * @param array $args 必需;[id,name,slug]；默认:空
 * @param mixed $pageNumber 可选;int|[PAGE];默认:空
 * @return string 生成的内部网址链接
 */
function daohangUrlFilter($args=[])
{
    //URL链接参数
    $args  = DcArrayFilter($args,['termId','termSlug','termName','pageSize','pageNumber','sortName','sortOrder']);
    //伪静态规则
    $route = config('daohang.rewrite_filter');
    //未定义伪静态规则
    if(!$route){
        return daohangUrl('daohang/filter/index', $args);
    }
    //模型参数
    if( preg_match('/:controll|<controll/i',$route) ){
        $args['controll'] = DcEmpty($args['controll'],'web');
    }
    //分类相关
    if( preg_match('/:termId|<termId/i',$route) ){
        $args['termId'] = intval($args['termId']);
    }
    if( preg_match('/:termSlug|<termSlug/i',$route) ){
        $args['termSlug'] = DcEmpty($args['termSlug'],'termSlug');
    }
    if( preg_match('/:termName|<termName/i',$route) ){
        $args['termName'] = DcEmpty($args['termName'],'termName');
    }
    //分页相关
    if( preg_match('/:pageSize|<pageSize/i',$route) ){
        $args['pageSize'] = DcEmpty($args['pageSize'], 10);
    }
    if( preg_match('/:pageNumber|<pageNumber/i',$route) ){
        $args['pageNumber'] = DcEmpty($args['pageNumber'], 1);
    }
    if( preg_match('/:sortName|<sortName/i',$route) ){
        $args['sortName'] = DcEmpty($args['sortName'], 'info_id');
    }
    if( preg_match('/:sortOrder|<sortOrder/i',$route) ){
        $args['sortOrder'] = DcEmpty($args['sortOrder'], 'desc');
    }
    //生成链接
    return daohangUrl('daohang/filter/index', $args);
}

/**
 * 获取完整图片附件地址
 * @version 1.0.0 首次引入
 * @version 1.2.0 去掉根目录参数
 * @param string $file 必需;图片附件路径;默认：空
 * @param string $root 可选;根目录;默认：/
 * @param string $default 可选;默认图片地址;默认：空
 * @return string $string 无图片时返回默认横向图
 */
function daohangUrlImage($file='', $default='')
{
    //附件处理
    if(!$file && $default){
        $file = $default;
    }
    //空值处理
    if(!$default){
        $default = DcRoot().'public/images/x.gif';
    }
    return DcEmpty(DcUrlAttachment($file), $default);
}

/**
 * 转换为拼音格式的别名链接
 * @version 1.3.1 优化
 * @version 1.2.0 首次引入
 * @param strung $chinese 必需;中文汉字；默认:空
 * @param string $controll 必需;category|tag|detail;默认:空
 * @return string 生成的内部网址链接
 */
function daohangUrlPinyin($chinese='呆错', $controll='category')
{
    $pinyin = \daicuo\Pinyin::get($chinese, false);
    
    $result = 'javascript:;';
    
    switch ($controll)
    {
        case 'category':
            if($info = daohangCategorySlug($pinyin, true)){
                $result = daohangUrlCategory($info);
            }
        case 'tag':
            if($info = daohangTagSlug($pinyin, true)){
                $result = daohangUrlTag($info);
            }
        default:
            if($info = daohangSlug($pinyin, true)){
                $result = daohangUrlInfo($info);
            }
    }
    
    return $result;
}

/**
 * 根据网址类型返回打开窗品方式
 * @version 1.2.0 首次引入
 * @param array $info 必需;[id,name,slug]；默认：空
 * @return string 生成的内部网址链接
 */
function daohangTypeTarget($infoType='index')
{
    if( in_array($infoType, ['fast','friend','recommend','head','foot']) ){
        return '_blank';
    }
    return '_self';
}

/**
 * 根据搜索引擎名称返回打开窗品方式
 * @version 1.2.0 首次引入
 * @param string $action 必需;搜索引擎名称；默认：空
 * @return string 生成的内部网址链接
 */
function daohangSearchTarget($action='index')
{
    if(in_array($action,['index','web','mp','mini'])){
        return '_self';
    }else{
        return '_blank';
    }
}

/**
 * 根据搜索引擎名称返回打开窗品方式
 * @version 1.2.0 首次引入
 * @param string $action 必需;搜索引擎名称；默认：空
 * @return string 生成的内部网址链接
 */
function daohangDisplay($max=3,$default='d-none d-md-inline')
{
    if(in_array($action,['index','web','mp','mini'])){
        return '_self';
    }else{
        return '_blank';
    }
}

/**
 * 查询数据时limit自动处理
 * @version 1.2.0 首次引入
 * @param string $pageSize 必需;地址栏分页参数;空
 * @return string 过滤后的文本
 */
function daohangLimit($pageSize=0)
{
    $pageSize = intval($pageSize);
    $default  = DcEmpty(config('daohang.page_size'), 20);
    $pageMax  = DcEmpty(config('daohang.page_max'), 100);
    if($pageSize > $pageMax){
        return $default;
    }
    if($pageSize < 1){
        return $default;
    }
    return $pageSize;
}

/**
 * 导航模块排序字段格式化
 * @version 1.2.0 首次引入
 * @param string $sortName 必需;排序字段；默认:空
 * @param string $sortDefault 必需;默认字段；默认:info_update_time
 * @return string 生成合法的排序字段
 */
function daohangSortName($sortName='',$sortDefault='info_update_time')
{
    if( in_array($sortName,['info_up','info_down','info_id','info_order','info_views','info_hits','info_create_time','info_update_time']) ){
        return $sortName;
    }
    return $sortDefault;
}

/**
 * 导航模块排序方式格式化
 * @version 1.2.0 首次引入
 * @param string $sortName 必需;排序字段；默认:空
 * @param string $sortDefault 必需;默认字段；默认:desc
 * @return string 生成合法的排序字段
 */
function daohangSortOrder($sortOrder='',$sortDefault='desc')
{
    if( in_array($sortOrder,['desc','asc']) ){
        return $sortOrder;
    }
    return $sortDefault;
}

/**
 * 替换全站搜索引擎关键字
 * @version 1.0.0 首次引入
 * @param string $route 必需;包含待替换的关键字;空
 * @param string $pageNumber 可选;页码;空
 * @return string 过滤后的文本
 */
function daohangSeo($string='', $pageNumber=1)
{
    $search = ['[siteName]', '[siteDomain]', '[pageNumber]'];
    $replace = [config('common.site_name'), config('common.site_domain'), $pageNumber];
    return DcHtml(daohangTrim(str_replace($search, $replace, $string)));
}

/**
 * 允许的HTML标签列表
 * @version 1.2.0 首次引入
 * @param string $string 必需;待处理的字符串;默认：空
 * @return string $string 处理后的字符串
 */
function daohangStrip($string=''){
    return daohangTrim( DcStrip($string, DcEmpty(config('daohang.label_strip'),'<strong>')) );
}

/**
 * 字符串截取
 * @version 1.2.0 首次引入
 * @param string $string 必需;待截取的字符串
 * @param int $start 必需;起始位置;默认：0
 * @param int $length 必需;截取长度;默认：420
 * @param bool $suffix 可选;超出长度是否以...显示;默认：true
 * @param string $charset 可选;字符编码;默认：utf-8
 * @return string $string 截取后的字符串
 */
function daohangSubstr($string, $start=0, $length=140, $suffix=true, $charset="UTF-8"){
    return DcSubstr(DcHtml(daohangTrim($string)), $start, $length, $suffix, $charset);
}

/**
 * 过滤连续空白
 * @version 1.2.0 首次引入
 * @param string $str 待过滤的字符串
 * @return string 处理后的字符串
 */
function daohangTrim($str=''){
    $str = str_replace("　",' ',str_replace("&nbsp;",' ',trim($str)));
    $str = preg_replace('#\s+#', ' ', $str);
    return $str;
}

/**
 * 提备公安备案号
 * @version 1.2.0 首次引入
 * @param string $str 待过滤的字符串
 * @return string 处理后的字符串
 */
function daohangGongan(){
    $str = config('common.site_gongan');
    if(!is_numeric($str)){
        $str = DcPregMatch('备([0-9]+)号',$str);
    }
    return floatval($str);
}

/**
 * 获取顶级域名
 * @version 1.3.1 首次引入
 * @param string $url 必需;直链网址;默认:空
 * @return string 生成的内部网址链接
 */
function daohangTopHost($url=''){
    if(!$url){
        return '';
    }
    $url = strtolower($url);
    $hosts = parse_url($url);
    $host = $hosts['host'];
    //查看是几级域名
    $data = explode('.', $host);
    $n = count($data);
    //判断是否是双后缀
    $preg = '/[\w].+\.(com|net|org|gov|edu)\.cn$/';
    if(($n > 2) && preg_match($preg,$host)){
        //双后缀取后3位
        $host = $data[$n-3].'.'.$data[$n-2].'.'.$data[$n-1];
    }else{
        //非双后缀取后两位
        $host = $data[$n-2].'.'.$data[$n-1];
    }
    return $host;
}

/**
 * 生成直链网址安全跳转链接
 * @version 1.3.1 首次引入
 * @param string $infoReferer 必需;直链网址;默认:空
 * @return string 生成的内部网址链接
 */
function daohangReferer($infoReferer=''){
    return DcEmpty(DcHtml($infoReferer),'javascript:;');
}

/**
 * 内容模型扩展字段计数增加
 * @version 1.3.1 首次引入
 * @param int $id 必需;ID值;默认:空
 * @param string $field 必需;字段值;默认:info_views
 * @param int $numb 可选;步进值;默认:1
 * @param int $time 可选;延迟更新;默认:0
 * @return int 最新值
 */
function daohangMetaInc($id=0, $field='info_up', $num=1, $time=0){
    if(!$id){
        return 0;
    }
    return dbUpdateInc('common/infoMeta', ['info_id'=>['eq',$id],'info_meta_key'=>['eq',$field]], 'info_meta_value', $num, $time);
}

/**
 * 获取网址模型所有字段
 * @version 1.3.1 首次引入
 * @return mixed 成功时返回array,失败时null
 */
function daohangFields()
{
    $fields = array_keys(DcFields('info'));
    $fieldsMeta = daohangMetaKeys('detail',NULL);
    if(is_array($fields) && is_array($fieldsMeta)){
        return array_merge($fields, $fieldsMeta);
    }
    return null;
}

/**
 * 根据地址栏参数的扩展字段生成多条件查询参数
 * @version 1.4.1 优化
 * @version 1.3.1 首次引入
 * @param array $query 必需;地址栏请求参数;默认：空
 * @return array 适用于模型查询函数的meta_query选项
 */
function daohangMetaQuery($query=[]){
    return DcMetaQuery(daohangMetaList('detail',NULL), $query);
}

/**
 * 只获取模块的所有动态扩展字段KEY
 * @version 1.4.1 首次引入
 * @param string $controll 可选;控制器；默认:category
 * @param string $action 可选;操作名；默认:system
 * @return array 二维数组
 */
function daohangMetaKeys($controll='detail', $action='index')
{
    $args = [];
    $args['module']   = 'daohang';
    $args['controll'] = $controll;
    $args['action']   = $action;
    $keys = model('common/Field','loglic')->forms(DcArrayEmpty($args),'keys');
    return array_unique($keys);
}

/**
 * 获取模块的所有动态扩展字段列表
 * @version 1.4.1 首次引入
 * @param string $controll 可选;控制器；默认:category
 * @param string $action 可选;操作名；默认:system
 * @return array 二维数组
 */
function daohangMetaList($controll='detail', $action='index')
{
    $args = [];
    $args['module']   = 'daohang';
    $args['controll'] = $controll;
    $args['action']   = $action;
    return model('common/Field','loglic')->forms( DcArrayEmpty($args) );
}

/**
 * 验证请求是否合法（防CC、假墙功能）
 * @version 1.3.1 首次引入
 * @param string $ip 必需;客户端IP;默认：127.0.0.1
 * @param string $agent 必需;浏览器头;默认：default
 * @return bool true|false
 */
function daohangRequestCheck($ip='127.0.0.1', $agent='default'){
    //后台验证开关
    $configMax = intval(config('daohang.request_max'));
    if($configMax < 1){
        return true;
    }
    //客户端唯一标识
    $client = md5($ip.$agent);
    //60秒内最大请求次数
    $requestMax = intval(DcCache('request'.$client));
    if($requestMax > $configMax){
        return false;
    }
    DcCache('request'.$client, $requestMax+1, 300);
    //未超出限制
    return true;
}