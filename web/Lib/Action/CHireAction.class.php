<?php
// 职位列表
class CHireAction extends CommonAction {
    public function index(){
        $Food = D('FoodView');

        $map['fcid']   = 26; // 校招
        $map['status'] = 0;
        
        import('ORG.Util.Page');// 导入分页类
        $count    = $Food->where($map)->count();
        $Page     = new Page($count,10);
        $show     = $Page->show();
        $foodlist = $Food->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('fsort desc, fid asc')->select();

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
        $map['fcid']   = 26; // 校招
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
}