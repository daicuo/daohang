<nav class="navbar navbar-expand-md navbar-dark bg-purple">
<div class="container">
  <a class="navbar-brand" href="{$path_root}">{:config('common.site_name')}</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav">
    <span class="navbar-toggler-icon"></span>
  </button>
  {if $user['user_id']}
    {assign name="navbars" value=":DcTermNavbar(['type'=>'navbar','status'=>['in','normal,private']])" /}
  {else/}
    {assign name="navbars" value=":DcTermNavbar(['type'=>'navbar','status'=>['in','normal,public']])" /}
  {/if}
  <div class="collapse navbar-collapse" id="nav">
    <ul class="navbar-nav ml-auto">
      {volist name="navbars" id="navbar" offset="0" length="99"}
      {if $navbar['_child']}
        <li class="nav-item dropdown {:DcDefault($module.$controll.$action, $navbar['navs_active'], 'active', 'nav-'.$key)}" id="{$navbar.navs_active|default='nav-'.$key}">
          <a class="nav-link dropdown-toggle" href="{$navbar.navs_link}" data-toggle="dropdown">{$navbar.navs_name|DcSubstr=0,6,false}</a>
          <div class="dropdown-menu mt-0">
            {volist name="navbar._child" id="navSon"}
            <a class="dropdown-item" href="{$navSon.navs_link}" target="{$navSon.navs_target}">{$navSon.navs_name|DcSubstr=0,6,false}</a>
            {/volist}
          </div>
        </li>
      {else/}
        <li class="nav-item {:DcDefault($module.$controll.$action, $navbar['navs_active'], 'active', '')}" id="{$navbar.navs_active}">
          <a class="nav-link" href="{$navbar.navs_link}" target="{$navbar.navs_target}">{$navbar.navs_name|DcSubstr=0,6,false}</a>
        </li>
      {/if}
      {/volist}
    </ul>
  </div>
</div>
</nav>