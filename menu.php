<?php
include "wechat/qywechat.class.php";
include "config/wechat.php";

$weObj = new Wechat($options);
$weObj->valid();

$type  = $weObj->getRev()->getRevType();
$event = $weObj->getRev()->GetRevEvent();
$uid   = $weObj->getRev()->getRevFrom();

if ($type == Wechat::MSGTYPE_EVENT) {
    switch($event['key']) {
        case "MENU_1_1":
            $weObj->text("MENU_1_1")->reply();
            break;
        case "MENU_1_2":
            $weObj->text("MENU_1_2")->reply();
            break;
        case "MENU_1_3":
            $weObj->text("MENU_1_3")->reply();
            break;
        case "MENU_3_1":
            $weObj->text("MENU_3_1")->reply();
            break;
        case "MENU_3_2":
            $weObj->text("MENU_3_2")->reply();
            break;
        default:
    }
}
?>