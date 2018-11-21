<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);
ini_set('date.timezone','Asia/Shanghai');
use \GatewayWorker\Lib\Gateway;
use Medoo\Medoo;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * 
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id) {
        //echo "$client_id\n";
        // 向当前client_id发送数据 
        //Gateway::sendToClient($client_id, "Hello $client_id\n");
        // 向所有人发送
        //Gateway::sendToAll("$client_id login\n");
    }
    
   /**
    * 当客户端发来消息时触发
    * @param int $client_id 连接id
    * @param mixed $message 具体消息
    */
   public static function onMessage($client_id, $message) {
       require_once __DIR__.'/lib/global.func.php';
       $medoo = new Medoo([
           'database_type' => 'mysql',
           'database_name' => 'wap',
           'server' => '10.68.4.139',
           'username' => 'root',
           'password' => 'rooT@41!39',
           'charset' => 'utf8',
       ]);
       $data = json_decode($message,true);
       //全媒体用户信息记录接口
       $appid = 'wap';
       $secret = 'abcdefg';
       $signature = sha1($appid.$secret.time());
       //测试
       //$url = 'http://10.4.62.41:8080/weChatAdapter/api/v1/wap/staffService/message?timestamp='.time().'&signature='.$signature;
       //正式
       $url = 'http://10.4.28.68:8081/weChatAdapter/api/v1/wap/staffService/message?timestamp='.time().'&signature='.$signature;
       $postdata = ['Content'=>$data['text'],'FromUserId'=>$data['sessionid'],'FromUserName'=>$data['name'],'MsgType'=>'event.CLICK.RG','accname'=>$data['channel']];
       $medoo->insert('log',['sessionid'=>$data['sessionid'],'content'=>$data['name'].'用户发送消息','data'=>$message,'dateline'=>date('Y-m-d H:i:s')]);
       $data['time'] = date('H:i:s');
       $data['userType'] = 'self';
       if ($data['action'] <> 'validatePhone'){
           $filePath = 'http://113.106.207.11/web';       //正式   http://125.93.53.91:31337/ftp
           $msgTypeArray = ['sendMessage'=>'text','postPhoto'=>'photo','postVideo'=>'video'];
           $postdata['MsgType'] = 'text';
           $msgType = $data['msgType'] = $msgTypeArray[$data['action']];
           if ($msgType == 'photo') {
               $data['text'] = '<img src="'.$filePath.$data['text'].'"/>';
               $postdata['MsgType'] = 'image';
           }elseif ($msgType == 'video'){
               $data['text'] = '<span class="video-mask J-Play" data-path="'.$filePath.$data['text'].'"></span><span class="video-play"></span><img id="img" src="'.$data['thumbnail'].'" />';
               $postdata['MsgType'] = 'video';
           }
       }else{
           Gateway::joinGroup($client_id,$data['sessionid']);
       }
       // 向当前用户发送
       $data = json_encode($data);
       Gateway::sendToCurrentClient($data);
       //传输数据给全媒体
       if(isset($postdata['FromUserName']) && !empty($postdata['FromUserName'])){
           $re = httpPost($url,json_encode($postdata));
           //echo json_encode($re)."\n";
           if ($re['errcode'] <> 0) echo 'something has problem:'.$re['errmsg'];
       }
   }
   
   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id) {
       // 向所有人发送 
       //GateWay::sendToAll("$client_id logout");
   }
}
