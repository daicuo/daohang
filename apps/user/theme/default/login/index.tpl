{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{:config('user.title_login')}－{:config('common.site_name')}</title>
<meta name="keywords" content="{:config('user.keywords_login')}" />
<meta name="description" content="{:config('user.description_login')}"  />
{/block}
{block name="header"}{include file="widget/header" /}{/block}
{block name="main"}
<section class="bg-purple">
<div class="container py-10">
<div class="row">
<div class="col-12 col-md-8 text-white text-center d-none d-md-flex flex-column justify-content-center">
  <p class="mb-5"><i class="fa fa-lg fa-user-o" style="font-size: 12.0rem"></i></p>
  <h4>欢迎回到{:config('common.site_name')}</h4>
</div>
<div class="col-12 col-md-4">
<div class="card">
  <h6 class="card-header text-center">帐号登录</h6>
  <form class="card-body" action="{:DcUrl('user/login/update')}" method="post" target="_self" data-toggle="form" data-callback="daicuo.user.dialog">
    <input type="hidden" name="callback" value="{$callback}">
    <input type="hidden" name="state" value="{$state}">
    <div class="input-group input-group-sm mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-fw fa-user"></i></span>
      </div>
      <input type="text" class="form-control" name="user_name" value="" required="true" placeholder="用户名/手机/邮箱">
    </div>
    <div class="input-group input-group-sm mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-fw fa-lock"></i></span>
      </div>
      <input type="password" class="form-control" name="user_pass" value="" required="true" placeholder="密码">
    </div>
    {if DcBool(config('common.site_captcha'))}
    <div class="input-group input-group-sm mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-fw fa-key"></i></span>
      </div>
      <input type="text" class="form-control" name="user_captcha" value="" required="true" placeholder="{:lang('user_captcha')}" autocomplete="off">
    </div>
    <p class="mb-4">
      <img class="rounded img-fluid border w-100" id="captcha" src="../../public/images/x.gif" alt="{:lang('user_captcha')}" data-toggle="captcha"/>
    </p>
    {/if}
    <p class="card-text small">
      <input type="checkbox" name="user_expire" checked="checked" value="1"> 保持登录 
    </p>
    <p class="text-center mb-0">
      <button class="btn btn-purple btn-block" type="submit">{:lang('login')}</button>
    </p>
  </form>
    <div class="card-footer text-center">
      <a class="small mx-1 text-dark text-decoration-none" href="javascript:;">
        <i class="fa fa-fw fa-user-o"></i> 忘记密码
      </a>
      <a class="small mx-1 text-dark text-decoration-none" href="{:DcUrl('user/register/index')}">
        <i class="fa fa-fw fa-sign-in"></i> 帐号注册
      </a>
    </div>
</div>
</div>
<!---->
</div>
</div>
</section>
{/block}
{block name="footer"}{include file="widget/footer" /}{/block}