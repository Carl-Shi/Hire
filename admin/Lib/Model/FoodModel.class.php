<?php
class FoodModel extends Model {
    // 自动验证设置
    protected $_validate = array(
        array('fname','require','职位不可以为空'),
    );
}
?>