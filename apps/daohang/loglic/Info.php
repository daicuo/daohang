<?php
namespace app\daohang\loglic;

class Info 
{
    /**
    * 定义网站的字段
    * @version 1.3.1 优化
    * @version 1.0.0 首次引入
    * @param array $data 可选;初始数据;默认：空
    * @return array 表格列字段属性（DcBuildTable）
    */
    public function fields($data)
    {
        $categorys = DcTermCheck([
            'module' => ['eq','daohang'],
            'action' => ['in',['index','channel']],
        ]);
        $fields = [
            'html_1' => [
                'order'           => 0,
                'type'            => 'html',
                'value'           => '<div class="row"><div class="col-12 col-md-1 order-1">',
                'data-filter'     => false,
                'data-visible'    => false,
            ],
            'info_ation' => [
                'order'           => 0,
                'type'            => 'hidden',
                'value'           => 'index',
            ],
            'info_controll' => [
                'order'           => 0,
                'type'            => 'hidden',
                'value'           => 'detail',
            ],
            'info_module' => [
                'order'           => 0,
                'type'            => 'hidden',
                'value'           => 'daohang',
            ],
            'info_user_id' => [
                'order'           => 0,
                'type'            => 'hidden',
                'value'           => DcUserCurrentGetId(),
            ],
            'category_id' => [
                'order'           => 0,
                'type'            => 'checkbox',
                'value'           => $data['category_id'],
                'option'          => $categorys,
                'title'           => lang('category'),
                'class_right'     => 'col-12 pre-scrollable',
                'data-filter'     => true,
                'data-type'       => 'select',
                'data-option'     => $this->dataOption($categorys),
            ],
            'category_names' => [
                'order'           => 4,
                'data-title'      => lang('dh_category_id'),
                'data-visible'    => true,
                'data-width'      => 150,
                'data-class'      => 'text-wrap',
                'data-align'      => 'left',
            ],
            'html_2' => [
                'order'           => 0,
                'type'            => 'html',
                'value'           => '</div><div class="col-12 col-md-8 order-2">',
            ],
            'info_id' => [
                'order'           => 1,
                'type'            => 'hidden',
                'value'           => $data['info_id'],
                'data-visible'    => true,
                'data-title'      => 'id',
                'data-sortable'   => true,
                'data-width'      => 80,
            ],
            'info_name' => [
                'order'           => 2,
                'type'            => 'text',
                'value'           => $data['info_name'],
                'data-visible'    => true,
                'data-escape'     => true,
                'data-class'      => 'text-wrap',
                'data-align'      => 'left',
            ],
            'info_slug' => [
                'order'           => 0,
                'type'            => 'text',
                'value'           => $data['info_slug'],
            ],
            'info_referer' => [
                'order'           => 3,
                'type'            => 'text',
                'value'           => $data['info_referer'],
                'title'           => lang('dh_info_referer'),
                'placeholder'     => lang('dh_info_referer_tips'),
                'data-visible'    => true,
                'data-escape'     => true,
                'data-class'      => 'text-wrap',
                'data-align'      => 'left',
                'data-title'      => lang('dh_info_referer'),
            ],
            'tag_name' => [
                'order'           => 0,
                'type'            => 'tags',
                'value'           => implode(',',$data['tag_name']),
                'option'          => daohangTags(10),
                'title'           => lang('dh_tag_name'),
                'placeholder'     => '',
                'class_tags'      => 'form-text pt-1',
                'class_tags_list' => 'text-purple mr-2',
            ],
            'info_excerpt' => [
                'order'           => 0,
                'type'            => 'textarea',
                'value'           => $data['info_excerpt'],
                'rows'            => 3,
            ],
            'info_content' => [
                'order'           => 0,
                'type'            => 'editor',
                'value'           => $data['info_content'],
                'rows'            => 20,
                'height'          => '20rem',
            ],
            'info_title' => [
                'order'           => 0,
                'type'            => 'text',
                'value'           => $data['info_title'],
            ],
            'info_keywords' => [
                'order'           => 0,
                'type'            => 'text',
                'value'           => $data['info_keywords'],
            ],
            'info_description' => [
                'order'           => 0,
                'type'            => 'text',
                'value'           => $data['info_description'],
            ],
            'html_3' => [
                'order'           => 0,
                'type'            => 'html',
                'value'           => '</div><div class="col-12 col-md-3 order-3">',
            ],
            'info_status' => [
                'order'           => 0,
                'type'            => 'select',
                'value'           => $data['info_status'],
                'option'          => ['normal'=>lang('normal'),'hidden'=>lang('hidden')],
                'data-filter'     => true,
            ],
            'info_status_text' => [
                'order'           => 5,
                'data-visible'    => true,
                'data-title'      => lang('info_status'),
                'data-width'      => 90,
            ],
            'info_type' => [
                'order'           => 6,
                'type'            => 'select',
                'value'           => DcEmpty($data['info_type'],'index'),
                'option'          => daohangTypeOption(),
                'title'           => lang('dh_type'),
                'data-filter'     => true,
            ],
            'info_type_text' => [
                'order'           => 7,
                'data-visible'    => true,
                'data-title'      => lang('dh_type'),
                'data-width'      => 90,
            ],
            'info_color' => [
                'order'           => 0,
                'type'            => 'select',
                'value'           => $data['info_color'],
                'title'           => lang('dh_color'),
                'option'          => [
                    'text-dark'      => 'text-dark',
                    'text-danger'    => 'text-danger',
                    'text-success'   => 'text-success',
                    'text-primary'   => 'text-primary',
                    'text-info'      => 'text-info',
                    'text-secondary' => 'text-secondary',
                    'text-muted'     => 'text-muted',
                    'text-light'     => 'text-light',
                ],
            ],
            'image_ico' => [
                'order'           => 0,
                'type'            => 'image',
                'value'           => $data['image_ico'],
                'title'           => lang('dh_image_ico'),
                'placeholder'     => lang('dh_image_ico_tips'),
            ],
            'image_level' => [
                'order'           => 0,
                'type'            => 'image',
                'value'           => $data['image_level'],
                'title'           => lang('dh_image_level'),
                'placeholder'     => lang('dh_image_level_tips'),
            ],
            'info_tpl' => [
                'order'           => 0,
                'type'            => 'text',
                'value'           => $data['info_tpl'],
            ],
            'info_order' => [
                'order'           => 8,
                'type'            => 'number',
                'value'           => intval($data['info_order']),
                'order'           => 93,
                'data-sortable'   => true,
                'data-visible'    => true,
                'data-width'      => 80,
            ],
            'info_views' => [
                'order'           => 9,
                'type'            => 'number',
                'value'           => intval($data['info_views']),
                'data-sortable'   => true,
                'data-visible'    => true,
                'data-width'      => 80,
            ],
            'info_hits' => [
                'order'           => 10,
                'type'            => 'number',
                'value'           => intval($data['info_hits']),
                'data-sortable'   => true,
                'data-visible'    => true,
                'data-width'      => 80,
            ],
            'info_up' => [
                'order'           => 11,
                'type'            => 'number',
                'value'           => intval($data['info_up']),
                'title'           => lang('dh_up'),
                'data-sortable'   => true,
                'data-visible'    => true,
                'data-title'      => lang('dh_up'),
                'data-width'      => 80,
            ],
            'info_down' => [
                'order'           => 12,
                'type'            => 'number',
                'value'           => intval($data['info_down']),
                'title'           => lang('dh_down'),
                'order'           => 97,
                'data-sortable'   => true,
                'data-visible'    => true,
                'data-title'      => lang('dh_down'),
                'data-width'      => 80,
            ],
            'info_domain' => [
                'order'           => 0,
                'type'            => 'text',
                'value'           => $data['info_domain'],
                'title'           => lang('dh_info_domain'),
                'placeholder'     => lang('dh_info_domain_tips'),
            ],
            'info_unique' => [
                'order'           => 0,
                'type'            => 'text',
                'value'           => $data['info_unique'],
                'title'           => lang('dh_info_unique'),
                'placeholder'     => lang('dh_info_unique_tips'),
            ],
            'user_name' => [
                'order'           => 98,
                'data-visible'    => true,
                'data-escape'     => true,
                'data-width'      => 100,
            ],
            'info_update_time' => [
                'order'           => 99,
                'data-sortable'   => true,
                'data-visible'    => true,
                'data-width'      => 120,
            ],
            'html_4' => [
                'order'           => 0,
                'type'            => 'html',
                'value'           => '</div></div>',
            ]
        ];
        //动态扩展字段（可精确到操作名）
        $customs = daohangMetaList('detail', 'index');
        //合并所有字段
        if($customs){
            $fields = DcArrayPush($fields, DcFields($customs, $data), 'html_3');
        }
        //返回所有表单字段
        return $fields;
    }
    
    //快审发布网站的表单字段
    public function fastFields()
    {
        $items  = [
            'info_name' => [
                'type'      => 'text',
                'maxlength' => '250',
                'required'  => true,
                'placeholder' => lang('dh_info_name_tips'),
            ],
            'info_referer' => [
                'type'      => 'text',
                'maxlength' => '250',
                'required'  => true,
                'placeholder' => lang('dh_info_referer_tips'),
            ],
            'image_ico' => [
                'type'        => 'image',
                'placeholder' => lang('dh_image_ico_tips'),
            ],
            'image_level' => [
                'type'        => 'image',
                'placeholder' => lang('dh_image_level_tips'),
            ],
            'info_excerpt' => [
                'type'        => 'text',
                'placeholder' => lang('dh_info_excerpt_tips'),
            ],
            'info_content' => [
                'type'        => 'textarea',
                'rows'        => 3,
                'placeholder' => lang('dh_info_content_tips'),
            ],
            /*
            'tag_name' => [
                'type'        => 'tags',
                'option'      => daohangTags(10),
                'placeholder' => '',
            ],*/
            'category_id'   => [
                'type'      => 'checkbox',
                'multiple'  => true,
                'size'      => 15,
                'option'    => model('daohang/Term','loglic')->categoryOption(),
                'class_right'         => 'col-12 col-md-10 row',
                'class_right_check'   => 'col-4 col-md-2 form-check form-check-inline pl-3 mr-0 mb-1',
            ],
        ];
        
        foreach($items as $key=>$value){
            $items[$key]['title']       = lang('dh_'.$key);
            if(!isset($value['class_left'])){
                $items[$key]['class_left'] = 'col-12 col-md-2';
            }
            if(!isset($value['class_right'])){
                $items[$key]['class_right'] = 'col-12 col-md-10';
            }
        }
        
        return $items;
    }
    
    //初始筛选的option
    private function dataOption($array=[])
    {
        $array[0] = '------';
        return $array;
    }
}