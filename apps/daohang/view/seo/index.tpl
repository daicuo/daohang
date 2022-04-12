{extend name="apps/common/view/admin.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{:lang("daohang/seo/index")}－{:lang('appName')}</title>
{/block}
{block name="header_addon"}
<link href="{$path_root}{$path_addon}view/theme.css">
<script src="{$path_root}{$path_addon}view/theme.js"></script>
{/block}
<!-- -->
{block name="main"}
<h6 class="border-bottom pb-2 text-purple">
  {:lang("daohang/seo/index")}
  <small class="text-muted">[siteName]，[siteDomain]，[pageNumber]，[searchText]</small>
</h6>
{:DcBuildForm([
    'name'     => 'daohang/seo/index',
    'class'    => 'bg-white py-2',
    'action'   => DcUrlAddon(['module'=>'daohang','controll'=>'seo','action'=>'update']),
    'method'   => 'post',
    'ajax'     => true,
    'submit'   => lang('submit'),
    'reset'    => lang('reset'),
    'close'    => false,
    'disabled' => false,
    'callback' => '',
    'items'    => $items,
])}
{/block}