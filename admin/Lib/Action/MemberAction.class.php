<?php
// 成员管理
class MemberAction extends CommonAction {
    public function index() {
        $Members = M('Members');

        import('ORG.Util.Page');// 导入分页类
        $count    = $Members->where('userstatus = 0')->count();
        $Page     = new Page($count,10);
        $show     = $Page->show();
        $userlist = $Members->where('userstatus = 0')->limit($Page->firstRow.','.$Page->listRows)->order('uid desc')->select();

        $this->assign('page',$show);
        $this->assign('userlist',$userlist);
        $this->display();
    }

    public function indexs() {
        $da = I('id');
        $map['_string'] = '(username like "%'.$da.'%") OR (usertel like "%'.$da.'%") OR (gid like "%'.$da.'%")';
        $map['userstatus'] = 0;

        $Members = M('Members');

        import('ORG.Util.Page');// 导入分页类
        $count    = $Members->where($map)->count();
        $Page     = new Page($count,10);
        $show     = $Page->show();
        $userlist = $Members->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('page',$show);
        $this->assign('userlist',$userlist);
        $this->display();
    }

    public function delete() {
        $da['uid'] = I('id');

        $Member = M('Members');
        $result = $Member->where($da)->delete();
        if($result) {
            $this->success('删除成功',U('Member/index'));
        } else {
            $this->error('删除失败');
        }
    }

    public function edit() {
        $id = trim($_GET['id']);
        $Member = M('Members');
        $item = $Member->find($id);

        $this->assign('item',$item);
        $this->display();
    }

    public function editsave() {
        $id = $this->_post('uid');
        if(!$id) {
            $this->error('ID不能为空');
        }

        $Member = D('Members');

        $data["uid"] = $id;
        $maps['uid'] = array('neq',$id);
        $map['userpoint'] = $_POST['userpoint'] - $_POST['exchange'];

        if (!$Member->where($maps)->create($map)){
            $this->error($Member->getError());
            return;
        } else {
            $Member->where($data)->save($map);
        }

        $Credit = D("Credit");

        $map['uid']      = $_POST['uid'];
        $map['sname']    = $_POST['username'];
        $map['crecount'] = $_POST['exchange'];
        $map['ctime']    = time();

        if (!$Credit->create($map)) {
            $this->error($Credit->getError());
        } else {
            $result = $Credit->add($map);
            $this->success('添加成功',U('Member/index'));
        }
    }

    public function adminindex() {
        $Member = M('Members');
        $adminlist = $Member->where('usergroup=99')->select();

        $this->assign('adminlist',$adminlist);
        $this->display();
    }

    public function admindelete() {
        $Member = M('Members');
        $id = trim($_GET['id']);
        $result = $Member->delete($id);

        if($result) {
            $this->success('删除成功',U('Member/adminindex'));
        } else {
            $this->error('删除失败');
        }
    }

    public function adminadd() {
        $this->display();
    }

    public function adminaddsave() {
        $map["username"] = trim($_POST['username']);
        if (!$map["username"]) {
            $this->error('用户名不能为空');
        }

        $map["userpass"] = md5(trim($_POST['password']));
        $repassword = md5(trim($_POST['repassword']));
        if (!$map["userpass"]) {
            $this->error('密码不能为空');
        }
        if($map["userpass"] != $repassword) {
            $this->error('二次输入的密码不一样');
        }

        $map["create_time"] = time();
        $map["usergroup"]   = 99;

        $Member = M('Members');
        $result = $Member->add($map);
        if($result) {
            $this->success('添加成功',U('Member/adminindex'));
        } else {
            $this->error('添加失败');
        }
    }

    public function adminedit() {
        $id = trim($_GET['id']);
        $Member = M('Members');
        $item = $Member->find($id);

        $this->assign('item',$item);
        $this->display();
    }

    public function admineditsave(){
        $data["uid"] = trim($_POST['uid']);
        $map["username"] = trim($_POST['username']);
        if (!$map["username"]) {
            $this->error('用户名不可以为空');
        }

        $map["userpass"] = md5(trim($_POST['password']));
        $repassword = md5(trim($_POST['repassword']));
        if (!$map["userpass"]) {
            $this->error('密码不可为空');
        }
        if($map["userpass"] != $repassword) {
            $this->error('二次输入的密码不一样');
        }

        $map["create_time"] = time();
        $map["usergroup"] = 99;

        $Member = M('Members');
        $result = $Member->where($data)->save($map);
        if($result) {
            $this->success('修改成功',U('Member/adminindex'));
        } else {
            $this->error('修改失败');
        }
    }
}