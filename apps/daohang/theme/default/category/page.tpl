{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{$seoTitle}－{:config('common.site_name')}</title>
<meta name="keywords" content="{$seoKeywords}" />
<meta name="description" content="{$seoDescription}" />
{/block}
<!-- -->
{block name="header"}{include file="widget/header" /}{/block}
<!--main -->
{block name="main"}
<div class="container pt-2">
{include file="widget/ads970" /}
<ol class="breadcrumb bg-white mb-2">
  <li class="breadcrumb-item"><a class="text-danger" href="{:daohangUrl('daohang/index/index')}">首页</a></li>
  <li class="breadcrumb-item active">{$term_name}</li>
</ol>
<div class="card mb-2 py-3 px-3">
  <h3 class="text-truncate">{$term_name}</h3>
  <p class="text-muted mb-0">{$term_info|DcEmpty='呆错导航系统是一款免费开源的专业分类导航建站系统。'}</p>
</div>
</div>
{/block}
{block name="footer"}{include file="widget/footer" /}{/block}
<!-- -->