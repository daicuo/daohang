{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>我的投稿-{:config('common.site_name')}</title>
{/block}
<!-- -->
{block name="header"}{include file="widget/header" /}{/block}
<!-- -->
{block name="main"}
<div class="container pt-5 pt-md-3 mb-3">
<div class="row dh-row">
  <div class="col-12 col-md-2 px-1">
    {include file="widget/sitebar" /}
  </div>
  <div class="col-12 col-md-10 px-1">
    <div class="card">
    <div class="card-header h5">我的投稿</div>
    <div class="card-body">
      敬请期待...
    </div> 
  </div>
  </div> <!--col-12 end-->
</div> <!-- row end-->
</div> <!-- /container -->
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}