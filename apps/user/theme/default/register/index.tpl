{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{:config('user.title_register')}－{:config('common.site_name')}</title>
<meta name="keywords" content="{:config('user.keywords_register')}" />
<meta name="description" content="{:config('user.description_register')}"  />
{/block}
{block name="header"}{include file="widget/header" /}{/block}
{block name="main"}
<section class="bg-purple">
<div class="container py-10">
<div class="row">
<div class="col-12 col-md-8 text-white text-center d-none d-md-flex flex-column justify-content-center">
  <p class="mb-5"><i class="fa fa-lg fa-user-o" style="font-size: 12.0rem"></i></p>
  <h4>欢迎加入{:config('common.site_name')}</h4>
</div>
<div class="col-12 col-md-4">
  <div class="card">
    <h6 class="card-header text-center">用户注册</h6>
    <form class="card-body" action="{:DcUrl('user/register/save')}" method="post" target="_self" data-toggle="form" data-callback="daicuo.user.dialog">
    <input type="hidden" name="callback" value="{$callback}">
    <input type="hidden" name="state" value="{$state}">
    {if config('user.register_name')}
    <div class="input-group input-group-sm mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-fw fa-user"></i></span>
      </div>
      <input type="text" class="form-control" name="user_name" value="" required="true" placeholder="{:lang('user_name')}">
    </div>
    {/if}
    {if config('user.register_email')}
    <div class="input-group input-group-sm mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-fw fa-email">@</i></span>
      </div>
      <input type="email" class="form-control" name="user_email" value="" required="true" placeholder="{:lang('user_email')}">
    </div>
    {/if}
    {if config('user.register_mobile')}
    <div class="input-group input-group-sm mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-fw fa-mobile"></i></span>
      </div>
      <input type="text" class="form-control" name="user_mobile" value="" required="true" placeholder="{:lang('user_mobile')}">
    </div>
    {/if}
    <div class="input-group input-group-sm mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-fw fa-lock"></i></span>
      </div>
      <input type="password" class="form-control" name="user_pass" value="" required="true" placeholder="{:lang('user_pass')}">
    </div>
    <div class="input-group input-group-sm mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-fw fa-lock"></i></span>
      </div>
      <input type="password" class="form-control" name="user_pass_confirm" value="" required="true" placeholder="{:lang('user_pass_confirm')}">
    </div>
    {if DcBool(config('common.site_captcha'))}
    <div class="input-group input-group-sm mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-fw fa-key"></i></span>
      </div>
      <input type="text" class="form-control" name="user_captcha" value="" required="true" placeholder="{:lang('user_captcha')}" autocomplete="off">
    </div>
    <p class="mb-3">
      <img class="rounded img-fluid border w-100" id="captcha" src="../../public/images/x.gif" alt="{:lang('user_captcha')}" data-toggle="captcha"/>
    </p>
    {/if}
    <p class="text-center mb-0">
      <button class="btn btn-purple btn-block" type="submit">{:lang('signUp')}</button>
     </p>
    </form>
    <div class="card-footer text-center">
    <a class="small mx-1 text-dark text-decoration-none" href="javascript:;">
      <i class="fa fa-fw fa-user-o"></i> 忘记密码
    </a>
    <a class="small mx-1 text-dark text-decoration-none" href="{:DcUrl('user/login/index')}">
      <i class="fa fa-fw fa-sign-in"></i> 帐号登录
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