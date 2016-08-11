<?php
// 职位列表
class IndexAction extends CommonAction {
    public function index(){
        $Food = D('FoodView');

        import('ORG.Util.Page');// 导入分页类
        $count    = $Food->where('status=0')->count();
        $Page     = new Page($count,10);
        $show     = $Page->show();
        $foodlist = $Food->where('status=0')->limit($Page->firstRow.','.$Page->listRows)->order('fsort desc, fid asc')->select();

        $this->assign('page',$show);
        $this->assign('foodlist',$foodlist);

        $gid = session('gid');
        if(!$gid) {
            $gid = $_GET['gid'];
            session('gid',$gid);
        }

        $this->display();
    }

    public function indexs() {
        $da = I('id');

        $map['_string'] = '(fname like "%'.$da.'%") OR (ftitle like "%'.$da.'%") OR (fcontent like "%'.$da.'%") OR (fpic like "%'.$da.'%")';
        $map['status']  = 0;
        
        $food = D('FoodView');

        import('ORG.Util.Page');// 导入分页类
        $count     = $food->where($map)->count();
        $Page      = new Page($count,10);
        $show      = $Page->show();
        $foodlist = $food->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('fsort desc, fid asc')->select();

        $this->assign('page',$show);
        $this->assign('foodlist',$foodlist);
        $this->display();
    }

    public function flist(){
        $data['fcid']   = I('id');
        $data['status'] = '0';

        $Foods = D('Foodcat');
        $foodcatlist=$Foods->select();
        $this->assign('foodcatlist',$foodcatlist);

        $Food = M('Food');

        import('ORG.Util.Page');
        $count    = $Food->where($data)->count();
        $Page     = new Page($count,10);
        $show     = $Page->show();
        $foodlist = $Food->where($data)->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('foodlist',$foodlist);
        $this->assign('page',$show);
        $this->display();
    }
}