$(function() {
    $.getUrlParam = function(name){
        var reg = new RegExp("(^|&)"+name +"=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r!=null) {
            return unescape(r[2]);
        }
        return null;
    };
    $.extend(daicuo.admin, {
        daohang : {
            events: {
                'click [data-toggle="edit"]': function (event, value, row, index) {
                    $(event.currentTarget).attr('data-toggle','');
                    $(event.currentTarget).attr('data-callback','');
                }
            },
            eventsDialog: {
                'click [data-toggle="edit"]': function (event, value, row, index) {
                    $(event.currentTarget).attr('data-callback','window.daicuo.admin.daohang.dialog');
                }
            },
            dialog: function($data, $status, $xhr) {
                window.daicuo.bootstrap.dialogForm($data);
                window.daicuo.upload.init();
            },
            userName : function(value, row, index, field){
                var $url = daicuo.config.file + '/addon/index?module='+$.getUrlParam('module')+'&controll='+$.getUrlParam('controll')+'&action=index&'+ field +'='+value;
                return '<a class="text-purple" href="'+$url+'">'+value+'</a>';
            },
        }
    }); //extendEnd

}); //jqueryEnd