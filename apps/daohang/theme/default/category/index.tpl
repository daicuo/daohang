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
  <div class="col-12 col-md-3 px-1 order-2 order-md-1">
    <div class="card mb-2">
      <div class="card-header px-2 bg-white d-flex flex-row justify-content-between align-items-center">
        <span><i class="fa fa-fw fa-desktop mr-1 text-danger"></i>人气排行</span>
        <a class="small text-danger" href="{:daohangUrlFilter(['termId'=>$term_id,'pageSize'=>20,'pageNumber'=>1,'sortName'=>'info_views','sortOrder'=>'desc'])}">更多>></a>
      </div>
      <div class="card-body px-2 pb-0">
        {volist name=":daohangSelect(['status'=>'normal','term_id'=>['in',$term_ids],'limit'=>15,'sort'=>'info_views','order'=>'desc'])" id="web"}
        <p class="text-truncate">
          {gt name="i" value="3"}
          <span class="badge dh-badge badge-secondary mr-2">{$i}</span>
          {else/}
          <span class="badge dh-badge badge-danger mr-2">{$i}</span>
          {/gt}
          <a class="text-dark" href="{:daohangUrlInfo($web)}">{$web.info_name|DcHtml|daohangSubstr=0,10,false}</a>
          <small class="float-right text-muted">{$web.info_views|number_format}</small>
        </p>
        {/volist}
      </div>
    </div>
    {include file="widget/ads250" /}
    <div class="card mb-2">
      <div class="card-header px-2 bg-white d-flex flex-row justify-content-between align-items-center">
        <span><i class="fa fa-fw fa-tags mr-1 text-danger"></i>热门标签</span>
        <a class="small text-danger" href="{:daohangUrl('daohang/tag/all')}">更多>></a>
      </div>
      <div class="card-body px-2 pb-0 text-center row dh-row">
        {volist name=":daohangTagSelect(['limit'=>'30','status'=>'normal','sort'=>'term_count','order'=>'desc'])" id="tag"}
        <p class="col-4 px-1">
          <a class="btn btn-light btn-block btn-sm" href="{:daohangUrlTag($tag)}">{$tag.term_name|daohangSubstr=0,4,false}</a>
        </p>
        {/volist}
      </div> 
    </div>
  </div>
  <!---->
  <div class="col-12 col-md-9 px-1 order-1 order-md-2">
    <ol class="breadcrumb bg-white mb-2">
      <li class="breadcrumb-item"><a class="text-danger" href="{:daohangUrl('daohang/index/index')}">首页</a></li>
      <li class="breadcrumb-item"><a href="{:daohangUrl('daohang/category/all')}">栏目分类</a></li>
      <li class="breadcrumb-item active">{$term_name|DcHtml}</li>
    </ol>
    <!---->
    {assign name="list" value=":daohangSelect([
      'cache'    => true,
      'status'   => 'normal',
      'sort'     => $sortName,
      'order'    => $sortOrder,
      'limit'    => 20,
      'page'     => $pageNumber,
      'term_id'  => ['in',$term_ids],
    ])" /}
    <!---->
    <div class="list-group mb-2">
      {foreach $list['data'] as $web}
      <li class="list-group-item">
        <h6 class="mt-0 text-truncate">
          <a class="{$web.info_color|daohangColor}" href="{:daohangUrlInfo($web)}">{$web.info_name|DcHtml}</a>
          <a class="badge badge-danger dh-badge-pink font-weight-normal" href="{:daohangUrlJump($web['info_type'],$web['info_referer'],$web['info_id'])}" target="_blank" data-id="{$web.info_id}" data-type="{$web.info_type|default='index'}">浏览</a>
          {if $web['info_type'] eq 'fast'}<i class="fa fa-fw fa-check-circle text-danger"></i>{/if}
        </h6>
        <p class="text-muted small">
          {$web.info_excerpt|DcHtml}
        </p>
        <div class="w-100 d-flex justify-content-between">
          <ul class="list-inline small mb-0">
            <li class="list-inline-item">收录时间：<label class="text-muted">{$web.info_create_time|daohangDate='Y-m-d',###}</label></li>
            <li class="list-inline-item">浏览人数：<label class="text-muted">{$web.info_views|number_format}</label></li>
            <li class="list-inline-item">点击次数：<label class="text-muted">{$web.info_hits|number_format}</label></li>
            <li class="list-inline-item">分类与标签：
            {volist name="web.category" id="term" offset="0" length="3"}
            <a class="text-muted" href="{:daohangUrlCategory($term)}">{$term.term_name}</a>
            {/volist}
            {volist name="web.tag" id="term" offset="0" length="3"}
            <a class="text-muted" href="{:daohangUrlTag($tag)}">{$tag.term_name|DcHtml}</a>
            {/volist}
            </li>
          </ul>
          <div class="small text-muted d-none d-md-inline">
            <a class="text-danger" href="{:daohangUrlInfo($web)}">网站详情>></a>
          </div>
        </div>
      </li>
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