<?php
namespace app\daohang\loglic;

class Term 
{
    /**
    * 按内容模型获取分类关系
    * @version 1.2.0 首次引入
    * @param array $data 可选;初始数据;默认：空
    * @return array key=>value格式
    */
    public function categoryOption(){
        $item = daohangCategorySelect([
            'result'   => 'array',
            'module'   => 'daohang',
            'controll' => 'category',
            'action'   => 'index',
            'with'     => '',
            'field'    => 'term_id,term_name',
        ]);
        $option = [];
        foreach($item as $key=>$value){
            $option[$value['term_id']] = $value['term_name'];
        }
        return $option;
    }
}