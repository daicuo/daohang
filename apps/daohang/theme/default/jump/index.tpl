{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{$seoTitle}的官方网址－{:config('common.site_name')}</title>
<meta name="keywords" content="{$seoKeywords}" />
<meta name="description" content="{$seoDescription}" />
{/block}
<!-- -->
{block name="header"}{include file="widget/header" /}{/block}
<!--main -->
{block name="main"}
<div class="container pt-2">
  <ol class="breadcrumb bg-white mb-2">
  <li class="breadcrumb-item"><a class="text-danger" href="{:daohangUrl('daohang/index/index')}">首页</a></li>
  <li class="breadcrumb-item active">{$info_name|DcHtml}的官方网址如下</li>
  </ol>
 <div class="card mb-2">
    <div class="card-body">
      <h1 class="text-center my-3">{$info_name|DcHtml}</h1>
      <h5 class="text-center text-danger my-3">{$info_referer|daohangReferer}</h5>
      <section class="text-muted lead">{$info_content|daohangStrip}</section>
    </div> 
    <div class="card-footer bg-white text-center">
      <a class="btn btn-dark mr-2" href="{$info_referer|daohangReferer}">继续访问</a>
      <a class="btn btn-outline-dark" href="{:daohangUrl('daohang/index/index')}">返回首页</a>
    </div>
  </div>
  <div class="row dh-row">{include file="widget/ads970" /}</div>
</div>
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}