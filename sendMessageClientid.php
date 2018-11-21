<?php
error_reporting(E_ERROR);
ini_set('date.timezone','Asia/Shanghai');

use GatewayWorker\Lib\Gateway;
use Medoo\Medoo;

require_once __DIR__ . '/vendor/autoload.php';

$time = strip_tags(trim($_GET['timestamp']));
$webSignature = strip_tags(trim($_GET['signature']));

$appid = 'wap';
$accesstoken = '123456789';
$localSignature = sha1($appid.$accesstoken.$time);
if ($localSignature <> $webSignature) die(json_encode(['status'=>-1,'msg'=>'signature验证失败']));

$raw = json_decode(file_get_contents('php://input'),true);

$msgType = 'text';

//$host = 'http://10.4.62.41/';    //测试

$host = 'http://125.93.53.91:31337/ftp/';    //正式

if (preg_match('/(\\\\)n/i',$raw['Content'])){
    $text = preg_replace('/(\\\\)n/i','<br/>',$raw['Content']);
}else{
    $text = str_replace("\n",'<br/>',$raw['Content']);
}

$clientid = $raw['ToUserId'] ? strip_tags($raw['ToUserId']) : '7f0000010b5400000001';

$medoo = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'wap',
    'server' => '10.68.4.139',
    'username' => 'root',
    'password' => 'rooT@41!39',
    'charset' => 'utf8',
]);
$medoo->insert('log',['sessionid'=>$clientid,'content'=>$raw['WorkerName'].'座席发送给用户','data'=>json_encode($raw),'dateline'=>date('Y-m-d H:i:s')]);

if ($text){
    if ($raw['MsgType'] == 'image'){
        $text = '<img src="'.$host.$text.'"/>';
        $msgType = 'photo';
    }elseif ($raw['MsgType'] == 'video'){
        $text = '<video src="'.$host.$text.'">Your browser does not support the video tag.</video>';
        $msgType = 'video';
    }

    $data = json_encode(['name'=>$raw['WorkerName'],'time'=>date('H:i:s'),'text'=>$text,'userType'=>'customer','msgType'=>$msgType]);

    Gateway::$registerAddress = '127.0.0.1:1238';

    Gateway::sendToGroup($clientid,$data);
    die(json_encode(['status'=>0,'msg'=>'ok']));
}else{
    die(json_encode(['status'=>-1,'msg'=>'提交内容不能为空']));
}

