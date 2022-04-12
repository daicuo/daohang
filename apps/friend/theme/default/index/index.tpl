{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{$seoTitle}－{:config('common.site_name')}</title>
<meta name="keywords" content="{$seoKeywords}" />
<meta name="description" content="{$seoDescription}"  />
{/block}
{block name="header"}{include file="widget/header" /}{/block}
{block name="main"}
<div class="container">
<div class="card mb-2">
  <div class="card-header px-2 bg-white d-flex flex-row justify-content-between align-items-center">
    <span><i class="fa fa-fw fa-link mr-1 text-danger"></i>友情链接</span>
    <a class="text-danger small" href="{:DcUrl('friend/publish/index')}" target="_self">申请友情链接</a>
  </div>
  <div class="card-body row py-1">
    {volist name=":friendSelect(['status'=>'normal','sort'=>'info_order','order'=>'desc'])" id="friend"}
    <div class="col-6 col-md-2 my-2">
    <a class="text-dark" href="{$friend.friend_referer|default='javascript:;'}" target="_blank" data-id="{$friend.info_id}" data-type="links">{$friend.info_name|DcHtml|DcSubstr=0,8,false}</a>
    </div>
    {/volist}
  </div> 
</div>
{if function_exists('adsenseShow')}
<div class="w-100 text-center">{:adsenseShow("doubi97090")}</div>
{/if}
</div>
{/block}
{block name="footer"}{include file="widget/footer" /}{/block}