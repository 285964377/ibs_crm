<?php
use \GatewayWorker\Lib\Gateway;
use \GatewayWorker\Lib\Db;
/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */

class Events
{
   /**
    * 当客户端发来消息时触发
    * @param int $client_id 连接id
    * @param mixed $message 具体消息
    */
   public static function onMessage($client_id, $data) {
       $message = json_decode($data, true);
       $message_type = $message['type'];
       switch($message_type) {
		   //init 接入聊天室
           case 'init':
                // 将当前链接与标识绑定
				Gateway::bindUid($client_id, $message['id']);
				Gateway::joinGroup($client_id,$message['group_id']);
                // 通知当前客户端初始化
                $init_message = array(
					'message_type' => 'init',
					'id'           => $message['id'],
					'client_id'=> $client_id
                );
                Gateway::sendToClient($client_id, json_encode($init_message));
                return;

				break;
           case 'ping':
               return;
           default:
               echo "unknown message $data" . PHP_EOL;
       }
   }
   
   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id) {
	   /*
       $logout_message = [
           'message_type' => 'logout',
           'id'           => $_SESSION['id']
       ];
       Gateway::sendToAll(json_encode($logout_message));
	   */
   }
}