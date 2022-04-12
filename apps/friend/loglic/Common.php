<?php
namespace app\friend\loglic;

class Common
{
    /**
    * 友链模型的字段
    * @version 1.0.0 首次引入
    * @param array $data 可选;初始数据;默认：空
    * @return array 表格列字段属性（DcBuildTable）
    */
    public function fields($data)
    {
        return [
            'info_slug' => [
                'type'            => 'hidden',
                'value'           => DcEmpty($data['info_slug'], uniqid()),
            ],
            'info_status' => [
                'type'            => 'select',
                'value'           => DcEmpty($data['info_status'],'normal'),
                'order'           => 6,
                'option'          => ['normal'=>lang('normal'), 'hidden'=>lang('hidden')],
                'title'           => lang('friend_status'),
                'data-filter'     => true,
                'data-visible'    => false,
            ],
            'info_status_text' => [
                'order'           => 6,
                'data-title'      => lang('friend_status'),
                'data-visible'    => true,
            ],
            'info_id' => [
                'type'            => 'hidden',
                'value'           => $data['info_id'],
                'order'           => 1,
                'data-title'      => lang('friend_id'),
                'data-filter'     => false,
                'data-visible'    => true,
                'data-sortable'   => true,
                'data-width'      => '60',
                'data-width-unit' => 'px',
            ],
            'info_name' => [
                'type'            => 'text',
                'value'           => $data['info_name'],
                'order'           => 2,
                'required'        => true,
                'title'           => lang('friend_name'),
                'placeholder'     => lang('friend_name_placeholder'),
                'data-title'      => lang('friend_name'),
                'data-filter'     => false,
                'data-visible'    => true,
                'data-align'      => 'left',
                'data-class'      => 'text-wrap',
                'data-width'      => '35',
                'data-width-unit' => '%',
            ],
            'friend_referer' => [
                'type'            => 'text',
                'value'           => $data['friend_referer'],
                'order'           => 3,
                'title'           => lang('friend_url'),
                'placeholder'     => lang('friend_url_placeholder'),
                'data-title'      => lang('friend_url'),
                'data-visible'    => true,
                'data-align'      => 'left',
                'data-width'      => '15',
                'data-width-unit' => '%',
            ],
            'friend_logo' => [
                'type'            => 'image',
                'value'           => $data['friend_logo'],
                'order'           => 4,
                'title'           => lang('friend_logo'),
                'placeholder'     => lang('friend_logo_placeholder'),
                'data-title'      => lang('friend_logo'),
                'data-filter'     => false,
                'data-visible'    => true,
                'data-align'      => 'left',
                'data-width'      => '15',
                'data-width-unit' => '%',
            ],
            'info_order' => [
                'type'            => 'number',
                'value'           => intval($data['info_order']),
                'order'           => 5,
                'data-visible'    => true,
                'data-sortable'   => true,
            ],
            'info_content' => [
                'type'            => 'textarea',
                'value'           => $data['info_content'],
                'order'           => 10,
                'rows'            => 5,
                'placeholder'     => '',
                'title'           => lang('friend_content'),
                'data-title'      => lang('friend_content'),
            ],
            'info_create_time' => [
                'order'           => 7,
                'data-visible'    => true,
                'data-sortable'   => true,
            ],
            'info_update_time' => [
                'order'           => 8,
                'data-visible'    => true,
                'data-sortable'   => true,
            ]
        ];
    }
}