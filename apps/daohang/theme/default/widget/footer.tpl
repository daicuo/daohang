<div class="container pt-2">
<p class="text-md-center mb-2">
  Copyright © 2020-2021 {:config('common.site_domain')}
  {if config('common.site_icp')}
  <a href="https://beian.miit.gov.cn" target="_blank">{:config('common.site_icp')}</a>
  {/if}
  {if config('common.site_gongan')}
  <img src="{$path_root}public/images/gongan.png" alt="gongan" width="16" height="16">
  <a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode={:daohangGongan()}" target="_blank">{:config('common.site_gongan')}</a>
  {/if}
</p>
<p class="text-md-center">
  {volist name=":daohangNavbar(['type'=>'link','status'=>['in',['normal','public']],'sort'=>'term_order','order'=>'desc'])" id="links"}
  <a class="text-dark" href="{$links.navs_link}" target="{$links.navs_target}">{$links.navs_name|daohangSubstr=0,6,false}</a>
  {/volist}
</p>
</div>