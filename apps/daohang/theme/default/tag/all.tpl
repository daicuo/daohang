{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{$seoTitle|DcEmpty='呆错导航系统标签列表'}－{:config('common.site_name')}</title>
<meta name="keywords" content="{$seoKeywords|DcEmpty='呆错导航系统,daiduodaohang'}" />
<meta name="description" content="{$seoDescription|DcEmpty='呆错导航系统是一款免费开源的专业分类导航建站系统。'}"  />
{/block}
<!-- -->
{block name="header"}{include file="widget/header" /}{/block}
<!--main -->
{block name="main"}
<div class="container pt-2">
{include file="widget/ads970" /}
<ol class="breadcrumb bg-white mb-2">
  <li class="breadcrumb-item"><a class="text-danger" href="{:daohangUrl('daohang/index/index')}">首页</a></li>
  <li class="breadcrumb-item active">标签列表</li>
</ol>
<!---->
{assign name="list" value=":daohangTagSelect([
    'cache'   => true,
    'status'  => 'normal',
    'sort'    => $sortName,
    'order'   => $sortOrder,
    'limit'   => 100,
    'page'    => $pageNumber,
])" /}
<!---->
<div class="row dh-row">
  {volist name="list.data" id="tag"}
  <div class="col-6 col-md-3 px-1 mb-2">
    <a class="btn btn-light btn-block btn-sm py-3 bg-white" href="{:daohangUrlTag($tag)}">
      <p>
        <strong class="text-danger">{$tag.term_name|DcHtml}</strong>
        <span class="small text-muted">（{$tag.term_count}）</span>
      </p>
      <p class="text-center mb-0 small text-truncate">{$tag.term_info|DcEmpty='与'.DcHtml($tag['term_name']).'相关的网站'}</p>
    </a>
  </div>
  {/volist}
  <!---->
</div>
{gt name="list.last_page" value="1"}
<div class="border rounded bg-white py-2 d-flex justify-content-center d-md-none mb-2">
  {:DcPageSimple($list['current_page'], $list['last_page'], $pagePath)}
</div>
<div class="d-none border rounded bg-white py-2 d-md-flex justify-content-center mb-2">
  {:DcPage($list['current_page'], $list['per_page'], $list['total'], $pagePath)}
</div>
{/gt}
</div>
{/block}
{block name="footer"}{include file="widget/footer" /}{/block}
<!-- -->