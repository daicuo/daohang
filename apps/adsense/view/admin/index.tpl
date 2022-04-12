{extend name="apps/common/view/admin.tpl" /}
<!-- -->
{block name="header_meta"}
<title>广告管理－{:lang('appName')}</title>
{/block}
{block name="header_addon"}
<link href="{$domain}{$path_root}{$path_addon}/view/theme.css?{:DcConfig('common.site_applys.adsense.version')}" rel="stylesheet">
<script src="{$domain}{$path_root}{$path_addon}/view/theme.js?{:DcConfig('common.site_applys.adsense.version')}"></script>
{/block}
<!-- -->
{block name="main"}
<h6 class="border-bottom pb-2 text-purple">
  广告管理
</h6>
<!-- -->
<form action="{:DcUrlAddon(['module'=>'adsense','controll'=>'admin','action'=>'delete'])}" method="post" data-toggle="form">
<input type="hidden" name="_method" value="delete">
<div id="toolbar" class="toolbar mb-2">
  <a class="btn btn-sm btn-purple" href="{:DcUrlAddon(['module'=>'adsense','controll'=>'admin','action'=>'create'])}" data-toggle="create" data-modal-lg="true" data-callback="daicuo.admin.adsense.bakCreate">
    <i class="fa fa-plus fa-fw"></i>
    {:lang('create')}
  </a>
  <button class="btn btn-sm btn-danger" type="submit" data-toggle="delete">
    <i class="fa fa-trash"></i>
    {:lang('delete')}
  </button>
  <a class="btn btn-sm btn-dark" href="javascript:;" data-toggle="reload">
    <i class="fa fa-refresh fa-fw"></i>
    {:lang('refresh')}
  </a>
</div>
{:DcBuildTable([
    'data-name'               => 'adsense/admin/index',
    'data-escape'             => false,
    'data-toggle'             => 'bootstrap-table',
    'data-url'                => DcUrlAddon(['module'=>'adsense','controll'=>'admin','action'=>'index']),
    'data-buttons-prefix'     => 'btn',
    'data-buttons-class'      => 'purple',
    'data-icon-size'          => 'sm',
    
    'data-toolbar'            => '.toolbar',
    'data-toolbar-align'      => 'none float-md-left',
    'data-buttons-align'      => 'right',
    'data-search-align'       => 'none float-md-right',
    'data-search'             => true,
    'data-show-search-button' => true,
    'data-show-refresh'       => false,
    'data-show-toggle'        => true,
    'data-show-fullscreen'    => true,
    'data-smart-display'      => false,
    
    'data-unique-id'          => 'info_id',
    'data-id-field'           => 'info_id',
    'data-select-item-name'   => 'id[]',
    'data-query-params-type'  => 'params',
    'data-query-params'       => 'daicuo.table.query',
    'data-sortable'           => false,//禁用所有列的排序
    'data-sort-name'          => '',//禁用初始排序
    'data-sort-order'         => 'desc',
    'data-sort-class'         => 'table-active',
    'data-sort-stable'        => true,
    
    'data-side-pagination'    => 'server',
    'data-total-field'        => 'total',
    'data-data-field'         => 'data',
    
    'data-pagination'         => false,
    'data-page-number'        => $page,
    'data-page-size'          => '50',
    'data-page-list'          => '[50,100,200]',
    'columns'=>[
        [
            'data-checkbox'=>'true',
        ],
        [
            'data-field'=>'info_id',
            'data-title'=>'id',
            'data-width'=>'50',
            'data-width-unit'=>'px',
            'data-sortable'=>'true',
            'data-sort-name'=>'info_id',
            'data-sort-order'=>'desc',
            'data-class'=>'',
            'data-align'=>'center',
            'data-valign'=>'middle',
            'data-halign'=>'center',
            'data-falign'=>'center',
            'data-visible'=>'true',
            'data-formatter'=>'',
            'data-footer-formatter'=>'',
        ],
         [
            'data-field'=>'info_slug',
            'data-title'=>'广告标识',
            'data-align'=>'left',
            'data-halign'=>'center',
            'data-width'=>'180',
            'data-width-unit'=>'px',
        ],
        [
            'data-field'=>'info_show',
            'data-title'=>'调用代码',
            'data-align'=>'left',
            'data-halign'=>'center',
        ],
        [
            'data-field'=>'info_name',
            'data-title'=>'广告描述',
            'data-align'=>'left',
            'data-halign'=>'center',
        ],
        [
            'data-field'=>'info_views',
            'data-title'=>'展示次数',
            'data-align'=>'center',
            'data-halign'=>'center',
            'data-width'=>'60',
            'data-width-unit'=>'px',
            'data-sort-name'=>'info_views',
            'data-sort-order'=>'desc',
        ],
        [
            'data-field'=>'info_hits',
            'data-title'=>'点击次数',
            'data-align'=>'center',
            'data-halign'=>'center',
            'data-width'=>'60',
            'data-width-unit'=>'px',
            'data-sort-name'=>'info_hits',
            'data-sort-order'=>'desc',
        ],
        [
            'data-field'=>'info_action_text',
            'data-title'=>'广告类型',
            'data-align'=>'center',
            'data-halign'=>'center',
        ],
        [
            'data-field'=>'info_status_text',
            'data-title'=>lang('status'),
            'data-align'=>'center',
            'data-halign'=>'center',
        ],
        [
            'data-field'=>'info_operate',
            'data-title'=>lang('operate'),
            'data-align'=>'center',
            'data-halign'=>'center',
            'data-width'=>'150',
            'data-width-unit'=>'px',
            'data-formatter'=>'window.daicuo.admin.adsense.bakOperate',
        ]
    ]
])}
</form>
{/block}
<!-- -->