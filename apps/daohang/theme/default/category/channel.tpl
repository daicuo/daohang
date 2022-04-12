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
<div class="container pt-2 mb-2">
  <div class="bg-gradient rounded px-3">
    <div class="row">
      <div class="col-12 col-lg-8 offset-lg-2">
        <form class="mx-auto" id="search" action="{:daohangUrlSearch('index')}" method="post" target="_blank">
          <div class="input-group">
            <input class="form-control" type="text" name="searchText" id="searchText" placeholder="网站名称、网站地址" autocomplete="off" required>
            <div class="input-group-append">
              <button class="btn btn-danger" type="submit"><i class="fa fa-search mr-1"></i>搜索</button>
            </div>
          </div>
          <p class="d-none d-md-flex flex-row justify-content-between align-items-center mt-3 mb-0">
          {volist name=":daohangSelect(['status'=>'normal','type'=>'head','limit'=>6,'sort'=>'info_order','order'=>'desc'])" id="daohang"}
          <a class="{$daohang.info_color|daohangColor}" href="{$daohang.info_referer|daohangReferer}" target="_blank" data-id="{$daohang.info_id}" data-type="{$daohang.info_type|default='index'}">{$daohang.info_name|daohangSubstr=0,8,false}</a>
          {/volist}
          </p>
        </form>
      </div>
    </div>
  </div>
</div>
<!---->
<div class="container">
<div class="row dh-row">
  <div class="col-12 px-1 mb-2">
    <div class="card">
      <div class="card-header px-2 d-flex flex-row justify-content-between align-items-center">
        <span><i class="fa fa-fw fa-desktop mr-1 text-danger"></i>网站大全</span>
        <a class="text-danger small" href="{:daohangUrl('daohang/publish/index')}">发布网站</a>
      </div>
      <div class="card-body row pb-0">
        {volist name=":daohangSelect(['type'=>['in','fast,head,recommend'],'status'=>'normal','limit'=>90,'sort'=>'info_order desc,info_id','order'=>'desc'])" id="web"}
        <p class="col-6 col-md-3 col-lg-2 text-truncate">
          <a class="{$web.info_color|daohangColor}" href="{:daohangUrlJump($web['info_type'],$web['info_referer'],$web['info_id'])}" target="_blank" data-id="{$web.info_id}" data-type="{$web.info_type|default='index'}">{if $web['info_type'] eq 'fast'}<i class="mr-1 fa fa-fw fa-clone text-danger"></i>{else/}<i class="mr-1 fa fa-fw fa-clone mr-1"></i>{/if}{$web.info_name|daohangSubstr=0,10}</a>
        </p>
        {/volist}
      </div>
    </div>
  </div>
  {include file="widget/ads970" /}
  {volist name=":daohangCategorySelect(['action'=>'index','status'=>'normal','limit'=>100,'sort'=>'term_order','order'=>'desc'])" id="category"}
  <div class="col-12 px-1">
    <div class="card mb-2">
      <div class="card-header px-2 bg-white d-flex flex-row justify-content-between align-items-center">
        <span><i class="fa fa-fw fa-navicon mr-1 text-danger"></i>{$category.term_name}</span>
        <a class="text-muted small" href="{:daohangUrlCategory($category)}" target="_self">全部>></a>
      </div>
      <div class="card-body row pb-0 mb-0">
        {volist name=":daohangSelect(['term_id'=>$category['term_id'],'status'=>'normal','limit'=>30,'sort'=>'info_order desc,info_update_time','order'=>'desc'])" id="web"}
        <ul class="col-4 col-md-2 col-lg-auto w-10 list-unstyled text-truncate text-center">
          <li class="w-100 mb-2"><a href="{:daohangUrlInfo($web)}"><img src="{:daohangUrlImage($web['image_ico'],$web['image_level'])}" class="dh-circle border p-1" alt="{$web.info_name|DcHtml}" width="64" height="64"></a></li>
          <li class="w-100"><a class="{$web.info_color|daohangColor}" href="{:daohangUrlInfo($web)}">{$web.info_name|daohangSubstr=0,6,false}</a></li>
        </ul>
        {/volist}
      </div>
    </div>
  </div>
  {/volist}
  <!---->
</div>
</div>
<!---->
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}