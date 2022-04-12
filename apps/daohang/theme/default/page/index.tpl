{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>网站地图页－{:config('common.site_name')}</title>
<meta name="keywords" content="网站地图,网站结构" />
<meta name="description" content="{$seoDescription|default='{:config('common.site_name')}的网站结构，通过此页面可以快速了解本站提供的服务。'}"  />
{/block}
<!-- -->
{block name="header"}{include file="widget/header" /}{/block}
<!--main -->
{block name="main"}
<div class="container pt-2">
  <div class="card mb-2">
    <div class="card-header h5">信息发布</div>
    <div class="card-body pb-0">
      <ul class="bg-white px-3 py-0">
        <li class="mb-2"><a href="{:daohangUrl('daohang/publish/index')}">免费发布网站</a></li>
        <li class="mb-2"><a href="{:daohangUrl('daohang/fast/index')}">免审发布网站</a></li>
      </ul>
    </div> 
  </div>
  <div class="card mb-2">
    <div class="card-header h5">会员服务</div>
    <div class="card-body pb-0">
      <ul class="bg-white px-3 py-0">
        <li class="mb-2"><a href="{:DcUrl('user/register/index',['pid'=>1])}">免费注册</a></li>
        <li class="mb-2"><a href="{:DcUrl('user/login/index')}">帐号登录</a></li>
        <li class="mb-2"><a href="{:DcUrl('user/logout/index')}">安全退出</a></li>
        <li class="mb-2"><a href="{:DcUrl('user/recharge/index')}">积分充值</a></li>
        <li class="mb-2"><a href="{:DcUrl('user/group/index')}">升级VIP</a></li>
        <li class="mb-2"><a href="{:DcUrl('user/repwd/index')}">修改密码</a></li>
      </ul>
    </div> 
  </div>
  <div class="card mb-2">
    <div class="card-header h5">网站分类</div>
    <div class="card-body pb-0">
      <ul class="bg-white px-3 py-0">
        {volist name=":daohangCategorySelect(['status'=>['eq','normal']])" id="category"}
        <li class="mb-2"><a href="{:daohangUrlCategory($category)}">{$category.term_name}</a></li>
        {/volist}
      </ul>
    </div>
  </div>
  <div class="card mb-2">
    <div class="card-header h5">常用链接</div>
    <div class="card-body pb-0">
      <ul class="bg-white px-3 py-0">
        <!--固定链接-->
        <li class="mb-2"><a href="{:daohangUrl('daohang/category/all')}">全站分类</a></li>
        <li class="mb-2"><a href="{:daohangUrl('daohang/tag/all')}">全站标签</a></li>
        <li class="mb-2"><a href="{:daohangUrl('daohang/publish/index')}">免费收录</a></li>
        <li class="mb-2"><a href="{:daohangUrl('daohang/publish/fast')}">快速收录</a></li>
        <li class="mb-2"><a href="{:daohangUrl('daohang/sitemap/index')}">网站地图</a></li>
        <li class="mb-2"><a href="{:daohangUrl('friend/index/index')}">申请友链</a></li>
        <!--导航菜单-->
        {volist name=":daohangNavbar(['action'=>['in','navbar,sitebar,navs,links,ico,image,other'],'status'=>['in','normal,publish']])" id="navbar"}
        {if $navbar['_child']}
          {volist name="navbar._child" id="navSon"}
          <li class="mb-2"><a href="{$navSon.navs_link}">{$navSon.navs_name}</a></li>
          {/volist}
        {else/}
          <li class="mb-2"><a href="{$navbar.navs_link}">{$navbar.navs_name}</a></li>
        {/if}
        {/volist}
        <!--单页-->
        {if function_exists('pageSelect')}
          {volist name=":pageSelect(['status'=>'normal','sort'=>'info_id','order'=>'desc'])" id="page"}
          <li class="py-2"><a href="{:pageUrl($page)}">{$page.info_name|DcHtml}</a></li>
          {/volist}
        {/if}
      </ul>
    </div>
  </div>
  <div class="card mb-2">
    <div class="card-header h5">sitemMap</div>
    <div class="card-body pb-0">
      <ul class="list-inline bg-white px-3 py-0">
        {for start="1" end="51"}
        <li class="list-inline-item mb-2"><a href="{:daohangUrl('daohang/sitemap/index',['pageNumber'=>$i])}" title="{:config('common.site_name')}第{$i}页">{$i}</a></li>
        {/for}
      </ul>
    </div>
  </div>
</div>
{/block}
{block name="footer"}{include file="widget/footer" /}{/block}