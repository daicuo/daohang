<?php
/**
 * 将urlPid写入COOKIE中(后者推广覆盖前者)
 * @version 1.0.0 首次引入
 * @return boole 无
 */
function userPidSet(){
    $userPid = input('pid/d', 0);
    if( $userPid < 1){
        return false;
    }
    cookie('userPid', $userPid, 2592000);
    return true;
}

/**
 * 读取PID、优先urlPid
 * @version 1.0.0 首次引入
 * @return number 上级ID
 */
function userPidGet(){
    $userPid = input('pid/d', 0);
    if($userPid < 1){
        $userPid = cookie('userPid');
    }
    return intval($userPid);
}

/**
 * 返回用户模块的所有字段
 * @version 1.1.0 首次引入
 * @return array
 */
function userFields(){
    $base = array_keys(DcFields('user'));
    $plus = model('common/User','loglic')->metaKeys();
    if($plus){
        return array_merge($base,$plus);
    }else{
        return $base;
    }
}

/**
 * 返回用户模块所有的扩展字段
 * @version 1.2.1 首次引入
 * @return array
 */
function userFieldsMeta(){
    $array = array_merge(array_keys(config('custom_fields.user_meta')),config('user.meta_user'));
    return array_unique($array);
}

/**
 * 按条件获取导航菜单列表
 * @version 1.1.0 首次引入
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
 * @return mixed 查询结果obj|null
 */
function userNavbar($args=[])
{
    return DcTermNavbar($args);
}

/**
 * 通过用户ID获取用户积分
 * @version 1.3.0 首次引入
 * @param number $userId 必需;用户ID;默认:0
 * @param number $score 必需;递减值;默认:0
 * @return intval 操作结果
 */
function userScoreGet($userId=0){
    return db('userMeta')->where([
        'user_id'       => ['eq',$userId],
        'user_meta_key' => ['eq','user_score'],
    
    ])->value('user_meta_value');
}

/**
 * 用户积分递减
 * @version 1.1.0 首次引入
 * @param number $userId 必需;用户ID;默认:0
 * @param number $score 必需;递减值;默认:0
 * @return intval 操作结果
 */
function userScoreDec($userId=0,$score=0){
    $result = dbUpdateDec('common/userMeta',[
        'user_id'       => ['eq',$userId],
        'user_meta_key' => ['eq','user_score'],
    ],'user_meta_value',$score);
    //缓存处理
    if(config('cache.expire_detail') > 0 && $result){
        DcCacheTag('user_id_'.$userId, NULL);
    }
    return $result;
}

/**
 * 用户积分递增
 * @version 1.1.0 首次引入
 * @param number $userId 必需;用户ID;默认:0
 * @param number $score 必需;递减值;默认:0
 * @return intval 操作结果
 */
function userScoreInc($userId=0, $score=0){
    $result = dbUpdateInc('common/userMeta',[
        'user_id'       => ['eq',$userId],
        'user_meta_key' => ['eq','user_score'],
    ],'user_meta_value',$score);
    //缓存处理
    if(config('cache.expire_detail') > 0 && $result){
        DcCacheTag('user_id_'.$userId, NULL);
    }
    //返回结果
    return $result;
}

/**
 * 读取用户组列表（去除administator,guest）
 * @version 1.1.0 首次引入
 * @return array 用户组列表
 */
function userGroup(){
    $group = model('common/Role','loglic')->option();
    unset($group['administrator']);
    unset($group['guest']);
    unset($group['caps']);
    return $group;
}

/**
 * 读取用户组权限节点（去除积分为0的用户组)
 * @version 1.1.0 首次引入
 * @return array 用户组列表
 */
function userGroupCaps(){
    $groupCaps = DcAuthConfig();
    foreach($groupCaps as $key=>$group){
        if( intval(config('user.score_group_'.$key)) < 1){
            unset($groupCaps[$key]);
        }
    }
    return $groupCaps;
}

/**
 * 读取用户组升级对应积分（key=>value形式)
 * @version 1.1.0 首次引入
 * @return array 用户组对应积分
 */
function userGroupScore(){
    $groupScore = [];
    foreach(userGroupCaps() as $key=>$value){
        $groupScore[$key] = intval(config('user.score_group_'.$key));
    }
    return $groupScore;
}

/**
 * 按用户组获取权限节点（表格样式)
 * @version 1.1.0 首次引入
 * @return array 二维数组
 */
function userCapsTable(){
    $caps    = userGroupCaps();
    $countTr = count(max($caps));
    $tr = [];
    foreach($caps as $key=>$value){
        for($i=0;$i<$countTr;$i++){
            $tr[$i][$key] = DcEmpty($value[$i],'-');
        }
    }
    return $tr;
}

/**
 * 按权限节点获取用户组
 * @version 1.3.13 首次引入
 * @type string 节点类型;front|back;默认front
 * @return array 二维数组
 */
function userCapsRoles($type='front'){
    if($type=='back'){
        $setCaps = model('admin/Caps','loglic')->back();
    }else{
        $setCaps = model('admin/Caps','loglic')->front();
    }
    //用户角色对应的权限节点
    $userGroupCaps = DcAuthConfig();
    unset($userGroupCaps['administrator']);
    unset($userGroupCaps['guest']);
    unset($userGroupCaps['caps']);
    //拼装结果
    $result = [];
    foreach($setCaps as $key=>$value){
        foreach($userGroupCaps as $role=>$caps){
            if(in_array($value,$caps)){
                $result[$value][$role] = 1;
            }else{
                $result[$value][$role] = 0;
            }
        }
    }
    return $result;
}

/**
 * 计算人民币充值积分值
 * @version 1.1.0 首次引入
 * @return number 积分值
 */
function userRmbToScore($cny=1){
    return intval(config('user.score_recharge')) * $cny;
}

/**
 * 积分值转换成人民币
 * @version 1.3.0 首次引入
 * @return number 积分值
 */
function userScoreToRmb($score=100){
    return floatval($score / intval(config('user.score_recharge')));
}