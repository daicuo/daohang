<?php
namespace app\adsense\loglic;

class Datas
{
    //批量添加后台菜单
    public function insertMenu()
    {
        $result = model('common/Menu','loglic')->install([
            [
                'term_name'   => '广告',
                'term_slug'   => 'adsense',
                'term_info'   => 'fa-cny',
                'term_module' => 'adsense',
            ],
        ]);
        
        $result = model('common/Menu','loglic')->install([
            [
                'term_name'   => '广告管理',
                'term_slug'   => 'adsense/admin/index',
                'term_info'   => 'fa-list',
                'term_module' => 'adsense',
                'term_order'  => 9,
            ],
            [
                'term_name'   => '广告联盟',
                'term_slug'   => 'adsense/union/index',
                'term_info'   => 'fa-gear',
                'term_module' => 'adsense',
                'term_order'  => 8,
            ],
        ],'广告');
    }
    
    //安装与升级共用脚本
    public function insertData()
    {
        //默认广告
        $data = [
            [
                'info_slug'    => 'doubiText',
                'info_name'    => '抖币充值文字广告',
                'info_module'  => 'adsense',
                'info_controll'=> 'index',
                'info_action'  => 'text',
                'web' => [
                    'text' => [
                        'title' => '抖币优惠充值，最低8折',
                        'link'  => '/adsense/chongzhi/doubi/',
                        'class' => 'text-danger',
                        'size'  => '',
                    ]
                ],
                'mobile' => [
                    'text' => [
                        'title' => '抖币优惠充值，最低8折',
                        'link'  => '/adsense/chongzhi/doubi/',
                        'class' => 'text-danger',
                        'size'  => '',
                    ]
                ]
            ],
            [
                'info_slug'    => 'doubi250250',
                'info_name'    => '抖币充值图片广告250*250',
                'info_module'  => 'adsense',
                'info_controll'=> 'index',
                'info_action'  => 'image',
                'web' => [
                    'image' => [
                        'src'    => 'https://cdn.daicuo.cc/youdu/douyin/250250.png',
                        'link'   => '/adsense/chongzhi/doubi/',
                        'alt'    => '抖币优惠充值，最低8折',
                        'class'  => '',
                        'width'  => '250px',
                        'height' => '250px',
                    ]
                ],
                'mobile' => [
                    'image' => [
                        'src'    => 'https://cdn.daicuo.cc/youdu/douyin/250250.png',
                        'link'   => '/adsense/chongzhi/doubi/',
                        'alt'    => '抖币优惠充值，最低8折',
                        'class'  => '',
                        'width'  => '250px',
                        'height' => '250px',
                    ]
                ]
            ],
            [
                'info_slug'    => 'doubi300250',
                'info_name'    => '抖币充值图片广告300*250',
                'info_module'  => 'adsense',
                'info_controll'=> 'index',
                'info_action'  => 'image',
                'web' => [
                    'image' => [
                        'src'    => 'https://cdn.daicuo.cc/youdu/douyin/300250.png',
                        'link'   => '/adsense/chongzhi/doubi/',
                        'alt'    => '抖币优惠充值，最低8折',
                        'class'  => '',
                        'width'  => '300px',
                        'height' => '250px',
                    ]
                ],
                'mobile' => [
                    'image' => [
                        'src'    => 'https://cdn.daicuo.cc/youdu/douyin/300250.png',
                        'link'   => '/adsense/chongzhi/doubi/',
                        'alt'    => '抖币优惠充值，最低8折',
                        'class'  => '',
                        'width'  => '300px',
                        'height' => '250px',
                    ]
                ]
            ],
            [
                'info_slug'    => 'doubi300300',
                'info_name'    => '抖币充值图片广告300*300',
                'info_module'  => 'adsense',
                'info_controll'=> 'index',
                'info_action'  => 'image',
                'web' => [
                    'image' => [
                        'src'    => 'https://cdn.daicuo.cc/youdu/douyin/300300.png',
                        'link'   => '/adsense/chongzhi/doubi/',
                        'alt'    => '抖币优惠充值，最低8折',
                        'class'  => '',
                        'width'  => '300px',
                        'height' => '300px',
                    ]
                ],
                'mobile' => [
                    'image' => [
                        'src'    => 'https://cdn.daicuo.cc/youdu/douyin/300300.png',
                        'link'   => '/adsense/chongzhi/doubi/',
                        'alt'    => '抖币优惠充值，最低8折',
                        'class'  => '',
                        'width'  => '300px',
                        'height' => '300px',
                    ]
                ]
            ],
            [
                'info_slug'    => 'doubi32050',
                'info_name'    => '抖币充值图片广告320*50',
                'info_module'  => 'adsense',
                'info_controll'=> 'index',
                'info_action'  => 'image',
                'web' => [
                    'image' => [
                        'src'    => 'https://cdn.daicuo.cc/youdu/douyin/32050.png',
                        'link'   => '/adsense/chongzhi/doubi/',
                        'alt'    => '抖币优惠充值，最低8折',
                        'class'  => '',
                        'width'  => '320px',
                        'height' => '50px',
                    ]
                ],
                'mobile' => [
                    'image' => [
                        'src'    => 'https://cdn.daicuo.cc/youdu/douyin/32050.png',
                        'link'   => '/adsense/chongzhi/doubi/',
                        'alt'    => '抖币优惠充值，最低8折',
                        'class'  => '',
                        'width'  => '320px',
                        'height' => '50px',
                    ]
                ]
            ],
            [
                'info_slug'    => 'doubi46890',
                'info_name'    => '抖币充值图片广告468*90',
                'info_module'  => 'adsense',
                'info_controll'=> 'index',
                'info_action'  => 'image',
                'web' => [
                    'image' => [
                        'src'    => 'https://cdn.daicuo.cc/youdu/douyin/46890.png',
                        'link'   => '/adsense/chongzhi/doubi/',
                        'alt'    => '抖币优惠充值，最低8折',
                        'class'  => 'img-fluid',
                        'width'  => '',
                        'height' => '',
                    ]
                ],
                'mobile' => [
                    'image' => [
                        'src'    => 'https://cdn.daicuo.cc/youdu/douyin/46890.png',
                        'link'   => '/adsense/chongzhi/doubi/',
                        'alt'    => '抖币优惠充值，最低8折',
                        'class'  => 'img-fluid',
                        'width'  => '',
                        'height' => '',
                    ]
                ]
            ],
            [
                'info_slug'    => 'doubi72890',
                'info_name'    => '抖币充值图片广告728*90',
                'info_module'  => 'adsense',
                'info_controll'=> 'index',
                'info_action'  => 'image',
                'web' => [
                    'image' => [
                        'src'    => 'https://cdn.daicuo.cc/youdu/douyin/72890.png',
                        'link'   => '/adsense/chongzhi/doubi/',
                        'alt'    => '抖币优惠充值，最低8折',
                        'class'  => 'img-fluid',
                        'width'  => '100%',
                        'height' => '',
                    ]
                ],
                'mobile' => [
                    'image' => [
                        'src'    => 'https://cdn.daicuo.cc/youdu/douyin/72890.png',
                        'link'   => '/adsense/chongzhi/doubi/',
                        'alt'    => '抖币优惠充值，最低8折',
                        'class'  => 'img-fluid',
                        'width'  => '100%',
                        'height' => '',
                    ]
                ]
            ],
            [
                'info_slug'    => 'doubi97090',
                'info_name'    => '抖币充值图片广告970*90',
                'info_module'  => 'adsense',
                'info_controll'=> 'index',
                'info_action'  => 'image',
                'web' => [
                    'image' => [
                        'src'    => 'https://cdn.daicuo.cc/youdu/douyin/97090.png',
                        'link'   => '/adsense/chongzhi/doubi/',
                        'alt'    => '抖币优惠充值，最低8折',
                        'class'  => 'img-fluid',
                        'width'  => '100%',
                        'height' => '',
                    ]
                ],
                'mobile' => [
                    'image' => [
                        'src'    => 'https://cdn.daicuo.cc/youdu/douyin/97090.png',
                        'link'   => '/adsense/chongzhi/doubi/',
                        'alt'    => '抖币优惠充值，最低8折',
                        'class'  => 'img-fluid',
                        'width'  => '100%',
                        'height' => '',
                    ]
                ]
            ],
            [
                'info_slug'    => 'image300',
                'info_name'    => '呆错导航系统300*300',
                'info_module'  => 'adsense',
                'info_controll'=> 'index',
                'info_action'  => 'image',
                'web' => [
                    'image' => [
                        'src'    => 'http://cdn.daicuo.cc/images/banner/dh540.540.jpg',
                        'link'   => 'https://daohang.daicuo.cc',
                        'alt'    => '呆错网址导航系统免费下载',
                        'class'  => 'img-fluid',
                        'width'  => '100%',
                        'height' => '',
                    ]
                ],
                'mobile' => [
                    'image' => [
                        'src'    => 'http://cdn.daicuo.cc/images/banner/dh540.540.jpg',
                        'link'   => 'https://daohang.daicuo.cc',
                        'alt'    => '呆错网址导航系统免费下载',
                        'class'  => 'img-fluid',
                        'width'  => '100%',
                        'height' => '',
                    ]
                ]
            ],
            [
                'info_slug'    => 'image728',
                'info_name'    => '呆错导航系统728*90',
                'info_module'  => 'adsense',
                'info_controll'=> 'index',
                'info_action'  => 'image',
                'web' => [
                    'image' => [
                        'src'    => 'http://cdn.daicuo.cc/images/banner/dh728.90.jpg',
                        'link'   => 'https://daohang.daicuo.cc',
                        'alt'    => '呆错网址导航系统免费下载',
                        'class'  => 'img-fluid',
                        'width'  => '100%',
                        'height' => '',
                    ]
                ],
                'mobile' => [
                    'image' => [
                        'src'    => 'http://cdn.daicuo.cc/images/banner/dh728.90.jpg',
                        'link'   => 'https://daohang.daicuo.cc',
                        'alt'    => '呆错网址导航系统免费下载',
                        'class'  => 'img-fluid',
                        'width'  => '100%',
                        'height' => '',
                    ]
                ]
            ],
        ];
        
        //验证规则
        config('common.validate_name', false);
        //验证场景
        config('common.validate_scene', false);
        //别名附加条件
        config('common.where_slug_unique', false);
        //扩展字段
        config('custom_fields.info_meta',[]);
        
        foreach($data as $key=>$value){
            $value['info_content']   = serialize(['web'=>$value['web'],'mobile'=>$value['mobile']]);
            unset($data['web']);
            unset($data['mobile']);
            \daicuo\Info::save($value);
        }
    }
}