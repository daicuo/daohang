window.daicuo.daohang = {
    init: function(){
        this.typeClick();
        this.searchDropdown();
        this.infoUpClick();
    },
    typeClick: function(){
        $('a[data-id]').on('click', document.body, function () {
            if( $.inArray($(this).data('type'), ['fast','friend','recommend','head','foot']) > -1 ){
                $.get(daicuo.config.root+'daohang/json/hits/?id='+$(this).data('id'));
            }
            //return false;
        });
    },
    infoUpClick: function(){
        $('[data-toggle="infoUp"]').on("click", document.body, function() {
            $(this).addClass('disabled');
            var btn = $(this).find('.infoUpValue');
            daicuo.ajax.get($(this).attr('href'), function($json, $status, $xhr) {
                if($json.code == 1){
                    btn.text($json.data.value);
                }
                
            });
            return false;
        });
    },
    dialog: function($data, $status, $xhr) {
        $msg = $data.msg.split('%');
        if($msg.length > 1){
            window.daicuo.bootstrap.dialog($msg[1]);
        }else{
            window.daicuo.bootstrap.dialog($msg);
        }
        if($data.code==1){
            setTimeout('location.reload()', 1000);
        }
    },
    dropdownEvent: function(){
        $('#searchDropdown').on('show.bs.dropdown', function () {
            //$('#searchDropdown').dropdown('show');
        });
    },
    searchDropdown: function(){
        $('#searchDropdown .dropdown-item').on('click', function(){
            var formAction = $('form[id="search"]').attr('action');
            var formText   = $('form [data-toggle="dropdown"]').text();
            var thisAction = $(this).data('href');
            var thisText   = $(this).text();
            //表单
            $('form[id="search"]').attr('action',thisAction);
            $('form [data-toggle="dropdown"]').text(thisText);
            //当前
            $(this).data('href',formAction);
            $(this).text(formText);
        });
    }
};
//主题JS
$(document).ready(function() { 
    //框架脚本初始化
    window.daicuo.init();
    window.daicuo.captcha.refresh();
    //window.daicuo.table.init();
    //window.daicuo.language.init();
    //window.daicuo.sortable.init();
    //主题脚本初始化
    window.daicuo.daohang.init();
});