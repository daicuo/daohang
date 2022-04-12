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
<div class="bg-white py-4 mb-2">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-10 order-2 order-md-1">
        <h2 class="mb-3 text-truncate">{$info_name|DcHtml}{if $info_type neq 'index'}<i class="fa fa-fw fa-hand-peace-o text-danger"></i>{/if}</h2>
        <p class="lead text-muted mb-0">{$info_excerpt|daohangSubstr=0,84}</p>
      </div>
      <div class="col-12 col-md-2 text-center order-1 order-md-2 mb-3 col-mb-0">
        <img class="img-thumbnail rounded-circle img-detail" src="{:daohangUrlImage($image_ico,$image_level)}" alt="{$info_name|DcHtml}">
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row dh-row">
    <!---->
    <div class="col-12 col-md-3 px-1 order-2 order-md-1">
      <div class="card mb-2">
        <div class="card-header px-2 d-flex flex-row justify-content-between align-items-center">
          <span><i class="fa fa-fw fa-desktop mr-1 text-danger"></i>最新收录</span>
          <a class="small" href="{:daohangUrlFilter(['termId'=>$category_id[0],'pageSize'=>20,'pageNumber'=>1,'sortName'=>'info_update_time','sortOrder'=>'desc'])}">更多>></a>
        </div>
        <div class="card-body px-2 pb-0">
          {volist name=":daohangSelect(['term_id'=>['in',$category_id],'status'=>'normal','limit'=>'10','sort'=>'info_id','order'=>'desc'])" id="daohang"}
          <p class="text-truncate">
          {gt name="i" value="3"}
          <span class="badge dh-badge badge-secondary mr-2">{$i}</span>
          {else/}
          <span class="badge dh-badge badge-danger mr-2">{$i}</span>
          {/gt}
          <a class="{$daohang.info_color|daohangColor}" href="{:daohangUrlInfo($daohang)}">{$daohang.info_name|daohangSubstr=0,12,false}</a>
          <small class="float-right text-muted">{$daohang.info_create_time|daohangDate='m.d',###}</small>
          </p>
          {/volist}
        </div>  
      </div>
      {include file="widget/ads250" /}
    </div>
    <!---->
    <div class="col-12 col-md-9 px-1 order-1 order-md-2">
      <ol class="breadcrumb bg-white mb-2">
        <li class="breadcrumb-item"><a class="text-danger" href="{:daohangUrl('daohang/index/index')}">首页</a></li>
        {volist name="category" id="term"}
        <li class="breadcrumb-item"><a href="{:daohangUrlCategory($term)}">{$term.term_name}</a></li>
        {/volist}
        <li class="breadcrumb-item active">网站信息 </li>
      </ol>
      <div class="card mb-2">
        <div class="card-body pb-0">
          <div class="row">
            <p class="col-12 text-truncate"><strong>网站地址：</strong><a class="text-danger" href="{:daohangUrlJump($info_type,$info_referer,$info_id)}" target="_blank" data-id="{$info_id}" data-type="{$info_type|default='index'}">{$info_referer|daohangReferer}</a></p>
            <p class="col-12 col-md-6 text-truncate"><strong>网站名称：</strong>{$info_name|DcHtml}</p>
            <p class="col-12 col-md-6"><strong>收录时间：</strong>{$info_create_time}</p>
            <p class="col-12 col-md-6"><strong>浏览次数：</strong>{$info_views|number_format}</p>
            <p class="col-12 col-md-6"><strong>出站次数：</strong>{$info_hits|number_format}</p>
            <p class="col-12"><strong>分类标签：</strong>
            {volist name="category" id="term" offset="0" length="5"}
              <a href="{:daohangUrlCategory($term)}">{$term.term_name|DcHtml}</a>
            {/volist}
            {volist name="tag" id="term" offset="0" length="5"}
              <a href="{:daohangUrlTag($term)}">{$term.term_name|DcHtml}</a>
            {/volist}</p>
            <p class="col-12 mb-4">
              <strong>网站介绍：</strong>
              {$info_content|daohangStrip}
            </p>
            <p class="col-12 text-center">
              <a class="btn btn-lg btn-danger" href="{:daohangUrl('daohang/json/up',['id'=>$info_id])}" data-toggle="infoUp">
                <i class="fa fa-thumbs-o-up"></i>
                <small class="infoUpValue">{$info_up|number_format}</small>
              </a>
            </p>
          </div>
        </div>
      </div>
      {include file="widget/ads728" /}
      <div class="card mb-2">
        <div class="card-header px-2 d-flex flex-row justify-content-between align-items-center">
          <span><i class="fa fa-fw fa-desktop mr-1 text-danger"></i>人气网站</span>
          <a class="small" href="{:daohangUrlFilter(['termId'=>$category_id[0],'pageSize'=>20,'pageNumber'=>1,'sortName'=>'info_update_time','sortOrder'=>'desc'])}">更多>></a>
        </div>
        <div class="card-body row pb-0 mb-0">
        {volist name=":daohangSelect(['term_id'=>['in',$category_id],'status'=>'normal','limit'=>32,'sort'=>'info_views','order'=>'desc'])" id="web" mod="9"}
        <p class="col-6 col-md-3 px-1 text-truncate">
          <a class="{$web.info_color|daohangColor}" href="{:daohangUrlInfo($web)}">
            {if in_array($web['info_type'],['fast','head','recommend'])}<i class="fa fa-fw fa-desktop text-danger"></i>{else/}<i class="fa fa-fw fa-desktop text-muted"></i>{/if}
            {$web.info_name|daohangSubstr=0,10}
          </a>
        </p>
        {/volist}
      </div>
      </div>
      <div class="card mb-2">
        <div class="card-header">
          <i class="fa fa-fw fa-question mr-1 text-danger"></i>免责申明
        </div>
        <div class="card-body pb-0">
          <p>1、本文数据来源于{$info_name|DcHtml}（{$info_referer|DcDomain}）。</p>
          <p>2、本站收录{$info_name|DcHtml}时该网站内容都正常，如遇失效、请联系网站管理员修复。</p>
          <p>3、本站仅提供{$info_name|DcHtml}的信息展示，不承担相关法律责任。</p>
          <p>4、本站不接受任何违法信息提交，如有违法内容，请立即举报。</p>
          <p>5、本文地址 {$domain}{:daohangUrlInfo(['info_id'=>$info_id,'info_slug'=>$info_slug,'info_name'=>$info_name])}，复制请保留版权链接。</p>
        </div>
      </div>
    </div>
  </div>
</div>
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}