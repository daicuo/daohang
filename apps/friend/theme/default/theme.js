window.daicuo.friend = {
    publish: function($result, $status, $xhr){
        if ($result.code == 1) {
            window.daicuo.bootstrap.dialog($result.msg);
            setTimeout('location.reload()', 3000);
        }else{
            window.daicuo.captcha.refresh();
            window.daicuo.bootstrap.dialog($result.msg);
        }
    }
};
$(document).ready(function() { 
    window.daicuo.captcha.init();
    window.daicuo.form.init();
    window.daicuo.upload.init();
});