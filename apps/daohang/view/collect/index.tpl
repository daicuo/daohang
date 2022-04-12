{extend name="apps/common/view/admin.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{:lang("daohang/collect/index")}－{:lang('appName')}</title>
{/block}
<!-- -->
{block name="main"}
<h6 class="border-bottom pb-2">
  <a class="btn btn-sm btn-purple" href="{:DcUrlAddon(['module'=>'daohang','controll'=>'collect','action'=>'create'])}" data-toggle="create" data-modal-xl="0"><i class="fa fa-plus"></i> {:lang("daohang/collect/create")}</a>
  <a class="btn btn-sm btn-danger" href="https://hao.daicuo.cc/daohang/apis" target="_blank"><i class="fa fa-list"></i> {:lang("daohang/collect/server")}</a>
</h6>
<!-- -->
<ul class="list-group">
{volist name="item" id="caiji"}
  <li class="list-group-item">
    <p class="mb-2 text-purple"><strong class="text-dark">资源名称：</strong>{$caiji.collect_name}</p>
    <p class="mb-2 text-muted"><strong class="text-dark">采集接口：</strong>{$caiji.collect_url}</p>
    <p class="mb-2 text-muted"><strong class="text-dark">转换规则：</strong>{$caiji.collect_categoryBind|implode=',',###|default='不需转换'}</p>
    <p class="mb-0 text-muted">
      <a class="badge badge-dark mr-2" href="{:DcUrlAddon(['module'=>'daohang','controll'=>'collect','action'=>'write','id'=>$caiji['collect_id'],'time'=>date('Y-m-d')])}" data-toggle="collect">采集当天</a>
      <a class="badge badge-dark mr-2" href="{:DcUrlAddon(['module'=>'daohang','controll'=>'collect','action'=>'write','id'=>$caiji['collect_id'],'time'=>date('Y-m-d',strtotime("-7 days"))])}" data-toggle="collect">采集本周</a>
      <a class="badge badge-dark mr-2" href="{:DcUrlAddon(['module'=>'daohang','controll'=>'collect','action'=>'write','id'=>$caiji['collect_id'],'time'=>date('Y-m-d',strtotime("-30 days"))])}" data-toggle="collect">采集本月</a>
      <a class="badge badge-dark mr-2" href="{:DcUrlAddon(['module'=>'daohang','controll'=>'collect','action'=>'write','id'=>$caiji['collect_id']])}" data-toggle="collect">采集所有</a>
      <a class="badge badge-purple mr-2" href="{:DcUrlAddon(['module'=>'daohang','controll'=>'collect','action'=>'bind','id'=>$caiji['collect_id']])}" data-toggle="get">绑定分类</a>
      <a class="badge badge-secondary mr-2" href="{:DcUrlAddon(['module'=>'daohang','controll'=>'collect','action'=>'edit','id'=>$caiji['collect_id']])}" data-toggle="edit" data-modal-xl="0">修改</a>
      <a class="badge badge-secondary" href="{:DcUrlAddon(['module'=>'daohang','controll'=>'collect','action'=>'delete','id'=>$caiji['collect_id']])}" data-toggle="delete">删除</a>
    </p>
  </li>
{/volist}
</ul>
{/block}
{block name="js"}
<script>
var collectUrl  = true;
var collectAjax = function($url){
    if(collectUrl == false){
        return false;
    }
    $.ajax({
        url: $url,
        type: 'get',
        //dataType: 'json',
        error : function(){
            $('#collect-item').html('');
            $('#collect-loading').html('<h6 class="text-center py-5">加载采集组件失败，请重试...</h6>');
        },
        success: function(json){
            if(json.code==1){
                $('#collect-loading').html('<p class="small">'+json.msg+'</p>');
            }else{
                $('#collect-loading').html('<h6 class="text-center py-5">'+json.msg+'</h6>');
            }
            $('#collect-item').html('');
            $.each(json.data.list, function(index, value){
                $('#collect-item').append('<p class="small">'+value+'</p>');
            });
            if(json.data.nextPage){
                collectAjax(json.data.nextPage);
            }else{
                collectUrl  = false;
                $('#collect-item').html('');
                $('#collect-loading').html('<h2 class="text-center py-5">采集完成...</h2>');
            }
       }
    });
}
//点击事件
$(document).on("click", '[data-toggle="collect"]', function() {
    $('.dc-modal .modal-dialog').removeClass('modal-lg modal-xl').html('<div class="modal-content"><div class="modal-header pt-2 pb-1"><h6 class="my-0 py-0">一键API采集</h6><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="text-primary">&times;</span></button></div><div class="modal-body" id="collect-href" data-src="'+$(this).attr('href')+'"><div class="text-danger" id="collect-loading"><p class="text-center py-5"><span class="fa fa-spinner fa-spin"></span> Loading...</p></div><div id="collect-item"></div></div>');
    $('.dc-modal').modal('show');
    return false;
});
$('.dc-modal').on('show.bs.modal', function (event) {
    collectUrl  = true;
    collectAjax($('#collect-href').data('src'));
});
$('.dc-modal').on('hidden.bs.modal', function (event) {
    collectUrl = false;
    $('#collect-iframe').remove();
});
</script>
{/block}