{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>积分日志-{:config('common.site_name')}</title>
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
        <div class="col-2 text-center">日志ID</div>
        <div class="col-2 text-center">积分变化</div>
        <div class="col text-center">操作日志</div>
        <div class="col text-right">创建时间</div>
        </div>
      </li>
      {volist name="data" id="daicuo"}
      <li class="list-group-item small">
        <div class="row">
        <div class="col-2 text-center">{$daicuo.log_id}</div>
        <div class="col-2 text-center">{gt name="daicuo.log_value" 0}+{/gt}{$daicuo.log_value}</div>
        <div class="col text-center">{$daicuo.log_name|lang}</div>
        <div class="col text-right">{$daicuo.log_create_time}</div>
        </div>
      </li>
      {/volist}
      </ul>
      {gt name="last_page" value="1"}
      <div class="border rounded bg-white mt-2 pt-3 d-flex justify-content-center">
      {:DcPage($current_page, $per_page, $total, DcUrl('user/score/index',['pageNumber'=>'[PAGE]']))}
      </div>
      {/gt}
    </div> <!--col-12 end-->
  </div> <!-- row end-->
</div> <!-- /container -->
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}