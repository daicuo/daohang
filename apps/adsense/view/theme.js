$(function() {
    //扩展daicuo.admin
    $.extend(daicuo.admin, {
        adsense : {
            //监听切换事件
            onChange: function(){
                $(document).on("change", '.info_action .form-check-input', function(){
                    daicuo.admin.adsense.showInfoType($(this).val());
                });
            },
            //根据广告类型展示字段
            showInfoType: function($value){
                $('.dc-modal .adsense').addClass('d-none');
                $('.'+$value).removeClass('d-none');
            },
            //新增回调事件
            bakCreate: function($data, $status, $xhr){
                daicuo.bootstrap.dialogForm($data);
                daicuo.upload.init();
            },
            //编辑回调事件
            bakEdit:function($data, $status, $xhr) {
                daicuo.bootstrap.dialogForm($data);//展示表单数据
                daicuo.upload.init();//上传插件
                daicuo.admin.adsense.showInfoType($('.dc-modal .info_action .form-check-input:checked').val());//展示广告类型
            },
            //data-formatter 用户选项
            bakOperate: function(value, row, index, field){
                var $url_preview = row.info_link;
                var $url_edit = '?module=adsense&controll=admin&action=edit&id='+row.info_id;
                var $url_delete = '?module=adsense&controll=admin&action=delete&id='+row.info_id;
                return '<div class="btn-group btn-group-sm"><a class="btn btn-outline-secondary" href="'+$url_preview+'" target="_blank"><i class="fa fa-fw fa-link"></i></a><a class="btn btn-outline-secondary bg-light" href="'+$url_edit+'" data-toggle="edit" data-modal-lg="true" data-callback="daicuo.admin.adsense.bakEdit"><i class="fa fa-fw fa-pencil"></i></a><a class="btn btn-outline-secondary" href="'+$url_delete+'" data-toggle="delete"><i class="fa fa-fw fa-trash-o"></i></a></div>';
            }
        }
    }); //extend
    daicuo.admin.adsense.onChange();
}); //jquery