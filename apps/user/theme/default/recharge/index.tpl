{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>积分充值-{:config('common.site_name')}</title>
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
      <div class="card-header">积分充值</div>
      <div class="card-body px-md-5">
        <p class="text-center">1元人民币可充值（<strong class="text-danger">{:config('user.score_recharge')}</strong>）个{:config('common.site_name')}的积分</p>
        <form class="mb-2" action="{:DcUrl('user/recharge/save')}" method="post" target="_self" data-toggle="form-" data-callback="">
          <div class="input-group mb-3">
            <input class="form-control" type="text" name="value" id="value" value="10" placeholder="请输入金额" autocomplete="off" required>
            <div class="input-group-append">
              <button class="btn btn-dark" type="submit">在线充值</button>
            </div>
          </div>
          {foreach name=":payPlatForms()" id="platForm"}
          <div class="custom-control custom-radio mt-2">
            <input class="custom-control-input" name="platform" id="platform_{$key}" type="radio" value="{$platForm}" {if $key eq 0}checked{/if}>
            <label class="custom-control-label" for="platform_{$key}">{:lang('pay_'.$platForm)}</label>
          </div>
          {/foreach}
        </form>
        <!---->
        <div class="row">
          <div class="col-6 col-md-4 my-3">
            <a class="btn btn-outline-secondary btn-block py-3" href="{:DcUrl('user/recharge/save',['platform'=>'alipay','value'=>5])}" data-toggle="recharge">
              <h3 class="text-danger mb-2">5元</h3>
              <h6 class="text-center small text-truncate">充值（{:userRmbToScore(5)}）积分需要支付5元</h6>
            </a>
          </div>
          <div class="col-6 col-md-4 my-3">
            <a class="btn btn-outline-secondary btn-block py-3" href="{:DcUrl('user/recharge/save',['platform'=>'alipay','value'=>10])}" data-toggle="recharge">
              <h3 class="text-danger mb-2">10元</h3>
              <h6 class="text-center small text-truncate">充值（{:userRmbToScore(10)}）积分需要支付10元</h6>
            </a>
          </div>
          <div class="col-6 col-md-4 my-3">
            <a class="btn btn-outline-secondary btn-block py-3" href="{:DcUrl('user/recharge/save',['platform'=>'alipay','value'=>20])}" data-toggle="recharge">
              <h3 class="text-danger mb-2">20元</h3>
              <h6 class="text-center small text-truncate">充值（{:userRmbToScore(20)}）积分需要支付20元</h6>
            </a>
          </div>
          <div class="col-6 col-md-4 my-3">
            <a class="btn btn-outline-secondary btn-block py-3" href="{:DcUrl('user/recharge/save',['platform'=>'alipay','value'=>50])}" data-toggle="recharge">
              <h3 class="text-danger mb-2">50元</h3>
              <h6 class="text-center small text-truncate">充值（{:userRmbToScore(50)}）积分需要支付50元</h6>
            </a>
          </div>
          <div class="col-6 col-md-4 my-3">
            <a class="btn btn-outline-secondary btn-block py-3" href="{:DcUrl('user/recharge/save',['platform'=>'alipay','value'=>100])}" data-toggle="recharge">
              <h3 class="text-danger mb-2">100元</h3>
              <h6 class="text-center small text-truncate">充值（{:userRmbToScore(100)}）积分需要支付100元</h6>
            </a>
          </div>
          <div class="col-6 col-md-4 my-3">
            <a class="btn btn-outline-secondary btn-block py-3" href="{:DcUrl('user/recharge/save',['platform'=>'alipay','value'=>500])}" data-toggle="recharge">
              <h3 class="text-danger mb-2">500元</h3>
              <h6 class="text-center small text-truncate">充值（{:userRmbToScore(500)}）积分需要支付500元</h6>
            </a>
          </div>
        </div>
        <!---->
      </div> 
    </div>
  </div>
</div>
</section>
{/block}
<!-- -->
{block name="js"}
<script>
$('a[data-toggle="recharge"]').on('click',function(){
  var platForm = $('input[name="platform"]:checked').val();
  if(platForm != 'alipay'){
    var url = $(this).attr('href').replace('alipay',platForm);
    $(this).attr('href',url);
  }
});
</script>
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}