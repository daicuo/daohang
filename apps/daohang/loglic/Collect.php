<?php
namespace app\daohang\loglic;

class Collect
{
    protected $error = 'error';
    
    /**
     * 新增或修改一个采集
     * @version 1.3.1 首次引入
     * @param array $posts 必需;参考默认字段;默认：空
     * @return mixed 查询结果obj|null
     */
    public function write($post=[])
    {
        if(!$post['collect_name'] || !$post['collect_url']){
            $this->error = '名称与地址必须输入';
            return 0;
        }
        //取消验证规则
        config('common.validate_name', false);
        //写入数据
        $data = [];
        $data['op_name']     = $post['collect_name'];
        $data['op_module']   = 'daohang';
        $data['op_controll'] = 'collect';
        $data['op_action']   = 'api';
        $data['op_order']    = 0;
        $data['op_autoload'] = 'no';
        $data['op_status']   = 'normal';
        $data['op_value']    = [
            'collect_url'      => $post['collect_url'],
            'collect_token'    => $post['collect_token'],
            'collect_category' => $this->categorySet($post['collect_category']),
        ];
        //修改
        if($post['collect_id']){
            return \daicuo\Op::update_id($post['collect_id'], $data);
        }
        //新增
        return \daicuo\Op::save($data);
    }

    /**
     * 查询单个采集规则
     * @version 1.3.1 首次引入
     * @param array $args 必需;查询参数;默认：空
     * @return mixed 查询结果obj|null
     */
    public function get($args=[])
    {
        $args = DcArrayArgs($args,[
            'cache'    => false,
            'model'    => 'daohang',
            'controll' => 'collect',
            'action'   => 'api',
        ]);
        return $this->dataGet( model('common/Config','loglic')->get($args) );
    }
    
    /**
     * 查询多个采集规则
     * @version 1.3.1 首次引入
     * @param array $args 必需;查询参数;默认：空
     * @return mixed 查询结果obj|null
     */
    public function select($args=[]){
        $args = DcArrayArgs($args,[
            'cache'    => false,
            'model'    => 'daohang',
            'controll' => 'collect',
            'action'   => 'api',
        ]);
        $item = [];
        foreach(model('common/Config','loglic')->select($args) as $key=>$value){
            $item[$key] = $value['op_value'];
            $item[$key]['collect_name'] = $value['op_name'];
            $item[$key]['collect_id']   = $value['op_id'];
            $item[$key]['collect_categoryBind'] = $this->categoryGet($value['op_value']['collect_category']);
        }
        return $item;
    }
    
    /**
    * 数据获取器
    * @version 1.3.1 首次引入
    * @param array $value 必需;OP表的数据;默认：空
    * @return array 转换成collect字段
    */
    public function dataGet($value=[])
    {
        $result = $value['op_value'];
        $result['collect_name'] = $value['op_name'];
        $result['collect_id']   = $value['op_id'];
        $result['collect_categoryBind'] = $this->categoryGet($value['op_value']['collect_category']);
        return $result;
    }
    
    /**
    * 栏目分类名称转换定义
    * @version 1.3.1 首次引入
    * @param string $string 可选;分类转换关系/一行一个;默认：空
    * @return array keyValue形式的对应关系
    */
    public function categorySet($string=''){
        $result = [];
        foreach(explode(chr(10),$string) as $key=>$value){
            list($old,$new) = explode('=>',trim($value));
            if($old && $new){
                $result[$old] = $new;
            }
        }
        return $result;
    }
    
    /**
    * 栏目分类名称还原成字符
    * @version 1.3.1 首次引入
    * @param string $string 可选;分类转换关系/一行一个;默认：空
    * @return array keyValue形式的对应关系
    */
    public function categoryGet($array=[]){
        $result = [];
        foreach($array as $key=>$value){
            array_push($result,$key.'=>'.$value);
        }
        return $result;
    }
    
    /**
    * 获取资源站分类接口
    * @version 1.3.1 首次引入
    * @param string $url 必需;定义的资源站接口;默认：空
    * @return mixed array|null 
    */
    public function apiCategory($url='', $token='')
    {
        $url = $this->apiUrl($url, 'category', $token);
        $json = json_decode(DcCurl('auto', 30, $url), true);
        $this->error = DcEmpty($json['msg'],lang('dh_collect_error_404'));
        return $json['data'];
    }
    
    /**
    * 获取资源站内容列表接口
    * @version 1.3.1 首次引入
    * @param string $url 必需;定义的资源站接口;默认：空
    * @return mixed array|null 
    */
    public function apiDetail($url='', $token='', $args=[])
    {
        $query = [
            'time'       => $args['time'],
            'termId'     => $args['termId'],
            'pageNumber' => $args['pageNumber'],
            'sortOrder'  => $args['sortOrder'],
        ];
        $url = $this->apiUrl($url, 'detail', $token).'&'.http_build_query($query);
        $json = json_decode(DcCurl('auto', 30, $url), true);
        $this->error = DcEmpty($json['msg'],lang('dh_collect_error_404'));
        return $json['data'];
    }
    
    /**
    * 获取资源站内容接口
    * @version 1.3.1 首次引入
    * @param string $url 必需;定义的资源站接口;默认：空
    * @return mixed array|null 
    */
    public function apiIndex($url='', $token='', $id=1)
    {
        $url = $this->apiUrl($url, 'index', $token).'&id='.$id;
        $json = json_decode(DcCurl('auto', 30, $url), true);
        $this->error = DcEmpty($json['msg'],lang('dh_collect_error_404'));
        return $json['data'];
    }
    
    /**
    * 解析API接口地址
    * @version 1.3.1 首次引入
    * @param string $url 必需;初始数据;默认：空
    * @param string $action 必需;category|detail|index;默认：空
    * @param string $token 可选;令牌值;默认：空
    * @return url 合并后的API地址
    */
    public function apiUrl($url='', $action='category', $token='')
    {
        $url = parse_url($url);
        //解析URL
        if($url['port']){
            $apiUrl = $url['scheme'].'://'.$url['host'].':'.$url['port'].$url['path'];
        }else{
            $apiUrl = $url['scheme'].'://'.$url['host'].$url['path'];
        }
        //参数合并
        if($url['host'] == 'api.daicuo.cc'){
            $query = $action.'/?token='.DcEmpty($token,config('common.site_token'));
        }else{
            $query = '?s=daohang/data/'.$action.'&token='.DcEmpty($token,config('common.site_token'));
        }
        if($url['query']){
            $query .= '&'.$url['query'];
        }
        return $apiUrl.$query;
    }
    
    /**
    * 验证是否是否已采集
    * @version 1.3.1 首次引入
    * @param string $cmsRefer 必需;来源标识;默认：空
    * @return bool
    */
    public function apiUnique($infoUnique='')
    {
        //无数据直接pase
        if(!$infoUnique){
            $this->error = '无来源';
            return false;
        }
        //查询来源
        $where = array();
        $where['info_meta_key']   = ['eq','info_unique'];
        $where['info_meta_value'] = ['eq',$infoUnique];
        $infoMetaId = db('infoMeta')->where($where)->value('info_meta_id');
        if($infoMetaId){
            $this->error = '来源已存在，不需要重新采集';
            return false;
        }
        return true;
	}
    
    /**
     * 采集入库一篇文章
     * @version 1.2.4 首次引入
     * @param array $post 必需;数组格式,支持的字段列表请参考手册
     * @param array $collectCategory 可选;转换分类规则,支持的字段列表请参考手册
     * @return int 返回自增ID或0
     */
    public function apiSave($post=[],$collectCategory=[])
    {
        //必要条件
        if(!$post['info_name']){
            $this->error = '标题必需填写';
            return 0;
        }
        //转换分类
        if($collectCategory){
            foreach($post['category_name'] as $key=>$termName){
                if($collectCategory[$termName]){
                    $post['category_name'][$key] = $collectCategory[$termName];
                }
            }
        }
        //格式化数据
        unset($post['info_module']);
        unset($post['info_controll']);
        unset($post['info_action']);
        unset($post['info_create_time']);
        unset($post['info_update_time']);
        unset($post['info_category_id']);
        unset($post['info_tag_id']);
        unset($post['category_slug']);
        unset($post['tag_slug']);
        $post = DcArrayArgs($post,[
            'info_module'   => 'daohang',
            'info_controll' => 'detail',
            'info_action'   => 'index',
            'info_staus'    => 'normal',
            'info_type'     => 'index',
            'info_user_id'  => 1,
        ]);
        $post = daohangPostData($post, 'yes');
        
        config('common.validate_name', false);

        config('common.validate_scene', false);

        config('common.where_slug_unique', false);

        config('custom_fields.info_meta',daohangMetaKeys('detail',NULL));

        return \daicuo\Info::save($post, 'info_meta,term_map');
    }
    
    /**
    * 定义采集模型的字段
    * @version 1.3.1 首次引入
    * @param array $data 可选;初始数据;默认：空
    * @return array 表格列字段属性（DcBuildTable）
    */
    public function fields($data=[])
    {
        return [
            'collect_id' => [
                'order'           => 1,
                'type'            => 'hidden',
                'value'           => $data['collect_id'],
            ],
            'collect_name' => [
                'order'           => 2,
                'type'            => 'text',
                'value'           => $data['collect_name'],
                'title'           => lang('dh_collect_name'),
                'data-filter'     => false,
                'data-visible'    => true,
                'data-align'      => 'left',
                'data-class'      => 'text-wrap',
            ],
            'collect_url' => [
                'order'           => 3,
                'type'            => 'text',
                'value'           => $data['collect_url'],
                'title'           => lang('dh_collect_url'),
                'placeholder'     => lang('dh_collect_url_tips'),
                'data-filter'     => false,
                'data-visible'    => true,
                'data-align'      => 'left',
                'data-class'      => 'text-wrap',
            ],
            'collect_token' => [
                'order'           => 4,
                'type'            => 'text',
                'value'           => $data['collect_token'],
                'title'           => lang('dh_collect_token'),
                'placeholder'     => lang('dh_collect_token_tips'),
                'data-filter'     => false,
                'data-visible'    => true,
                'data-align'      => 'left',
                'data-class'      => 'text-wrap',
            ],
            'collect_category' => [
                'order'           => 5,
                'type'            => 'textarea',
                'value'           => implode(chr(10),$data['collect_categoryBind']),
                'rows'            => 10,
                'title'           => lang('dh_collect_category'),
                'placeholder'     => lang('dh_collect_category_tips'),
                'data-filter'     => false,
                'data-visible'    => true,
                'data-align'      => 'left',
                'data-class'      => 'text-wrap',
            ],
        ];
    }
    
    /**
     * 获取错误信息
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }
}