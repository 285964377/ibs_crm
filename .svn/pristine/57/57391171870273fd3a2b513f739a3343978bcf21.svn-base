<?php
/**
 *流转规则管理
 */

namespace Home\Controller;
class ChangeController extends BackController
{
   
    public function index()
    {
		$data=M('config_change')->where('id=1')->find();
		$this->assign('data',$data);
		$this->display();
    
    }
    /**
     * 修改
     */
    public function edit()
    {
        if (IS_POST) {
			$data=$_POST;
            M('config_change')->where('id=1')->save($data);
            $list['code'] = 200;
            $list['msg'] = '修改成功';
			$content ="修改流转规则";
            $this->op_log($content);
            echo json_encode($list, true);
            exit;
        }
    }

}