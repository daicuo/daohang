{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>呆错支付演示-{:config('common.site_name')}</title>
<meta name="keywords" content="呆错支付插件,呆错支付系统演示" />
<meta name="description" content="呆错支付是一款集成支付宝与微信支付的聚合支付系统、同时可自行扩展接入第四方免签平台。"  />
{/block}
{block name="header"}{include file="public/widget/header.tpl" /}{/block}
{block name="main"}
<div class="container pt-3">
  <div class="card">
    <h6 class="card-header d-flex justify-content-between align-items-center">
      <span>呆错支付演示</span>
      <small class="text-muted">使用呆错支付实现打赏功能</small>
    </h6>
    <div class="card-body">
      <form class="col-md-6 offset-md-3" action="{:DcUrl('pay/index/save')}" method="post">
        <div class="form-group mb-4">
          <label for="score_rmb"><strong>打赏金额</strong></label>
          <input class="form-control" name="score_rmb" id="score_rmb" type="text" value="9.9" autocomplete="off" required>
        </div>
        <div class="form-text mb-1">
          <label for="score_type"><strong>支付方式</strong></label>
        </div>
        {foreach name=":payPlatForms()" id="platForm"}
        <div class="custom-control custom-radio mb-3">
          <input class="custom-control-input" name="score_type" id="score_type_{$key}" type="radio" value="{$platForm}" {if $key eq 0}checked{/if}>
          <label class="custom-control-label" for="score_type_{$key}"><img class="pay-icon mr-1" src="https://cdn.daicuo.cc/images/icon.pay/{$platForm}.png" alt="{$platForm}">{:lang('pay_'.$platForm)}</label>
        </div>
        {/foreach}
        <div class="form-group text-center">
          <button class="btn btn-purple" type="submit">任性打赏</button>
        </div>
      </form>
    </div>
  </div>
</div>
{/block}
{block name="footer"}{include file="public/widget/footer.tpl" /}{/block}