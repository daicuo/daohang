{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{$seoTitle|DcEmpty='呆错导航系统免费收录网站'}－{:config('common.site_name')}</title>
<meta name="keywords" content="{$seoKeywords|DcEmpty='呆错导航系统,daiduodaohang'}" />
<meta name="description" content="{$seoDescription|DcEmpty='呆错导航系统是一款免费开源的专业分类导航建站系统。'}"  />
{/block}
<!-- -->
{block name="header"}{include file="widget/header" /}{/block}
<!--main -->
{block name="main"}
<div class="container pt-2">
<div class="rounded bg-white pt-4 px-3 pb-3">
<!---->
<h2 class="text-center mb-3">免费发布网站</h2>
<h6 class="text-center small mb-3">免费提交的网站需要管理员审核通过后才能显示、如需快速免审核服务请点击“<a class="text-danger" href="{:daohangUrl('daohang/fast/index')}">这里</a>”。</h6>
<div class="alert alert-secondary mb-3">
  {$seoDescription|DcEmpty='呆错导航系统是一款免费开源的专业分类导航建站系统，不收录任何非法或灰色边缘网站、谢谢合作！'}
</div>
<div class="row">
  <form class="col-12 col-md-9 order-2" action="{:daohangurl('daohang/publish/save')}" method="post" target="_self" data-toggle="form" data-callback="daicuo.daohang.dialog">
    <input type="hidden" name="info_controll" value="web" />
    <div class="form-group mb-4">
      <label for="info_name" ><strong for="tag_name">网站名称</strong></label>
      <input class="form-control form-control-sm" type="text" name="info_name" id="info_name" autocomplete="off" required>
    </div>
    <div class="form-group mb-4">
      <label for="info_referer"><strong>网站地址</strong></label>
      <input class="form-control form-control-sm" type="text" name="info_referer" id="info_referer" placeholder="http(s)开头的网址" autocomplete="off" required>
    </div>
    <div class="form-group row">
      <label class="col-12 mb-2"><strong>网站分类</strong></label>
      {foreach name=":daohangCategorySelect(['module'=>'daohang','action'=>'index','result'=>'array'])" item="category" key="checkKey"}
      <div class="col-4 col-md-2 form-check form-check-inline pl-3 mr-0 mb-1">
        <input class="form-check-input" type="checkbox" id="category_{$category.term_id}" name="category_id[]" value="{$category.term_id}">
        <label class="form-check-label" for="category_{$category.term_id}">{$category.term_name|daohangSubstr=0,6,false}</label>
      </div>
      {/foreach}
    </div>
    <div class="form-group">
      <label for="tag_name"><strong>网站介绍</strong></label>
      <textarea class="form-control small" id="info_content" name="info_content" rows="3" placeholder="给网站做一个详细的介绍..." required></textarea>
    </div>
    <div class="form-group text-center pt-3">
      <button class="btn btn-lg btn-danger" type="submit">免费提交</button>
    </div>
  </form>
  <div class="col-12 col-md-3 order-1">
    <section class="mb-4 text-muted">
      <h6 class="mb-3 text-dark">{:config('common.site_name')}收录条款</h6>
      <p class="small">1、只收录拥有顶级域名的网站；</p>
      <p class="small">2、只收录页面制作精良的网站；</p>
      <p class="small">3、务必在当天做好友情连接；</p>
      <p class="small">4、不收录非法或灰色边缘网站；</p>
      <p class="small">5、不收录没做好友情连接的网站；</p>
    </section>
    <section class="mb-0 text-muted">   
       <h6 class="mb-3 text-dark">{:config('common.site_name')}链接信息</h6>
      <p class="small">网站名称：{:config('common.site_name')}</p>
      <p class="small">网站地址：{$domain}</p>
    </section>
  </div>
</div>
<!---->
</div>
</div>
{/block}
{block name="footer"}{include file="widget/footer" /}{/block}