<div class="modal-content">
  <div class="modal-header">
    <h6 class="modal-title text-purple">{:lang('daohang/collect/create')}</h6>
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
  </div>
  <div class="modal-body">
    {:DcBuildForm([
        'name'     => 'daohang/collect/create',
        'class'    => 'bg-white',
        'action'   => DcUrlAddon(['module'=>'daohang','controll'=>'collect','action'=>'save']),
        'method'   => 'post',
        'submit'   => lang('submit'),
        'reset'    => lang('reset'),
        'close'    => false,
        'disabled' => false,
        'ajax'     => true,
        'callback' => '',
        'data'     => $data,
        'items'    => $fields,
    ])}
  </div>
</div>