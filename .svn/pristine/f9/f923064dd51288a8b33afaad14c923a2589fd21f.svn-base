<?php

namespace Home\Controller;
//标签管理
class LabelController extends BackController
{
    public function index()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            $page = (I('get.page') != '') ? I('get.page') - 1 : 0;    //页码
            $num = (I('get.limit') != '') ? I('get.limit') : 10;         //每页条数
			if(I('get.type')){
				$where['type']=array('eq',I('get.type'));
			}
            $data = M('label')->where($where)->limit($num*$page,$num)->select();
            foreach ($data as $k => $v) {
                switch ($v['type']) {
                    case 1;
                        $data[$k]['type'] = '客户备注';
                        break;
                    case 2;
                        $data[$k]['type'] = '商机备注';
                        break;
                    case 3;
                        $data[$k]['type'] = '商机跟进';
                        break;
                    case 4;
                        $data[$k]['type'] = '订单办理';
                        break;
                }
				$data[$k]['type_id']=$v['type'];
            }
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = M('label')->where($where)->count();
            echo json_encode($list, true);
        }
    }

    public function add()
    {
        if (IS_POST) {
            $data['type'] = I('post.type');
            $data['content'] = I('post.content');
            $where['type'] = array('eq', $data['type']);
            $where['content'] = array('eq', $data['content']);
            $check = M('label')->where($where)->find();
            if ($check) {
                $list['code'] = 'error';
                $list['msg'] = '标签重复';
                echo json_encode($list, true);
                exit;
            } else {
				switch ($data['type']) {
					case 1;
						$type = '客户备注';
						break;
					case 2;
						$type = '商机备注';
						break;
					case 3;
						$type = '商机跟进';
						break;
					case 4;
						$type = '订单办理';
						break;
				}
				$content = "添加标签;类型:".$type.";内容：".$data['content'];
				$this->op_log($content);
                M('label')->add($data);
                $list['code'] = 200;
                $list['msg'] = '添加成功';
                echo json_encode($list, true);
                exit;
            }
        }
    }

    /**
     * 修改
     */
    public function edit()
    {
        if (IS_POST) {
            $id = I('post.id');
            $data['type'] = I('post.type');
            $data['content'] = I('post.content');
            $where['type'] = array('eq', $data['type']);
            $where['content'] = array('eq', $data['content']);
            $check = M('label')->where($where)->find();
            if ($check && $check['id'] != $id) {
                $list['code'] = 'error';
                $list['msg'] = '标签重复';
                echo json_encode($list, true);
                exit;
            }
			$re=M('label')->where('id=' . $id)->find();
			switch ($re['type']) {
				case 1;
					$type = '客户备注';
					break;
				case 2;
					$type = '商机备注';
					break;
				case 3;
					$type = '商机跟进';
					break;
				case 4;
					$type = '订单办理';
					break;
			}
            M('label')->where('id=' . $id)->save($data);
			$content = '修改'.$type.'标签:' . $re['content']."=>".$data['content'];
            $this->op_log($content);
            $list['code'] = 200;
            $list['msg'] = '修改成功';
            echo json_encode($list, true);
            exit;
        }
    }

    //**删除
    public function delete()
    {
        $id = I('get.id');
        if ($id) {
			$re=M('label')->where('id=' . $id)->find();
			switch ($re['type']) {
				case 1;
					$type = '客户备注';
					break;
				case 2;
					$type = '商机备注';
					break;
				case 3;
					$type = '商机跟进';
					break;
				case 4;
					$type = '订单办理';
					break;
			}
            M('label')->where('id=' . $id)->save($data);
			$content = '删除'.$type.'标签:' . $re['content'];
            $this->op_log($content);
			
            M('label')->where('id=' . $id)->delete();
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
	
		// 上下架
	public function status(){
		$id = I('post.id');
		$data['status']  =I('post.status');
		if($data['status'] == 1){
			$msg="上架标签";
		}else{
			$msg="下架标签";
		}
		$re=M('label')->where('id=' . $id)->find();
		switch ($re['type']) {
			case 1;
				$type = '客户备注';
				break;
			case 2;
				$type = '商机备注';
				break;
			case 3;
				$type = '商机跟进';
				break;
			case 4;
				$type = '订单办理';
				break;
		}
		M('label')->where('id=' . $id)->save($data);
		$content = $msg."类型:".$type.";内容：".$re['content'];
		$this->op_log($content);
		M('faq')->where('id='.$id)->save($data);
		echo json_encode(["code"=>200,"msg"=>$msg.'成功'],true);
		
	}

}