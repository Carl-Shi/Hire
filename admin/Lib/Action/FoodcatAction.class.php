<?php
// 职位分类管理
class FoodcatAction extends CommonAction {
    public function index() {
        $Foodcat = M('Foodcat');
        $foodcatlist = $Foodcat->select();

        $this->assign('foodcatlist',$foodcatlist);
        $this->display();
    }

    public function add() {
        $this->display();
    }

    public function addsave() {
        $Foodcat = M('Foodcat');
        $map['fcname'] = $_POST['fcname'];
        $map['fcsort'] = $_POST['fcsort'];
        $map['ctime']  = time();

        if(!$map['fcname']) {
            $this->error('分类名不能为空');
        }

        $result = $Foodcat->add($map);
        if($result) {
            $this->success('添加成功',U('Foodcat/index'));
        } else {
            $this->error('添加失败');
        }
    }

    public function edit() {
        $Foodcat = M('Foodcat');
        $map['fcid'] = $_GET['id'];
        $foodcatitem = $Foodcat->where($map)->find();

        $this->assign('item',$foodcatitem);
        $this->display();
    }

    public function editsave() {
        $Foodcat = M('Foodcat');
        $map['fcid']    = $_POST['fcid'];
        $data['fcname'] = $_POST['fcname'];
        $data['fcsort'] = $_POST['fcsort'];
        $Foodcat->where($map)->save($data);

        $this->success('修改成功',U('Foodcat/index'));
    }

    public function del() {
        $Foodcat = M('Foodcat');
        $map['fcid'] = $_GET['id'];
        $result = $Foodcat->where($map)->delete();

        if ($result) {
            $this->success('删除成功',U('Foodcat/index'));
        } else {
            $this->error('删除失败');
        }
    }
}

?>