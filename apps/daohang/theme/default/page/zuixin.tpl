{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>最新网站－{:config('common.site_name')}</title>
<meta name="keywords" content="免费收录网站,最新收录的网站" />
<meta name="description" content="{:config('common.site_name')}收录的网站按收录时间最近排行。" />
{/block}
<!-- -->
{block name="header"}{include file="widget/header" /}{/block}
<!--main -->
{block name="main"}
<div class="container pt-2">
<div class="row dh-row">
{include file="widget/ads970" /}
{volist name=":daohangCategorySelect(['action'=>'index','status'=>'normal','sort'=>'term_order','order'=>'desc','result'=>'array'])" id="category"}
  <div class="col-12 col-md-3 px-1 mb-2">
    <div class="card">
      <div class="card-header px-2 d-flex flex-row justify-content-between align-items-center">
        <span><i class="fa fa-fw fa-desktop mr-1 text-danger"></i>{$category.term_name}</span>
        <a class="small text-danger" href="{:daohangUrlFilter(['termId'=>$category['term_id'],'pageSize'=>30,'pageNumber'=>1,'sortName'=>'info_update_time','sortOrder'=>'desc'])}">更多>></a>
      </div>
      <div class="card-body pb-0 px-2">
        {volist name=":daohangSelect(['status'=>'normal','limit'=>'10','sort'=>'info_id','order'=>'desc','term_id'=>['eq',$category['term_id']]])" id="daohang"}
        <p class="text-truncate">
          {gt name="i" value="3"}
          <span class="badge dh-badge badge-secondary mr-2">{$i}</span>
          {else/}
          <span class="badge dh-badge badge-danger mr-2">{$i}</span>
          {/gt}
          <a class="{$daohang.info_color|daohangColor}" href="{:daohangUrlInfo($daohang)}">{$daohang.info_name|daohangSubstr=0,11,false}</a>
          <small class="float-right text-muted">{$daohang.info_create_time|daohangDate='m.d',###}</small>
        </p>
        {/volist}
      </div> 
    </div>
  </div>
{/volist}
</div>
</div>
{/block}
{block name="footer"}{include file="widget/footer" /}{/block}
<!-- -->