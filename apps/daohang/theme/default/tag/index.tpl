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
<div class="row dh-row">
  <div class="col-12 px-0">{include file="widget/ads970" /}</div>
  <!---->
  <div class="col-12 px-1">
    <ol class="breadcrumb bg-white mb-2">
      <li class="breadcrumb-item"><a class="text-danger" href="{:daohangUrl('daohang/index/index')}">首页</a></li>
      <li class="breadcrumb-item"><a href="{:daohangUrl('daohang/tag/all')}">标签列表</a></li>
      <li class="breadcrumb-item active">{$term_name|DcHtml}</li>
    </ol>
    <!---->
    <div class="card mb-2">
      <div class="card-header px-2 d-flex flex-row justify-content-between align-items-center">
        <span><i class="fa fa-fw fa-desktop mr-1 text-danger"></i>与<strong class="mx-1 text-danger">{$term_name|DcHtml}</strong>相关的网站</span>
        <a class="text-muted" href="{:daohangUrlFilter(['termId'=>$term_id,'pageSize'=>20,'pageNumber'=>1,'sortName'=>'info_id','sortOrder'=>'desc'])}">更多>></a>
      </div>
      <div class="card-body row pb-0 mb-0">
        {volist name=":daohangSelect(['term_id'=>$term_id,'status'=>'normal','limit'=>100,'sort'=>'info_order desc,info_update_time','order'=>'desc'])" id="web" mod="9"}
        <ul class="col-4 col-md-2 col-lg-auto w-10 list-unstyled text-truncate text-center">
          <li class="w-100 mb-2"><a href="{:daohangUrlInfo($web)}"><img src="{:daohangUrlImage($web['image_ico'],$web['image_level'])}" class="dh-circle border p-1" alt="{$web.info_name|DcHtml}" width="64" height="64"></a></li>
          <li class="w-100"><a class="{$web.info_color|daohangColor}" href="{:daohangUrlInfo($web)}">{$web.info_name|daohangSubstr=0,6,false}</a></li>
        </ul>
        {/volist}
      </div>
    </div>
    <!---->
  </div>
  <!---->
</div>
</div>
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}