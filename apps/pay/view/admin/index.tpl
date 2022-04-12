{extend name="apps/common/view/admin.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{:lang('pay/admin/index')}－{:lang('appName')}</title>
{/block}
<!-- -->
{block name="main"}
<h6 class="border-bottom pb-2 mb-0 text-purple">
  {:lang('pay/admin/index')}
</h6>
<!-- -->
<form action="{:DcUrlAddon(['module'=>'pay','controll'=>'admin','action'=>'index'])}" method="post" data-toggle="form">
<div class="form-row collapse" id="filter-row">
  {:DcFormFilter($fields)}
</div>
<div class="toolbar d-flex justify-content-between d-md-block" id="toolbar">
  <div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-purple dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
       {:lang('action')}
    </button>
    <div class="dropdown-menu">
      <button class="dropdown-item px-3" type="submit" data-action="{:DcUrlAddon(['module'=>'pay','controll'=>'admin','action'=>'delete'])}" data-toggle="submit">
        <i class="fa fa-fw fa-trash"></i> {:lang('delete')}
      </button>
    </div>
  </div>
  <a class="btn btn-sm btn-secondary" href="#filter-row" data-toggle="collapse">
    <i class="fa fa-filter"></i> {:lang('filter')}
  </a>
  <a class="btn btn-sm btn-dark" href="javascript:;" data-toggle="refresh">
    <i class="fa fa-refresh"></i> {:lang('refresh')}
  </a>
</div>
{:DcBuildTable([
    'data-escape'             => false,
    'data-toggle'             => 'bootstrap-table',
    'data-url'                => DcUrlAddon(['module'=>'pay','controll'=>'admin','action'=>'index']),
    'data-url-sort'           => '',
    'data-url-preview'        => '',
    'data-url-edit'           => DcUrlAddon(['module'=>'pay','controll'=>'admin','action'=>'edit','id'=>'']),
    'data-url-delete'         => DcUrlAddon(['module'=>'pay','controll'=>'admin','action'=>'delete','id'=>'']),
    'data-buttons-prefix'     => 'btn',
    'data-buttons-class'      => 'purple',
    'data-buttons-align'      => 'none float-md-right',
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
    
    'data-unique-id'          => 'pay_id',
    'data-id-field'           => 'pay_id',
    'data-select-item-name'   => 'id[]',
    'data-query-params-type'  => 'params',
    'data-query-params'       => 'daicuo.table.query',
    'data-sort-name'          => 'pay_id',
    'data-sort-order'         => 'desc',
    'data-sort-class'         => 'table-active',
    'data-sort-stable'        => 'true',
    
    'data-side-pagination'    => 'server',
    'data-total-field'        => 'total',
    'data-data-field'         => 'data',
    'data-pagination'         => 'true',
    
    'data-page-number'        => $page,
    'data-page-size'          => 50,
    'data-page-list'          => '[50, 100, 200]',
    
    'columns'                 => $columns,
])}
</form>
{/block}