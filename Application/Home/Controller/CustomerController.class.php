<?php
/*客户
*/
namespace Home\Controller;
class CustomerController extends BackController 
{
	
	public $page;
	public $num;
	public $where;
	public $see_tel;
	public $now_time;
	
	public function _initialize()
    {
        parent::_initialize();
        $this->page = (I('get.page') != '') ? I('get.page') - 1 : 0;
        $this->num = (I('get.limit') != '') ? I('get.limit') : 10;
        $this->now_time = date('Y-m-d H:i:s',time());
        //查看当前用户的数据查看权限
        $role = M('group_access')->where('uid=' . session('user'))->getField('group_id');
        $power = M('group_role')->where('id=' . $role)->getField('show_data');
        if ($power == 'self') {  //只能查看自己的数据
            $param['user_id'] = array('eq', session('user'));
        }
        if ($power == 'part') {//查看部门数据
            $part_id = M('user')->where('uid=' . session('user'))->getField('part_id');
            $my_part_code = M('part')->where('id=' . $part_id)->getField('code');
            $param['part_code'] = array('like',$my_part_code . "%");
        }
      
        //客户号码
        if (I('get.phone')) {
            $param['phone'] = array('like', "%" . I('get.phone') . "%");
        }
        //客户姓名
        if (I('get.name')) {
            $param['name'] = array('like', "%" . I('get.name') . "%");
        }
        
        //客户编号
        if (I('get.code')) {
            $param['code'] = array('like', "%" . I('get.code') . "%");
        }
		
		//所属部门
        if (I('get.part_id')) {
            $param['part_id'] = array('eq', I('get.part_id'));
        }
		
		//客户分类
        if (I('get.type_id')) {
            $param['type_id'] = array('eq', I('get.type_id'));
        }
		
        //创建时间
        if (I('get.creat_time_start')) {
            $s_time = I('get.creat_time_start');
            $e_time = I('get.creat_time_end');
            $param['creat_time'] = array('between', array($s_time, $e_time));
        }
		
		//分配时间
		if (I('get.allot_time_start')) {
			$s_time = I('get.allot_time_start');
			$e_time = I('get.allot_time_end');
			$param['allot_time'] = array('between', array($s_time, $e_time));
		}
		
	
        $this->where = $param;
        $power = M('group_role')->where('id=' . $role)->getField('show_tel');
        if ($power == 1) {
            $this->see_tel = 1;
        } else {
            $this->see_tel = 2;
        }

    }
	
		
		
	public function index()
	{
		if ($_GET['index']) {
            $this->display();
        }
		
        if ($_GET['search_data']) {
			$where = $this->where;
			$where['type']=2;
			$data=M('customer')->where($where)->limit($this->num * $this->page, $this->num)->order('ID desc')->select();
			$data=$this->all($data);
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = $data = M('customer')->where($where)->count();
            echo json_encode($list, true);
			exit;
        }

	}

	public function alloted()
	{
		if ($_GET['index']) {
            $this->display();
        }
		
        if ($_GET['search_data']) {
			$where = $this->where;
			$where['type']=1;
			$data=M('customer')->where($where)->limit($this->num * $this->page, $this->num)->order('ID desc')->select();
			$data=$this->all($data);
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = $data = M('customer')->where($where)->count();
            echo json_encode($list, true);
			exit;
        }

	}
	
	
	//修改客户信息
	public function edit(){
		$id=I('param.id');
		$where['id']=array('eq',$id);
		if(IS_POST){
			$data=$_POST;
			unset($data['id']);
			M('customer')->where($where)->save($data);
			$list['code'] = 200;
			$list['msg'] = '修改成功';
			echo json_encode($list, true);
		}else{
			$data=M('customer')->where($where)->find();
			$this->assign('data',$data);
			$this->display();
		}
	}
	
	
	//批量修改分类
	public function change_type(){
		if(IS_POST){
			$id=I('param.id');
			$type_id=I('param.type_id');
			$data['type_id']=$type_id;
			$where['id']=array('in',$id);
			M('customer')->where($where)->save($data);
			$list['code'] = 200;
			$list['msg'] = '修改成功';
			echo json_encode($list, true);
		}else{
			$this->assign('id',I('param.id'));
			$this->display();
		}
		
	}
	
	//商机转化
	public function add(){
		A('Resources')->add();
	}
	/*导出*/
	public  function export()
	{
		if(IS_POST){
			$list['code'] = 200;
			$list['msg'] = '拥有权限';
			echo json_encode($list, true);
			exit;
		}else{
			$where = $this->where;
			$data=M('customer')->where($where)->limit($this->num * $this->page, $this->num)->select();
			$xlsData= $data;
			$xlsName  = "客户列表";
			$xlsCell  = array(
				array('code','客户编号'),
				array('creat_time','创建日期'),
				array('phone','联系电话'),
				array('name','姓名'),
				array('idcard','身份证'),
				array('money','贷款金额'),
				array('remark','备注')
			);
			$this->op_log($type,'导出客户'.count($data).'条');
			$this->exportE($xlsName,$xlsCell,$xlsData);
		}
	}
  
  //客户导入
	public function import()
	{
		if ($_GET['index']) {
            $this->display();
        }
		
		if($_FILES['file']){
			$path = 'uploader/upload/excel/'.date('Ymd');
			if (!file_exists($path)) {
				mkdir($path,0777);
			}
			chmod($path,0777);
			$end_file = strrchr($_FILES['file']['name'], '.');
			$files =mt_rand(0, 99).$end_file;
			$path = $path.'/'.date('YmdHis') . '_' . $files;
			$resoult = move_uploaded_file($_FILES['file']['tmp_name'], $path);
			if($resoult){
				$savePath= $path;
				$list['code'] = 200;
				$list['msg'] = '上传成功';
				$list['file'] = $savePath;
			}else{
				$list['code'] = "ERROR";
				$list['msg'] = '文件上传失败';
			}
			echo json_encode($list, true);
			exit;
		}
		
		//执行数据验证 sql写入
		if(IS_POST){
			$savePath=I('param.file');
			if(!$savePath){
				$list['code'] = "ERROR";
				$list['msg'] = '缺少文件路径';
				echo json_encode($list, true);
				exit;
			}
			set_time_limit(0);
				//预备记录
			$xxxx .="写入取消，文件地址:".$savePath;
			$id=$this->op_log($xxxx);
			$step['step']='loading';		//初始化状态
			
			//使用一个txt文件来记录读写情况
			$path=explode('.',$savePath)[0].'.txt';
			file_put_contents("".$path."",json_encode($step,true));
			
			
			header("content-type:text/html;charset=utf-8");
			vendor("PHPExcel.PHPExcel");
			include_once("./ThinkPHP/Library/Vendor/PHPExcel/PHPExcel.class.php");
			$objReader = new \PHPExcel_Reader_Excel2007();
			$objPHPExcel=$objReader->load($savePath);			//$file_url即Excel文件的路径  只能是相对路径
			if (!$objReader->canRead($savePath)) {
				$objReader = new \PHPExcel_Reader_Excel5();
				if (!$objReader->canRead($savePath)) {
					$step['step']='error';		//初始化状态
					echo json_encode(["code"=>"ERROR","msg"=>"读取文件失败"],true);
					exit;
				}
			}
			$sheet=$objPHPExcel->getSheet(0);						//获取第一个工作表
			$highestRow=$sheet->getHighestRow();					//取得总行数
			$highestColumn=$sheet->getHighestColumn(); 				//取得总列数
			
			
			//字段验证
			//					D      	E			G		K     L			N
			$c_title= array('联系人','常用电话','身份证','年龄','备注','贷款金额');
			$title[] =  $objPHPExcel->getActiveSheet()->getCell("D1")->getValue();
			$title[] =  $objPHPExcel->getActiveSheet()->getCell("E1")->getValue();
			$title[] =  $objPHPExcel->getActiveSheet()->getCell("G1")->getValue();		
			$title[] =  $objPHPExcel->getActiveSheet()->getCell("K1")->getValue();		
			$title[] =  $objPHPExcel->getActiveSheet()->getCell("L1")->getValue();		
			$title[] =  $objPHPExcel->getActiveSheet()->getCell("N1")->getValue();		
			foreach($title as $key=>$val){
				if($val!=$c_title[$key]){
					$step['step']='error';
					file_put_contents("".$path."",json_encode($step,true));
					unlink($savePath); //删除excel文件 unlink()删除文件
					echo json_encode(["code"=>"ERROR","msg"=>"表头错误,请将".$val."修改为".$c_title[$key]],true);
					exit;
				}
			}
			if($highestRow>1){
				$customer=M('customer')->field('phone')->select();
				$resources=M('resources')->field('phone')->select();
				if(function_exists('array_column')){
					$cus_tel = array_column($customer,'phone');	 //提取字段
					$res_tel = array_column($resources,'phone');	 //提取字段
				}else{
					foreach($customer as $key=>$val){
						$cus_tel[]=$val['phone'];
					}
					foreach($resources as $key=>$val){
						$res_tel[]=$val['phone'];
					}
				}
				$now_customer=array_merge($res_tel,$cus_tel);//合并数组
				$now_customer=array_flip($now_customer);     //翻转键值 这样可以去重
			}else{
				$step['step']='error';
				file_put_contents("".$path."",json_encode($step,true));
				unlink($savePath); //删除excel文件 unlink()删除文件
				$list['code'] = "ERROR";
				$list['msg'] = '请勿上传空文件';
				echo json_encode($list, true);
				exit;
			}
			
			// usefull =  success +  repeat；
			$usefull=0; //有效数据
			$useless=0;	//无效数据
			$success=0;	//成功写入的数据
			$repeat=0;	//与数据库重复的数据
		
			$times=ceil(($highestRow-1)/20); //分 总数/20次  来写入
			
			/*记录状态 */
			$step['total']=$times;
			$step['step']='decoding';
			$step['process']=0;
			file_put_contents("".$path."",json_encode($step,true));
			
			
			/*遍历数据*/ 
			for($i=0;$i<$times;$i++){
				if($times>1){					//如果总页码大于1页
					$now_time=$i*20+2;		//本页开始的位置
					$next_time=$now_time+20;	//本页结束的位置
					if($next_time>$highestRow){
						$next_time=$highestRow;
					}
				}else{							//如果只有1页，就直接计算到最后一页
					$now_time=2;
					$next_time=$highestRow;
				}
				
				if($next_time==$highestRow){
					$next_time=$next_time+1;
				}
				$step['loaded']=$i;
				file_put_contents("".$path."",json_encode($step,true));
				for($j=$now_time;$j<$next_time;$j++){//从第二行开始读取数据
				/*-------验证必填字段start-------*/
			//					D      		E			G		K		L			N
			$c_title= array('联 系 人','常用电话','身份证','年    龄','备    注','贷款金额');
			
					$data['name']         =  $objPHPExcel->getActiveSheet()->getCell("D$j")->getValue();
					$data['phone']		  =  $objPHPExcel->getActiveSheet()->getCell("E$j")->getValue(); 
					if(is_object($data['name'])) $data['name']= $data['name']->__toString();
					if(is_object($data['phone']))  $data['phone']= $data['phone']->__toString();
					$data['idcard']		  =  $objPHPExcel->getActiveSheet()->getCell("G$j")->getValue(); 
					$data['age']		  =  $objPHPExcel->getActiveSheet()->getCell("K$j")->getValue(); 
					$data['remark']		  =  $objPHPExcel->getActiveSheet()->getCell("L$j")->getValue(); 
					$data['money']		  =  $objPHPExcel->getActiveSheet()->getCell("N$j")->getValue(); 
					
					/*验证必填数据*/
					if(!$data['name'] || !$data['phone'] ){
						$useless++;
						continue;
					}
					/*-------end-------*/
					
					/*-------统一将Excel中的对象转为字符串start-------*/
					foreach($data as $key=>$val){
						if(is_object($val))  $data[$key]= $val->__toString();
					}
					/*-------------end-----*/
					$data['type']=2;
					$data['creat_user']=session('user');
					/*-------去除文件中重复的电话 start-------*/
					$nmf=$data['phone'];
					
					if($usefull>0){
						if(isset($check_arr2[$nmf])){		//if(in_array($nmf,$check_arr2)){								//   in_array  和 增加数组 是导致运行效率低下的罪魁祸首
							$useless++;
							continue;
						}
					}
					
					/*-------去除文件中重复的电话 end-------*/
					
					
					//记录有效数据条数               
					$usefull++;
					$check_arr2[$nmf]=$nmf;	
					/*-------与数据库进行匹配去重 start-------*/
					if(isset($now_customer[(string)$nmf])){		//	if(!in_array($nmf,$now_customer)){
						//记录重复条数
						$repeat++;
						continue;
					}else{
						$data['uid']=session('uid');
						$data['code']='KH' . date('Ymd', $_SERVER['REQUEST_TIME']) . str_pad(mt_rand(0, 999), 3, "0", STR_PAD_LEFT) . session('user');
						$arr[]=$data;							
						//记录成功条数
						$success++;
					}	
				} 
			}
			$step['step']='decoding';
			$step['process']=$times;
			
			
			
			/*修改状态*/
			$step['step']='insert';
			$step['total']=10;
			$step['process']=0;
			file_put_contents("".$path."",json_encode($step,true));
			//分页写入sql
			$arr_lang=count($arr);
			$per=ceil($arr_lang/10);
			for($i=0;$i<10;$i++){
				$step['process']=$i;
				file_put_contents("".$path."",json_encode($step,true));
				$add_arr=array_slice($arr,$i*$per,$per,false);
				M('customer')->addAll($add_arr);
			}
				
			$step['step']='success';
			file_put_contents("".$path."",json_encode($step,true));
		
			M('operation_log')->where('id='.$id)->delete();//如果导入成功，删除预备记录
			$content ="共:".$usefull+$useless."条";
			$content ="有效数据:".$usefull."条";
			$content .="无效数据:".$useless."条";
			$content .="重复数据:".$repeat."条";
			$content .="成功导入:".$success."条";
			$content .="文件地址:".$savePath;
			$this->op_log($content);
			
			$list['code'] = 200;
			$list['msg'] = '导入成功';
			$list['count'] =$usefull+$useless;
			$list['usefull'] =$usefull;
			$list['useless'] =$useless;
			$list['repeat']  =$repeat;
			$list['success'] =$success;
			echo json_encode($list, true);
			die;
		}
		
		 /*查看本次导入进度*/
		if($_GET['progress']){
			 $file=I('param.file');
			 $path=explode('.',$file)[0].'.txt';
			 $fp= fopen($path,"r");
			 $json= fread($fp,filesize($path));
			 $result=json_decode($json,true);
			 echo json_encode($result, true);
			 if($json['step']=='success' || $json['step']=='error'){
					unlink($path);
			 }
			 exit();
		}
	}

 
  /*下载模板*/
    public function dw_export()
	{
		if(IS_POST){
			$list['code'] = 200;
			$list['msg'] = '拥有权限';
			echo json_encode($list, true);
			die;
		}else{
			$file=fopen('demo-customer.xlsx',"r");
			header("Content-Type: application/octet-stream");
			header("Accept-Ranges: bytes");
			header("Accept-Length: ".filesize('demo-customer.xlsx'));
			header("Content-Disposition: attachment; filename=客户导入样表.xlsx");
			echo fread($file,filesize('demo-customer.xlsx'));
			fclose($file);
		}
    }
	
	/*分配*/
	public function allot(){
		if(IS_POST){
			//接收人
			$accept_id=I('param.accept_id');		
			$ac_user=M('user')->where('uid='.$accept_id)->find();
			$part=M('part')->where('id='.$ac_user['part_id'])->find();
			$res_id=I('param.id');
			$we['id']=array('in',$res_id);
			$res=M('customer')->where($we)->select();
			foreach($res as $key=>$val){
				/*分配情况*/
				$data['part_id'] = $part['id'];
				$data['part_code'] = $part['code'];
				$data['user_id'] = $accept_id;
				$data['allot_time'] = $this->now_time;
				$data['allot_user_id'] = session('user');
				$data['type'] = 1;
				/*修改商机字段*/
				M('customer')->where('id='.$val['id'])->save($data);
			}
			//workerman提醒
			A('Workerman')->send_msg($accept_id,'客户移交通知', '您获得了'.count($res).'个客户，,赶快去查看吧');
			$list['code'] = 200;
			$list['msg'] = '分配成功';
			echo json_encode($list, true);
			exit;
		}else{
			$id=I('param.id');
			$this->assign('id',$id);
			$this->display();
		}
	}
	
	/*根据ID 分配*/
	public function allot_buy_id(){
		if(IS_POST){
			//接收人
			$accept_id=I('param.accept_id');		
			$ac_user=M('user')->where('uid='.$accept_id)->find();
			$part=M('part')->where('id='.$ac_user['part_id'])->find();
			
			$start = (I('param.start') != '') ? I('param.start') : 0;
			$end= (I('param.end') != '') ? I('param.end') : 0;
			$we['id']=array('between',array($start,$end));
			$res=M('customer')->where($we)->select();
			
			if(count($res)<1){
				$list['code'] = "error";
				$list['msg'] = '请输入有效的ID区间';
				echo json_encode($list, true);
				exit;
			}
			foreach($res as $key=>$val){
				/*分配情况*/
				$data['part_id'] = $part['id'];
				$data['part_code'] = $part['code'];
				$data['user_id'] = $accept_id;
				$data['allot_time'] = $this->now_time;
				$data['allot_user_id'] = session('user');
				$data['type'] = 1;
				/*修改商机字段*/
				M('customer')->where('id='.$val['id'])->save($data);
			}
			//workerman提醒
			A('Workerman')->send_msg($accept_id,'客户移交通知', '您获得了'.count($res).'个客户，,赶快去查看吧');
			$list['code'] = 200;
			$list['msg'] = '分配成功';
			echo json_encode($list, true);
			exit;
		}else{
			$id=I('param.id');
			$this->assign('id',$id);
			$this->display();
		}
	}
	
	//查询关联数据全部
    public function all($data)
    {
        foreach ($data as $ke => $values) {
            if ($this->see_tel == 2) {
                $data[$ke]['phone'] = substr_replace($values['phone'], '****', 3, 4);
            }
			$data[$ke]['tel'] = $values['phone'];
            /*商机所属人*/
            if ($values['user_id']) {
                $user_name = M('user')->where('uid=' . $values['user_id'])->find();
                $data[$ke]['user'] = $user_name['name']."（".$user_name['code']."）";
            }
			$creat_user = M('user')->where('uid=' . $values['creat_user'])->find();
			$data[$ke]['creat_user'] = $creat_user['name']."（".$creat_user['code']."）";
			if ($values['allot_user_id']) {
				$allot_user = M('user')->where('uid=' . $values['allot_user_id'])->find();
				$data[$ke]['allot_user'] = $creat_user['name']."（".$creat_user['code']."）";
			}
            /*部门*/
            if ($values['part_id']) {
                $part = M('part')->where('id=' . $values['part_id'])->find();
                $data[$ke]['part'] = $part['name'];
            }
			/*分类*/
			if($values['type_id']){
				$type = M('custype')->where('id=' . $values['type_id'])->find();
				$data[$ke]['custype'] = $type['name'];
			}
        }
        return $data;
    }

}


