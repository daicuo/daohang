{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>呆错广告插件演示－{:config('common.site_name')}</title>
<meta name="keywords" content="广告管理,广告展示" />
<meta name="description" content="呆错广告插件是一款系统增强工具，其主要功能是统一网站广告的添加、修改、删除与调用！"  />
{/block}
{block name="header"}{include file="public/widget/header.tpl" /}{/block}
<!--main -->
{block name="main"}
<div class="container">
  <h2 class="text-center mt-5 mb-3">呆错广告插件</h2>
  <p class="lead text-center text-muted">呆错广告插件是一款系统增强工具，其主要功能是统一网站广告的添加、修改、删除与调用！</p>
  <ul class="list-group mb-3">
  {volist name="item" id="adsense"}
  <li class="list-group-item">
    <div class="mb-2 w-100 d-flex justify-content-between align-items-center">
      <h5 class="mb-1">{$adsense.info_name}</h5>
      <small class="text-muted"><a class="badge badge-primary" href="{$adsense.info_link}" target="_blank" data-id="{$adsense.info_id}" data-toggle="adsense">预览</a></small>
    </div>
    <p class="mb-1 text-muted small">调用代码：{:adsenseShowTpl($adsense['info_slug'])}</p>
  </li>
  {/volist}
  </ul>
  <h5>统计点击次数</h5>
  <p class="small text-muted mb-1">如需统计点击次数，请在插件的JS里添加以下代码</p>
  <pre><code>{literal}$(function() {
    $(document).on("click", '[data-toggle="adsense"]', function(){
        $.get(daicuo.config.root+'index.php?s=adsense/hits/index&id='+$(this).data('id'));
    });
});{/literal}
  </code></pre>
{/block}
{block name="footer"}{include file="public/widget/footer.tpl" /}{/block}