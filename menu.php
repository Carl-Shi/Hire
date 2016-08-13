<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

include "config/wechat.php";
include "wechat/qywechat.class.php";
include "ezsql/ez_sql_core.php"; 
include "ezsql/ez_sql_mysql.php"; 

$config = require './config/db.php';

$weObj = new Wechat($options);
$weObj->valid();

$type  = $weObj->getRev()->getRevType();
$event = $weObj->getRev()->GetRevEvent();
$uid   = $weObj->getRev()->getRevFrom();

$db = new ezSQL_mysql($config['DB_USER'],$config['DB_PWD'],$config['DB_NAME'],$config['DB_HOST']);

$userinfo  = $weObj->getUserInfo($uid);
$username  = $userinfo['name'];
$useremail = $userinfo['email'];
$usertel   = $userinfo['mobile'];
$gid       = $userinfo['userid'];

if ($userinfo) {
    $sql = "select count(*) as total from sn_members where gid='$gid'";
    $total = $db->get_var($sql);
    if ($total == 0) {
        $sql = "insert into sn_members (username,useremail,usertel,gid) values ('$username','$useremail','$usertel','$gid')";
        $db->query($sql);
    }
}

$db->disconnect();

if ($type == Wechat::MSGTYPE_EVENT) {
    switch($event['key']) {
        case "MENU_1_1":
            $weObj->text($userinfo['name'].", welcome!")->reply();
            break;
        case "MENU_1_2":
            $weObj->text($userinfo['name'].", welcome!")->reply();
            break;
        case "MENU_1_3":
            $weObj->text($userinfo['name'].", welcome!")->reply();
            break;
        case "MENU_3_1":
            $weObj->text($userinfo['name'].", welcome!")->reply();
            break;
        case "MENU_3_2":
            $weObj->text($userinfo['name'].", welcome!")->reply();
            break;
        default:
    }
}
?>