<?php
/*
部门管理
*/
namespace Home\Controller;
class PartController extends BackController {
	//部门列表
	public function index(){
		if($_GET['index']){
			$this->display();
		}
		if($_GET['search_data']){
			$data=M('part as p')
				->field('p.*,u.name as user_name,u.code as user_code')
				->join('left join user as u on u.uid=p.leader_id')
				->select();
			foreach($data as $key=>$val){
				foreach($val as $k=>$v){
					if($k=='id' || $k=='pid'){
						$data[$key][$k]=intval($v);
					}
				}
			}
			$list['code']=200;
			$list['data']=$data;
			echo json_encode($list,true);
		}
    }
	
	public function add(){
		if(IS_POST){
			$name=I('post.name');
			$code=I('post.code');
			$pid=I('post.pid');
			$where['name']=array('eq',$name);
			$part=M('part')->where($where)->find();
			if($part){
				$list['code']='error';
				$list['msg']='部门名字重复';
				echo json_encode($list,true);
				exit;
			}
			$part=M('part')->order('id ASC')->select();
			foreach($part as $key=>$val){
				$sl_check=strlen($code);
				$sl_code=strlen($val['code']);
				if($sl_check>$sl_code){
					$check=substr($code,0,strlen($val['code']));
					if($check==$val['code']){
						if(!$pid){
							$list['code']='error';
							$list['msg']='部门代码不能包含其他部门';
							echo json_encode($list,true);
							exit;
						}
					}
				}
				if($sl_check==$sl_code){
					if($code==$val['code']){
						$list['code']='error';
						$list['msg']='部门代码重复';
						echo json_encode($list,true);
						exit;
					}
					
				}
				if($sl_check<$sl_code && !$pid){
					$check=substr($val['code'],0,strlen($code));
					if($check==$code){
						$list['code']='error';
						$list['msg']='部门代码不能被其他部门包含';
						echo json_encode($list,true);
						exit;
					}
				}
			}
		
			//验证上级部门编码
			if($pid){
				$p_part=M('part')->where('id='.$pid)->getField('code');
				$check=substr($code,0,strlen($p_part));
				if($check==$code){
					$list['code']='error';
					$list['msg']='部门代码必须包含上级部门代码';
					echo json_encode($list,true);
					exit;
				}
			}
			
			
			$leader_id=I('post.leader_id');
			if(!$leader_id){
				$list['code']='error';
				$list['msg']='请选择部门负责人';
				echo json_encode($list,true);
				exit;
			}
			$leader=M('user')->where('uid='.$leader_id)->find();
			if(!$leader){
				$list['code']='error';
				$list['msg']='该员工已被删除';
				echo json_encode($list,true);
				exit;
			}
			
			$data['name']=$name;
			$data['code']=$code;
			$data['leader_id']=$leader_id;
			$data['pid']=$pid;
			M('part')->add($data);
			$this->op_log('添加部门:'.$name);
			$list['code']=200;
			$list['msg']='添加成功';
			echo json_encode($list,true);
			exit;
			
		}else{
			$this->display();
		}
		
	}
	
	
	public function edit(){
		$id=I('post.id');
		$name=I('post.name');
		
		$leader_id=I('post.leader_id');
		if(!$leader_id){
			$list['code']='error';
			$list['msg']='请选择部门负责人';
			echo json_encode($list,true);
			exit;
		}
		$leader=M('user')->where('uid='.$leader_id)->find();
		if(!$leader){
			$list['code']='error';
			$list['msg']='该员工已被删除';
			echo json_encode($list,true);
			exit;
		}
		$where['name']=array('eq',$name);
		$part=M('part')->where($where)->find();
		if($part && $part['id']!=$id){
			$list['code']='error';
			$list['msg']='重复命名';
			echo json_encode($list,true);
			exit;
		}
	
		$data['name']=$name;
		$data['rush']=I('post.rush');
		$data['leader_id']=$leader_id;
		M('part')->where('id='.$id)->save($data);
		$content='修改部门:id='.$id.';';
		$content.=$part['name'].'=>'.$name.';';
		$this->op_log($content);
		$list['code']=200;
		$list['msg']='修改成功';
		echo json_encode($list,true);
		exit;
	}
	
	
	public  function delete(){
		$id=I('param.id');
		$part=M('part')->where('pid='.$id)->find();
		if($part){
			$list['code']='error';
			$list['msg']='存在下级部门,无法删除';
			echo json_encode($list,true);
			exit;
		}
		$user=M('user')->where('part_id='.$id)->find();
		if($part){
			$list['code']='error';
			$list['msg']='部门下还有员工,无法删除';
			echo json_encode($list,true);
			exit;
		}
		$data=M('part')->where('id='.$id)->find();
		M('part')->where('id='.$id)->delete();
		$content = '删除部门:' . "{$data['name']}";
		$this->op_log($content);
		$list['code']=200;
		$list['msg']='删除成功';
		echo json_encode($list,true);
		exit;
	}
	
	
}

