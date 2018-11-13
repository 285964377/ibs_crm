<?php
/**
 *客户类型管理
 */

namespace Home\Controller;
class CustypeController extends BackController
{
    //商机来源列表
    public function index()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            $data = M('custype')->select();
            foreach ($data as $key => $val) {
                foreach ($val as $k => $v) {
                    if ($k == 'id' || $k == 'pid') {
                        $data[$key][$k] = intval($v);
                    }
                }
            }
            $list['code'] = 200;
            $list['data'] = $data;
            echo json_encode($list, true);
        }

    }

    public function add()
    {
        if (IS_POST) {
            $data['name'] = I('post.name');
            $data['pid'] = I('post.pid');
            $where['name'] = array('eq', $data['name']);
            $check = M('custype')->where($where)->find();
            if ($check) {
                $list['code'] = 'error';
                $list['msg'] = '类型存在重复';
                echo json_encode($list, true);
                exit;
            } else {
                M('custype')->add($data);
                $content = '添加客户类型:' . "{$data['name']}";
                $this->op_log($content);
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
            $data['name'] = I('post.name');
            $data['pid'] = I('post.pid');
            $where['name'] = array('eq', $data['name']);
            $check = M('custype')->where($where)->find();
            if ($check && $check['id'] != $id) {
                $list['code'] = 'error';
                $list['msg'] = '重复命名';
                echo json_encode($list, true);
                exit;
            }
            $re = M('custype')->where(['id' => $id])->find();
            $content = '修改客户类型:' . "{$data['name']}" . '修改之后为'."{$re['name']}";
            $this->op_log($content);
            M('custype')->where('id=' . $id)->save($data);
            $list['code'] = 200;
            $list['msg'] = '修改成功';
            echo json_encode($list, true);
            exit;
        }
    }


    //**删除
    public  function delete(){
		$id=I('param.id');
		$part=M('custype')->where('pid='.$id)->find();
		if($part){
			$list['code']='error';
			$list['msg']='存在下级类型,无法删除';
			echo json_encode($list,true);
			exit;
		}
		$data=M('custype')->where('id='.$id)->find();
		$content = '删除客户类型:' . "{$data['name']}";
		$this->op_log($content);
		M('custype')->where('id='.$id)->delete();
		$list['code']=200;
		$list['msg']='删除成功';
		echo json_encode($list,true);
		exit;
	}
}