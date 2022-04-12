{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>充值记录-{:config('common.site_name')}</title>
{/block}
<!-- -->
{block name="header"}{include file="widget/header" /}{/block}
<!-- -->
{block name="main"}
<div class="container pt-2">
  <div class="row">
    <div class="col-12 col-md-2">
      {include file="widget/sitebar" /}
    </div>
    <div class="col-12 col-md-10">
       <ul class="list-group">
         <li class="list-group-item small">
            <div class="row">
            <div class="col-5">订单号</div>
            <div class="col text-center">金额</div>
            <div class="col text-center">支付状态</div>
            <div class="col text-center">创建时间</div>
            </div>
          </li>
          {volist name="data" id="order"}
          <li class="list-group-item small">
            <div class="row">
            <div class="col-5">{$order.pay_sign}</div>
            <div class="col text-center">{$order.pay_total_fee}</div>
            <div class="col text-center">{if $ordey['pay_status'] eq 1}等待付款{else/}{$order.pay_status_text}{/if}</div>
            <div class="col text-center">{$order.pay_create_time}</div>
            </div>
          </li>
          {/volist}
      </ul>
      {gt name="last_page" value="1"}
      <div class="border rounded bg-white mt-2 pt-3 d-flex justify-content-center">
      {:DcPage($current_page, $per_page, $total, DcUrl('user/recharge/log',['pageNumber'=>'[PAGE]']))}
      </div>
      {/gt}
    </div> <!--col-12 end-->
  </div> <!-- row end-->
</div> <!-- /container -->
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}