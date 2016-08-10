<?php
// 申请管理
class OrderAction extends CommonAction {
    public function index() {
        $Order = M('Foodorder');

        import('ORG.Util.Page');// 导入分页类
        $count      = $Order->count();
        $Page       = new Page($count,10);
        $show       = $Page->show();
        $orderlist= $Order->limit($Page->firstRow.','.$Page->listRows)->order('oid desc')->select();

        $this->assign('page',$show);
        $this->assign('orderlist',$orderlist);
        $this->display();
    }

    public function indexs() {
        $da = I('id');
        $map['_string'] = '(uname like "%'.$da.'%") OR (gid like "%'.$da.'%") OR (shopname like "%'.$da.'%")';

        $Order = M('Foodorder');

        import('ORG.Util.Page');// 导入分页类
        $count     = $Order->where($map)->count();
        $Page      = new Page($count,10);
        $show      = $Page->show();
        $orderlist = $Order->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('oid desc')->select();

        $this->assign('page',$show);
        $this->assign('orderlist',$orderlist);
        $this->display();
    }

    public function index0() {
        $Order = M('Foodorder');

        import('ORG.Util.Page');// 导入分页类
        $count      = $Order->where('orderstatus = 0')->count();
        $Page       = new Page($count,10);
        $show       = $Page->show();
        $orderlist= $Order->where('orderstatus = 0')->limit($Page->firstRow.','.$Page->listRows)->order('oid desc')->select();

        $this->assign('page',$show);
        $this->assign('orderlist',$orderlist);
        $this->display();
    }

    public function index1() {
        $Order = M('Foodorder');

        import('ORG.Util.Page');// 导入分页类
        $count     = $Order->where('orderstatus = 1')->count();
        $Page      = new Page($count,10);
        $show      = $Page->show();
        $orderlist = $Order->where('orderstatus = 1')->limit($Page->firstRow.','.$Page->listRows)->order('oid desc')->select();

        $this->assign('page',$show);
        $this->assign('orderlist',$orderlist);
        $this->display();
    }

    public function index4() {
        $Order = M('Foodorder');

        import('ORG.Util.Page');// 导入分页类
        $count     = $Order->where('orderstatus = 4')->count();
        $Page      = new Page($count,10);
        $show      = $Page->show();
        $orderlist = $Order->where('orderstatus = 4')->limit($Page->firstRow.','.$Page->listRows)->order('oid desc')->select();

        $this->assign('page',$show);
        $this->assign('orderlist',$orderlist);
        $this->display();
    }

    public function orderone() {
        $data['oid'] = I('id');
        $Order = M('Foodorder');
        $map['orderstatus'] = 1;
        $result = $Order->where($data)->save($map);
        if($result) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    public function ordertwo() {
        $data['oid'] = I('id');
        $Order = M('Foodorder');
        $map['orderstatus'] = 2;
        $result = $Order->where($data)->save($map);
        if($result) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    public function orderthree() {
        $data['oid'] = I('id');
        $Order = M('Foodorder');
        $map['orderstatus'] = 3;
        $result=$Order->where($data)->save($map);
        if($result) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    public function orderfour() {
        $data['oid'] = I('id');
        $Order = M('Foodorder');
        $map['orderstatus'] = 4;
        $map['order_endtime'] = time();
        $result = $Order->where($data)->save($map);
        if($result) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    public function orderfive() {
        $data['oid'] = I('id');
        $Order = M('Foodorder');
        $map['orderstatus'] = 5;
        $result = $Order->where($data)->save($map);
        if($result) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    public function ordersix() {
        $data['oid'] = I('id');
        $Order = M('Foodorder');
        $map['orderstatus'] = 6;
        $result = $Order->where($data)->save($map);
        if($result) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    public function delete(){
        $data['oid'] = I('id');
        $Order = M('Foodorder');

        $result=$Order->where($data)->delete();
        if($result) {
            $this->success('删除成功',U('Order/index'));
        } else {
            $this->error('删除失败');
        }
    }
}