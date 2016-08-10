<?php
class PublicAction extends Action {
    public function header() {
        $this->display();
    }

    public function footer() {
        $this->display();
    }

    public function login() {
        $this->assign('webtitle',C('web_title'));
        $this->display();
    }

    public function dologin() {
        $this->assign('webtitle',C('web_title'));

        $Member = M('Members');

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $verify   = trim($_POST['verify']);

        if(!$username) {
            $emg = "用户不可以为空";
            $this->assign('emg',$emg);
            $this->display();
        }
        if(!$password) {
            $emg = "密码不可以为空";
            $this->assign('emg',$emg);
            $this->display();
        }
        $maps['username']  = $username;
        $maps['usergroup'] = 99;
        $uuid = $Member->where($maps)->field('uid,userpass,nickname,username,create_time,usergroup')->find();

        if(!$uuid) {
            $emg = "用户不存在";
            $this->assign('emg',$emg);
            $this->display();
        } else {
            if ($uuid["userpass"] != md5($password)) {
                $emg = "密码错误";
                $this->assign('emg',$emg);
                $this->display();
            } else{
                session('username',$uuid["username"]);
                cookie('nickname',$uuid["nickname"]);
                session('admin_key',$uuid["uid"]);

                $data = array(
                    'create_time' => time(),
                    'last_login_time' =>$uuid["create_time"],
                    'last_login_ip' => get_client_ip(),
                );
                M('Members')->where("uid=".$uuid["uid"])->save($data);

                $emg = "验证成功";
                $this->assign('emg',$emg);
                $this->redirect(U('Config/index'));
            }
        }
    }

    public function logout() {
        session('admin_key',null);
        session_destroy();
        $this->redirect(U('Public/login'));
    }
}

?>