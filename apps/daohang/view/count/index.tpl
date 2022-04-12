<div class="card-deck mb-2">
  <div class="card bg-light text-dark">
    <div class="card-body d-flex flex-row justify-content-between align-items-center">
      <div>
        <p class="card-title mb-1">{:lang('daohang/count/detail')}</p>
        <h5 class="card-text" id="count-detail">0</h5>
      </div>
      <i class="fa fa-2x fa-link"></i>
    </div>
  </div>
  <div class="card bg-light text-dark">
    <div class="card-body d-flex flex-row justify-content-between align-items-center">
      <div>
        <p class="card-title mb-1">{:lang('daohang/count/category')}</p>
        <h5 class="card-text" id="count-category">0</h5>
      </div>
      <i class="fa fa-2x fa-folder-o"></i>
    </div>
  </div>
  <div class="card bg-light text-dark">
    <div class="card-body d-flex flex-row justify-content-between align-items-center">
      <div>
        <p class="card-title mb-1">{:lang('daohang/count/tag')}</p>
        <h5 class="card-text" id="count-tag">0</h5>
      </div>
      <i class="fa fa-2x fa-tags"></i> 
    </div>
  </div>
  <div class="card bg-light text-dark">
    <div class="card-body d-flex flex-row justify-content-between align-items-center">
      <div>
        <p class="card-title mb-1">{:lang('daohang/count/user')}</p>
        <h5 class="card-text" id="count-user">0</h5>
      </div>
      <i class="fa fa-2x fa-users"></i> 
    </div>
  </div>
</div>
<script>
$(document).ready(function () {
    daicuo.ajax.get("{:DcUrlAddon( ['module'=>'daohang','controll'=>'count','action'=>'index'] )}", function(data, status, xhr){
        $('#count-detail').text(data.detail);
        $('#count-category').text(data.category);
        $('#count-tag').text(data.tag);
        $('#count-user').text(data.user);
    });
});
</script>