<?php
/**
 *  产品管理
 */

namespace Home\Controller;
class GoodsController extends BackController
{
    public function index()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
			if (I('get.search')) {
                $complex[] = array(
                    'g.name' => array('like', "%" . I('get.search') . "%"),
                    'g.type' => array('like', "%" . I('get.search') . "%"),
                    '_logic' => 'or'
                );
                
            }
			if(I('get.money')){
				$complex[]=array(
					'g.money_start'=>array('elt',I('get.money'))
				);
				$complex[]=array(
					'g.money_end'=>array('glt',I('get.money'))
				);
			}
			if($complex){
				$where = array(
					'_complex' => $complex,
					'_logic' => 'and'
				);
			}
			
            $page = (I('get.page') != '') ? I('get.page') - 1 : 0;    //页码
            $num = (I('get.limit') != '') ? I('get.limit') : 10;        //每页条数
            $data = M('goods as g')->field('g.*')->join('left join user as u on u.uid=g.user_id')->where($where)->limit($num * $page, $num)->select();
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] =  M('goods as g')->where($where)->count();
			
            echo json_encode($list, true);
        }
    }

    //添加产品
    public function add()
    {
        if (IS_POST) {
            $data = $_POST;
			$where['name']=array('eq',$data['name']);
			$where['type']=array('eq',$data['type']);
            $goods = M('goods')->where($where)->find();
            if ($goods) {
                echo json_encode(["code" => "ERROR", "msg" => "产品重复!"], true);
                exit;
            }
			$wh['code']=array('eq',$data['code']);
			$goods = M('goods')->where($where)->find();
            if ($goods) {
                echo json_encode(["code" => "ERROR", "msg" => "产品编号重复!"], true);
                exit;
            }
            //操作人
            $user = M('user')->where(['id' => session('user')])->find();
            M('goods')->add($data);
            $content = '添加产品:' . "{$data['name']}";
            $this->op_log($content);
            $list['code'] = 200;
            $list['msg'] = '添加成功';
            echo json_encode($list, true);
            die;
        }else{
			$this->display();
		}
    }

  

    public function edit()
    {
       
        if (IS_POST) {
			$id = I('post.id');
            $data = $_POST;
			$where['name']=array('eq',$data['name']);
			$where['type']=array('eq',$data['type']);
            $goods = M('goods')->where($where)->find();
            if ($goods && $goods['id'] !=$id) {
                echo json_encode(["code" => "ERROR", "msg" => "产品重复!"], true);
                exit;
            }
			$wh['code']=array('eq',$data['code']);
			$goods = M('goods')->where($where)->find();
            if ($goods && $goods['id'] !=$id) {
                echo json_encode(["code" => "ERROR", "msg" => "产品编号重复!"], true);
                exit;
            }
            $content ='修改产品:' . "{$data['name']}";
            $this->op_log($content);
            M('goods')->where(['id' => $id])->save($data);
			$list['code'] = 200;
            $list['msg'] = '修改成功';
            echo json_encode($list, true);
        }else{
			$id = I('get.id');
			$data = M('goods')->where(['id' => $id])->find();
            $this->assign('data', $data);
			$this->display();
		}
    }

    public function delete()
    {
        $id = I('post.id');
        if ($id){
            //被删除的产品
            $goods = M('goods')->where(['id'=>$id])->find();
            $list['code'] = 200;
            $list['msg'] = '删除成功';
            $content = '删除产品:' . "{$goods['name']}";
            $this->op_log($content);
            M('goods')->where(['id' => $id])->delete();
            echo json_encode($list, true);
            die;
        }else{
            $list['code'] = "ERROR";
            $list['msg'] = '参数错误';
            echo json_encode($list, true);
            die;
        }
    }

    // 上架&下架
    public function status()
    {
        $id = I('post.id');
        $data['status'] = I('post.status');
        if ($data['status'] == 1) {
            $msg = "上架产品";
        } else {
            $msg = "下架产品";
        }

        $goods = M('goods')->where(['id'=>$id])->find();
        $content = "{$msg}".":"."{$goods['name']}";
        $this->op_log($content);
        M('goods')->where('id=' . $id)->save($data);
        echo json_encode(["code" => 200, "msg" => $msg . '成功'], true);
        die;
    }
}