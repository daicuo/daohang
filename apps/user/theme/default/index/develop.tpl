{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>开发文档-{:config('common.site_name')}</title>
<meta name="keywords" content="{:config('user.keywords_login')}" />
<meta name="description" content="{:config('user.description_login')}"  />
{/block}
{block name="header"}{include file="widget/header" /}{/block}
{block name="main"}
<div class="container pt-3">
  <div class="card mb-3">
    <h6 class="card-header">{:config('common.site_name')}</h6>
    <div class="card-body">
      <p>
        <a class="small mx-1 text-dark text-decoration-none" href="{:DcUrl('user/register/index','','')}">
          <i class="fa fa-fw fa-user"></i> 帐号注册
        </a>
      </p>
      <p>
        <a class="small mx-1 text-dark text-decoration-none" href="{:DcUrl('user/login/index','')}">
          <i class="fa fa-fw fa-sign-in"></i> 帐号登录
        </a>
      </p>
      <p>
        <a class="small mx-1 text-dark text-decoration-none" href="{:DcUrl('user/logout/index','')}">
          <i class="fa fa-fw fa-sign-out"></i> 安全退出
        </a>
      </p>
    </div>
  </div>
  <div class="card mb-3">
    <div class="card-header">数据库字段</div>
    <pre class="card-body pb-0">{:dump( userFields() )}</pre> 
  </div>
  <div class="card mb-3">
    <div class="card-header">内部链接</div>
    <pre class="card-body pb-0">{literal}
    DcUrl('user/index/register');//注册
    DcUrl('user/index/login');//登录
    DcUrl('user/index/logout');//退出
    DcUrl('user/center/index');//用户中心
    DcUrl('user/center/repwd');//修改密码
    {/literal}</pre> 
  </div>
  <div class="card mb-3">
    <div class="card-header">预埋钩子</div>
    <pre class="card-body pb-0">{literal}
    return [
        'form_build' => [
            'app\\user\\behavior\\Hook',
        ],
        'table_build' => [
            'app\\user\\behavior\\Hook',
        ],
        'user_register_before' => [
            'app\\user\\behavior\\Hook',
        ],
        'user_register_after' => [
            'app\\user\\behavior\\Hook',
        ],
        'user_login_before' => [
            'app\\user\\behavior\\Hook',
        ],
        'user_login_after' => [
            'app\\user\\behavior\\Hook',
        ],
        'user_admin_index' => [
            'app\\user\\behavior\\Hook',
        ]
    ];{/literal}</pre> 
  </div>
  <div class="card">
    <div class="card-header">预埋配置</div>
    <pre class="card-body pb-0">{literal}
    //初始配置
    config('form_fields.admin_user_index');
    config('form_fields.admin_user_create');
    config('form_fields.admin_user_edit');
    //初始值
    config('form_data.admin_user_index');
    config('form_data.admin_user_create');
    config('form_data.admin_user_edit');
    {/literal}</pre> 
  </div>
</div>
{/block}