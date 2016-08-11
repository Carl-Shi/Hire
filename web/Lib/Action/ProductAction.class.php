<?php
// 职位
class ProductAction extends CommonAction {
    public function index(){
        $data['fid'] = I('id');

        $Food=M('Food');
        $fooditem=$Food->where($data)->find();
        $this->assign('fooditem',$fooditem);
        $this->display();
    }
}