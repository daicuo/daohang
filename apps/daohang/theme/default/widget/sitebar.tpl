<ul class="list-group mb-3 mb-md-0">
  {volist name=":daohangNavbar(['type'=>'sitebar'])" id="navbar"}
    <a class="list-group-item list-group-item-action {:DcDefault($module.$controll.$action,$navbar['navs_active'],'list-group-item-dark','list-group-item-light')}" href="{$navbar.navs_link}" target="{$navbar.navs_target}">{$navbar.navs_name|daohangSubstr=0,6,false}</a>
  {/volist}
</ul>