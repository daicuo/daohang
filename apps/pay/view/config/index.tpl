{extend name="apps/common/view/admin.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{:lang("pay/config/index")}－{:lang('appName')}</title>
{/block}
{block name="header_addon"}
<link href="{$path_root}{$path_addon}view/theme.css">
<script src="{$path_root}{$path_addon}view/theme.js"></script>
{/block}
<!-- -->
{block name="main"}
<ul class="nav nav-tabs mb-3">
{volist name="platForms" id="platform"}
  <li class="nav-item">
    <a class="nav-link rounded-0 {:DcDefault($opControll,$key,'active','')}" href="{:DcUrlAddon(['module'=>'pay','controll'=>'config','action'=>'index','opControll'=>$key])}">{:lang('pay_'.$key)}</a>
  <li>
{/volist}
</ul>
{:DcBuildForm([
    'name'     => 'pay/config/index',
    'class'    => 'bg-white py-2',
    'action'   => DcUrlAddon(['module'=>'pay','controll'=>'config','action'=>'save']),
    'method'   => 'post',
    'submit'   => lang('submit'),
    'reset'    => lang('reset'),
    'close'    => false,
    'disabled' => false,
    'ajax'     => false,
    'callback' => '',
    'items'    => $items,
])}
{/block}