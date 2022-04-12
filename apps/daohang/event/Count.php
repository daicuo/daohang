<?php
namespace app\daohang\event;

use think\Controller;

class Count extends Controller
{ 
    public function index()
    {
        $result = [];
        $result['category'] = number_format( db('term')->where(['term_module'=>'daohang','term_type'=>'category'])->count('term_id') );
        $result['tag']      = number_format( db('term')->where(['term_module'=>'daohang','term_type'=>'tag'])->count('term_id') );
        $result['detail']   = number_format( db('info')->where(['info_module'=>'daohang'])->count('info_id') );
        $result['user']     = number_format( db('user')->count('user_id') );
        return json($result);
    }
}