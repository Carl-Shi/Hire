<?php
// 招聘后台首页
class IndexAction extends CommonAction {
//    public function index() {
//         $this->redirect('Config/index');
//    }

    function _initialize() {
        import("ORG.Util.Category");

        $this->assign('webtitle', C('web_title'));
        if (!$_SESSION['admin_key']) {
            $this->redirect(U('Public/login'));
        }
    }
}

?>