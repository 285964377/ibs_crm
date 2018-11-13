<?php
//操作日志
namespace Home\Controller;
class OperlogController extends BackController
{

    public function index()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            $page = (I('get.page') != '') ? I('get.page') - 1 : 0;    //页码
            $num = (I('get.limit') != '') ? I('get.limit') : 10;        //每页条数
            if(I('get.time_start')){
                $s_time = I('get.time_start');
                $e_time = strtotime(I('get.time_end'));
                $e_time = date('Y-m-d',$e_time+86400);
                $where['l.creat_time'] =array('between',array($s_time,$e_time));
            }

            if(I('get.search')){
				$search=I('get.search') ;
                $complex[]=array(
                    'u.name' => array('like', "%$search%"),
                    'u.code' => array('like', "%$search%"),
                    '_logic' => 'or'
                );
            }
			if(I('get.type')){
                $complex[]=array(
                    'l.type'=>array('like',"%".I('get.type')."%")
                );
            }
			if($complex){
				$where['_complex'] =$complex;
				$where['_logic'] ='and';
			}
			
            $data = M('operation_log as l')
                ->field('l.*,u.name,u.code')
                ->join('left join user as u on u.uid=l.user_id')
                ->where($where)
				->order('id DESC')
                ->limit($page*$num,$num)
                ->select();

            foreach ($data as $k => $v) {
                $type = explode('/', $v['type'])[0];
                $controller=$this->get_controller($type);
                $type = explode('/', $v['type'])[1];
                $action=$this->get_action($type);
                $data[$k]['type'] =$controller .":".$action;

            }
            //print_r($data);
            $list['code'] = 200;
            $list['msg'] = '';
            $list['data'] = $data;
            $list['count'] = M('operation_log as l')->join('left join user as u on u.uid=l.user_id')->where($where)->count();
            echo json_encode($list, true);
            exit;

        }
    }

    //layui  selectTree 接口
    public function linkage()
    {
        $data = M('group_rule')->where('id<55')->select();
		
        foreach ($data as $k => $v) {
            if ($v['pid'] == 0) {
				$data[$k]['name']= explode('/', $v['name'])[0];
                $data[$k]['title'] = $this->get_controller(explode('/', $v['name'])[0]);
            }
			if(!$data[$k]['title']){
				unset($data[$k]);
				continue;
			}
			if( explode('/', $v['name'])[1]== 'details' ){
					unset($data[$k]);
					continue;
			}
			$str=$data[$k]['name'];
			$data[$k]['name']=$data[$k]['title']; 
			$data[$k]['title'] = $str;
        }
		
        $data = $this->roles($data);
		$data[]=array(
			'id'=>0,
			'pid'=>0,
			'name'=>'客户管理',
			'title'=>'Customer',
			'children'=>array(
				0=>array(
					'name'=>'导入客户',
					'title'=>'Customer/import'
				),
				1=>array(
					'name'=>'下载模板',
					'title'=>'Customer/dw_export'
				),
				2=>array(
					'name'=>'分配',
					'title'=>'Customer/allot'
				)
			)
		);
		
		$data[]=array(
			'id'=>0,
			'pid'=>0,
			'name'=>'财务',
			'title'=>'Finance',
			'children'=>array(
				0=>array(
					'name'=>'移交业绩',
					'title'=>'Finance/exchange'
				),
				1=>array(
					'name'=>'修改业绩',
					'title'=>'Finance/edit'
				),
				2=>array(
					'name'=>'业绩分享',
					'title'=>'Finance/share'
				)
			)
		);
		$data[]=array(
			'id'=>0,
			'pid'=>0,
			'name'=>'全部'
		);
		$data[]=array(
			'id'=>0,
			'pid'=>0,
			'name'=>'登录',
			'title'=>'Login'
		);
        echo json_encode($data, true);
        exit;

    }
	
	public function get_controller($type)
    {
		switch($type){
			case "Login":
				$type="登录";
				break;
			case "Part":
				$type="部门管理";
				break;
			case "User":
				$type="员工管理";
				break;
			case "Role":
				$type="角色管理";
				break;
			case "Wealth":
				$type="资质管理";
				break;
			case "Orgin":
				$type="商机来源管理";
				break;
			case "Restype":
				$type="商机类型管理";
				break;
			case "Label":
				$type="标签管理";
				break;
			case "Faq":
				$type="FAQ管理";
				break;
			case "Msg":
				$type="站内信管理";
				break;
			case "Goods":
				$type="产品管理";
				break;
			case "Change":
				$type="流转设置";
				break;
			case "Finance":
				$type="财务";
				break;
			case "Orders":
				$type="订单管理";
			break;
				case "Customer":
				$type="客户管理";
				break;
			default:
				$type=null;
				break;
		}
        return $type;
    }

    public function get_action($type)
    {
        if ($type == "login") $type = "登录";
        if ($type == "add") $type = "添加";
        if ($type == "edit") $type = "修改";
        if ($type == "delete") $type = "删除";
        if ($type == "status") $type = "上架/下架&冻结/解冻";
        if ($type == "reset") $type = "重置密码";
        if ($type == "send") $type = "发送";
        if ($type == "edit_table") $type = "修改资质";
        if ($type == "delete_table") $type = "删除资质";
        if ($type == "add_field") $type = "添加字段";
        if ($type == "edit_field") $type = "修改字段";
        if ($type == "delete_field") $type = "删除字段";
        if ($type == "exchange") $type = "业绩移交";
        if ($type == "share") $type = "业绩分享";
        if ($type == "dw_export") $type = "下载模板";
        if ($type == "import") $type = "导入";
        if ($type == "allot") $type = "分配";
        return $type;
    }

}