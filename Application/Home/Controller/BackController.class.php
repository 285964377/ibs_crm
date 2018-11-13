<?php

namespace Home\Controller;

use Think\Controller;

class BackController extends Controller
{
    public function _initialize()
    {
		/*
		for($i=1;$i<200;$i++){
			$arr[]=$i;
		}
		echo implode(',',$arr);
		die;
		*/
	
		
		$time=date('Y-m-d H:i:s',time());
        A('Auto')->check_login();//登录验证
        A('Auto')->check_power();//权限验证
        A('Auto')->auto_out_first($time);//未首电掉库
        A('Auto')->auto_out_fllow($time);//超期跟进掉库
        A('Auto')->auto_out_over($time);//成单过期掉库
		
		//获取当前用户的搜索栏权限

		$rule=M('group_role as gr')->field('gr.rules,gr.title')->join('group_access as ga on ga.group_id=gr.id')->where('ga.uid='.session('user'))->find();
		$where['id']=array('in','('.$rule['rules'].')');
		$where['search']=array('eq',2);
		$power = M('group_rule')->field('name')->where($where)->select();
		foreach($power as $key=>$val){
			$new_arr[]=$val['name'];
		}
		$this->assign('search_power',$new_arr);
    }
	
	//获取用户
	public function get_user(){
		$page = (I('get.page') != '') ? I('get.page')-1 : 0;    //页码
		$num = (I('get.limit') != '') ? I('get.limit') : 10;        //每页条数
		if(I('get.search')){
			$complex[]=array(
                'u.name'=>array('like',"%".I('get.search')."%"),
                'u.tel'=>array('like',"%".I('get.search')."%"),
                'u.code'=>array('like',"%".I('get.search')."%"),
                '_logic'=>'or'
            );
		}
		
		if(I('get.part_id')){
			$code=M('part')->where('id='.I('get.part_id'))->getField('code');
			$complex[]=array(
				'p.code'=> array('like',"%".$code."%")
			);
		}
		$role = M('group_access')->where('uid=' . session('user'))->getField('group_id');
        $power = M('group_role')->where('id=' . $role)->getField('show_data');
		if ($power == 'self') {  //只能查看自己的数据
			$complex[]=array(
				'u.uid'=> array('eq',session('user'))
			);
        }
        if ($power == 'part') {//查看部门数据
            $part_id = M('user')->where('uid=' . session('user'))->getField('part_id');
            $my_part_code = M('part')->where('id=' . $part_id)->getField('code');
			$complex[]=array(
				'p.code'=> array('like',$my_part_code."%")
			);
        }
		
		if($complex){
			$where=array(
				'_complex'=>$complex,
				'_logic'=>'and'
			);
		}
		
		
		$data=M('user as u')
			->field('u.uid,u.name as user_name,u.code as user_code,p.name,u.tel')
			->join('left join part as p on p.id=u.part_id')
			->where($where)
			->limit($num*$page,$num)
			->select();
		$list['code'] = 200;
		$list['data'] = $data;
		$list['count'] =  M('user as u')->join('left join part as p on p.id=u.part_id')->where($where)->count();
		echo json_encode($list,true);
		exit;
	}
	
	//获取所有用户
	public function get_all_user(){
		$page = (I('get.page') != '') ? I('get.page')-1 : 0;    //页码
		$num = (I('get.limit') != '') ? I('get.limit') : 10;        //每页条数
		if(I('get.search')){
			$complex[]=array(
                'u.name'=>array('like',"%".I('get.search')."%"),
                'u.tel'=>array('like',"%".I('get.search')."%"),
                'u.code'=>array('like',"%".I('get.search')."%"),
                '_logic'=>'or'
            );
		}
		
		if(I('get.part_id')){
			$code=M('part')->where('id='.I('get.part_id'))->getField('code');
			$complex[]=array(
				'p.code'=> array('like',$code."%")
			);
		}
		 if ($complex) {
			$where = array(
				'_complex' => $complex,
				'_logic' => 'and'
			);
		}
		$data=M('user as u')
			->field('u.uid,u.name as user_name,u.code as user_code,p.name,u.tel,p.code')
			->join('left join part as p on p.id=u.part_id')
			->where($where)
			->limit($num*$page,$num)
			->select();
		$list['code'] = 200;
		$list['data'] = $data;
		$list['count'] =  M('user as u')->join('left join part as p on p.id=u.part_id')->where($where)->count();
		echo json_encode($list,true);
		exit;
	}
	
	//商机销售阶段
	public function res_step($stage){
		switch ($stage) {
				case 0;
                    $stage = "未首电";
                    break;
                case 1;
                    $stage = "咨询";
                    break;
                case 2;
                    $stage = "犹豫";
                    break;
                case 3;
                    $stage = "意向";
                    break;
                case 4;
                    $stage = "已上门";
                    break;
                case 5;
                    $stage = "签约";
                    break;
                default:
                    $stage = '未首电';
					break;
            }
		return $stage;
	}
	
	//商机状态
	public function res_status($stage){
		switch ($stage) {
				case 1;
                    $stage = "待首电";
                    break;
                case 2;
                    $stage = "跟进中";
                    break;
                case 3;
                    $stage = "已签单";
                    break;
                case 4;
                    $stage = "待审核 ";
                    break;
                case 5;
                    $stage = "审核被拒";
                    break;
                case 6;
                    $stage = "白名单";
                    break;
                default:
                    $stage = '掉库';
					break;
            }
		return $stage;
	}
	
	//商机下次跟进阶段
	public function res_next_step($stage){
		switch ($stage) {
                case 1;
                    $stage = "咨询";
                    break;
                case 2;
                    $stage = "犹豫";
                    break;
                case 3;
                    $stage = "意向";
                    break;
                case 4;
                    $stage = "上门";
                    break;
                case 5;
                    $stage = "签约";
                    break;
                default:
                    $stage = '无';
					break;
            }
		return $stage;
	}
	
	//订单状态
	public function order_status($stage){
		
		switch ($stage) {
				case 0;
					$stage = "草稿";
					break;
				case 1;
					$stage = "待审核";
					break;
				case 2;
					$stage = "已驳回";
					break;
				case 3;
					$stage = "办理中";
					break;
				case 4;
					$stage = "办理完毕";//(未收款)
					break;
				case 5;
					$stage = "办理完毕";//(已收款)
					break;
				case 6;
					$stage = "退单待审核";
					break;
				case 7;
					$stage = "已退单";
					break;
		}
		return $stage;
	}
	
	//工单状态
	public  function demand_status($stage){
		switch ($stage) {
				case 1;
					$stage = "办理暂缓";
					break;
				case 2;
					$stage = "办理超期";
					break;
				case 3;
					$stage = "正常进行中";
					break;
				case 4;
					$stage = "办理完毕";
					break;
		}
		return $stage;
	}
	
	//工单进度
	public  function demand_step($stage){
		switch ($stage) {
				case 1;
					$stage = "进件";
					break;
				case 2;
					$stage = "出件";
					break;
				case 3;
					$stage = "银行审批";
					break;
				case 4;
					$stage = "放款";
					break;
				default:
					$stage ='待跟进';
					break;
		}
		return $stage;
	}
	
	//财务申请
	public  function apply_step($stage){
		switch ($stage) {
				case 1;
					$stage = "待初审";
					break;
				case 2;
					$stage = "待复审";
					break;
				case 3;
					$stage = "初审被拒";
					break;
				case 4;
					$stage = "复审被拒";
					break;
				case 5;
					$stage = "审核通过";
					break;
		}
		return $stage;
	}
	//商机掉库类型
	public  function  out_type($stage){
		
		switch ($stage) {
				case 0;
                    $stage = '抢单库';
                    break;
                case 1;
                    $stage = '超期未首电';
                    break;
                case 2;
                    $stage = '超期未跟进';
                    break;
                case 3;
                    $stage = '反无效掉库';
                    break;
                case 4;
                    $stage = '退单掉库';
                    break;
                case 5;
                    $stage = '保护过期';
                    break;
            }
		return $stage;
	}
	// 客户婚姻状况
	public function cus_marry($stage){
		switch ($stage) {
				case 0;
                    $stage = "未知";
                    break;
                case 1;
                    $stage = "已婚";
                    break;
                case 2;
                    $stage = "未婚";
                    break;
                case 3;
                    $stage = "离异";
                    break;
                case 4;
                    $stage = "丧偶";
                    break;
                case 5;
                    $stage = "再婚";
                    break;
                default:
                    $stage = '无';
					break;
            }
		return $stage;
	}
	
		// 客户学历
	public function cus_educate($stage){
		switch ($stage) {
				case 0;
                    $stage = "未知";
                    break;
                case 1;
                    $stage = "高中以下";
                    break;
                case 2;
                    $stage = "大专";
                    break;
                case 3;
                    $stage = "本科";
                    break;
                case 4;
                    $stage = "硕士及以上";
                    break;
                default:
                    $stage = '无';
					break;
            }
		return $stage;
	}
	
	//商机操作类型 控制器转中文
	public function op_log_trans($controler){
		switch ($controler) {
				case 'Customer/add';
                    $stage = "转化";
                    break;
				case 'Resources/add';
                    $stage = "新增商机";
                    break;
				case 'Resources/edit';
                    $stage = "编辑基础信息";
                    break;
				case 'Resources/change_type';
                    $stage = "修改商机类型";
                    break;
				case 'Resources/change_orgin';
                    $stage = "修改商机来源";
                    break;
				case 'Resources/add_wealth';
                    $stage = "添加资质";
                    break;
				case 'Resources/delete_wealth';
                    $stage = "删除资质";
                    break;
				case 'Resources/add_contact';
                    $stage = "添加联系人";
                    break;
				case 'Resources/delete_contact';
                    $stage = "删除联系人";
                    break;
				case 'Resources/add_goods';
                    $stage = "添加推荐产品";
                    break;
				case 'Resources/delete_goods';
                    $stage = "删除推荐产品";
                    break;
				case 'Resources/add_fujian';
                    $stage = "添加附件";
                    break;
				case 'Resources/delete_fujian';
                    $stage = "删除附件";
                    break;
				case 'Resources/go_in';
                    $stage = "跟进";
                    break;
				case 'Resources/xd';
                    $stage = "下单";
                    break;
				case 'Resources/tcheck';
                    $stage = "审核剔除";
                    break;
				case 'Resources/fcheck';
                    $stage = "审核反无效";
                    break;
				case 'Resources/tichu_res';
                    $stage = "申请剔除";
                    break;
				case 'Resources/fan_res';
                    $stage = "申请反无效";
                    break;
				case 'Resources/allot';
                    $stage = "移交/分配到个人";
                    break;
				case 'Resources/allot_part';
                    $stage = "分配到部门";
                    break;
				case 'Resources/change_cb_nei';
                    $stage = "修改内部成本";
                    break;
				case 'Resources/change_cb_wai';
                    $stage = "修改外部成本";
                    break;
				case 'Resources/qiang';
                    $stage = "抢单";
                    break;
				case 'Resources/re_get';
                    $stage = "抢单";
                    break;
				case 'Resources/edit_order';
                    $stage = "修改订单草稿";
                    break;	
				case 'Resources/cg_delete';
                    $stage = "删除订单草稿";
                    break;	
				case 'Resources/cg_xd';
                    $stage = "订单草稿下单";
                    break;	
				case 'Resources/tui';
                    $stage = "订单申请退单";
                    break;	
				case 'Orders/check';
					$stage = "订单审核";
					break;	
				case 'Orders/tui';
					$stage = "流程退单";
					break;			
				case 'Orders/check_tui';
					$stage = "退单审核";
					break;
				case 'Resources/rk_apply';
					$stage = "申请认款";
					break;
				case 'Orders/rk_apply';
					$stage = "费用申请";
					break;
				case 'Finance/check_first';
					$stage = "财务初审";
					break;	
				case 'Finance/check_last';
					$stage = "财务复审";
					break;	
					
            }

		return $stage;
	}
	
    //管理员操作日志
    public function op_log($content)
    {
        $data['type'] = CONTROLLER_NAME . '/' . ACTION_NAME;
        $data['user_id'] = session("user");
        $data['ip'] = $_SERVER["REMOTE_ADDR"];
        $data['content'] = $content;
        $id=M('operation_log')->add($data);
		return $id;
    }

    //商机操作记录
    public function res_op_log($res_id, $content)
    {
        $data['controler'] = CONTROLLER_NAME . '/' . ACTION_NAME;
        $data['user_id'] = session("user");
        $data['res_id'] = $res_id;
        $data['content'] = $content;
        M('res_op_log')->add($data);
    }

    //工单跟进操作记录
    public function dmd_op_log($demd_id, $content)
    {
        $data['controler'] = CONTROLLER_NAME . '/' . ACTION_NAME;
        $data['user_id'] = session("user");
        $data['demd_id'] = $demd_id;
        $data['content'] = $content;
        M('dmd_op_log')->add($data);
    }


    //获取符合权限的部门
    public function select_part()
    {
		$role = M('group_access')->where('uid=' . session('user'))->getField('group_id');
        $power = M('group_role')->where('id=' . $role)->getField('show_data');
		$data = M('part')->field('name,id,pid')->select();
		$data = $this->roles($data);
		if ($power == 'self') {  //只能查看自己的数据
			$data=array();
        }
        if ($power == 'part') {//查看部门数据
            $part_id = M('part')->where('leader_id=' . session('user'))->getField('id');
			if(!$part_id){
				$data=array();
			}
        }
		if($part_id){
			$arr=$data;
			$data=array();
			$data[]=$this->searchKey($arr,'id',$part_id);
		}
		
		$data[]=array(
			'id'=>0,
			'pid'=>0,
			'name'=>'全部',
		);
        echo json_encode($data, true);
        exit;
    }
	
	//获取所有部门
	 public function select_all_part()
    {
		$role = M('group_access')->where('uid=' . session('user'))->getField('group_id');
        $power = M('group_role')->where('id=' . $role)->getField('show_data');
		$data = M('part')->field('name,id,pid')->select();
		$data = $this->roles($data);
		$data[]=array(
			'id'=>0,
			'pid'=>0,
			'name'=>'全部',
		);
        echo json_encode($data, true);
        exit;
    }
	
	//从二维数组中取出指定键值
	public function searchKey($data,$k,$value){
		foreach($data as $key=>$val){
			if($val[$k]==$value){
				return $val;
			}else{
				return $this->searchKey($val['children'],$k,$value);
			}
		}
		
	}

	//获取商机类型
	public function select_restype(){
		$data = M('restype')->select();
		$data = $this->roles($data);
		echo json_encode($data, true);
		exit;
	}
	
	//获取客户类型
	public function select_custype(){
		$data = M('custype')->select();
		$data = $this->roles($data);
		echo json_encode($data, true);
		exit;
	}
	
	//获取认款类型
	public function select_rk_money(){
		$data = M('money_rk_type')->select();
		$data = $this->roles($data);
		echo json_encode($data, true);
		exit;
	}
	
	
	//获取商机来源
	public function select_origin(){
		$data = M('origin')->select();
		$data = $this->roles($data);
		echo json_encode($data, true);
		exit;
	}
	
    //递归无限极分类
    public function roles($data, $pid = 0)
    {
        foreach ($data as $key => $val) {
            if ($val['pid'] == $pid) {
				$val['pid']=0;
                $arr[$key] = $val;
                $arr[$key]['children'] = $this->roles($data, $val['id']);
            }
        }
        $arr = array_merge($arr);
        return $arr;
    }
	


    //导出 到excel
    /*
    $xlsData= $data;
    $xlsName  = "中国城市列表";
    $xlsCell  = array(
        array('name','名字'),
        array('pid','上级ID'),
        array('id','下级ID'),
    );

    $this->exportE($xlsName,$xlsCell,$xlsData);
    */
    public function exportE($xlsName, $xlsCell, $xlsData)
    {
        $xlsName .= time();
        $length = count($xlsData);
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsName . '.xls"');
        header("Content-Disposition:attachment;filename=$xlsName.xls");//attachment新窗口打印inline本窗口打印
        $data .= "<table border=1>";
        $data .= "<tr>";
        foreach ($xlsCell as $key => $val) {
            $data .= "<td>" . $val[1] . "</td>";
        }
        $data .= "</tr>";

        for ($i = 0; $i < $length; $i++) {
            $data .= "<tr>";
            foreach ($xlsCell as $k => $v) {
                $data .= "<td>" . $xlsData[$i][$v[0]] . "</td>";
            }
            $data .= "</tr>";
        }
        /*
        foreach($xlsData as $key=>$val){
            $data .= "<tr>";
            foreach($xlsCell as $k=>$v){
                $data .= "<td>".$val[$v[0]]."</td>";
            }
            $data .= "</tr>";
        }
        */
        $data .= "</table>";
        exit($data);

    }

   
}