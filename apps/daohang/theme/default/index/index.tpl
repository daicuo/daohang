{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{$seoTitle}－{:config('common.site_name')}</title>
<meta name="keywords" content="{$seoKeywords}" />
<meta name="description" content="{$seoDescription}" />
{/block}
{block name="header"}{include file="widget/header" /}{/block}
<!--main -->
{block name="main"}
<div class="container pt-2 mb-2">
  <div class="bg-gradient rounded border px-3 pt-4 pb-3">
    <div class="row">
      <div class="col-12 col-lg-8 offset-lg-2">
        <form class="mx-auto mb-0" id="search" action="{:daohangUrlSearch('index')}" method="post" target="_blank">
          <div class="input-group">
            <input class="form-control" type="text" name="searchText" id="searchText" placeholder="网站名称、网站地址" autocomplete="off" required>
            <div class="input-group-prepend position-relative" id="searchDropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">站内</button>
              <div class="dropdown-menu">
                {volist name="searchList" id="searchName" offset="1" length="10"}
                <a class="dropdown-item" href="javascrit:;" data-href="{:daohangUrlSearch($searchName)}">{:lang('dh_search_'.$searchName)}</a>
                {/volist}
              </div>
            </div>
            <div class="input-group-append">
              <button class="btn btn-danger" type="submit"><i class="fa fa-search mr-1"></i>搜索</button>
            </div>
          </div>
          <p class="d-none d-lg-flex flex-row justify-content-between align-items-center mt-3 mb-0">
          {volist name=":daohangSelect(['status'=>'normal','type'=>'head','limit'=>7,'sort'=>'info_order desc,info_id','order'=>'desc'])" id="daohang"}
          <a class="text-dark" href="{$daohang.info_referer|daohangReferer}" target="_blank" data-id="{$daohang.info_id}" data-type="{$daohang.info_type|default='index'}">{$daohang.info_name|daohangSubstr=0,8,false}</a>
          {/volist}
          </p>
        </form>
      </div>
    </div>
  </div>
</div>
<!---->
<div class="container">
{if $limitWeb}
<div class="row dh-row">
  <div class="col-12 px-1 mb-2">
    <div class="card">
      <div class="card-header px-2 d-flex flex-row justify-content-between align-items-center">
        <span><i class="fa fa-fw fa-desktop mr-1 text-danger"></i><a class="text-dark" href="{:DcUrl('daohang/page/zuixin')}">网站大全</a></span>
        <a class="text-danger small" href="{:daohangUrl('daohang/publish/index')}">发布网站</a>
      </div>
      <div class="card-body row pb-0">
        {volist name=":daohangSelect(['type'=>['in','fast,recommend'],'status'=>'normal','limit'=>$limitWeb,'sort'=>'info_order desc,info_update_time','order'=>'desc'])" id="web" mod="9"}
        <p class="col-6 col-md-3 col-lg-2 text-truncate">
          <a class="{$web.info_color|daohangColor}" href="{:daohangUrlJump($web['info_type'],$web['info_referer'],$web['info_id'])}" target="_blank" data-id="{$web.info_id}" data-type="{$web.info_type|default='index'}">{if $web['info_type'] eq 'fast'}<i class="mr-1 fa fa-fw fa-clone text-danger"></i>{else/}<i class="mr-1 fa fa-fw fa-clone mr-1"></i>{/if}{$web.info_name|daohangSubstr=0,10}</a>
        </p>
        {/volist}
      </div>
    </div>
  </div>
  <!---->
  {include file="widget/ads970" /}
</div>
{/if}

<div class="row dh-row">
  <div class="col-12 col-md-4 col-lg-3 px-1 order-2 order-lg-1">
    {if $limitHot}
    <div class="card mb-2">
      <div class="card-header px-2 d-flex flex-row justify-content-between align-items-center">
        <span><i class="fa fa-fw fa-fire mr-1 text-danger"></i>热门网站</span>
        <a class="small text-muted" href="{:DcUrl('daohang/page/remen')}">更多>></a>
      </div>
      <div class="card-body px-2 pb-0">
        {volist name=":daohangSelect(['status'=>'normal','limit'=>$limitHot,'sort'=>'info_views','order'=>'desc'])" id="daohang"}
        <p class="text-truncate">
          {gt name="i" value="3"}
          <span class="badge dh-badge badge-secondary mr-2">{$i}</span>
          {else/}
          <span class="badge dh-badge badge-danger mr-2">{$i}</span>
          {/gt}
          <a class="{$daohang.info_color|daohangColor}" href="{:daohangUrlInfo($daohang)}">{$daohang.info_name|daohangSubstr=0,12,false}</a>
          <small class="float-right text-muted">{$daohang.info_views|number_format}</small>
        </p>
        {/volist}
      </div> 
    </div>
    {/if}
    {include file="widget/ads250" /}
  </div>
  <!---->
  <div class="col-12 col-md-8 col-lg-9 px-1 order-1 order-lg-2">
    <div class="card mb-2">
      <div class="card-header px-2 d-flex flex-row justify-content-between align-items-center">
        <span><i class="fa fa-fw fa-navicon mr-1 text-danger"></i>栏目分类</span>
        <a class="text-muted small" href="{:daohangUrl('daohang/category/all')}" target="_self">全部>></a>
      </div>
      <div class="card-body pb-0 row dh-row">
        {volist name=":daohangCategorySelect(['action'=>['eq','index'],'status'=>'normal','limit'=>$limitCategory,'sort'=>'term_order','order'=>'desc'])" id="category"}
        <p class="col-4 col-md-3 col-lg-12 px-1 text-truncate d-lg-flex flex-row justify-content-between align-items-center">
          <a class="btn btn-light btn-sm btn-sm-block" href="{:daohangUrlCategory($category)}" target="_self">{$category.term_name}</a>
          {volist name=":daohangSelect(['term_id'=>['eq',$category['term_id']],'limit'=>7,'sort'=>'info_id','order'=>'desc'])" id="daohang"}
          <a class="d-none d-lg-inline {$daohang.info_color|daohangColor}" href="{:daohangUrlInfo($daohang)}" target="_self">{$daohang.info_name|daohangSubstr=0,6,false}</a>
          {/volist}
          <a class="text-muted small d-none d-lg-inline" href="{:daohangUrlCategory($category)}" target="_self">更多>></a>
        </p>
        {/volist}
      </div> 
    </div>
    {include file="widget/ads728" /}
    {if $limitTag}
    <div class="card mb-2">
      <div class="card-header px-2 d-flex flex-row justify-content-between align-items-center">
        <span><i class="fa fa-fw fa-tags mr-1 text-danger"></i>网站标签</span>
        <a class="small text-muted" href="{:daohangUrl('daohang/tag/all')}">更多>></a>
      </div>
      <div class="card-body px-2 pb-0 text-center row dh-row">
        {volist name=":daohangTagSelect(['status'=>'normal','limit'=>$limitTag,'sort'=>'term_count','order'=>'desc'])" id="tag"}
        <p class="col-4 col-md-3 col-lg-2">
          <a class="btn btn-light btn-block btn-sm" href="{:daohangUrlTag($tag)}">{$tag.term_name|daohangSubstr=0,4,false}</a>
        </p>
        {/volist}
      </div>
    </div>
    {/if}
  </div>
</div>
    
</div>
<!---->
{if function_exists('friendSelect')}
<div class="container mb-2">
  <div class="card">
    <div class="card-header px-2 d-flex flex-row justify-content-between align-items-center">
      <span><i class="fa fa-fw fa-link mr-1 text-danger"></i>友情链接</span>
      <a class="text-muted small" href="{:daohangUrl('friend/index/index')}" target="_self">全部>></a>
    </div>
    <div class="card-body row py-1">
      {volist name=":friendSelect(['status'=>'normal','limit'=>'30','sort'=>'info_order','order'=>'desc'])" id="friend"}
      <div class="col-6 col-md-2 my-1">
        <a class="text-dark" href="{$friend.info_referer|daohangReferer}" target="_blank" data-id="{$friend.info_id}" data-type="links">{$friend.info_name|daohangSubstr=0,8,false}</a>
      </div>
      {/volist}
    </div> 
  </div>
</div>
{/if}
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}