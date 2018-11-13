<?php
namespace Home\Controller;
use \GatewayWorker\Lib\Gateway;
use Think\Controller;
Gateway::$registerAddress = '172.16.1.78:1236';
/*
默认端口
Gateway::$registerAddress = '127.0.0.1:1236';
使用之前，确保getway服务已经启动。


实时推送消息逻辑
	1.windos 使用cmd启动 start_register start_gateway start_businessworker 服务
	
	2.用户端进入首页时连接 聊天服务器，成功之后发送 登录信息，Events 进行绑定。
		进行绑定，1.client绑定uid	 Gateway::bindUid($client_id,uid);
	3.发送消息逻辑
		判断这一条消息 的接收人  1.指定员工  
								 2.发送给所有人

*/
class WorkermanController extends Controller {
	
    public function send_msg($to_id,$title,$msg_content,$msg_id=0,$type=1,$chat_type='personal'){
	    $chat_message = array(
			'message_type' => 'chatMessage',
			'title'      => $title,
			'content'      => $msg_content
		);
	   switch($chat_type){
			case 'personal':	//指定ID发送	
				$arr['user_id']=$to_id;
				$arr['title']=$title;
				$arr['msg_id']=$msg_id;
				$arr['content']=$msg_content;
				$id=M('msg_user')->add($arr);
				$chat_message['id']=$id;
				Gateway::sendToUid($to_id, json_encode($chat_message));
				break;
			//向所有人发送
			/*
			default:			
				Gateway::sendToAll(json_encode($chat_message));
				break;
			*/	
	   }
	   
   }
   

}