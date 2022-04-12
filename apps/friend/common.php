<?php
/**
 * 添加一条友链
 * @version 1.0.0 首次引入
 * @param array $post 必需;数组格式,支持的字段列表请参考手册
 * @return mixed 成功时返回obj,失败时null
 */
function friendSave($post=[])
{
    $post = DcArrayArgs($post,[
        'info_module'   => 'friend',
        'info_controll' => 'detail',
        'info_action'   => 'index',
        'info_status'    => 'hidden',
    ]);
    
    return model('common/Info','loglic')->write($post,'friend/Common','save',false);
}

/**
 * 按ID删除一条或多条友链
 * @version 1.0.0 首次引入
 * @param mixed $ids 必需;多个用逗号分隔或使用数组传入(array|string);默认：空 
 * @return array ID作为键名,键值为删除结果(bool)
 */
function friendDelete($ids=[])
{
    $result = [];
    if(is_string($ids)){
        $ids = explode(',', $ids);
    }
    foreach($ids as $key=>$id){
        $result[$id] = \daicuo\Info::delete(['info_id'=>['eq',$id]],'info_meta');
    }
    return $result;
}

/**
 * 修改一篇友链(需传入主键值作为更新条件)
 * @version 1.0.0 首次引入
 * @param array $post 必需;表单字段 {
 *     @type int $info_id 必需;按ID修改;默认：空
 * }
 * @param bool $autoSave 可选;当分类与标签不存在时是否自动新增;默认:false
 * @return mixed 成功时返回obj,失败时null
 */
function friendUpdate($post=[])
{
    $post = DcArrayArgs($post,[
        'info_module'   => 'friend',
        'info_controll' => 'detail',
        'info_action'   => 'index',
        'info_status'   => 'hidden',
    ]);

    return model('common/Info','loglic')->write($post, 'friend/Common', 'update', false);
}

/**
 * 按条件查询多条友链数据
 * @version 1.0.0 首次引入
 * @param array $args 必需;查询条件数组格式 {
 *     @type bool $cache 可选;是否缓存;默认：true
 *     @type string $result 可选;返回结果类型(array|obj);默认：array
 *     @type string $field 可选;查询字段;默认：*
 *     @type string $status 可选;显示状态（normal|hidden|private）;默认：空
 *     @type string $limit 可选;分页大小;默认：0
 *     @type string $page 可选;当前分页;默认：0
 *     @type string $sort 可选;排序字段名(info_id|info_order|info_views|info_hits|meta_value_num);默认：info_id
 *     @type string $order 可选;排序方式(asc|desc);默认：asc
 *     @type string $search 可选;搜索关键词（info_name|info_slug|info_excerpt）;默认：空
 *     @type mixed $id 可选;内容ID限制条件(int|array);默认：空
 *     @type mixed $title 可选;标题限制条件(stirng|array);默认：空
 *     @type mixed $name 可选;名称限制条件(stirng|array);默认：空
 *     @type mixed $slug 可选;别名限制条件(stirng|array);默认：空
 *     @type mixde $action 可选;所属操作名(stirng|array);默认：空
 *     @type mixde $controll 可选;所属控制器(stirng|array);默认：空
 *     @type mixed $term_id 可选;分类法ID限制条件(string|array);默认：空
 *     @type array $meta_query 可选;自定义字段(二维数组[key=>['eq','key'],value=>['in','key']]);默认：空
 *     @type array $with 可选;自定义关联查询条件;默认：空
 *     @type array $view 可选;自定义视图查询条件;默认：空
 *     @type array $where 可选;自定义高级查询条件;默认：空
 *     @type array $paginate 可选;自定义高级分页参数;默认：空
 * }
 * @return mixed 查询结果（array|null）
 */
function friendSelect($args)
{
    $args = DcArrayArgs($args,[
        'cache'    => true,
        'result'   => 'array',
        'module'   => 'friend',
    ]);
    return model('common/Info','loglic')->select($args);
}

/**
 * 按条件查询一条友链
 * @version 1.0.0 首次引入
 * @param array $args 必需;查询条件数组格式 {
 *     @type bool $cache 可选;是否缓存;默认：true
 *     @type string $status 可选;显示状态（normal|hidden）;默认：空
 *     @type mixed $id 可选;内容ID(stirng|array);默认：空
 *     @type mixed $name 可选;内容名称(stirng|array);默认：空
 *     @type mixed $slug 可选;内容别名(stirng|array);默认：空
 *     @type mixed $title 可选;内容别名(stirng|array);默认：空
 *     @type mixed $user_id 可选;用户ID(stirng|array);默认：空
 *     @type array $with 可选;自定义关联查询条件;默认：空
 *     @type array $view 可选;自定义视图查询条件;默认：空
 *     @type array $where 可选;自定义高级查询条件;默认：空
 * }
 * @return mixed 查询结果（array|null）
 */
function friendGet($args)
{
    $args = DcArrayArgs($args,[
        'cache'    => true,
        'module'   => 'friend',
        'status'   => 'normal',
        //'id'     => $value,
        //'slug'   => $value,
        //'name'   => $value,
    ]);
    
    $args = DcArrayEmpty($args);
    
    return model('common/Info','loglic')->get($args);
}

/**
 * 智能转换内部与外部网址链接
 * @version 1.0.0 首次引入
 * @param string $url 必需;待验证的网址;默认：空
 * @return string 转换后的链接
 */
function friendUrl($url='')
{
    //默认值
    $url = DcEmpty($url, 'friend/index/index');
    //分解地址栏
    $array = parse_url($url);
    if($array['scheme']){
        return $url;
    }
    //内部链接
    return DcUrl($array['path'], $array['query'], '');
}

/**
 * 按条件获取导航菜单列表
 * @version 1.0.0 首次引入
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
function friendNavbar($args=[])
{
    return model('common/Navs','loglic')->select($args);
}