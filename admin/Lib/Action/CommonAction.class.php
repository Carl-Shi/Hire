<?php
// 后台共用文件
class CommonAction extends Action {
    function _initialize() {
        import("ORG.Util.Category");

        $this->assign('webtitle', C('web_title'));
        if (!$_SESSION['admin_key']) {
            $this->redirect(U('Public/login'));
        }
    }
}

?>