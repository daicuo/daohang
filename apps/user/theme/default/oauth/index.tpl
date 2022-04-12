{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>绑定第三方帐号-{:config('common.site_name')}</title>
{/block}
<!-- -->
{block name="header"}{include file="widget/header" /}{/block}
<!-- -->
{block name="main"}
<section class="container pt-2">
<div class="row dh-row">
  <div class="col-12 col-md-2 px-1">
    {include file="widget/sitebar" /}
  </div>
  <div class="col-12 col-md-10 px-1">
    <div class="card">
      <div class="card-header">绑定第三方帐号</div>
      <div class="card-body py-5">
        <ul class="list-group w-75 mx-auto">
          {volist name="list" id="oauth"}
          <li class="list-group-item py-3 d-flex justify-content-between align-items-center">
            {$oauth.name}
            {if $oauth['isBind']}
              <font class="text-muted">已经绑定</font>
              <a class="badge badge-pill badge-danger" href="{$oauth.urlDelete}">解除绑定</a>
            {else/}
              <font class="text-muted">暂未绑定</font>
              <a class="badge badge-pill badge-primary" href="{$oauth.urlBind}">我要绑定</a>
            {/if}
          </li>
          {/volist}
        </ul>
        <!---->
      </div> 
    </div>
  </div>
</div>
</section>
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}