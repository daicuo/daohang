{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{$seoTitle}－{:config('common.site_name')}</title>
<meta name="keywords" content="{$seoKeywords}" />
<meta name="description" content="{$seoDescription}"  />
{/block}
{block name="header"}{include file="widget/header" /}{/block}
{block name="main"}
<div class="container">
  <div class="alert alert-secondary">
    <strong>提示!</strong> 请先做上本站的友情链接后再申请、否则不通过审核。
  </div>
  <div class="card mb-3">
    <div class="card-header">免费申请友情链接</div>
    <div class="card-body px-md-5">
      {:DcBuildForm([
        'name'     => 'friend_publish_index',
        'class'    => 'bg-white',
        'action'   => DcUrl('friend/publish/save'),
        'method'   => 'post',
        'submit'   => lang('submit'),
        'reset'    => lang('reset'),
        'close'    => false,
        'ajax'     => true,
        'disabled' => false,
        'callback' => 'daicuo.friend.publish',
        'data'     => '',
        'items'    => $items,
      ])}
    </div>
  </div>
  <div class="card mb-3">
    <div class="card-header">{:config('common.site_name')} 链接信息</div>
    <div class="card-body">
      <p class="small text-muted mb-3">网站名称：{:config('common.site_name')}</p>
      <p class="small text-muted mb-0">网站地址：{$domain}</p>
    </div>
  </div>
</div>
{/block}
{block name="footer"}{include file="widget/footer" /}{/block}