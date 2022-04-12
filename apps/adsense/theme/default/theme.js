//theme.js
$(function() {
    $(document).on("click", '[data-toggle="adsense"]', function(){
        $.get(daicuo.config.root+'index.php?s=adsense/hits/index&id='+$(this).data('id'));
    });
});