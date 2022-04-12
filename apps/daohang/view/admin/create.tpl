{extend name="apps/common/view/admin.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{:lang('daohang/admin/create')}－{:lang('appName')}</title>
{/block}
{block name="header_addon"}
<link href="{$path_root}{$path_addon}view/theme.css" rel="stylesheet">
{/block}
<!-- -->
{block name="main"}
<h6 class="border-bottom pb-2 mb-2 text-purple">
  {:lang('daohang/admin/create')}
</h6>
<!-- -->
{:DcBuildForm([
    'name'     => 'daohang/web/create',
    'class'    => 'bg-white form-create',
    'action'   => DcUrlAddon(['module'=>'daohang','controll'=>'admin','action'=>'save']),
    'method'   => 'post',
    'submit'   => lang('submit'),
    'reset'    => lang('reset'),
    'close'    => false,
    'disabled' => false,
    'callback' => '',
    'ajax'     => true,
    'data'     => '',
    'items'    => $fields,
])}
{/block}