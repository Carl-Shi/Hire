<?php
// 兑换管理
class CreditAction extends CommonAction {
    public function index(){
        $Credit = M('Credit');

        import('ORG.Util.Page');// 导入分页类
        $count      = $Credit->count();
        $Page       = new Page($count,10);
        $show       = $Page->show();
        $creditlist = $Credit->limit($Page->firstRow.','.$Page->listRows)->order('creid desc')->select();

        $this->assign('page',$show);
        $this->assign('creditlist',$creditlist);
        $this->display();
    }

    public function indexs() {
        $da = I('id');
        $map['sname'] = $da ;

        $Credit = M('Credit');

        import('ORG.Util.Page');// 导入分页类
        $count      = $Credit->where($map)->count();
        $Page       = new Page($count,10);
        $show       = $Page->show();
        $creditlist = $Credit->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('creid desc')->select();

        $this->assign('page',$show);
        $this->assign('creditlist',$creditlist);
        $this->display();
    }

    public function delete(){
        $Credit = M('Credit');
        $id = trim($_GET['id']);
        if(!$id) {
            $this->error('ID不能为空');
        } else {
            $data['creid'] = $id;
            $result = $Credit->where($data)->delete();

            if($result) {
                $this->success('删除成功',U('Credit/index'));
            } else {
                $this->error('删除失败');
            }
        }
    }
}