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
  <li class="breadcrumb-item active">栏目分类</li>
</ol>
<div class="card px-3 pb-3 mb-2">
  <div class="row">
  {foreach name=":daohangCategorySelect([
    'cache'  => true,
    'status' => 'normal',
    'result' => 'array',
    'action' => 'index',
    'sort'   => 'term_order',
    'order'  => 'desc',
  ])" item="category"}
    <div class="col-4 col-md-2 py-3">
      <a class="btn btn-light btn-block btn-sm" href="{:daohangUrlCategory($category)}" target="_self">{$category.term_name}</a>
    </div>
  {/foreach}
  </div>
</div>
</div>
{/block}
{block name="footer"}{include file="widget/footer" /}{/block}
<!-- -->