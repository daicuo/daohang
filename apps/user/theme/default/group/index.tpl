{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>用户组升级-{:config('common.site_name')}</title>
{/block}
<!-- -->
{block name="header"}{include file="widget/header" /}{/block}
<!-- -->
{block name="main"}
<section class="container pt-2">
<div class="row dh-row">
  <div class="col-12 col-md-2 px-1">
    {include file="widget/sitebar" /}
  </div>
  <div class="col-12 col-md-10 px-1">
    <div class="card">
      <div class="card-header">用户组升级</div>
      <div class="card-body">
        <ul class="list-group mb-3">
          {volist name=":userGroupScore()" id="score"}
          <li class="list-group-item py-3 d-flex justify-content-between align-items-center">
            <span>升级到<strong class="mx-2">{:lang($key)}</strong>需要（{$score}）积分</span>
            {if in_array($key,$user['user_capabilities'])}
              <span class="badge badge-pill badge-secondary">已是{:lang($key)}</span>
            {else/}
              <a class="badge badge-pill badge-primary" href="{:DcUrl('user/group/update',['value'=>$key])}">我要升级</a>
            {/if}
          </li>
          {/volist}
        </ul>
        <!---->
        <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover bg-white">
          <thead>
            <tr class="text-center">
              <th scope="col">权限</th>
              {volist name=":end($capsFront)" id="value"}
              <th scope="col">{:lang($key)}</th>
              {/volist}
            </tr>
          </thead>
          <tbody>
            {volist name="capsFront" id="roles"}
              <tr>
                <td>{$key|lang}</td>
                {foreach $roles as $value}
                <td class="text-center"><i class="text-purple fa fa-fw {:DcDefault($value,1,'fa-check','fa-close')}"></i></td>
                {/foreach}
              </tr>
            {/volist}
          </tbody>
        </table>
        </div>
        <!---->
      </div> 
    </div>
  </div>
</div>
</section>
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}