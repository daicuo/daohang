{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>修改密码-{:config('common.site_name')}</title>
{/block}
<!-- -->
{block name="header"}{include file="widget/header" /}{/block}
<!-- -->
{block name="main"}
<section class="container pt-2">
<div class="row dh-row">
  <div class="col-12 col-md-2 px-1">
    {include file="widget/sitebar" /}
  </div>
  <div class="col-12 col-md-10 px-1">
    <div class="card">
      <div class="card-header">修改密码</div>
      <div class="card-body">
      {:DcBuildForm([
        'name'     => 'user_repwd_index',
        'class'    => 'bg-white',
        'action'   => DcUrl('user/repwd/update'),
        'method'   => 'post',
        'submit'   => lang('submit'),
        'reset'    => lang('reset'),
        'close'    => false,
        'ajax'     => true,
        'disabled' => false,
        'callback' => '',
        'data'     => '',
        'items'    => DcFormItems([
            'user_pass_old'     => ['type'=>'text','class_left'=>'col-12','class_right'=>'col-12','maxlength'=>'60','required'=>true,'placeholder'=>''],
            'user_pass'         => ['type'=>'text','class_left'=>'col-12','class_right'=>'col-12','maxlength'=>'60','required'=>true,'placeholder'=>''],
            'user_pass_confirm' => ['type'=>'text','class_left'=>'col-12','class_right'=>'col-12','maxlength'=>'60','required'=>true,'placeholder'=>''],
        ]),
    ])}
    </div> 
    </div>
  </div>
</div>
</section>
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}