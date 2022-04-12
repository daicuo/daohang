<ul class="list-group mb-3 mb-md-0">
  {volist name=":userNavbar(['type'=>'sitebar','status'=>['in','normal,private'],'sort'=>'term_order','order'=>'desc'])" id="sitebar"}
    <a class="list-group-item list-group-item-action {:DcDefault($module.$controll.$action,$sitebar['navs_active'],'list-group-item-dark','list-group-item-light')}" href="{$sitebar.navs_link}">{$sitebar.navs_name}</a>
  {/volist}
</ul>