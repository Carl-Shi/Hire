<?php
class FoodorderModel extends RelationModel{
    protected $_link = array(
        'Foodorderext'=>array(
            'mapping_type'=>HAS_MANY,
            'class_name'=>'Foodorderext',
            'foreign_key'=>'oid',
        ),
    );
}
?>
