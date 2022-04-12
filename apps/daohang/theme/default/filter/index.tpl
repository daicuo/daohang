{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{:config('common.site_name')}已免费收录的{:lang('dh_option_'.$controll)}第{$page}页</title>
<meta name="keywords" content="{:config('common.site_name')},免费收录{:lang('dh_option_'.$controll)}" />
<meta name="description" content="{:config('common.site_name')}收录的{:lang('dh_option_'.$controll)}类型有{:implode(',',array_values($termIds))}"  />
{/block}
<!-- -->
{block name="header"}{include file="widget/header" /}{/block}
<!--main -->
{block name="main"}
<div class="container pt-2">
<div class="row dh-row">
  <div class="col-12 px-0">{include file="widget/ads970" /}</div>
  <!---->
  <div class="col-12 px-1">
    <ol class="breadcrumb bg-white mb-2">
      <li class="breadcrumb-item"><a class="text-danger" href="{:daohangUrl('daohang/index/index')}">首页</a></li>
      <li class="breadcrumb-item"><a href="{$pageReset}">重置条件</a></li>
      <li class="breadcrumb-item active">{$term_name|default='按条件筛选'|DcHtml}</li>
    </ol>
    <div class="w-100 bg-white rounded px-3 pt-3 pb-1 mb-2">
      <p><strong>栏目分类：</strong>
        <a class="mx-1 badge badge-pill {:DcDefault($termId, 0, 'badge-dark', 'badge-light')}" href="{:daohangUrlFilter(array_merge($pageFilter,['termId'=>0]))}">全部</a>
        {volist name="termIds" id="filterTermName" offset="0" length="30"}
        <a class="mx-1 badge badge-pill {:DcDefault($key, $termId, 'badge-dark', 'badge-light')}" href="{:daohangUrlFilter(array_merge($pageFilter,['termId'=>$key]))}">{$filterTermName}</a>{/volist}
      </p>
      <p><strong>每页数量：</strong>{volist name="pageSizes" id="filterSize" offset="0" length="10"}
        <a class="mx-1 badge badge-pill {:DcDefault($key, $pageSize, 'badge-dark', 'badge-light')}" href="{:daohangUrlFilter(array_merge($pageFilter,['pageSize'=>$key]))}">{$filterSize}</a>
        {/volist}
      </p>
      <p><strong>排序字段：</strong>{volist name="sortNames" id="filterName" offset="0" length="10"}
        <a class="mx-1 badge badge-pill {:DcDefault($key, $sortName, 'badge-dark', 'badge-light')}" href="{:daohangUrlFilter(array_merge($pageFilter,['sortName'=>$key]))}">{$filterName}</a>
        {/volist}
      </p>
      <p><strong>排序方式：</strong>{volist name="sortOrders" id="filterOrder" offset="0" length="10"}
        <a class="mx-1 badge badge-pill {:DcDefault($key, $sortOrder, 'badge-dark', 'badge-light')}" href="{:daohangUrlFilter(array_merge($pageFilter,['sortOrder'=>$key]))}">{$filterOrder}</a>
        {/volist}
      </p>
    </div>
    <div class="list-group mb-2">
    {foreach $list['data'] as $web}
    <div class="media bg-white rounded mb-2 px-3 pt-3">
      <a href="{:daohangUrlInfo($web)}"><img class="mr-3 mb-2 border p-1" src="{:daohangUrlImage($web['image_ico'],$mp['image_level'])}" alt="{$web.info_name|DcHtml}" width="72" height="96"></a>
      <div class="media-body">
        <h6 class="mt-0"><a class="{$web.info_color|daohangColor}" href="{:daohangUrlInfo($web)}">{$web.info_name|DcHtml}</a></h6>
        <p class="mb-2">{$web.info_excerpt|daohangSubstr=0,128}</p>
        <div class="w-100 d-flex justify-content-between">
          <ul class="list-inline small mb-0">
          <li class="list-inline-item">收录时间：<label class="text-muted">{$web.info_create_time|daohangDate='Y-m-d',###}</label></li>
          <li class="list-inline-item">浏览人数：<label class="text-muted">{$web.info_views|number_format}</label></li>
          <li class="list-inline-item">点赞人数：<label class="text-muted">{$web.info_up|number_format}</label></li>
          <li class="list-inline-item">点击次数：<label class="text-muted">{$web.info_hits|number_format}</label></li>
          <li class="list-inline-item">分类与标签：
          {volist name="web.category" id="category" offset="0" length="3"}
          <a class="text-muted" href="{:daohangUrlCategory($category)}">{$category.term_name}</a>
          {/volist}
          {volist name="web.tag" id="tag" offset="0" length="3"}
          <a class="text-muted" href="{:daohangUrlTag($tag)}">{$tag.term_name}</a>
          {/volist}
          </li>
          </ul>
          <div class="small text-muted d-none d-md-inline">
            <a class="text-danger" href="{:daohangUrlInfo($web)}">网站详情>></a>
          </div>
        </div>
      </div>
    </div>
    {/foreach}
    </div>
    <!---->
    {gt name="list.last_page" value="1"}
    <div class="border rounded bg-white py-3 d-flex justify-content-center d-md-none mb-2">
      {:DcPageSimple($list['current_page'], $list['last_page'], $pagePath)}
    </div>
    <div class="d-none border rounded bg-white py-3 d-md-flex justify-content-center mb-2">
      {:DcPage($list['current_page'], $list['per_page'], $list['total'], $pagePath)}
    </div>
    {/gt}
  </div>
  <!---->
</div>
</div>
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}