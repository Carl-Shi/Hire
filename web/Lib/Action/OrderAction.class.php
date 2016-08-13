<?php
// 申请
class OrderAction extends CommonAction {
    public function index(){
        $item['fid'] = I('id');

        $username = session('username');
        if($username) {
            $item['username'] = $username;
        }     
        $usertel = session('usertel');
        if($usertel) {
            $item['usertel'] = $usertel;
        }
        $useremail = session('useremail');
        if($useremail) {
            $item['useremail'] = $useremail;
        }
        $gid = session('gid');
        if($gid) {
            $item['gid'] = $gid;
        }

        $this->assign('item',$item);
        $this->display();
    }

    public function addsave() {
        session('username', trim($_POST['username']));
        session('usertel', trim($_POST['usertel']));
        session('useremail', trim($_POST['useremail']));
        session('gid', trim($_POST['gid']));

        $map['username'] = session('username');
        if(!$map['username']) {
            $this->error('姓名不能为空');
        }

        $map['usertel']   = session('usertel');
        $map['useremail'] = session('useremail');
        $map['gid']       = session('gid');
        if(!$map['usertel'] and !$map['useremail'] and !$map['gid']) {
            $this->error('电话, 邮箱, 微信号不能全部为空');
        }

        $Member = M('Members');
        $item = $Member->where($map)->find();
        if(!$item) {
            $Member->add($map);
            $item = $Member->where($map)->find();
        }
        
        $Order = M('Foodorder');

        $omap['uid']      = $item['uid'];
        $omap['shopname'] = $_POST['fid'];
        $oitem = $Order->where($omap)->find();
        if(!$oitem) {
            $omap['uname'] = $map['username'];
            $omap['gid']   = $map['gid'];
            $oitem = $Order->Add($omap);
        }

        $this->success('已保存', U('Product/index','id='.$_POST['fid']));
    }
}