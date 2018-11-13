<?php
//角色控制器
namespace Home\Controller;
class RoleController extends BackController {
	public function index(){
		if($_GET['index']){
			$this->display();
		}
		if($_GET['search_data']){
			$page = (I('get.page') != '') ? I('get.page')-1 : 0;    //页码
			$num = (I('get.limit') != '') ? I('get.limit') : 10;        //每页条数
			if(I('get.search')){
				$where=array(
					'title'=>array('like',"%".I('get.search')."%")
				);
			}else{
				$where=array(
					'id'=>array('neq','1')
				);
			}
			$where['id'] = array('neq','1');
			$data =M('group_role')
				->where($where)
				->limit($page*$num,$num)
				->select();
			$list['code'] = 0;
			$list['msg'] = '';
			$list['data'] = $data;
			$list['count'] =  M('group_role')->where($where)->count();
			echo json_encode($list,true);
			exit;
		}
	}
		
	public function add(){
		if(IS_POST){
			$data['rules'] = implode(',',I('post.id'));
			$data['title'] = I('post.title');
			$data['descript'] =  I('post.descript');
			$data['show_tel'] =  I('post.show_tel');
			$data['show_data'] =  I('post.show_data');
			$id = M('group_role')->add($data);
			$this->op_log('新增角色:'.$data['title']);
			echo json_encode(["code"=>200,"msg"=>"新增角色成功"],true);
			exit;
		}else{
				//获取权限队列
			$rule = M('group_rule')->order('sort ASC')->select();
			$result =  [];  //初始化一个数组
			foreach($rule as $k=>$v){
				  $type = explode('/',$v['name'])[0];
				  if(!$type){
					  continue;
				  }
				  if($type == "Part") $type="部门管理";
				  if($type == "User") $type="员工管理";
				  if($type == "Role") $type="角色管理";
				  if($type == "Customer") $type="客户管理";
				  if($type == "Custype") $type="客户分类管理";
				  if($type == "Wealth") $type="资质管理";
				  if($type == "Orgin") $type="商机来源管理";
				  if($type == "Restype") $type="商机类型管理";
				  if($type == "Article") $type="系统公告管理";
				  if($type == "Label") $type="标签管理";
				  if($type == "Faq") $type="FAQ管理";
				  if($type == "Msg") $type="站内信管理";
				  if($type == "Goods") $type="产品管理";
				  if($type == "Change") $type="流转设置";
				  if($type == "Operlog") $type="系统操作日志";
				  if($type == "Resources") $type="商机管理";
				  if($type == "Orders") $type="订单管理";
				  if($type == "Finance") $type="财务管理";
				  if($type == "search_cus") $type="客户搜索权限";
				  if($type == "search_order") $type="订单搜索权限";
				  if($type == "search_finance") $type="财务搜索权限";
				  if($type == "search_res") $type="商机搜索权限";
				  if($type == "count") $type="统计分布图";
				  $result[$type][]    =   $v;  //根据initial 进行数组重新赋值
			}
			$this->assign('result',$result);
			$this->display();
		}
	}
	
	public function edit(){
		if(IS_GET){
			//获取当前角色信息
			$where['id'] = array('eq',I('get.id'));
			$role = M('group_role')->where($where)->find();
			$this->assign('role',$role);
					//获取权限队列
			$rule = M('group_rule')->order('sort ASC')->select();
			$result =   [];  //初始化一个数组
			foreach($rule as $k=>$v){
				$type = explode('/',$v['name'])[0];
				if(!$type){
					continue;
				}
				if($type == "Part") $type="部门管理";
				if($type == "User") $type="员工管理";
				if($type == "Role") $type="角色管理";
				if($type == "Customer") $type="客户管理";
				if($type == "Custype") $type="客户分类管理";
				if($type == "Wealth") $type="资质管理";
				if($type == "Orgin") $type="商机来源管理";
				if($type == "Restype") $type="商机类型管理";
				if($type == "Label") $type="标签管理";
				if($type == "Article") $type="系统公告管理";
				if($type == "Faq") $type="FAQ管理";
				if($type == "Msg") $type="站内信管理";
				if($type == "Goods") $type="产品管理";
				if($type == "Change") $type="流转设置";
				if($type == "Operlog") $type="系统操作日志";
				if($type == "Resources") $type="商机管理";
				if($type == "Orders") $type="订单管理";
				if($type == "Finance") $type="财务管理";
				if($type == "search_cus") $type="客户搜索权限";
				if($type == "search_order") $type="订单搜索权限";
				if($type == "search_finance") $type="财务搜索权限";
				if($type == "search_res") $type="商机搜索权限";
				if($type == "count") $type="统计分布图";
				$result[$type][]    =   $v;  //根据initial 进行数组重新赋值
			}
			$this->assign('result',$result);
			$this->assign('role',$role);
			$this->display();
		}
		if(IS_POST){
			$data['rules'] = implode(',',I('post.id'));
			$data['title'] = I('post.title');
			$data['descript'] =  I('post.descript');
			$data['show_tel'] =  I('post.show_tel');
			$data['show_data']=  I('post.show_data');
			$id=I('post.rid');
		    $re = M('group_role')->where('id='.$id)->find();
			M('group_role')->where('id='.$id)->save($data);
			$this->op_log("修改角色:ID:$id;".$re['title']."=>".$data['title']);
			echo json_encode(["code"=>200,"msg"=>"编辑角色成功"],true);
		}
	}
		
	public function delete(){
		$uid = I('get.id');
		$where['id'] = array('eq',$uid);
		//判断本角色是否在使用中
		$where_a['group_id'] = array('eq',$uid);
		if( M('group_access')->where($where_a)->find()){
				echo json_encode(["code"=>"ERROR","msg"=>"包含正在使用中的角色！无法删除，请在用户列表中检查角色"],true);
				exit;
		}
        $re = M('group_role')->where($where)->find();
		M('group_role')->where($where)->delete();
		$this->op_log('删除角色:'.$re['title']);
		echo json_encode(["code"=>0,"msg"=>"删除成功"],true);
		
	}
}