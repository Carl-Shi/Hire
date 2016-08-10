<?php
// 配置管理
class ConfigAction extends CommonAction {
    public function index() {
        $cate = $_GET['id'];
        if(!$cate) {
            $cate = 0;
        }

        $Config = M('Config');
        $data = $Config->where('cate='.$cate)->select();

        if($data && is_array($data)) {
            foreach ($data as $k=>$value) {
                $datas[$k]['title']  = $value['title'];
                $datas[$k]['name']   = $value['name'];
                $datas[$k]['type']   = $value['type'];
                $datas[$k]['remark'] = $value['remark'];
                $datas[$k]['status'] = $value['status'];
                if($value['type'] == 3 || $value['type'] == 4) {
                    $datas[$k]['extra'] = $this->parse($value['extra']);
                }
                if($value['type'] == 6) {
                    $datas[$k]['value'] = explode(',', $value['value']);
                } else {
                    $datas[$k]['value'] = $value['value'];
                }
            }
        }

        $this->assign('citem',$datas);
        $this->assign('cate',$cate);
        $this->assign('data',$data);
        $this->display('index'.$cate);
    }

    private function parse($value) {
        $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
        if(strpos($value,':')) {
            $value  = array();
            foreach ($array as $val) {
                list($k, $v) = explode(':', $val);
                $value[$k] = $v;
            }
        } else {
            $value = $array;
        }

        return $value;
    }

    public function add() {
        $cate = I('cate');

        //基本设置处理
        if($cate == 0){
            $Config = M('Config');

            $map['title']   = $this->_post('title');
            $map['name']    = $this->_post('name');
            $map['key']     = $this->_post('key');
            $map['des']     = I('des');
            $map['url']     = $this->_post('url');
            $map['tj']      = $this->_post('tj');
            $map['beian']   = $this->_post('beian');
            $map['isorder'] = $this->_post('isorder');
            $map['islogin'] = $this->_post('islogin');

            foreach ($map as $name => $value) {
                $data = array('name' => $name);
                $Config->where($data)->setField('value', $value);
            }

            $this->success('操作成功');
            unset($map);
        }
    }

    public function unrunfile() {
        $runflie="./data/~runtime.php";
        if(file_exists($runflie)) {
            unlink($runflie); //删除RUNTIME_FILE;
        }
        $runflies="./admin/Runtime/~runtime.php";
        if(file_exists($runflies)) {
            unlink($runflies); //删除RUNTIME_FILE;
        }
        $this->success('清除缓存成功');
    }
}