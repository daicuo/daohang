<?php
namespace app\pay\loglic;

class Common
{
    protected $error = '';
    
    //获取错误信息
    public function getError()
    {
        return $this->error;
    }
    
    /**
     * 自动获取表单字段基本格式
     * @param array $where 删除条件
     * @return array 基础格式的表单字段
     */
    public function fields($data)
    {
        $fields = DcFields('pay', $data);
        //对字段做表单与表格格式化修改
        foreach($fields as $key=>$value){
            if(in_array($key,['pay_id','pay_sign','pay_number','pay_user_id','pay_price','pay_quantity','pay_status','pay_module','pay_controll','pay_action','pay_scene','pay_platform','pay_total_fee','pay_update_time'])){
                //是否显示表格列
                $fields[$key]['data-visible'] = true;
                //是否显示筛选
                if(in_array($key,['pay_id','pay_update_time','pay_price','pay_quantity','pay_total_fee'])){
                    $fields[$key]['data-filter'] = false;
                }else{
                    $fields[$key]['data-filter']  = true;
                }
                //是否显示排序
                if(!in_array($key,['pay_sign','pay_number','pay_module','pay_controll','pay_action','pay_scene','pay_platform'])){
                    $fields[$key]['data-sortable'] = true;
                }else{
                    $fields[$key]['data-sortable'] = false;
                }
            }else{
                $fields[$key]['data-visible'] = false;
                $fields[$key]['data-filter']  = false;
            }
            //字段个性化
            $fields[$key]['placeholder'] = '';
            if(in_array($key,['pay_content'])){
                $fields[$key]['type'] = 'textarea';
                $fields[$key]['rows'] = '3';
            }
            if(in_array($key,['pay_id'])){
                $fields[$key]['data-width'] = 80;
            }
        }
        return $fields;
    }
    
    /**
     * 生成订单并返回所有订单信息
     * @param int $payId 订单ID
     * @param bool $cache 是否开启缓存功能 由后台统一配置
     * @param string $with 预关联查询字段 orders_user,orders_goods
     * @return array|null 不为空时返回修改后的数据
     */
    public function createOrder($post=[])
    {
        $post = DcArrayArgs($post,[
            'pay_name'       => 'rechargeScore',
            'pay_sign'       => payCreateSign(),
            'pay_info_id'    => 1,
            'pay_user_id'    => 1,
            'pay_price'      => 0,
            'pay_quantity'   => 1,
            'pay_total_fee'  => 0,
            'pay_status'     => 1,
            'pay_module'     => 'user',
            'pay_controll'   => 'recharge',
            'pay_action'     => 'score',
            'pay_scene'      => 'pc',
            'pay_platform'   => 'alipay',
            'pay_content'    => '---',
        ]);
        $post['pay_id'] = $this->save($post);
        return $post;
    }
    
    /**
     * 按ID查询一条订单
     * @param int $payId 订单ID
     * @param bool $cache 是否开启缓存功能 由后台统一配置
     * @param string $with 预关联查询字段 orders_user,orders_goods
     * @return array|null 不为空时返回修改后的数据
     */
    public function getId($payId=0, $cache=false){
        if ( !$payId ) {
            return null;
        }
        return $this->get([
            'cache' => $cache,
            'where' => ['pay_id'=>['eq', $payId]],
        ]);
    }
    
    /**
     * 按Id修改一条订单
     * @param string $value 字段值
     * @param array $data 写入数据（一维数组） 
     * @return obj|null 不为空时返回obj
     */
    public function updateId($payId=0, $data=[])
    {
        if ( ! $data ) {
            return null;
        }
        if($payId < 1){
            return null;
        }
        $where = array();
        $where['pay_id'] = ['eq', $payId];
        return $this->update($where, $data);
    }
    
    // 创建订单
    public function save($data)
    {
        return DcDbSave('pay/Pay', $data);
    }
    
    /**
     * 按条件删除一条订单
     * @param array $where 删除条件
     * @return int 返回操作记录
     */
    public function delete($where)
    {
        return DcDbDelete('pay/Pay', $where);
    }
    
    /**
     * 修改一个订单
     * @param array $where 修改条件
     * @param array $data 写入数据（一维数组） 
     * @return null|obj 不为空时返回obj
     */
    public function update($where, $data)
    {
        return DcDbUpdate('pay/Pay', $where, $data);
    }
    
    /**
     * 按条件查询一个订单
     * @param array $args 查询参数
     * @return mixed obj|null
     */
    public function get($args)
    {
        //格式验证
        if(!is_array($args)){
            return null;
        }
        //初始参数
        $args = DcArrayArgs($args, [
            'cache'     => true,
            'field'     => '',
            'fetchSql'  => false,
            'where'     => '',
            'with'      => 'pay_user',
            'view'      => '',
        ]);
        //返回结果
        return $this->data_array( DcDbFind('pay/Pay', $args) );
    }
    
    /**
     * 按条件查询多个内容模型
     * @param array $args 查询条件（一维数组）
     * @return obj|null 成功时返回obj
     */
    public function all($args)
    {
        //格式验证
        if(!is_array($args)){
            return null;
        }
        //分页处理
        if($args['limit'] && $args['page']){
            $args['paginate'] = [
                'list_rows' => $args['limit'],
                'page' => $args['page'],
            ];
            unset($args['limit']);
            unset($args['page']);
        }//参数初始化
        $args = array_merge([
            'cache'     => true,
            'field'     => '*',
            'fetchSql'  => false,
            'sort'      => 'pay_id',
            'order'     => 'desc',
            'paginate'  => '',
            'where'     => '',
            'with'      => 'pay_user',
        ], $args);
        //查询数据
        return DcDbSelect('pay/Pay', $args);
    }
    
    /**
     * 获取器、合并关联数据
     * @param array $data 表单数据
     * @param string|array $relation 关联表 
     * @return array|null 关联写入数据格式
     */
    public function data_array($data)
    { 
        if(is_null($data)){
            return null;
        }
        if(is_object($data)){
            $data = $data->toArray();
        }
        //预加载
        if($users= $data['pay_user']){
            unset($data['pay_user']);
            $data = array_merge($data,$users);
        }
        return $data;
    }
}