<?php
//欢迎页控制器 首页
namespace Home\Controller;
class IndexController extends BackController {
	public function index(){
		$web_set=M('web_set')->find();
		//获取当前用户的权限组
		$rule=M('group_role as gr')->field('gr.rules,gr.title')->join('group_access as ga on ga.group_id=gr.id')->where('ga.uid='.session('user'))->find();
		$power = M('group_rule')->field('name')->where('id in ('.$rule['rules'].')')->select();
		foreach($power as $key=>$val){
			$new_arr[]=$val['name'];
		}
		$basic_menu_power=2;
		$basic_menu=array(
			'Part/index',
			'User/index',
			'Orgin/index',
			'Wealth/index',
			'Restype/index',
			'Label/index',
			'Role/index',
			'Faq/index',
			'Msg/index',
			'Goods/index',
			'Change/index',
			'Operlog/index'
		);
		foreach($basic_menu as $key=>$val){
			if(in_array($val,$new_arr)){
				$basic_menu_power=1;
				break;
			}
		}
		$user = M('user as u')
                ->field('u.*,p.name as part_name')
                ->join('left join part as p on p.id=u.part_id')
                ->where('u.uid='.session('user'))
                ->find();
		//查看用是否为部门负责人
		$part=M('part')->where('leader_id='.session('user'))->find();
		if($part){
			$this->assign('rush',$part);
		}
		$user['role']=$rule['title'];
		$this->assign('basic_menu_power',$basic_menu_power);
		$this->assign('power',$new_arr);
		$this->assign('web_set',$web_set);
		$this->assign('user',$user);
		$this->display();
	}
		
	public function change_rush(){
		$part=M('part')->where('leader_id='.session('user'))->find();
		if(!$part){
			$list['code'] = "error";
			$list['msg'] = '抱歉，您还不是部门负责人';
			echo json_encode($list, true);
		}
		$data['status']=I('param.status');
		if($data['status'] == 1){
			$msg="开启抢单模式";
		}else{
			$msg="关闭抢单模式";
		}
		M('part')->where('leader_id='.session('user'))->save($data);
		$content = $msg.":".$part['name'];
		$this->op_log($content);
		echo json_encode(["code"=>200,"msg"=>$msg.'成功'],true);
	}	
		
	public function welcome(){
		
		//获取当前用户的统计图权限

		$rule=M('group_role as gr')->field('gr.rules,gr.title')->join('group_access as ga on ga.group_id=gr.id')->where('ga.uid='.session('user'))->find();
		$where_power['id']=array('in','('.$rule['rules'].')');
		$where_power['search']=array('eq',3);
		$power = M('group_rule')->field('name')->where($where_power)->select();
		foreach($power as $key=>$val){
			$new_arr[]=$val['name'];
		}
		
		
		$this->assign('count_power',$new_arr);
		
		$user = M('user as u')
                ->field('u.*,p.name as part_name')
                ->join('left join part as p on p.id=u.part_id')
                ->where('u.uid='.session('user'))
                ->find();
		$user['role']=$rule['title'];
		$this->assign('user',$user);
		
	   //查看当前用户的数据查看权限
        $role = M('group_access')->where('uid=' . session('user'))->getField('group_id');
        $power = M('group_role')->where('id=' . $role)->getField('show_data');
        if ($power == 'self') {  //只能查看自己的数据
            $where['user_id'] = array('eq', session('user'));
			//订单数据， 前台和后台都能看见与自己相关的数据
			$complex[] = array(
                    'user_id' => array('eq', session('user')),
                    'accept_user' => array('eq', session('user')),
                    '_logic' => 'or'
                );
        }
        if ($power == 'part') {//查看部门数据
            $part_id = M('user')->where('uid=' . session('user'))->getField('part_id');
            $my_part_code = M('part')->where('id=' . $part_id)->getField('code');
            $where['part_code'] = array('like', $my_part_code . "%");
			$complex[] = array(
                    'part_code' => array('like', $my_part_code . "%"),
                    'accept_part_code' => array('like', $my_part_code . "%"),
                    '_logic' => 'or'
				);
        }
		
	
			
		//掉库预警
		$where['status']=array('in',"(1,2)");
		$where['left(guess_out_time,10)'] = array('eq', date('Y-m-d', time()));
		$out_worning['today']=M('resources')->where($where)->count();
		$ht = date("Y-m-d",strtotime("+1 day")); 
		$where['left(guess_out_time,10)'] = array('eq', $ht);
		$out_worning['tomarrow']=M('resources')->where($where)->count();
		unset($where['left(guess_out_time,10)']);
		unset($where['status']);
		$this->assign('out_worning',$out_worning);
		
		//商机类型分布
		$res_type=M('resources')->field('res_type_id')->where($where)->group('res_type_id')->select();
		
		foreach($res_type as $key=>$val){
			if(!$val['res_type_id']){
				continue;
			}
			$name=M('restype')->where('id='.$val['res_type_id'])->getField('name');
			$type=$where;
			$type['res_type_id']=array('eq',$val['res_type_id']);
			$value=M('resources')->where($type)->count();
			if($key >0){
				$res_type_str.=",";
			}
			$res_type_str.="{";
			$res_type_str.='"name":"'.$name.'('.$value.')",';
			$res_type_str.='"value":"'.$value.'"';
			$res_type_str.="}";
		}
		if(!$res_type){
			$res_type_str="{'name':'暂无','value':1}";
		}
		$this->assign('res_type',$res_type_str);
		
		//商机来源分布
		$res_regin=M('resources')->field('origin_id')->where($where)->group('origin_id')->select();
		foreach($res_regin as $key=>$val){
			if(!$val['origin_id']){
				continue;
			}
			$name=M('origin')->where('id='.$val['origin_id'])->getField('name');
			$regin=$where;
			$regin['origin_id']=array('eq',$val['origin_id']);
			$value=M('resources')->where($regin)->count();
			if($key >0){
				$res_regin_str.=",";
			}
			$res_regin_str.="{";
			$res_regin_str.='"name":"'.$name.'('.$value.')",';
			$res_regin_str.='"value":"'.$value.'"';
			$res_regin_str.="}";
		}
		if(!$res_regin){
			$res_regin_str="{'name':'暂无','value':1}";
		}
		$this->assign('res_regin',$res_regin_str);
		
		//阶段分布
		$res_step=M('resources')->field('status')->where($where)->group('status')->select();
		foreach($res_step as $key=>$val){
			$name=$this->res_status($val['status']);
			$step=$where;
			$step['status']=array('eq',$val['status']);
			$value=M('resources')->where($step)->count();
			if($key >0){
				$res_step_str.=",";
			}
			$res_step_str.="{";
			$res_step_str.='"name":"'.$name.'('.$value.')",';
			$res_step_str.='"value":"'.$value.'"';
			$res_step_str.="}";
		}
		if(!$res_step){
			$res_step_str="{'name':'暂无','value':1}";
		}
		$this->assign('res_step',$res_step_str);
		
		
		//今日办分布
		$where['left(next_time,10)']=array('eq',date('Y-m-d',time()));
		$res_next=M('resources')->field('next_step')->where($where)->group('next_step')->select();
		foreach($res_next as $key=>$val){
			$name=$this->res_next_step($val['next_step']);
			$next=$where;
			$next['next_step']=array('eq',$val['next_step']);
			$value=M('resources')->where($next)->count();
			if($key >0){
				$res_next_str.=",";
			}
			$res_next_str.="{";
			$res_next_str.='"name":"'.$name.'('.$value.')",';
			$res_next_str.='"value":"'.$value.'"';
			$res_next_str.="}";
		}
		if(!$res_next){
			$res_next_str="{'name':'暂无','value':1}";
		}
		$this->assign('res_next',$res_next_str);
		
		//业绩排名
		$yj_order=$this->yj_order();
		$yj_order=array_slice($yj_order,0,10);
		$this->assign('yj_order',$yj_order);
		
		
		
		/*订单分布*/
		/*订单状态分布*/
		if ($complex) {
                $where_order = array(
                    '_complex' => $complex,
                    '_logic' => 'and'
                );
            }
			
		$order_status=M('orders')->field('status')->where($where_order)->group('status')->select();
		foreach($order_status as $key=>$val){
			$name=$this->order_status($val['status']);
			$status=$where_order;
			$status['status']=array('eq',$val['status']);
			$value=M('orders')->where($status)->count();
			if($key >0){
				$order_status_str.=",";
			}
			$order_status_str.="{";
			$order_status_str.='"name":"'.$name.'('.$value.')",';
			$order_status_str.='"value":"'.$value.'"';
			$order_status_str.="}";
		}
		if(!$order_status){
			$order_status_str="{'name':'暂无','value':1}";
		}
	
		$this->assign('order_status',$order_status_str);
		
		/*工单分布*/
		
		$my_order=M('orders')->where($where_order)->field('id')->select();
		
		if(function_exists('array_column')){
			$order_id = array_column($my_order,'id');	 //提取字段
		}else{
			foreach($my_order as $key=>$val){
				$order_id[]=$val['id'];
			}
		}
		if($order_id){
			$where_demand['order_id']=array('in',$order_id);
			$demand_status=M('demand')->field('status')->where($where_demand)->group('status')->select();
			foreach($demand_status as $key=>$val){
				$name=$this->demand_status($val['status']);
				$status=$where_demand;
				$status['status']=array('eq',$val['status']);
				$value=M('demand')->where($status)->count();
				if($key >0){
					$demand_status_str.=",";
				}
				$demand_status_str.="{";
				$demand_status_str.='"name":"'.$name.'('.$value.')",';
				$demand_status_str.='"value":"'.$value.'"';
				$demand_status_str.="}";
			}
			if(!$demand_status){
				$demand_status_str="{'name':'暂无','value':1}";
			}
			
			$demand_step=M('demand')->field('step')->where($where_demand)->group('step')->select();
			foreach($demand_step as $key=>$val){
				$name=$this->demand_step($val['step']);
				$step=$where_demand;
				$step['step']=array('eq',$val['step']);
				$value=M('demand')->where($step)->count();
				if($key >0){
					$demand_step_str.=",";
				}
				$demand_step_str.="{";
				$demand_step_str.='"name":"'.$name.'('.$value.')",';
				$demand_step_str.='"value":"'.$value.'"';
				$demand_step_str.="}";
			}
			if(!$demand_step){
				$demand_step_str="{'name':'暂无','value':1}";
			}
			
		}else{
			$demand_status_str="{'name':'暂无','value':1}";
			$demand_step_str="{'name':'暂无','value':1}";
		}
		
		$this->assign('demand_status',$demand_status_str);
		$this->assign('demand_step',$demand_step_str);
		$this->display();
	}

	
	//通知消息
	public function get_msg(){
		$page = (I('get.page') != '') ? I('get.page') - 1 : 0;    //页码
		$num = (I('get.limit') != '') ? I('get.limit') : 10;         //每页条数
		$where['user_id']=array('eq',session('user'));
		$data = M('msg_user')->where($where)->order('id DESC')->limit($num*$page,$num)->select();
		foreach($data as $key=>$val){
			if(!$val['title']){
				$data[$key]['title']=M('msg')->where('id='.$val['msg_id'])->getField('title');
			}
		}
		$list['code'] = 200;
		$list['data'] = $data;
		$list['count'] = M('msg_user')->where($where)->count();
		echo json_encode($list, true);
		exit;
	}
	
	//通知详情
	public function msg_details(){
		$id=I('get.id');
		$data=M('msg_user')->where('id='.$id)->find();
		if(!$data['title']){
			$msg=M('msg')->where('id='.$data['msg_id'])->find();
			$data['title']=$msg['title'];
			$data['content']=$msg['content'];
		}
		$this->assign('data',$data);
		$status['status']=1;
		$status['read_time']=date('Y-m-d H:i:s',time());
		M('msg_user')->where('id='.$id)->save($status);
		$this->display();
	}
	
	//系统公告
	public function get_article(){
		$page = (I('get.page') != '') ? I('get.page') - 1 : 0;    //页码
		$num = (I('get.limit') != '') ? I('get.limit') : 10;         //每页条数
		$data = M('article')->order('id DESC')->limit($num*$page,$num)->select();
		$list['code'] = 200;
		$list['data'] = $data;
		$list['count'] = M('article')->where($where)->count();
		echo json_encode($list, true);
		exit;
	}
	
	//公告详情
	public function article_details()
    {
        $id = I('get.id');
        $data = M('article')->where(['id' => $id])->find();
		$data['content'] =  htmlspecialchars_decode(html_entity_decode($data['content']));
        $this->assign('data', $data);
		$this->display();
    }
	
	//搜索faq
	public function faq(){
		 if ($_GET['index']) {
			$this->assign('keywords',I('get.keywords'));
            $this->display();
        }
        if ($_GET['search_data']) {
            $page = (I('get.page') != '') ? I('get.page') - 1 : 0;    //页码
            $num = (I('get.limit') != '') ? I('get.limit') : 10;         //每页条数
			
			$complex[]=array(
				'status'=>array('eq',1)
			);
			
			if(I('get.keywords')){
				$complex[] = array(
					'title' => array('like', "%" . I('get.keywords') . "%"),
					'content' => array('like', "%" . I('get.keywords') . "%"),
					'_logic' => 'or'
				);
			}
			
			$where = array(
				'_complex' => $complex,
				'_logic' => 'and'
			);
			
            $data = M('faq')->where($where)->order('id DESC')->limit($num*$page,$num)->select();
		
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = M('faq')->where($where)->count();
            echo json_encode($list, true);
        }
		
		
	}
	
	//我的业绩  只计算个人，部门的在财务才统计
	public function my_yj(){
		if(I('get.search_data')){
			$page = (I('get.page') != '') ? I('get.page') - 1 : 0;    //页码
			$num = (I('get.limit') != '') ? I('get.limit') : 5;         //每页条数
			if (I('get.creat_time_start')) {
				$s_time = I('get.creat_time_start');
				$e_time = I('get.creat_time_end');
				$where['creat_time'] = array('between', array($s_time, $e_time));
			}
			$where['user_id']=array('eq',session('user'));
			$data=M('money_yj_log')->where($where)->order('id DESC')->limit($num*$page,$num)->select();
			$list['code'] = 200;
			$list['data'] = $data;
			$list['count'] = M('money_yj_log')->where($where)->count();
			echo json_encode($list, true);
			exit;
		}
		if(I('get.count')){
			if (I('get.creat_time_start')) {
				$s_time = I('get.creat_time_start');
				$e_time = I('get.creat_time_end');
				$where['creat_time'] = array('between', array($s_time, $e_time));
			}
			$where['user_id']=array('eq',session('user'));
		    $money = M('money_yj_log')->where($where)->sum('money'); //认款总和
			if(!$money){
				$money=0;
			}
			$list['code'] = 200;
			$list['data'] = $money;
			echo json_encode($list, true);
			exit;
		}
	}
	
	//公司本月业绩排名
	public function yj_order(){
		$today = date("Y-m-d",strtotime("+1 day")); //今天
        $month_start=date("Y-m-d",mktime(0, 0 , 0,date("m"),1,date("Y")));//本月
        $where['creat_time'] = array( array('EGT',$month_start),array('ELT',$today));
		
		$usres=M('money_yj_log')->field('user_id')->where($where)->group('user_id')->select();
		foreach($usres as $key=>$val){
			$where['user_id']=array('eq',$val['user_id']);
			$moeny=M('money_yj_log')->where($where)->sum('money');
			$user=M('user')->where('uid='.$val['user_id'])->find();
			$yj['user']=$user['name']."——".M('part')->where('id='.$user['part_id'])->getField('name');
			$yj['money']=$moeny;
			$arr[]=$yj;
		}
		$arr=arraySequence($arr,'money');
		return $arr;
	}
	
	//FAQ内容
   public function details()
    {
        $id = I('get.id');
        $data = M('faq')->where(['id' => $id])->find();
		M('faq')->where(['id' => $id])->setInc('nums');
		$data['content'] =  htmlspecialchars_decode(html_entity_decode($data['content']));
        $this->assign('data', $data);
		$this->display();
    }
	
	//修改密码
	public function change_pwd(){
		$where['uid'] = array('eq',session('user'));
		$data['login_pwd'] = MD5(I('post.pwd'));
		M('user')->where($where)->save($data);
		echo json_encode(["code"=>200,"msg"=>'修改成功'],true);
	}
}

/**
 * 二维数组根据字段进行排序
 * @params array $array 需要排序的数组
 * @params string $field 排序的字段
 * @params string $sort 排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
 */
 function arraySequence($array, $field, $sort = 'SORT_DESC')
{
    $arrSort = array();
    foreach ($array as $uniqid => $row) {
        foreach ($row as $key => $value) {
            $arrSort[$key][$uniqid] = $value;
        }
    }
    array_multisort($arrSort[$field], constant($sort), $array);
    return $array;
}