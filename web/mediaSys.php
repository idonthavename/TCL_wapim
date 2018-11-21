<?php
error_reporting(E_ERROR);
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*');
$type = intval($_GET['type']);
$customName = strip_tags(trim($_GET['name']));
$skillid = intval($_GET['skillid']);

//$host = 'http://10.4.62.41:8080';    //测试
$host = 'http://10.4.28.68:8081';   //正式

if ($type == 1){
    echo file_get_contents($host.'/weChatAdapter/transfer/getIVRAgent?name='.$customName);
}elseif ($type == 2){
    //echo file_get_contents($host.'/weChatAdapter/data/getAgentQueue?name='.$customName);    获取排队人数旧接口

    //success代表接口回调是否成功    code含义 : -1坐席全忙，0排队 ,1可接入  坐席全忙和接入的的result都为0
    echo file_get_contents($host.'/weChatAdapter/data/getStatu?skillid='.$skillid);
}