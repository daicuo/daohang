{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>用户中心-{:config('common.site_name')}</title>
<meta name="keywords" content="{:config('commin.site_keywords')}" />
<meta name="description" content="{:config('commin.site_description')}" />
{/block}
<!-- -->
{block name="header"}{include file="widget/header" /}{/block}
<!-- -->
{block name="main"}
<div class="container pt-2">
<div class="row dh-row">
  <div class="col-12 col-md-2 px-1">
    {include file="widget/sitebar" /}
  </div>
  <div class="col-12 col-md-10 px-1">
    <div class="card">
    <div class="card-header h5">用户资料</div>
    <div class="card-body">
      <table class="table table-bordered bg-white mb-0">
        <tbody>
          <tr>
            <td>用户名</td>
            <td>{$user.user_name}</td>
          </tr>
          <tr>
            <td>手机</td>
            <td>{$user.user_mobile}</td>
          </tr>
          <tr>
            <td>邮箱</td>
            <td>{$user.user_email}</td>
          </tr>
          <tr>
            <td>积分</td>
            <td>{$user.user_score|default="0"}</td>
          </tr>
          <tr>
            <td>角色</td>
            <td>{foreach $user['user_capabilities'] as $group} {$group|lang}{/foreach}</td>
          </tr>
          <tr>
            <td>状态</td>
            <td>{$user.user_status_text}</td>
          </tr>
          <tr>
            <td>令牌授权</td>
            <td>{$user.user_token} <a class="text-purple" href="{:DcUrl('api/token/update')}" data-toggle="get">更换</a></td>
          </tr>
          <tr>
            <td>令牌过期</td>
            <td>{$user.user_expire|date='Y-m-d H:i:s',###}</td>
          </tr>
          <!--<tr>
            <td>呢称</td>
            <td>{$user.user_nice_name|default="未填写"}</td>
          </tr>-->
         {foreach $user as $key=>$value}
         {if !in_array($key,['user_id','user_name','user_nice_name','user_score','user_email','user_mobile','user_pass','user_token','user_expire', 'user_module','user_controll','user_action','user_capabilities','user_caps','user_status','user_status_text','user_create_time','user_create_ip','user_hits'])}
          <tr>
            <td>{$key|lang}</td>
            <td>{$value}</td>
          </tr>
          {/if}
          {/foreach}
        </tbody>
      </table>
    </div> 
  </div>
  </div> <!--col-12 end-->
</div> <!-- row end-->
</div> <!-- /container -->
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}