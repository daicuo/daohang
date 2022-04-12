{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{$seoTitle|DcEmpty='呆错导航系统'}－{:config('common.site_name')}</title>
<meta name="keywords" content="{$seoKeywords|DcEmpty='呆错导航系统,daiduodaohang'}" />
<meta name="description" content="{$seoDescription|DcEmpty='呆错导航系统是一款免费开源的专业分类导航建站系统。'}"  />
{/block}
<!-- -->
{block name="header"}{include file="widget/header" /}{/block}
<!--main -->
{block name="main"}
<div class="container pt-2">
<!---->
<div class="row dh-row">
  <div class="col-12 col-md-3 px-1 order-2 order-md-1">
    <div class="card mb-2">
      <div class="card-header px-2">
        <i class="fa fa-fw fa-fire mr-1 text-danger"></i>热门关键词
      </div>
      <div class="card-body px-2 pb-0">
        {volist name=":explode(',',config('daohang.search_hot'))" id="keyword"}
        <p class="text-truncate">
          {gt name="i" value="3"}
          <span class="badge dh-badge badge-secondary mr-2">{$i}</span>
          {else/}
          <span class="badge dh-badge badge-danger mr-2">{$i}</span>
          {/gt}
          <a class="text-dh text-dark" href="{:daohangUrlSearch('index',['searchText'=>$keyword])}">{$keyword}</a>
          <small class="float-right text-muted">{:daohangDate('m.d',time())}</small>
        </p>
        {/volist}
      </div> 
    </div>
    {include file="widget/ads250" /}
  </div>
  <!---->
  <div class="col-12 col-md-9 px-1 order-1 order-md-2">
    <div class="card mb-2 py-3 px-3">
      <form class="w-100 mx-auto" action="{:daohangUrlSearch('','index')}" method="post" target="_self">
      <div class="input-group">
        <input class="form-control" type="text" name="searchText" id="searchText" value="{$searchText|DcHtml}" placeholder="网站名称、网站地址" autocomplete="off" required>
        <div class="input-group-append">
          <button class="btn btn-danger" type="submit"><i class="fa fa-search mr-1"></i>搜索</button>
        </div>
      </div>
      </form>
    </div>
    <div class="card mb-2 px-3 pt-3">
      <ul class="nav nav-pills border-bottom pb-2 mb-3">
        {volist name="search_list" id="searchUrl"}
        {if $key eq $action}
        <li class="nav-item"><a class="nav-link active" href="{$searchUrl}" target="{:daohangSearchTarget($key)}">{:lang('dh_search_'.$key)}</a></li>
        {else/}
        <li class="nav-item"><a class="nav-link" href="{$searchUrl}" target="{:daohangSearchTarget($key)}">{:lang('dh_search_'.$key)}</a></li>
        {/if}
        {/volist}
      </ul>
      <div class="mb-3 text-muted">
        {:config('common.site_name')}为您找到相关结果约<strong class="mx-1 text-danger">{$list.total|default=0}</strong>个
      </div>
      {foreach $list['data'] as $daohang}
      <h6 class="text-truncate">
        <a class="font-weight-bold {$daohang.info_color|daohangColor}" href="{:daohangUrlInfo($daohang)}">{$daohang.info_name|DcHtml}</a>
      </h6>
      <h6 class="text-muted small">
        {$daohang.info_referer|daohangReferer}
      </h6>
      <p class="border-bottom pb-2 mb-4">
        {$daohang.info_excerpt|daohangSubstr=0,86,true}
      </p>
      {/foreach}
      <!---->
      {gt name="list.last_page" value="1"}
      <div class="d-flex d-md-none justify-content-center mb-3">
        {:DcPageSimple($list['current_page'], $list['last_page'], $pagePath)}
      </div>
      <div class="d-none d-md-flex justify-content-center mb-3">
        {:DcPage($list['current_page'], $list['per_page'], $list['total'], $pagePath)}
      </div>
      {/gt}
    </div>
    <!---->
    {include file="widget/ads728" /}
  </div>
  <!---->
</div>
</div>
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}