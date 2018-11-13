<?php

namespace Home\Controller;
class MsgController extends BackController
{
    public function index()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            $page = (I('get.page') != '') ? I('get.page') - 1 : 0;    //页码
            $num = (I('get.limit') != '') ? I('get.limit') : 10;         //每页条数
            
			if(I('get.time_start')){
				$s_time = I('get.time_start');
				$e_time = strtotime(I('get.time_end'));
				$e_time = date('Y-m-d',$e_time+86400);
				$where['creat_time'] =array('between',array($s_time,$e_time));
			}
			if(I('get.title')){
				$where['title'] =array('like',"%".I('get.title')."%");
			}
			if(I('get.status')){
				$where['status'] =array('eq',I('get.status'));
			}
			$where['type']=array('eq',2);//这里不需要查找 自动发送的消息
            $data = M('msg')->where($where)->limit($num*$page,$num)->order('id DESC')->select();
            foreach ($data as $k => $v) {
				$arr=explode(',',$v['accept_user']);
				$wh['user_id']=array('in',$arr);
				$data[$k]['accept_user']=M('user')->field('name')->where($wh)->select();
				$user = M('user')->where(['id' => $v['user_id']])->field('name')->find();
                $data[$k]['username'] =$user['name'];
            }
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = M('msg')->where($where)->count();
            echo json_encode($list, true);
        }
    }
	
	public function add()
    {
        if (IS_POST) {
            $data['user_id'] = session('user');
            $data['title'] = trim(I('post.title'));
            $data['content'] = I('post.content');
			$data['accept_user']=I('post.accept_id');
            $msg_id=M('msg')->add($data);
			$this->op_log('添加站内信草稿:'.$data['title']);
            $list['code'] = 200;
            $list['msg'] = '添加成功';
            echo json_encode($list, true);
            exit;
        }else{
			$this->display();
		}
    }
	
	public function edit()
    {
        if (IS_POST) {
			$id=I('post.id');
			$re=M('msg')->where('id='.$id)->find();
			if(I('post.accept_id')){
				$data['accept_user']=I('post.accept_id');
				$this->op_log("修改站内信收件人:".$re['title']);
			}else{
				$data['title'] = trim(I('post.title'));
				$data['content'] = I('post.content');
				$this->op_log("修改站内信草稿:".$re['title']."=>".$data['title']);
			}
            M('msg')->where('id='.$id)->save($data);
            $list['code'] = 200;
            $list['msg'] = '修改成功';
            echo json_encode($list, true);
            exit;
        }else{
			$id=I('get.id');
			$data=M('msg')->where('id='.$id)->find();
			if($data['accept_user']){
				$where['uid']=array('in',$data['accept_user']);
			}
			$user=M('user')->where($where)->select();
			$this->assign('data',$data);
			$this->assign('user',$user);
			$this->display();
		}
    }
	
	public function details(){
		$id=I('get.id');
		$data=M('msg')->where('id='.$id)->find();
		$where['mu.msg_id']=array('eq',$id);
		$user=M('msg_user as mu')
			->field('u.name,u.code,mu.status,mu.read_time')
			->join('user as u on u.uid=mu.user_id')
			->where($where)->select();
		foreach($user as $key=>$val){
			if($val['status']==1){
				$user[$key]['status']='已读';
			}else{
				$user[$key]['status']='未读';
			}
		}
		$this->assign('data',$data);
		$this->assign('user',$user);
		$this->display();
	}
	
	//发送站内信
	public function send(){
		$id=I('get.id');
		$re=M('msg')->where('id='.$id)->find();
		if(!$re['accept_user']){
			$list['code'] = "error";
			$list['msg'] = '未选择收件人';
			echo json_encode($list, true);
			exit;
		}
		$user=explode(',',$re['accept_user']);
		foreach($user as $key=>$val){
			A('Workerman')->send_msg($val,$re['title'],$re['content'],$id,2);
		}
		$data['status']=1;
		$data['send_time']=date('Y-m-d H:i:s');
		M('msg')->where('id='.$id)->save($data);
		$this->op_log("发送站内信:ID:$id;".$re['title']);
		$list['code'] = 200;
		$list['msg'] = '发送成功';
		echo json_encode($list, true);
		exit;
	}
	
	  /**
     * 删除
     */
    public function delete()
    {
        $id = I('get.id');
        if ($id) {
			$re= M('msg')->where('id=' . $id)->find();
            M('msg')->where('id=' . $id)->delete();
			$this->op_log('删除站内信草稿:'.$re['title']);
            $list['code'] = 200;
            $list['msg'] = '删除成功';
            echo json_encode($list, true);
            exit;
        } else {
            $list['code'] = 'error';
            $list['msg'] = '参数不存在';
            echo json_encode($list, true);
            exit;
        }
    }
	
	public function get_part(){
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