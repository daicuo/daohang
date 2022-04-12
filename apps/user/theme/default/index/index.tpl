{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{:config('common.site_name')}</title>
<meta name="keywords" content="{:config('user.keywords_login')}" />
<meta name="description" content="{:config('user.description_login')}"  />
{/block}
{block name="header"}{include file="widget/header" /}{/block}
{block name="main"}
<div class="container pt-2">
  <div class="card mb-3">
    <h6 class="card-header">个人主页</h6>
    <div class="card-body">
      开发中...
    </div>
  </div>
</div>
{/block}