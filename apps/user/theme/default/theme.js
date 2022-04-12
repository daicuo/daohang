$(document).ready(function () {
    $.extend(window.daicuo, {
        user : {
            dialog: function($result, $status, $xhr){
                if ($result.code == 1) {
                    //window.location.href = $('form[data-toggle="form"]').data('center');
                    window.location.href = $result.data.redirect;
                }else{
                    window.daicuo.bootstrap.dialog($result.msg);
                    window.daicuo.captcha.refresh();
                }
            }
        }
    }); //extendEnd
    window.daicuo.captcha.refresh();
    window.daicuo.captcha.init();
    window.daicuo.form.init();
    window.daicuo.ajax.onClick('[data-toggle="get"]');
});