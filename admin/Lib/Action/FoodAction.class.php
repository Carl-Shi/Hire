<?php
// 职位管理
class FoodAction extends CommonAction {
    public function index() {
        $Food = D('FoodView');

        import('ORG.Util.Page');// 导入分页类
        $count      = $Food->count();
        $Page       = new Page($count,10);
        $show       = $Page->show();
        $foodlist = $Food->limit($Page->firstRow.','.$Page->listRows)->order('fid desc')->select();

        $this->assign('page',$show);
        $this->assign('foodlist',$foodlist);
        $this->display();
    }

    public function alist() {
        $map['fcid'] = $this->_get('id');

        $Food = D('FoodView');

        import('ORG.Util.Page');// 导入分页类
        $count      = $Food->where($map)->count();
        $Page       = new Page($count,10);
        $show       = $Page->show();
        $foodlist= $Food->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('fid desc')->select();

        $this->assign('page',$show);
        $this->assign('foodlist',$foodlist);
        $this->display();
    }

    public function add() {
        $Foodcat = M('Foodcat');
        $foodcatlist = $Foodcat->select();

        $this->assign('foodcatlist',$foodcatlist);
        $this->display();
     }

     public function addsave() {
        $Food = D("Food");

        $map['fname']    = $_POST['fname'];
        $map['fcid']     = $_POST['fcid'];
        $map['ftitle']   = $_POST['ftitle'];
        $map['fcontent'] = $_POST['fcontent'];
        $map['fpic']     = $_POST['fpic'];
        $map['fsort']    = $_POST['fsort'];
        $map['fprice']   = $_POST['fprice'];
        $map['fctime']   = time();

        if (!$Food->create($map)) {
            $this->error($Food->getError());
        } else {
            $result = $Food->add($map);
            $this->success('添加成功');
        }
    }

    public function edit() {
        $Food = M('Food');
        $map['fid'] = $_GET['id'];
        $fooditem = $Food->where($map)->find();

        $Foodcat = M('Foodcat');
        $foodcatlist = $Foodcat->select();

        $this->assign('foodcatlist',$foodcatlist);
        $this->assign('item',$fooditem);
        $this->display();
    }

    public function editsave() {
        $id = $this->_post('fid');
        if(!$id) {
            $this->error('ID不能为空');
        }

        $data["fid"] = $id;
        $maps['fid'] = array('neq',$id);

        $Food = D("Food");

        $map['fname']    = $_POST['fname'];
        $map['fcid']     = $_POST['fcid'];
        $map['ftitle']   = $_POST['ftitle'];
        $map['fcontent'] = $_POST['fcontent'];
        $map['fpic']     = $_POST['fpic'];
        $map['fsort']    = $_POST['fsort'];
        $map['fprice']   = $_POST['fprice'];
        $map['fctime']   = time();

        if (!$Food->where($maps)->create($map)){
            $this->error($Food->getError());
        } else {
            $Food->where($data)->save($map);
            $this->success('修改成功',U('Food/index'));
        }
    }

    public function del() {
        $Food = M('Food');
        $map['fid'] = $_GET['id'];
        $result = $Food->where($map)->delete();

        if ($result) {
            $this->success('删除成功',U('Food/index'));
        } else {
            $this->error('删除失败');
        }
    }

    public function down() {
        $Food = M('Food');
        $map['fid'] = $_GET['id'];
        $Food->where($map)->setField('status','1');

        $this->redirect(U('Food/index'));
    }

    public function up() {
        $Food = M('Food');
        $map['fid'] = $_GET['id'];
        $Food->where($map)->setField('status','0');

        $this->redirect(U('Food/index'));
    }
}

?>