{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{$seoTitle|DcEmpty='呆错导航系统免审核收录网站'}－{:config('common.site_name')}</title>
<meta name="keywords" content="{$seoKeywords|DcEmpty='呆错导航系统,daiduodaohang'}" />
<meta name="description" content="{$seoDescription|DcEmpty='呆错导航系统是一款免费开源的专业分类导航建站系统。'}"  />
{/block}
<!-- -->
{block name="header"}{include file="widget/header" /}{/block}
<!--main -->
{block name="main"}
<div class="container pt-2">
<div class="bg-white rounded pt-4 px-3 pb-3">
  <h2 class="text-center mb-3">快速收录网站</h2>
  <h6 class="text-center mb-3 text-muted small">快速收录不需要管理员审核就可以显示、可通过会员积分或升级到VIP，如需免费发布请点击“<a class="text-danger" href="{:daohangUrl('daohang/publish/index')}">这里</a>”。</h6>
  {if $user['user_id'] lt "1"}
  <div class="alert alert-danger mb-3">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>免审发布权限</strong> 系统检测到您还没有登录，请先<a class="text-danger mx-1" href="{:daohangUrl('user/register/index')}">注册</a>或<a class="text-danger mx-1" href="{:daohangUrl('user/login/index')}">登录</a>
  </div>
  {else /}
  <div class="alert alert-secondary mb-3">
    <p class="mb-0"><strong>按级别发布：</strong>一次性升级到VIP用户组、发布网站不限数量。 {if in_array('vip',$user['user_capabilities'])}<i class="fa fa-check-circle text-success"></i>{else/}<a class="text-danger" href="{:DcUrl('user/group/index')}">我要升级</a>{/if}</p>
    {if $scoreFast}
    <p class="mt-2 mb-0"><strong>按积分发布：</strong>每发布一条信息扣除（{$scoreFast}）积分、当前积分（{$user.user_score|intval}）个。<a class="text-danger" href="{:DcUrl('user/recharge/index')}">我要充值</a><small class="text-muted">（1元人民币等于{$scoreRecharge}个积分）</small></p>
    {/if}
  </div>
  {/if}
  <div class="border rounded p-3 mb-3">
    <p><strong>审核优势</strong> 一般网站提交后审核时间较长，快审服务可以立马通过审核！</p>
    <p><strong>展示优势</strong> 快审网站首页展示推荐，显示快审图标，标题更醒目！</p>
    <p><strong>链接优势</strong> 快审网站的网址全站直接链接、有助于SEO权重提升！</p>
    <p class="mb-0"><strong>提交要求</strong> 不收录非法网站、管理员复查时发现不合规站点一律删除！</p>
  </div>
  <section class="border rounded p-3">
  {:DcBuildForm([
    'name'     => 'daohang/fast/index',
    'class'    => 'bg-white',
    'action'   => daohangUrl('daohang/fast/save'),
    'method'   => 'post',
    'submit'   => lang('submit'),
    'reset'    => lang('reset'),
    'close'    => false,
    'ajax'     => true,
    'disabled' => false,
    'callback' => '',
    'data'     => '',
    'items'    => $fields,
    'submit_class' => 'btn btn-danger',
    'reset_class'  => 'btn btn-dark',
  ])}
  </section>
</div>
</div>
{/block}
{block name="footer"}{include file="widget/footer" /}{/block}