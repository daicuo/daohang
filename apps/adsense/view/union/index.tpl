{extend name="apps/common/view/admin.tpl" /}
<!-- -->
{block name="header_meta"}
<title>广告联盟推荐－{:lang('appName')}</title>
{/block}
<!-- -->
{block name="main"}
<h6 class="border-bottom pb-2 text-purple">
  广告联盟推荐
</h6>
{$alert}
<ul class="list-group mb-3">
  {volist name="item" id="adsense"}
  <li class="list-group-item">
    <p class="mb-2">
      <a class="text-purple text-decoration-none mr-1 h5" href="{$adsense.info_link}" target="_blank">{$adsense.info_name}</a>
      {$adsense.info_admin}
      {$adsense.info_badge}
    </p>
    <p class="mb-1 text-dark">{$adsense.info_excerpt}</p>
    <p class="mb-1 text-muted">{$adsense.info_content}</p>
  </li>
  {/volist}
</ul>
{/block}
<!-- -->