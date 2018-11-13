<?php
//登录控制器，  也存放需要跳过权限验证的公用函数
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
	// 单浏览器登录	登录验证 
	public function login(){
		if(IS_POST){
		   $login=I('post.login_id');
		   $pwd=md5(I('post.login_pwd'));
		   $ck_id['login_id']=array('eq',$login);
		   $user=M('user')->where($ck_id)->find();
		   if(!$user){
				$list['code']='error';
				$list['msg']='账号不存在';
				echo json_encode($list,true);
				exit;
		   }else{
			   if($user['status']!=1){
				    $list['code']='error';
					$list['msg']='账号被冻结';
					echo json_encode($list,true);
					exit;
			   }else{
				   if($pwd==$user['login_pwd']){
						$login_session = time();
						session('login_session',$login_session);
						session("user",$user['uid']);
						$data['login_session'] = $login_session;
						$data['login_time_last'] = $user['login_time_now'];
						$data['login_ip_last'] = $user["login_ip_now"];
						$data['login_time_now'] = date("Y-n-d H:i:s",time());
						$data['login_ip_now'] = $_SERVER["REMOTE_ADDR"];
						M('user')->where($ck_id)->save($data);
						
						$l['type']=CONTROLLER_NAME . '/' . ACTION_NAME;
						$l['time']=date('Y-m-d H:i:s',time());
						$l['user_id']=session("user");
						$l['ip']=$_SERVER["REMOTE_ADDR"];
						$l['content']='登录';
						M('operation_log')->add($l);
						
						$list['code']=200;
						$list['msg']='登录成功';
						echo json_encode($list,true);
						exit;
				   }else{
						$list['code']='error';
						$list['msg']='密码错误';
						echo json_encode($list,true);
						exit;
				   }
			   }
		   }
		  
	   }else{
		   if(session('user')){
			   $this->redirect('Index/index');
		   }
		   $web_set = M('web_set')->where('id=1')->find();
		   $this->assign('web_set',$web_set);
		   $this->display();
	   }
	}
	
	public function login_out(){
		session('user',null);
		session('login_session',null);
		$this->redirect('Login/login');
	}
	

	

}