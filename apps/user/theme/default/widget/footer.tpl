<div class="container pt-3">
  <p class="text-md-center">
    Copyright © 2019-2022 {:config('common.site_domain')} All rights reserved
    {if config('common.site_icp')}<a class="text-dark" href="https://beian.miit.gov.cn" target="_blank">{:config('common.site_icp')}</a>{/if}
  </p>
  <p class="text-md-center">
    {volist name=":DcTermNavbar(['type'=>'link','status'=>['eq','normal'],'sort'=>'term_order','order'=>'desc'])" id="navbar"}
    <a class="text-dark" href="{$navbar.navs_link}" target="{$navbar.navs_target}">{$navbar.navs_name|DcSubstr=0,6,false}</a>
    {/volist}
  </p>
</div>