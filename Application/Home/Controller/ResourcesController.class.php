<?php
/*
商机管理
*/

namespace Home\Controller;
class ResourcesController extends BackController
{


    public $page;
    public $num;
    public $where;
    public $see_tel;
    public $now_time;
    public $power;

    public function _initialize()
    {
        parent::_initialize();
        $this->page = (I('get.page') != '') ? I('get.page') - 1 : 0;
        $this->num = (I('get.limit') != '') ? I('get.limit') : 10;
        $this->now_time = date('Y-m-d H:i:s', time());
        //查看当前用户的数据查看权限
        $role = M('group_access')->where('uid=' . session('user'))->getField('group_id');
        $power = M('group_role')->where('id=' . $role)->getField('show_data');
        $this->power = $power;
        if ($power == 'self') {  //只能查看自己的数据
            $param['user_id'] = array('eq', session('user'));
        }
        if ($power == 'part') {//查看部门数据
            $part_id = M('user')->where('uid=' . session('user'))->getField('part_id');
            $my_part_code = M('part')->where('id=' . $part_id)->getField('code');
            $param['part_code'] = array('like', $my_part_code . "%");
        }
        //公共筛选条件
        //类型
        if (I('get.res_type_id')) {
            $param['res_type_id'] = array('eq', I('get.res_type_id'));
        }
        //来源渠道
        if (I('get.origin_id')) {
            $param['origin_id'] = array('eq', I('get.origin_id'));
        }
        //客户号码
        if (I('get.phone')) {
            $param['phone'] = array('like', "%" . I('get.phone') . "%");
        }
        //客户姓名
        if (I('get.name')) {
            $param['name'] = array('like', "%" . I('get.name') . "%");
        }
        //所属部门
        if (I('get.part_id')) {
            $param['part_id'] = array('eq', I('get.part_id'));
        }
        //销售阶段
        if (I('get.stage')) {
            if (I('get.stage') == 5) {
                $param['stage'] = array('eq', 0);//待首电
            } else {
                $param['stage'] = array('eq', I('get.stage'));
            }
        }

        //贷款金额
        if (I('get.dk_money_start')) {
            $param['dk_money'] = array('egt', I('get.dk_money_start'));
        }
        if (I('get.dk_money_end')) {
            $param['dk_money'] = array('elt', I('get.dk_money_end'));
        }

        if (I('get.dk_money_start') && I('get.dk_money_end')) {
            $param['dk_money'] = array('between', [I('get.dk_money_start'), I('get.dk_money_end')]);
        }
        //商机编号
        if (I('get.code')) {
            $param['code'] = array('like', "%" . I('get.code') . "%");
        }

        //创建时间
        if (I('get.creat_time_start')) {
            $s_time = I('get.creat_time_start');
            $e_time = I('get.creat_time_end');
            $param['creat_time'] = array('between', array($s_time, $e_time));
        }

        //申请时间
        if (I('get.apply_time_start')) {
            $s_time = I('get.apply_time_start');
            $e_time = I('get.apply_time_end');
            $param['apply_time'] = array('between', array($s_time, $e_time));
        }

        //审核时间
        if (I('get.check_time_start')) {
            $s_time = I('get.check_time_start');
            $e_time = I('get.check_time_end');
            $param['check_time'] = array('between', array($s_time, $e_time));
        }

        $this->where = $param;
        $power = M('group_role')->where('id=' . $role)->getField('show_tel');
        if ($power == 1) {
            $this->see_tel = 1;
        } else {
            $this->see_tel = 2;
        }

    }

    //跟进中商机
    public function ing()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            $where = $this->where;
            $where['status'] = array('ELT', 2);

            //特殊条件
            if (I('get.ing_type')) {
                $type = I('get.ing_type');
                switch ($type) {
                    case 'not_one':         //未首电
                        $where['status'] = array('eq', 1);
                        break;
                    case 'today_gj':         //今日待跟进
                        $where['left(next_time,10)'] = array('eq', date('Y-m-d', strtotime($this->now_time)));
                        break;
                    case 'over_gj':            //逾期跟进
                        $where['next_time'] = array('lt', $this->now_time);
                        break;
                    case 'today_sm':         //今日预约上门
                        $where['left(next_time,10)'] = array('eq', $this->now_time);
                        $where['next_step'] = array('eq', 4);
                        break;
                    case 'out_worning':            //掉库预警
                        $where['guess_out_time'] = array('lt', date('Y-m-d', time() + 86400));
                        break;
                    default:
                        break;

                }
            }

            //分配时间
            if (I('get.allot_time_start')) {
                $s_time = I('get.allot_time_start');
                $e_time = I('get.allot_time_end');
                $where['allot_time'] = array('between', array($s_time, $e_time));
            }
            //下次跟进时间
            if (I('get.next_time_start')) {
                $s_time = I('get.next_time_start');
                $e_time = I('get.next_time_end');;
                $where['next_time'] = array('between', array($s_time, $e_time));
            }
            //最后跟进时间
            if (I('get.last_time_start')) {
                $s_time = I('get.last_time_start');
                $e_time = I('get.last_time_end');
                $where['last_time'] = array('between', array($s_time, $e_time));
            }


            $data = M('resources')->where($where)->limit($this->num * $this->page, $this->num)->order('id DESC')->select();

            $data = $this->all($data);
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = M('resources')->where($where)->count();
            echo json_encode($list, true);
        }
    }

    //已成单商机
    public function over()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            $where = $this->where;
            $where['status'] = array('eq', 3);
            //特殊条件
            if (I('get.ing_type')) {
                $type = I('get.ing_type');
                switch ($type) {
                    case 'not_one':         //未首电
                        $where['status'] = array('eq', 1);
                        break;
                    case 'today_gj':         //今日待跟进
                        $where['left(next_time,10)'] = array('eq', date('Y-m-d', strtotime($this->now_time)));
                        break;
                    case 'over_gj':            //逾期跟进
                        $where['next_time'] = array('lt', $this->now_time);
                        $where['status'] = array('neq', 1);
                        break;
                    case 'today_sm':         //今日预约上门
                        $where['left(next_time,10)'] = array('eq', date('Y-m-d', strtotime($this->now_time)));
                        $where['next_step'] = array('eq', 4);
                        break;
                    case 'out_worning':            //掉库预警
                        $where['guess_out_time'] = array('lt', date('Y-m-d', time() + 86400));
                        break;
                }
            }

            //分配时间
            if (I('get.allot_time_start')) {
                $s_time = I('get.allot_time_start');
                $e_time = I('get.allot_time_end');
                $where['allot_time'] = array('between', array($s_time, $e_time));
            }
            //下次跟进时间
            if (I('get.next_time_start')) {
                $s_time = I('get.next_time_start');
                $e_time = I('get.next_time_end');;
                $where['next_time'] = array('between', array($s_time, $e_time));
            }
            //最后跟进时间
            if (I('get.last_time_start')) {
                $s_time = I('get.last_time_start');
                $e_time = I('get.last_time_end');
                $where['last_time'] = array('between', array($s_time, $e_time));
            }

            $data = M('resources')->where($where)->limit($this->num * $this->page, $this->num)->order('id DESC')->select();
            $data = $this->all($data);
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = M('resources')->where($where)->count();
            echo json_encode($list, true);
            exit;
        }


    }

    //待审核商机
    public function checking()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            $where = $this->where;
            $where['status'] = array('eq', 4);
            if (I('param.apply_type')) {
                $where['apply_type'] = array('eq', I('param.apply_type'));
            }
            $data = M('resources')->where($where)->limit($this->num * $this->page, $this->num)->order('id DESC')->select();
            $data = $this->all($data);
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = M('resources')->where($where)->count();
            echo json_encode($list, true);
        }

    }

    //审核被拒
    public function checked()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            $where = $this->where;
            $where['status'] = array('eq', 5);
            if (I('param.apply_type')) {
                $where['apply_type'] = array('eq', I('param.apply_type'));
            }
            $data = M('resources')->where($where)->limit($this->num * $this->page, $this->num)->order('id DESC')->select();
            $data = $this->all($data);
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = M('resources')->where($where)->count();
            echo json_encode($list, true);
        }

    }

    //白名单商机
    public function white()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            $where = $this->where;
            $where['status'] = array('eq', 6);
            unset($where['user_id']);  //全公司都能看
            unset($where['part_code']);	 //全公司都能看
            //剔除时间
            if (I('get.white_time_start')) {
                $s_time = I('get.white_time_start');
                $e_time = I('get.white_time_end');
                $where['white_time'] = array('between', array($s_time, $e_time));
            }
            $data = M('resources')->where($where)->limit($this->page * $this->num, $this->num)->order('id DESC')->select();
            $data = $this->all($data);
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = M('resources')->where($where)->count();
            echo json_encode($list, true);
        }
    }

    /**
     * 商机掉库
     */
    public function out()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            $where = $this->where;
            $where['status'] = array('eq', 7);
            //掉库时间
            if (I('get.real_out_time_start')) {
                $s_time = I('get.real_out_time_start');
                $e_time = I('get.real_out_time_end');
                $where['real_out_time'] = array('between', array($s_time, $e_time));
            }
            //掉库类型
            if (I('get.out_type') != '') {
                $where['out_type'] = array('eq', I('get.out_type'));
            }
            // 忽略查看自己数据的条件
            unset($where['user_id']);
            $part_id = M('user')->where('uid=' . session('user'))->getField('part_id');
            $my_part_code = M('part')->where('id=' . $part_id)->getField('code');
            if ($this->power != 'all') {
                if (I('get.out_type') == 0) {    //抢单库,部门可视数据修改为 本部门人员，不含下级部门
                    $where['part_code'] = array('eq', $my_part_code);
                } else {
                    $where['part_code'] = array('like', $my_part_code . "%");
                }
            }
            $data = M('resources')->where($where)->limit($this->page * $this->num, $this->num)->order('id DESC')->select();
            $data = $this->all($data);
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = M('resources')->where($where)->count();
            echo json_encode($list, true);
        }

    }

    //订单列表

    // 订单所属部门问题，下单之后，商机更换了所属人，订单也要被移交吗？ 目前是 不移交，订单有单独的部门ID，部门code，下单人
    public function res_order()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            $where = $this->where;
            if (I('param.order_status') != '') {
                $where['status'] = array('eq', I('param.order_status'));
            }
            $data = M('orders')->where($where)->limit($this->page * $this->num, $this->num)->order('id DESC')->select();
            foreach ($data as $key => $val) {
                //订单所属商机
                $res = M('resources as res')->field('res.code,res.name,res.id')->join('left join gr_res_orders as gr on gr.res_id=res.id')->where('gr.order_id=' . $val['id'])->find();
                $data[$key]['res_code'] = $res['code'];
                $data[$key]['res_name'] = $res['name'];
                $data[$key]['res_id'] = $res['id'];
                //订单状态
                $data[$key]['status'] = $this->order_status($val['status']);
                //下单人
                $creat_user = M('user')->where('uid=' . $val['user_id'])->find();
                //接单人
                $accept_user = M('user')->where('uid=' . $val['accept_user'])->find();
                $data[$key]['creat_user'] = $creat_user['name'] . "（" . $creat_user['code'] . "）";
                $data[$key]['accept_user'] = $accept_user['name'] . "（" . $accept_user['code'] . "）";
                //订单所属部门
                $data[$key]['part'] = M('part')->where('id=' . $val['part_id'])->getField('name');
                //工单
                $demand = M('demand')->where('order_id=' . $val['id'])->order('id DESC')->select();
                foreach ($demand as $k => $v) {
                    $creat_user = M('user')->where('uid=' . $v['creat_user'])->find();
                    $accept_user = M('user')->where('uid=' . $v['accept_user'])->find();
                    $data[$key]['demand'][] = array(
                        'demand_id' => $v['id'],
                        'demand_code' => $v['code'],
                        'demand_status' => $this->demand_status($v['status']),
                        'demand_step' => $this->demand_step($v['step']),
                        'odemand_creat_time' => $v['creat_time'],
                        'odemand_creat_user' => $creat_user['name'] . "（" . $creat_user['code'] . "）",
                        'odemand_accept_user' => $accept_user['name'] . "（" . $accept_user['code'] . "）"
                    );
                }
            }
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = M('orders')->where($where)->count();
            echo json_encode($list, true);
        }
    }

//查询关联数据全部
    public function all($data)
    {
        foreach ($data as $ke => $values) {
            if ($this->see_tel == 2) {
                $data[$ke]['phone'] = substr_replace($values['phone'], '****', 3, 4);
            }
            //1通用字段    资质   商机类型 商机来源 来源渠道      商机所属人	所属部门  最新跟进人	最新跟进时间	最新跟进类型 	最新跟进备注
            /*商机类型*/
            $res_type = M('restype')->field('name')->where('id=' . $values['res_type_id'])->find();
            $data[$ke]['res_type'] = $res_type['name'];


            /*商机资质*/
            $zz = M('gr_res_wealth')->field('wealth_table')->where('res_id=' . $values['id'])->group('wealth_table')->select();
            foreach ($zz as $key => $val) {
                $wx['table'] = array('eq', $val['wealth_table']);
                $wx['status'] = array('eq', 1);
                $zz = M('weal_table')->where($wx)->getField('name');
                $data[$ke]['zz'] .= ' ' . $zz;
            }

            /*商机所属人*/
            if ($values['user_id']) {
                $user_name = M('user')->where('uid=' . $values['user_id'])->find();
                $data[$ke]['user_name'] = $user_name['name'];
                $data[$ke]['user_code'] = $user_name['code'];
            }
            /*部门*/
            if ($values['part_id']) {
                $part = M('part')->where('id=' . $values['part_id'])->find();
                $data[$ke]['part'] = $part['name'];
            }
            /*商机来源*/
            $origin = M('origin')->where('id=' . $values['origin_id'])->find();
            $data[$ke]['origin'] = $origin['name'];

            /*商机类型*/

            /*(最新跟进)*/
            $res_op_log = M('res_op_log')->where(['res_id' => $values['id']])->order('id DESC')->select();//操作记录

            if ($res_op_log) {
                $user = M('user')->where('uid=' . $res_op_log[0]['user_id'])->find(); //操作人
                $data[$ke]['resop_time'] = $res_op_log[0]['creat_time'];
                $data[$ke]['resop_user_name'] = $user['name'];
                $data[$ke]['resop_user_code'] = $user['code'];
                $data[$ke]['resop_type'] = $this->op_log_trans($res_op_log[0]['controler']);
                $data[$ke]['resop_content'] = $res_op_log[0]['content'];
            }
            /*审核  相关*/
            if ($values['status'] == 5 || $values['status'] == 5 || $values['status'] == 4) {
                $apply_user = M('user')->where(['uid' => $values['apply_user']])->find();
                $data[$ke]['apply_user'] = $apply_user['name'] . "（" . $apply_user['code'] . "）";

                $check_user = M('user')->where(['uid' => $values['check_user']])->find();
                $data[$ke]['check_user'] = $check_user['name'] . "（" . $check_user['code'] . "）";

                switch ($data[$ke]['apply_type']) {
                    case 1;
                        $data[$ke]['apply_type'] = "剔除";
                        $data[$ke]['check_url'] = 'tcheck.html';
                        break;
                    case 2;
                        $data[$ke]['apply_type'] = "反无效";
                        $data[$ke]['check_url'] = 'fcheck.html';
                        break;
                }
            } else {
                unset($values['apply_type']);
                unset($values['apply_time']);
                unset($values['apply_user']);
            }

            //跟进中
            /*分配人*/
            if ($values['allot_user_id']) {
                $allot_user = M('user')->where('uid=' . $values['allot_user_id'])->find();
                $data[$ke]['allot_name'] = $allot_user['name'];
                $data[$ke]['allot_code'] = $allot_user['code'];
            }
            /*跟进阶段*/
            $data[$ke]['stage'] = $this->res_step($values['stage']);    //销售阶段
            $data[$ke]['status'] = $this->res_status($values['status']);    //销售阶段
            $data[$ke]['next_step'] = $this->res_next_step($values['next_step']);//下次跟进阶段
            if ($values['status'] == 1) {
                $data[$ke]['stage'] = "待首电";
            }

            //订单 查找商机是否有订单
			$w_order['gr.res_id']=array('eq',$values['id']);
			$power=$this->power;
			if ($power == 'self') {  	//只能查看自己的数据
				$w_order['user_id'] = array('eq', session('user'));
			}
			if ($power == 'part') {		//查看部门数据
				$part_id = M('user')->where('uid=' . session('user'))->getField('part_id');
				$my_part_code = M('part')->where('id=' . $part_id)->getField('code');
				$w_order['part_code'] = array('like', $my_part_code . "%");
			}

            $order = M('orders as o')
				->field('o.id,o.code,o.status,o.creat_time,o.user_id,o.accept_user')
				->join('gr_res_orders as gr on gr.order_id=o.id')
				->where($w_order)
				->order('gr.id DESC')->select();
            foreach ($order as $key => $val) {
                $creat_user = M('user')->where('uid=' . $val['user_id'])->find();
                $accept_user = M('user')->where('uid=' . $val['accept_user'])->find();
                $data[$ke]['orders'][] = array(
                    'order_code' => $val['code'],
                    'order_id' => $val['id'],
                    'order_status' => $this->order_status($val['status']),
                    'order_creat_time' => $val['creat_time'],
                    'order_creat_user' => $creat_user['name'] . "（" . $creat_user['code'] . "）",
                    'order_accept_user' => $accept_user['name'] . "（" . $accept_user['code'] . "）"
                );
            }

            //掉库类型
            if ($values['status'] == 7) {
                $data[$ke]['out_type'] = $this->out_type($values['out_type']);
            }

        }
        return $data;
    }

    /*
     * 剔除审核->进入白名单
    */
    public function tcheck()
    {
        $id = I('post.id');
        $data['check_user'] = session('user');
        $data['check_remark'] = I('post.check_remark');
        $data['check_time'] = $this->now_time;
        $res = M('resources')->where(['id' => $id])->find();
        $apply_user = M('user')->where(['uid' => $res['apply_user']])->find();//申请人

        if (I('post.status') == 1) {
            $data['status'] = 6;    //白名单
            $data['user_id'] = 0;
            $data['allot_user_id'] = 0;
            $data['white_time'] = $this->now_time;
            $data['guess_out_time'] = null;
            $list['msg'] = '已同意';
            $user_msg['content'] = "你申请的剔除已经通过审核。商机编号{$res['code']}";
        } else {
            $data['status'] = 5;
            $list['msg'] = '已拒绝';
            $user_msg['content'] = "你申请的剔除审核已经拒绝。商机编号{$res['code']}";
        }
        $user_msg['title'] = "剔除审核通知";
        M('resources')->where(['id' => $id])->save($data);
        $this->res_op_log($id, $list['msg'] . ":" . $data['check_remark']);
        A('Workerman')->send_msg($apply_user['uid'], $user_msg['title'], $user_msg['content']);
        $list['code'] = 200;
        echo json_encode($list, true);
        die();
    }

    /**
     * 反无效 ->掉库
     */
    public function fcheck()
    {
        $id = I('post.id');
        $data['check_user'] = session('user');
        $data['check_remark'] = I('post.check_remark');
        $data['check_time'] = $this->now_time;
        $res = M('resources')->where(['id' => $id])->find();
        $apply_user = M('user')->where(['uid' => $res['apply_user']])->find();//申请人
        if (I('post.status') == 1) {
            $data['status'] = 7;
            $data['out_type'] = 3;// 反无效掉库
            $data['user_id'] = 0;
            $data['allot_user_id'] = 0;
            $data['real_out_time'] = $data['check_time'];
            $data['guess_out_time'] = null;
            $list['msg'] = '已同意';
            $user_msg['content'] = "你申请的反无效已经通过审核。商机编号{$res['code']}";
            //掉库记录
            $log['part_id'] = $res['part_id'];
            $log['part_code'] = $res['part_code'];
            $log['user_id'] = $res['user_id'];
            $log['res_id'] = $res['res_id'];
            $log['type'] = $data['out_type'];
            $log['creat_time'] = $data['check_time'];
            M('res_dk_log')->add($log);

        } else {
            $data['status'] = 5;
            $list['msg'] = '已拒绝';
            $user_msg['content'] = "你申请的反无效审核已经拒绝。商机编号{$res['code']}";
        }
        M('resources')->where(['id' => $id])->save($data);
        $user_msg['title'] = "反无效申请通知";
        $this->res_op_log($id, $list['msg'] . ":" . $data['check_remark']);
        A('Workerman')->send_msg($apply_user['uid'], $user_msg['title'], $user_msg['content']);
        $list['code'] = 200;
        echo json_encode($list, true);
        die();
    }

    /**
     * 剔除
     */
    public function tichu_res()
    {
        $id = I('post.id');
        $data['status'] = 4;
        $data['apply_type'] = 1;
        $data['apply_remark'] = I('param.remark');
        $data['apply_time'] = $this->now_time;
        $data['apply_user'] = session('user');
        M('resources')->where(['id' => $id])->save($data);
        $content = I('param.remark');
        $this->res_op_log($id, $content);
        $list['code'] = 200;
        $list['msg'] = '申请成功';
        echo json_encode($list, true);
        die();
    }

    /**
     * 反无效
     */
    public function fan_res()
    {
        $id = I('post.id');
        $res = M('resources')->where(['id' => $id])->find();
        if ($res['status'] != 2) {
            $list['code'] = 'error';
            $list['msg'] = '首电之后才能反无效';
            echo json_encode($list, true);
            exit;
        }
        $data['status'] = 4;
        $data['apply_type'] = 2;
        $data['apply_remark'] = I('param.remark');
        $data['apply_time'] = $this->now_time;
        $data['apply_user'] = session('user');
        M('resources')->where(['id' => $id])->save($data);
        $content = I('param.remark');
        $this->res_op_log($id, $content);
        $list['code'] = 200;
        $list['msg'] = '申请成功';
        echo json_encode($list, true);
        die();
    }

    //下单
    public function xd()
    {
        if (IS_POST) {
            $wh['contract'] = I('param.contract');
            $contract = M('orders')->where($wh)->find();
            if ($contract) {
                $list['code'] = 'error';
                $list['msg'] = '合同编号重复';
                echo json_encode($list, true);
                die;
            }
			$creat_user = M('user')->where('uid=' . session('user'))->find();
			if(!$creat_user['part_id']){
				$list['code'] = 'error';
                $list['msg'] = '此账号没有部门，无法操作';
                echo json_encode($list, true);
                die;
			}
            if ($_FILES['img']['name']) {
                $end_file = strrchr($_FILES['img']['name'], '.');
                $files = mt_rand(0, 99) . $end_file;
                $path = 'uploader/upload/contract/' . date('YmdHis') . '/';
                if (!file_exists($path)) {
                    mkdir($path, 777);
                }
                chmod($path, 0777);
                $path = $path . date('YmdHis') . '_' . $files;
                $resoult = move_uploaded_file($_FILES['img']['tmp_name'], $path);
                if ($resoult) {
                    $data['contract_img'] = $path;
                } else {
                    echo json_encode(["code" => "ERROR", "msg" => "图片上传失败"], true);
                    exit;
                }
            } else {
                echo json_encode(["code" => "ERROR", "msg" => "请上传合同截图"], true);
                exit;

            }
            //数据写入


            $data['code'] = 'DD' . date('Ymd', $_SERVER['REQUEST_TIME']) . str_pad(mt_rand(0, 999), 3, "0", STR_PAD_LEFT) . session('uid');
            $data['status'] = I('param.status');                //  0 草稿  1 直接提交订单
            if (I('param.status')) {
                $content == '下单';
                $data['apply_time'] = $this->now_time;
            } else {
                $content == '保存草稿';
            }
            $data['contract'] = I('param.contract');        //合同编号
            $data['dk_money'] = I('param.dk_money');        //贷款金额（万 2位小数）
            $data['dk_time'] = I('param.dk_time');            //贷款时长 （整数）
            $data['dk_time_type'] = I('param.dk_time_type');//时间类型 （年 月 天）
            $data['dk_ratio'] = I('param.dk_ratio');        //利率  （% 2位小数）
            $data['dk_ratio_type'] = I('param.dk_ratio_type');//利率计算方式  （ 日息 月息 年息）
            $data['ding_money'] = I('param.ding_money');    //定金  （元 2位小数）
            $data['fuwu_money'] = I('param.fuwu_money');    //服务费（ % 2位小数 22.25%）

            $creat_user = M('user')->where('uid=' . session('user'))->find();
            $creat_part = M('part')->where('id=' . $creat_user['part_id'])->find();
            $data['user_id'] = session('user');
            $data['part_code'] = $creat_part['code'];
            $data['part_id'] = $creat_part['id'];

            $accept_user = M('user')->where('uid=' . I('param.accept_user'))->find();
            $accept_part = M('part')->where('id=' . $accept_user['part_id'])->find();
            $data['accept_user'] = I('param.accept_user');  //接单人
            $data['accept_part_id'] = $accept_part['id'];
            $data['accept_part_code'] = $accept_part['code'];

            $order_id = M('orders')->add($data);
            // 通知接单人
            $msg_content = "您收到了一个新订单，快去处理吧！";
            A('Workerman')->send_msg(I('param.accept_id'), '订单下单通知', $msg_content);

            //订单绑定商机
            $group['res_id'] = I('param.res_id');
            $group['order_id'] = $order_id;
            $group_id = M('gr_res_orders')->add($group);

            //主借人---次借贷人--入库
            for ($i = 0; $i < count($_POST['name']); $i++) {
                $res['name'] = $_POST['name'][$i];                    //姓名
                $res['id_number'] = $_POST['id_number'][$i];        //身份证
                $res['tel'] = $_POST['tel'][$i];                    //电话
                $res['marriage'] = $_POST['marriage'][$i];            //婚姻状况				中文输入
                $res['child'] = $_POST['child'][$i];                //子女数量				数字输入
                $res['family'] = $_POST['family'][$i];                //家属是否知晓			知晓 不知晓
                $res['ships'] = $_POST['ships'][$i];                //与借贷人关系			中文输入
                $res['type'] = $_POST['type'][$i];                    //是否为主借贷人		1 主借贷人 2次借贷人
                $res['is_self'] = $_POST['is_self'][$i];            //是否客户本人			是  否
                $res['order_id'] = $order_id;

                foreach ($res as $key => $val) {
                    if (!$val && $val != 0) {
                        M('gr_res_orders')->where('id=' . $group_id)->delete();
                        M('orders')->where('id=' . $order_id)->delete();
                        echo json_encode(["code" => "ERROR", "msg" => "借贷人信息不全"], true);
                        exit;
                    }
                }
                $borrow[] = $res;
            }

            $this->res_op_log(I('param.res_id'), $content);
            M('borrow')->addAll($borrow);
            $list['code'] = 200;
            $list['msg'] = "下单成功";
            echo json_encode($list, true);
            exit;
        } else {
            $res = M('resources')->where('id=' . I('param.id'))->find();
            $where['phone'] = array('eq', $res['phone']);
            $cus = M('customer')->where($where)->find();
            if ($cus['sex'] == 1) {
                $cus['sex'] = '男';
            }
            if ($cus['sex'] == 2) {
                $cus['sex'] = '女';
            }
            if (!$cus['sex']) {
                $cus['sex'] = '未知';
            }
            $cus['marriage'] = $this->cus_marry($cus['marriage']);
            $cus['education'] = $this->cus_educate($cus['education']);
            $res['origin'] = M('origin')->where('id=' . $res['origin_id'])->getField('name');
            $res['res_type'] = M('restype')->field('name')->where('id=' . $res['res_type_id'])->getField('name');
            $user = M('user')->where('uid=' . $res['user_id'])->find();
            $part = M('part')->where('id=' . $res['part_id'])->find();
            $res['user_name'] = $user['name'];
            $res['user_code'] = $user['code'];
            $res['part_name'] = $part['name'];
            $creat = M('user')->where('uid=' . $res['creat_user'])->find();
            if ($creat) {
                $res['creat_user'] = $creat['name'] . '（' . $creat['code'] . '）';
            }

            if (!$res['guess_out_time']) {
                $res['guess_out_time'] = '暂无';
            }

            $where['phone'] = array('eq', $res['phone']);
            $cus = M('customer')->where($where)->find();
            if ($cus['sex'] == 1) {
                $cus['sex'] = '男';
            }
            if ($cus['sex'] == 2) {
                $cus['sex'] = '女';
            }
            if (!$cus['sex']) {
                $cus['sex'] = '未知';
            }
            $cus['marriage'] = $this->cus_marry($cus['marriage']);
            $cus['education'] = $this->cus_educate($cus['education']);

            if ($this->see_tel == 2) {
                $res['tel'] = substr_replace($res['phone'], '****', 3, 4);
            }

            $res['stage'] = $this->res_step($res['stage']);    //销售阶段
            $res['status'] = $this->res_status($res['status']);    //销售阶段
            $res['next_step'] = $this->res_next_step($res['next_step']);//下次跟进阶段

            $this->assign('res', $res);
            $this->assign('cus', $cus);
            $this->display();
        }

    }


    //修改草稿
    public function edit_order()
    {
        if (IS_POST) {
            $wh['contract'] = I('param.contract');
            $contract = M('orders')->where($wh)->find();
            if ($contract && $contract['id'] != I('param.id')) {
                $list['code'] = 'error';
                $list['msg'] = '合同编号重复';
                echo json_encode($list, true);
                die;
            }

            if ($_FILES['img']['name']) {
                $end_file = strrchr($_FILES['img']['name'], '.');
                $files = mt_rand(0, 99) . $end_file;
                $path = 'uploader/upload/contract/' . date('YmdHis') . '/';
                if (!file_exists($path)) {
                    mkdir($path, 777);
                }
                chmod($path, 0777);
                $path = $path . date('YmdHis') . '_' . $files;
                $resoult = move_uploaded_file($_FILES['img']['tmp_name'], $path);
                if ($resoult) {
                    $data['contract_img'] = $path;
                } else {
                    echo json_encode(["code" => "ERROR", "msg" => "图片上传失败"], true);
                    exit;
                }
            }
            //数据写入
            $data['status'] = I('param.status');                //  0 草稿  1 直接提交订单
            if (I('param.status')) {
                $data['apply_time'] = $this->now_time;
                $content = '修改草稿并下单';
				   // 通知接单人
				$msg_content = "您收到了一个新订单，快去处理吧！";
				A('Workerman')->send_msg(I('param.accept_id'), '订单下单通知', $msg_content);

            } else {
                $content = '修改草稿';
            }

            $data['contract'] = I('param.contract');        //合同编号
            $data['dk_money'] = I('param.dk_money');        //贷款金额（万 2位小数）
            $data['dk_time'] = I('param.dk_time');            //贷款时长 （整数）
            $data['dk_time_type'] = I('param.dk_time_type');//时间类型 （年 月 天）
            $data['dk_ratio'] = I('param.dk_ratio');        //利率  （% 2位小数）
            $data['dk_ratio_type'] = I('param.dk_ratio_type');//利率计算方式  （ 日息 月息 年息）
            $data['ding_money'] = I('param.ding_money');    //定金  （元 2位小数）
            $data['fuwu_money'] = I('param.fuwu_money');    //服务费（ % 2位小数 22.25%）

            $creat_user = M('user')->where('uid=' . session('user'))->find();
            $creat_part = M('part')->where('id=' . $creat_user['part_id'])->find();
            $data['user_id'] = session('user');
            $data['part_code'] = $creat_part['code'];
            $data['part_id'] = $creat_part['id'];

            $accept_user = M('user')->where('uid=' . I('param.accept_user'))->find();
            $accept_part = M('part')->where('id=' . $accept_user['part_id'])->find();
            $data['accept_user'] = I('param.accept_user');  //接单人
            $data['accept_part_id'] = $accept_part['id'];
            $data['accept_part_code'] = $accept_part['code'];

            M('orders')->where('id=' . I('param.id'))->save($data);



            //主借人---次借贷人--入库
            for ($i = 0; $i < count($_POST['name']); $i++) {
                $res['name'] = $_POST['name'][$i];                    //姓名
                $res['id_number'] = $_POST['id_number'][$i];        //身份证
                $res['tel'] = $_POST['tel'][$i];                    //电话
                $res['marriage'] = $_POST['marriage'][$i];            //婚姻状况				中文输入
                $res['child'] = $_POST['child'][$i];                //子女数量				数字输入
                $res['family'] = $_POST['family'][$i];                //家属是否知晓			知晓 不知晓
                $res['ships'] = $_POST['ships'][$i];                //与借贷人关系			中文输入
                $res['type'] = $_POST['type'][$i];                    //是否为主借贷人		1 主借贷人 2次借贷人
                $res['is_self'] = $_POST['is_self'][$i];            //是否客户本人			是  否
                $res['order_id'] = $order_id;

                foreach ($res as $key => $val) {
                    if (!$val && $val != 0) {
                        echo json_encode(["code" => "ERROR", "msg" => "借贷人信息不全"], true);
                        exit;
                    }
                }
                $borrow[] = $res;
            }
            M('borrow')->where('order_id=' . I('param.id'))->delete();
            M('borrow')->addAll($borrow);

            $res_id = M('gr_res_orders')->where('order_id=' . I('param.id'))->getField('res_id');
            $this->res_op_log($res_id, $content);
            $list['code'] = 200;
            $list['msg'] = "操作成功";
            echo json_encode($list, true);
            exit;
        } else {
            $order = M('orders')->where('id=' . I('param.id'))->find();
            $order['accept_name'] = M('user')->where('uid=' . $order['accept_user'])->getField('name');

            $this->assign('order', $order);
            $w['order_id'] = array('eq', I('param.id'));
            $w['type'] = array('eq', 1);
            $borrowa = M('borrow')->where($w)->find();

            $this->assign('borrowa', $borrowa);
            $w['type'] = array('eq', 2);
            $borrow = M('borrow')->where($w)->select();
            $this->assign('borrow', $borrow);


            $res_id = M('gr_res_orders')->where('order_id=' . I('param.id'))->getField('res_id');
            $res = M('resources')->where('id=' . $res_id)->find();
            $where['phone'] = array('eq', $res['phone']);
            $cus = M('customer')->where($where)->find();
            if ($cus['sex'] == 1) {
                $cus['sex'] = '男';
            }
            if ($cus['sex'] == 2) {
                $cus['sex'] = '女';
            }
            if (!$cus['sex']) {
                $cus['sex'] = '未知';
            }
            $cus['marriage'] = $this->cus_marry($cus['marriage']);
            $cus['education'] = $this->cus_educate($cus['education']);
            $res['origin'] = M('origin')->where('id=' . $res['origin_id'])->getField('name');
            $res['res_type'] = M('restype')->field('name')->where('id=' . $res['res_type_id'])->getField('name');
            $user = M('user')->where('uid=' . $res['user_id'])->find();
            $part = M('part')->where('id=' . $res['part_id'])->find();
            $res['user_name'] = $user['name'];
            $res['user_code'] = $user['code'];
            $res['part_name'] = $part['name'];
            $creat = M('user')->where('uid=' . $res['creat_user'])->find();
            if ($creat) {
                $res['creat_user'] = $creat['name'] . '（' . $creat['code'] . '）';
            }

            if (!$res['guess_out_time']) {
                $res['guess_out_time'] = '暂无';
            }

            $where['phone'] = array('eq', $res['phone']);
            $cus = M('customer')->where($where)->find();
            if ($cus['sex'] == 1) {
                $cus['sex'] = '男';
            }
            if ($cus['sex'] == 2) {
                $cus['sex'] = '女';
            }
            if (!$cus['sex']) {
                $cus['sex'] = '未知';
            }
            $cus['marriage'] = $this->cus_marry($cus['marriage']);
            $cus['education'] = $this->cus_educate($cus['education']);

            if ($this->see_tel == 2) {
                $res['tel'] = substr_replace($res['phone'], '****', 3, 4);
            }

            $res['stage'] = $this->res_step($res['stage']);    //销售阶段
            $res['status'] = $this->res_status($res['status']);
            $res['next_step'] = $this->res_next_step($res['next_step']);//下次跟进阶段

            $this->assign('res', $res);
            $this->assign('cus', $cus);
            $this->display();
        }
    }

    //草稿删除
    public function cg_delete()
    {
        $order = M('orders')->where('id=' . I('param.id'))->find();
        if ($order['status'] != 0 && $order['status'] != 2) {
            $list['code'] = "error";
            $list['msg'] = "不能删除";
            echo json_encode($list, true);
            exit;
        }

        M('orders')->where('id=' . I('param.id'))->delete();
        $res_id = M('gr_res_orders')->where('order_id=' . I('param.id'))->getField('res_id');
        M('gr_res_orders')->where('order_id=' . I('param.id'))->delete();
        M('borrow')->where('order_id=' . I('param.id'))->delete();
        $this->res_op_log($res_id, '删除草稿');
        $list['code'] = 200;
        $list['msg'] = "删除成功";
        echo json_encode($list, true);
        exit;
    }

    //草稿下单
    public function cg_xd()
    {
        $order = M('orders')->where('id=' . I('param.id'))->find();
        if ($order['status'] != 0 && $order['status'] != 2) {
            $list['code'] = "error";
            $list['msg'] = "不能下单";
            echo json_encode($list, true);
            exit;
        }
        $data['status'] = 1;
        $data['apply_time'] = $this->now_time;
        M('orders')->where('id=' . I('param.id'))->save($data);
        $res_id = M('gr_res_orders')->where('order_id=' . I('param.id'))->getField('res_id');
        $this->res_op_log($res_id, '草稿下单');
        $list['code'] = 200;
        $list['msg'] = "下单成功";
        echo json_encode($list, true);
        exit;
    }


    //退单申请
    public function tui()
    {
        $order = M('orders')->where('id=' . I('param.id'))->find();
        if ($order['status'] != 1) {
            $list['code'] = "error";
            $list['msg'] = "无法退单";
            echo json_encode($list, true);
            exit;
        }
        $res_id = M('gr_res_orders')->where('order_id=' . I('param.id'))->getField('res_id');
        $data['status'] = 6;
        $data['apply_time'] = $this->now_time;
        $data['apply_remark'] = I('param.apply_remark');
        M('orders')->where('id=' . I('param.id'))->save($data);
        $this->res_op_log($res_id, I('param.apply_remark'));
        $list['code'] = 200;
        $list['msg'] = "提交成功";
        echo json_encode($list, true);
        exit;
    }


    //创建商机
    public function add()
    {
        if (IS_POST) {
            $tel = I('param.phone');
            $where['phone'] = array('eq', $tel);
            $resources = M('resources')->where($where)->select();
            if ($resources) {
                $list['code'] = "Error";
                $list['msg'] = '商机已存在';
                echo json_encode($list, true);
                die;
            }
			if(!$creat_user['part_id']){
				$list['code'] = 'error';
                $list['msg'] = '此账号没有部门，无法操作';
                echo json_encode($list, true);
                die;
			}
            $customer = M('customer')->where($where)->find();
            $data = $_POST;
            if (!$customer) {
                $data['code'] = 'KH' . date('Ymd', $_SERVER['REQUEST_TIME']) . str_pad(mt_rand(0, 999), 3, "0", STR_PAD_LEFT) . session('user');
                M('customer')->add($data);
            } else {
				$display=$data;
                $display['type'] = 3;
                M('customer')->where($where)->save($display);
                $data['name'] = $customer['name'];
            }
            $data['code'] = 'SJ' . date('Ymd', $_SERVER['REQUEST_TIME']) . str_pad(mt_rand(0, 999), 3, "0", STR_PAD_LEFT) . session('user');
            $user = M('user')->where(['uid' => session('user')])->find();
            $part = M('part')->where('id=' . $user['part_id'])->find();
            $data['part_id'] = $part['id'];
            $data['part_code'] = $part['code'];
            $data['user_id'] = $user['uid'];
            $data['creat_user'] = session('user');
            $id = M('resources')->add($data);


            //添加资质
            if ($_POST['weal_table']) {
                for ($i = 0; $i < count($_POST['weal_table']); $i++) {
                    $wh['table'] = array('eq', $_POST['weal_table'][$i]);
                    $fields = M('weal_field')->where($wh)->order('id ASC')->select();
                    $fiel_lenth = count($_POST[$_POST['weal_table'][$i] . '_' . $fields[0]['field']]);    //获取提交字段数组长度  1 某一类资质只添加了一个，2如果是添加的车，就是两个车
                    for ($j = 0; $j < $fiel_lenth; $j++) {
                        $file_arr = array();
                        foreach ($fields as $key => $val) {
                            $file_arr[$val['field']] = $_POST[$_POST['weal_table'][$i] . '_' . $val['field']][$j];
                        }
                        $wealth_id = M($_POST['weal_table'][$i])->add($file_arr);
                        if ($wealth_id) {
                            $g['res_id'] = $id;
                            $g['wealth_id'] = $wealth_id;
                            $g['wealth_table'] = $_POST['weal_table'][$i];
                            $group[] = $g;
                        }
                    }
                }
                //写入商机资质 关联表
                M('gr_res_wealth')->addAll($group);
            }

            $type = '创建商机';
            $this->res_op_log($id, $content);
            $list['code'] = 200;
            $list['msg'] = '添加成功';
            echo json_encode($list, true);
            die();
        } else {
            $tel = I('param.tel');
            $where['phone'] = array('eq', $tel);
            $customer = M('customer')->where($where)->find();
            if ($customer) {
				if($customer['part_id']){
					$part_n=M('part')->where('id='.$customer['part_id'])->getField('name');
				}
				if($customer['user_id']){
					$user_n=M('user')->where('uid='.$customer['user_id'])->getField('name');
				}
				$customer['user']=$part_n."——".$user_n;
                if ($customer['sex'] == 1) {
                    $customer['sex'] = '男';
                }
                if ($customer['sex'] == 2) {
                    $customer['sex'] = '女';
                }
                if (!$customer['sex']) {
                    $customer['sex'] = '未知';
                }
            }
            $res = M('resources')->where($where)->find();
            if ($res) {
                $res['origin'] = M('origin')->where('id=' . $res['origin_id'])->getField('name');
                $res['res_type'] = M('restype')->field('name')->where('id=' . $res['res_type_id'])->getField('name');
                $user = M('user')->where('uid=' . $res['user_id'])->find();
                $part = M('part')->where('id=' . $res['part_id'])->find();
                $res['user_name'] = $user['name'];
                $res['user_code'] = $user['code'];
                $res['part_name'] = $part['name'];
                $res['stage'] = $this->res_step($res['stage']);    //销售阶段
                $res['status'] = $this->res_status($res['status']);    //销售阶段
            }
            $this->assign('cus', $customer);
            $this->assign('res', $res);
            //需要填写的资质
            $tables = M('weal_table')->where('status=1')->select();
            foreach ($tables as $key => $val) {
                $where['table'] = array('eq', $val['table']);
                $tables[$key]['fields'] = M('weal_field')->where($where)->order('id ASC')->select();
            }
            $this->assign('tables', $tables);
            unset($where);
            $where['type'] = array('eq', 1);
            $where['status'] = array('eq', 1);
            $label = M('label')->where($where)->select();
            $this->assign('label', $label);

            $this->display();
        }
    }


    //分配/移交
    public function allot()
    {
        if (IS_POST) {
            //接收人
            $accept_id = I('param.accept_id');
            $ac_user = M('user')->where('uid=' . $accept_id)->find();
            $part = M('part')->where('id=' . $ac_user['part_id'])->find();
            /*商机*/
            $res_id = I('param.id');
            $we['id'] = array('in', $res_id);
            $res = M('resources')->where($we)->select();
            /*首电时间*/
            $first_time = M('config_change')->where('id=1')->find()['first_time'];
            foreach ($res as $key => $val) {
                /*原所属人*/
                $re_user = M('user')->where('uid=' . $val['user_id'])->find();
                /*分配情况*/
                $data['part_id'] = $part['id'];
                $data['part_code'] = $part['code'];
                $data['user_id'] = $accept_id;
                $data['allot_time'] = $this->now_time;
                $data['allot_user_id'] = session('user');
                $data['status'] = 1;
                $data['stage'] = 0;
                /*计算掉库时间*/
                $data['guess_out_time'] = date('Y-m-d H:i:s', time() + 60 * $first_time);

                /*修改商机字段*/
                M('resources')->where('id=' . $val['id'])->save($data);
				/*修改客户字段*/
				$w_c['phone']=array('eq',$val['phone']);
				$c['part_id']=$data['part_id'];
				$c['part_code']=$data['part_code'];
				$c['user_id']=$data['user_id'];
                M('customer')->where($w_c)->save($c);

                /*操作日志*/
                $content = "原所属人：" . $re_user['name'] . "（" . $re_user['code'] . "）;" . "现所属人：" . $ac_user['name'] . "（" . $ac_user['code'] . "）;";
                $this->res_op_log($res_id, $content);

            }

            //workerman提醒
            A('Workerman')->send_msg($accept_id, '商机移交通知', '您获得了' . count($res) . '个新商机,赶快去查看吧');
            $list['code'] = 200;
            $list['msg'] = '移交成功';
            echo json_encode($list, true);
            exit;
        } else {
            $id = I('param.id');
            $this->assign('id', $id);
            $this->display();
        }
    }


    //分配到部门
    public function allot_part()
    {
        if (IS_POST) {
            //接收部门
            $part_id = I('param.part_id');
            $part = M('part')->where('id=' . $part_id)->find();
            //判断 部门是否开启抢单，开启了，就分到抢单库。没有 就直接给部门主管
            if ($part['rush'] == 1) {
                $param['user_id'] = 0;
                $param['guess_out_time'] = null;
                $param['out_type'] = 0;
                $param['status'] = 7;
            } else {//就直接给部门主管
                $first_time = M('config_change')->where('id=1')->find()['first_time'];
                $param['user_id'] = $part['leader_id'];
                $param['guess_out_time'] = date('Y-m-d H:i:s', time() + 60 * $first_time);
                $param['status'] = 1;

            }
            $param['part_id'] = $part_id;
            $param['part_code'] = $part['code'];
            $param['allot_time'] = $this->now_time;

            /*商机*/
            $res_id = I('param.id');
            $we['id'] = array('in', $res_id);
            $res = M('resources')->where($we)->select();
            /*首电时间*/

            foreach ($res as $key => $val) {
                /*修改商机字段*/
                $data = $param;
                M('resources')->where('id=' . $val['id'])->save($data);
				/*修改客户字段*/
				$w_c['phone']=array('eq',$val['phone']);
				$c['part_id']=$data['part_id'];
				$c['part_code']=$data['part_code'];
				$c['user_id']=$data['user_id'];
                M('customer')->where($w_c)->save($c);
				
                /*操作日志*/
                $content = "分配到部门：" . $part['name'] . "（" . $part['code'] . "）;";
                $this->res_op_log($res_id, $content);
            }

            //workerman提醒
            A('Workerman')->send_msg($part['leader_id'], '商机分配通知', '您的部门获得了' . count($res) . '个新商机,赶快去查看吧');
            $list['code'] = 200;
            $list['msg'] = '分配成功';
            echo json_encode($list, true);
            exit;
        } else {
            $id = I('param.id');
            $this->assign('id', $id);
            $this->display();
        }
    }

    //抢单
    public function qiang()
    {
        //接收人
        $accept_id = session('user');
        $ac_user = M('user')->where('uid=' . $accept_id)->find();
        $part = M('part')->where('id=' . $ac_user['part_id'])->find();

        /*商机*/
        $res_id = I('param.id');
        $we['id'] = array('in', $res_id);
        $res = M('resources')->where($we)->select();
        /*首电时间*/
        $first_time = M('config_change')->where('id=1')->find()['first_time'];
        foreach ($res as $key => $val) {
			if($val['status']!=7){
				$list['code'] = "error";
				$list['msg'] = '下手慢了哟';
				echo json_encode($list, true);
				die();
			}
            /*分配情况*/
            $data['part_id'] = $part['id'];
            $data['part_code'] = $part['code'];
            $data['user_id'] = $accept_id;
            $data['allot_time'] = $this->now_time;
            $data['allot_user_id'] = 0;//session('user');
            $data['status'] = 1;    //修改为待首电

            /*计算掉库时间*/
            $data['guess_out_time'] = date('Y-m-d H:i:s', time() + 60 * $first_time);

            /*修改商机字段*/
            M('resources')->where('id=' . $val['id'])->save($data);
			/*修改客户字段*/
			$w_c['phone']=array('eq',$val['phone']);
			$c['part_id']=$data['part_id'];
			$c['part_code']=$data['part_code'];
			$c['user_id']=$data['user_id'];
			M('customer')->where($w_c)->save($c);
            /*操作日志*/
            $content = "抢单;";
            $this->res_op_log($res_id, $content);

        }
        $list['code'] = 200;
        $list['msg'] = '抢单成功,请及时跟进';
        echo json_encode($list, true);
        die();
    }

    //拾回
    public function re_get()
    {
        //接收人
        $accept_id = session('user');
        $ac_user = M('user')->where('uid=' . $accept_id)->find();
        $part = M('part')->where('id=' . $ac_user['part_id'])->find();

        /*商机*/
        $res_id = I('param.id');
        $we['id'] = array('in', $res_id);
        $res = M('resources')->where($we)->select();
        /*首电时间*/
        $first_time = M('config_change')->where('id=1')->find()['first_time'];
        foreach ($res as $key => $val) {
			if($val['status']!=5 && $val['status']!=6){
				$list['code'] = "error";
				$list['msg'] = '下手慢了哟';
				echo json_encode($list, true);
				die();
			}
            /*分配情况*/
            $data['part_id'] = $part['id'];
            $data['part_code'] = $part['code'];
            $data['user_id'] = $accept_id;
            $data['allot_time'] = $this->now_time;
            $data['allot_user_id'] = 0;//session('user');
            $data['status'] = 1;    //修改为待首电
            /*计算掉库时间*/
            $data['guess_out_time'] = date('Y-m-d H:i:s', time() + 60 * $first_time);

            /*修改商机字段*/
            M('resources')->where('id=' . $val['id'])->save($data);
			/*修改客户字段*/
			$w_c['phone']=array('eq',$val['phone']);
			$c['part_id']=$data['part_id'];
			$c['part_code']=$data['part_code'];
			$c['user_id']=$data['user_id'];
			M('customer')->where($w_c)->save($c);
            /*操作日志*/
            $content = "拾回;";
            $this->res_op_log($res_id, $content);

        }
        $list['code'] = 200;
        $list['msg'] = '拾回成功,请及时跟进';
        echo json_encode($list, true);
        die();
    }

    public function details()
    {
        $id = I('param.id');

        if (I('param.op_log')) {
            //操作记录
            $wl['lg.res_id'] = array('eq', $id);
            //操作类型
            if (I('param.controler')) {
                $wl['lg.controler'] = array('eq', I('param.controler'));
            }
            //操作时间
            if (I('get.time_start')) {
                $s_time = I('get.time_start');
                $e_time = I('get.time_end');
                $wl['lg.creat_time'] = array('between', array($s_time, $e_time));
            }

            $data = M('res_op_log as lg')
                ->field('lg.*,u.name,u.code')
                ->join('user as u on u.uid=lg.user_id')
                ->where($wl)
                ->order('id DESC')
                ->limit($this->num * $this->page, $this->num)
                ->select();
            foreach ($data as $key => $val) {
                $data[$key]['controler'] = $this->op_log_trans($val['controler']);
            }
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = M('res_op_log as lg')->join('user as u on u.uid=lg.user_id')->where($wl)->count();
            echo json_encode($list, true);
            exit;
        }

        //联系人
        if (I('param.contacts')) {
            $where['rc.res_id'] = array('eq', $id);
            $data = M('contacts as c')
                ->field('c.*,rc.id as gid')
                ->join('left join gr_res_contacts as rc on rc.contact_id=c.id')
                ->where($where)
                ->order('rc.id DESC')
                ->limit($this->num * $this->page, $this->num)
                ->select();
            foreach ($data as $key => $val) {
                switch ($val['type']) {
                    case 1:
                        $data[$key]['type'] = '配偶';
                        break;
                    case 2:
                        $data[$key]['type'] = '直系亲属';
                        break;
                    case 3:
                        $data[$key]['type'] = '本人';
                        break;
                    default:
                        $data[$key]['type'] = '其他';
                        break;
                }
            }
            $list['code'] = 200;
            $list['msg'] = '';
            $list['count'] = M('contacts as c')->join('left join gr_res_contacts as rc on rc.contact_id=c.id')->where($where)->count();
            $list['data'] = $data;
            echo json_encode($list, true);
            exit;
        }

        if (I('param.index')) {
            //基础信息
            $res = M('resources')->where('id=' . $id)->find();
            $res['origin'] = M('origin')->where('id=' . $res['origin_id'])->getField('name');
            $res['res_type'] = M('restype')->field('name')->where('id=' . $res['res_type_id'])->getField('name');
			if($res['user_id']){
				$user = M('user')->where('uid=' . $res['user_id'])->find();
			}
            if($res['part_id']){
				$part = M('part')->where('id=' . $res['part_id'])->find();
			}
            $res['user_name'] = $user['name'];
            $res['user_code'] = $user['code'];
            $res['part_name'] = $part['name'];
            $creat = M('user')->where('uid=' . $res['creat_user'])->find();
            if ($creat) {
                $res['creat_user'] = $creat['name'] . '（' . $creat['code'] . '）';
            }

            if (!$res['guess_out_time']) {
                $res['guess_out_time'] = '暂无';
            }

            $where['phone'] = array('eq', $res['phone']);
            $cus = M('customer')->where($where)->find();
            if ($cus['sex'] == 1) {
                $cus['sex'] = '男';
            }
            if ($cus['sex'] == 2) {
                $cus['sex'] = '女';
            }
            if (!$cus['sex']) {
                $cus['sex'] = '未知';
            }
            $cus['marriage'] = $this->cus_marry($cus['marriage']);
            $cus['education'] = $this->cus_educate($cus['education']);

            if ($this->see_tel == 2) {
                $res['tel'] = substr_replace($res['phone'], '****', 3, 4);
            }

            $res['stage'] = $this->res_step($res['stage']);    //销售阶段
            $res['status'] = $this->res_status($res['status']);    //销售阶段
            $res['next_step'] = $this->res_next_step($res['next_step']);//下次跟进阶段

            $this->assign('res', $res);//
            $this->assign('cus', $cus);//
            //客户资质
            $wh['gr.res_id'] = array('eq', $id);
            $wh['wt.status'] = array('eq', 1);
            $group = M('gr_res_wealth as gr')->field('wt.table,wt.name,gr.wealth_id,gr.id as gid')->join('weal_table as wt on wt.table=gr.wealth_table')->where($wh)->select();
            foreach ($group as $key => $val) {
                $whe['table'] = array('eq', $val['table']);
                $fld_key = M('weal_field')->where($whe)->select();
                $field = M($val['table'])->where('id=' . $val['wealth_id'])->find();
                foreach ($fld_key as $item => $v) {
                    foreach ($field as $q => $e) {
                        if ($q == $v['field']) {
                            $fld_key[$item]['value'] = $e;
                        }
                    }
                }
                $wealth[] = array('table' => $val['name'], 'gid' => $val['gid'], 'fields' => $fld_key);
            }
            $this->assign('wealth', $wealth);//
            //客户意向产品
            $goods = M('gr_res_goods as gr')->field('g.*,gr.id as gid')->join('goods as g on g.id=gr.goods_id')->where('gr.res_id=' . $id)->select();
            $this->assign('goods', $goods);//

            //附件
            $wfj['rc.res_id'] = array('eq', $id);
            $fujian = M('fujian as c')
                ->field('c.*,rc.id as gid')
                ->join('left join gr_res_fujian as rc on rc.fujian_id=c.id')
                ->where($wfj)
                ->limit($page * $num, $num)
                ->select();
            $file = C('TMPL_PARSE_STRING')['__WWW__'] . '/';
            foreach ($fujian as $key => $val) {
                $fujian[$key]['url'] = "http://" . $_SERVER['HTTP_HOST'] . $file . '/' . $val['url'];
            }
            $this->assign('fujian', $fujian);//
            $this->display();
        }

    }

    //修改商机类型
    public function change_type()
    {
        $id = I('post.id');
        $data['res_type_id'] = I('post.res_type_id');
        M('resources')->where('id=' . $id)->save($data);
        $content = "修改商机类型";
        $this->res_op_log($id, $content);
        $list['code'] = 200;
        $list['msg'] = '修改成功';
        echo json_encode($list, true);
    }

    //修改商机来源
    public function change_orgin()
    {
        $id = I('post.id');
        $data['origin_id'] = I('post.origin_id');
        M('resources')->where('id=' . $id)->save($data);
        $content = "修改商机来源";
        $this->res_op_log($id, $content);
        $list['code'] = 200;
        $list['msg'] = '修改成功';
        echo json_encode($list, true);
    }

    //修改内部成本
    public function change_cb_nei()
    {
        $id = I('post.id');
        $data['cb_nei'] = I('post.cb_nei');
        M('resources')->where('id=' . $id)->save($data);
        $content = "修改商机内部成本";
        $this->res_op_log($id, $content);
        $list['code'] = 200;
        $list['msg'] = '修改成功';
        echo json_encode($list, true);
    }

    //修改外部成本
    public function change_cb_wai()
    {
        $id = I('post.id');
        $data['cb_wai'] = I('post.cb_wai');
        M('resources')->where('id=' . $id)->save($data);
        $content = "修改商机外部成本";
        $this->res_op_log($id, $content);
        $list['code'] = 200;
        $list['msg'] = '修改成功';
        echo json_encode($list, true);
    }

    //编辑基础信息
    public function edit()
    {
        if (IS_POST) {
            $data = $_POST;
            $id = $data['id'];
            unset($data['id']);
            M('resources')->where('id=' . $id)->save($data);
            $where['phone'] = array('eq', $_POST['phone']);
            M('customer')->where($where)->save($data);
            $content = "修改基础信息";
            $this->res_op_log($id, $content);
            $list['code'] = 200;
            $list['msg'] = '修改成功';
            echo json_encode($list, true);
        } else {
            $id = I('get.id');
            $res = M('resources')->where('id=' . $id)->find();
            $where['phone'] = array('eq', $res['phone']);
            $cus = M('customer')->where($where)->find();
            $this->assign('res', $res);
            $this->assign('cus', $cus);
            $this->display();
        }
    }


    //添加资质
    public function add_wealth()
    {
        if (IS_POST) {
            $table = I('post.table');
            $res_id = I('post.res_id');
            unset($_POST['table']);
            unset($_POST['res_id']);
            $wealth = $_POST;
            $wealth_id = M($table)->add($wealth);
            $group['res_id'] = $res_id;
            $group['wealth_id'] = $wealth_id;
            $group['wealth_table'] = $table;
            M('gr_res_wealth')->add($group);
            $content = "新增资质";
            $this->res_op_log($id, $content);
            $list['code'] = 200;
            $list['msg'] = '操作成功';
            echo json_encode($list, true);
        } else {
            $tables = M('weal_table')->where('status=1')->select();
            foreach ($tables as $key => $val) {
                $where['table'] = array('eq', $val['table']);
                $tables[$key]['fields'] = M('weal_field')->where($where)->select();
            }
            $this->assign('tables', $tables);
            $this->assign('id', $_GET['id']);
            $this->display();
        }
    }


    public function delete_wealth()
    {
        $id = I('param.gid');
        $group = M('gr_res_wealth')->where('id=' . $id)->find();
        M('gr_res_wealth')->where('id=' . $id)->delete();
        M($group['wealth_table'])->where('id=' . $group['wealth_id'])->delete();
        $content = "删除资质";
        $this->res_op_log($group['res_id'], $content);
        $list['code'] = 200;
        $list['msg'] = '操作成功';
        echo json_encode($list, true);
    }


    //添加联系人
    public function add_contact()
    {
        if (IS_POST) {
            $res_id = I('param.res_id');
            $contact['type'] = I('param.type');
            $contact['ship'] = I('param.ship');
            $contact['tel'] = I('param.tel');
            $contact['address'] = I('param.address');
            $contact['job'] = I('param.job');
            $contact['name'] = I('param.name');
            $contact_id = M('contacts')->add($contact);
            $group['contact_id'] = $contact_id;
            $group['res_id'] = $res_id;
            M('gr_res_contacts')->add($group);
            $content = "新增联系人";
            $this->res_op_log($res_id, $content);
            $list['code'] = 200;
            $list['msg'] = '操作成功';
            echo json_encode($list, true);
        } else {
            $this->assign('id', $_GET['id']);
            $this->display();

        }
    }

    //删除联系人
    public function delete_contact()
    {
        $id = I('param.gid');
        $group = M('gr_res_contacts')->where('id=' . $id)->find();
        M('gr_res_contacts')->where('id=' . $id)->delete();
        M('contacts')->where('id=' . $group['contact_id'])->delete();
        $content = "删除联系人";
        $this->res_op_log($group['res_id'], $content);
        $list['code'] = 200;
        $list['msg'] = '操作成功';
        echo json_encode($list, true);
    }


    //添加附件

    public function add_fujian()
    {
        if (IS_POST) {
            $group['res_id'] = I('param.res_id');
            if (!$group['res_id']) {
                $list['code'] = 'error';
                $list['msg'] = '缺少参数:商机ID';
                echo json_encode($list, true);
                exit;
            }
            $data['title'] = I('param.title');
            if (!$data['title']) {
                $list['code'] = 'error';
                $list['msg'] = '缺少参数:附件名';
                echo json_encode($list, true);
                exit;
            }
            if ($_FILES['img']['name']) {
                $path = 'uploader/upload/fujian/' . date('Ymd');
                if (!file_exists($path)) {
                    mkdir($path, 0777);
                }
                chmod($path, 0777);

                $end_file = strrchr($_FILES['img']['name'], '.');
                $files = mt_rand(0, 99) . $end_file;
                $path = $path . '/' . date('YmdHis') . '_' . $files;
                $resoult = move_uploaded_file($_FILES['img']['tmp_name'], $path);
                if ($resoult) {
                    $data['url'] = $path;
                } else {
                    echo json_encode(["code" => "error", "msg" => "图片上传失败" . $path], true);
                    exit;
                }
            }

            $group['fujian_id'] = M('fujian')->add($data);
            M('gr_res_fujian')->add($group);
            $content = "添加附件";
            $this->res_op_log($group['res_id'], $content);
            $list['code'] = 200;
            $list['msg'] = '添加成功';
            echo json_encode($list, true);
            exit;

        } else {
            $this->assign('id', $_GET['id']);
            $this->display();
        }
    }


    //删除附件
    function delete_fujian()
    {
        $id = I('param.gid');
        $group = M('gr_res_fujian')->where('id=' . $id)->find();
        M('gr_res_fujian')->where('id=' . $id)->delete();
        $fujian = M('fujian')->where('id=' . $group['fujian_id'])->find();
        M('fujian')->where('id=' . $group['fujian_id'])->delete();
        //unlink($fujian['url']);
        $content = "删除附件";
        $this->res_op_log($group['res_id'], $content);
        $list['code'] = 200;
        $list['msg'] = '删除成功';
        echo json_encode($list, true);
        exit;
    }

    //添加推荐产品
    public function add_goods()
    {
        if (IS_POST) {
            $res_id = I('param.res_id');
            $goods_id = I('param.goods_id');
            $where['res_id'] = array('eq', $res_id);
            $where['goods_id'] = array('eq', $goods_id);
            $group = M('gr_res_goods')->where($where)->find();
            if ($group) {
                $list['code'] = "error";
                $list['msg'] = '请勿重复推荐产品';
                echo json_encode($list, true);
                exit;
            }
            $group['res_id'] = $res_id;
            $group['goods_id'] = $goods_id;
            M('gr_res_goods')->add($group);
            $content = "添加推荐产品";
            $this->res_op_log($group['res_id'], $content);
            $list['code'] = 200;
            $list['msg'] = '操作成功';
            echo json_encode($list, true);
            exit;
        } else {
            if (I('param.index')) {
                $this->assign('id', $_GET['id']);
                $this->display();
            } else {
                if (I('get.search')) {
                    $complex[] = array(
                        'g.name' => array('like', "%" . I('get.search') . "%"),
                        'g.type' => array('like', "%" . I('get.search') . "%"),
                        '_logic' => 'or'
                    );

                }
                if (I('get.money')) {
                    $complex[] = array(
                        'g.money_start' => array('elt', I('get.money'))
                    );
                    $complex[] = array(
                        'g.money_end' => array('egt', I('get.money'))
                    );
                }
                if ($complex) {
                    $where = array(
                        '_complex' => $complex,
                        '_logic' => 'and'
                    );
                }

                $page = (I('get.page') != '') ? I('get.page') - 1 : 0;    //页码
                $num = (I('get.limit') != '') ? I('get.limit') : 10;        //每页条数
                $data = M('goods as g')->field('g.*')
                    ->join('left join user as u on u.uid=g.user_id')
                    ->where($where)
                    ->limit($this->num * $this->page, $this->num)
                    ->select();
                $list['code'] = 200;
                $list['data'] = $data;
                $list['count'] = M('goods as g')->where($where)->count();
                echo json_encode($list, true);


            }

        }

    }

    //删除推荐产品
    public function delete_goods()
    {
        $id = I('param.gid');
        $group = M('gr_res_goods')->where('id=' . $id)->find();
        M('gr_res_goods')->where('id=' . $id)->delete();
        $content = "删除推荐产品";
        $this->res_op_log($group['res_id'], $content);
        $list['code'] = 200;
        $list['msg'] = '操作成功';
        echo json_encode($list, true);
    }


    //跟进
    public function go_in()
    {
        $id = I('param.id');
        if (IS_POST) {
            $res = M('resources')->where('id=' . $id)->find();
            switch ($res['status']) {
                case 4:
                    $list['code'] = "error";
                    $list['msg'] = '商机审核中,无法跟进';
                    echo json_encode($list, true);
                    exit;
                    break;
                case 6:
                    $list['code'] = "error";
                    $list['msg'] = '白名单商机,无法跟进';
                    echo json_encode($list, true);
                    exit;
                    break;
                case 7 :
                    $list['code'] = "error";
                    $list['msg'] = '掉库商机,无法跟进';
                    echo json_encode($list, true);
                    exit;
                    break;
            }

            //添加记录
            $remark = I('param.remark');
            $this->res_op_log($id, $remark);
            //计算跟进频率
            $wl['res_id'] = array('eq', $id);
            $wl['controler'] = array('eq', 'Resources/go_in');
            $res_op_log = M('res_op_log')->where($wl)->order('id DESC')->select();//跟进记录
            if ($res_op_log) {
                $count = count($res_op_log); //总跟进次数
                $first = strtotime($res_op_log[$count - 1]['creat_time']);  //第一次跟进
                $end = strtotime($res_op_log[0]['creat_time']);//最后一次跟进
                $times = ($end - $first) / (7 * 86400); //算出跟进率
                if (!$times) {
                    $times = 1;
                }
                $frequ = ceil($times) . '周/' . $count . '次';
                $data['frequ'] = $frequ;
            }
            $data['last_time'] = $res_op_log[0]['creat_time'];
            $data['next_time'] = I('post.next_time');
            $data['next_step'] = I('post.next_step');
            $data['next_remark'] = I('post.next_remark');
            $data['stage'] = I('post.stage');
            $config_change = M('config_change')->where('id=1')->find();

            if ($data['stage'] == 5) {    //如果商机阶段为 已签约 修改商机状态，并重新计算商机掉库时间
                $data['status'] = 3;
                if (!$res['over_time']) {    //只有第一次签约的时候才修改
                    $data['over_time'] = $data['last_time'];    //签约时间
                    $data['guess_out_time'] = date('Y-m-d H:i:s', time() + $config_change['success_time'] * 86400);//成单保护期
                }
            } else {
                $data['guess_out_time'] = date('Y-m-d H:i:s', time() + $config_change['over_time'] * 86400);
                $data['status'] = 2;
            }
            M('resources')->where('id=' . $id)->save($data);
            $list['code'] = 200;
            $list['msg'] = '跟进成功';
            echo json_encode($list, true);
            exit;
        } else {
            //查询跟进标签
            $where['type'] = array('eq', 3);
            $where['status'] = array('eq', 1);
            $label = M('label')->where($where)->select();
            //查询商机
            $res = M('resources')->where('id=' . $id)->find();
            $res['next_step'] = $this->res_next_step($res['next_step']);
            $this->assign('label', $label);
            $this->assign('res', $res);
            $this->display();
        }
    }

    public function order_details()
    {
        $order = M('orders')->where('id=' . I('param.id'))->find();
        $order['accept_name'] = M('user')->where('uid=' . $order['accept_user'])->getField('name');
        $this->assign('order', $order);
        $w['order_id'] = array('eq', I('param.id'));
        $borrow = M('borrow')->where($w)->select();
        $this->assign('borrow', $borrow);
        $res_id = M('gr_res_orders')->where('order_id=' . I('param.id'))->getField('res_id');
        $res = M('resources')->where('id=' . $res_id)->find();
        $where['phone'] = array('eq', $res['phone']);
        $cus = M('customer')->where($where)->find();
        if ($cus['sex'] == 1) {
            $cus['sex'] = '男';
        }
        if ($cus['sex'] == 2) {
            $cus['sex'] = '女';
        }
        if (!$cus['sex']) {
            $cus['sex'] = '未知';
        }
        $cus['marriage'] = $this->cus_marry($cus['marriage']);
        $cus['education'] = $this->cus_educate($cus['education']);
        $res['origin'] = M('origin')->where('id=' . $res['origin_id'])->getField('name');
        $res['res_type'] = M('restype')->field('name')->where('id=' . $res['res_type_id'])->getField('name');
        $user = M('user')->where('uid=' . $res['user_id'])->find();
        $part = M('part')->where('id=' . $res['part_id'])->find();
        $res['user_name'] = $user['name'];
        $res['user_code'] = $user['code'];
        $res['part_name'] = $part['name'];
        $creat = M('user')->where('uid=' . $res['creat_user'])->find();
        if ($creat) {
            $res['creat_user'] = $creat['name'] . '（' . $creat['code'] . '）';
        }

        if (!$res['guess_out_time']) {
            $res['guess_out_time'] = '暂无';
        }

        $where['phone'] = array('eq', $res['phone']);
        $cus = M('customer')->where($where)->find();
        if ($cus['sex'] == 1) {
            $cus['sex'] = '男';
        }
        if ($cus['sex'] == 2) {
            $cus['sex'] = '女';
        }
        if (!$cus['sex']) {
            $cus['sex'] = '未知';
        }
        $cus['marriage'] = $this->cus_marry($cus['marriage']);
        $cus['education'] = $this->cus_educate($cus['education']);

        if ($this->see_tel == 2) {
            $res['tel'] = substr_replace($res['phone'], '****', 3, 4);
        }

        $res['stage'] = $this->res_step($res['stage']);    //销售阶段
        $res['status'] = $this->res_status($res['status']);
        $res['next_step'] = $this->res_next_step($res['next_step']);//下次跟进阶段

        //客户资质
        $wh['gr.res_id'] = array('eq', $res['id']);
        $wh['wt.status'] = array('eq', 1);
        $group = M('gr_res_wealth as gr')->field('wt.table,wt.name,gr.wealth_id,gr.id as gid')->join('weal_table as wt on wt.table=gr.wealth_table')->where($wh)->select();
        foreach ($group as $key => $val) {
            $whe['table'] = array('eq', $val['table']);
            $fld_key = M('weal_field')->where($whe)->select();
            $field = M($val['table'])->where('id=' . $val['wealth_id'])->find();
            foreach ($fld_key as $item => $v) {
                foreach ($field as $q => $e) {
                    if ($q == $v['field']) {
                        $fld_key[$item]['value'] = $e;
                    }
                }
            }
            $wealth[] = array('table' => $val['name'], 'gid' => $val['gid'], 'fields' => $fld_key);
        }
        $this->assign('wealth', $wealth);//
        //客户意向产品
        $goods = M('gr_res_goods as gr')->field('g.*,gr.id as gid')->join('goods as g on g.id=gr.goods_id')->where('gr.res_id=' . $res['id'])->select();
        $this->assign('goods', $goods);//

        //附件
        $demand = M('demand')->field('id')->where(['order_id' => $order['id']])->select();
        if(function_exists('array_column')){
            $demand_id = array_column($demand,'id');   //提取字段
        }else{
            foreach($demand as $key=>$val){
                $demand_id[]=$val['id'];
            }
        }
        if ($demand_id){
            $wfj['rc.demand_id'] = array('in', $demand_id);
            $fujian = M('fujian as c')
                ->field('c.*,rc.id as gid')
                ->join('left join gr_order_fujian as rc on rc.fujian_id=c.id')
                ->where($wfj)
                ->select();
            $file = C('TMPL_PARSE_STRING')['__WWW__'] . '/';
            foreach ($fujian as $key => $val) {
                $fujian[$key]['url'] = "http://" . $_SERVER['HTTP_HOST'] . $file . '/' . $val['url'];
            }
        }
        $this->assign('fujian', $fujian);//
        $this->assign('res', $res);
        $this->assign('cus', $cus);
        $this->display();
    }

    //认款申请
    public function rk_apply()
    {
        if (IS_POST) {
            $data['res_id'] = I('param.res_id');
            $data['order_id'] = I('param.order_id');
            $data['demand_id'] = I('param.demand_id');
            $data['money'] = I('param.money');
            $data['pay_way'] = I('param.pay_way');
            $data['remark'] = I('param.remark');
            $data['rk_type'] = M('money_rk_type')->where('id=' . I('param.rk_type'))->getField('name');
            $data['code'] = 'RK' . date('Ymd', $_SERVER['REQUEST_TIME']) . str_pad(mt_rand(0, 999), 3, "0", STR_PAD_LEFT) . session('user');
            $demand = M('demand')->where('id=' . I('param.demand_id'))->find();
			if(!$demand['step']){
			    echo json_encode(["code" => "error", "msg" => "后台跟进后方可进行认款"], true);
				exit;
			}
            $data['dk_type'] = $demand['dk_type'];
            $data['channel'] = $demand['channel'];
            $order = M('orders')->where('id=' . I('param.order_id'))->find();
            $data['contract'] = $order['contract'];
            $data['creat_user'] = session('user');

            $data['user_id'] = $order['user_id'];                    //商务
            $data['part_code'] = $order['part_code'];
            $data['part_id'] = $order['part_id'];

            $data['accept_user'] = $order['accept_user'];                //做单人
            $data['accept_part_code'] = $order['accept_part_code'];
            $data['accept_part_id'] = $order['accept_part_id'];
            if ($_FILES['img']['name']) {
                $path = 'uploader/upload/rk/' . date('Ymd');
                if (!file_exists($path)) {
                    mkdir($path, 0777);
                }
                chmod($path, 0777);
                $end_file = strrchr($_FILES['img']['name'], '.');
                $files = mt_rand(0, 99) . $end_file;
                $path = $path . '/' . date('YmdHis') . '_' . $files;
                $resoult = move_uploaded_file($_FILES['img']['tmp_name'], $path);
                if ($resoult) {
                    $data['url'] = $path;
                } else {
                    echo json_encode(["code" => "error", "msg" => "图片上传失败" . $path], true);
                    exit;
                }
            }

            //添加记录
            $remark = I('param.remark');
            $this->res_op_log($data['res_id'], $remark);
            $this->dmd_op_log(I('param.demand_id'), $remark);
            M('money_apply_log')->add($data);
            echo json_encode(["code" => 200, "msg" => "已提交,等待初审"], true);
            exit;
        } else {
            $demand = M('demand')->where('id=' . I('get.id'))->find();
            $this->assign('demand', $demand);
            $order = M('orders')->where('id=' . $demand['order_id'])->find();
            $this->assign('order', $order);
            $res_id = M('gr_res_orders')->where('order_id=' . $order['id'])->getField('res_id');
            $res = M('resources')->where('id=' . $res_id)->find();
            $this->assign('res', $res);
            $this->display();
        }

    }


    //认款记录
    public function rk_log()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            $where = $this->where;
            $where['type'] = 1;
            //所属商机
            if (I('get.sj')) {
                $w['code'] = array('like', "%" . I('get.sj') . "%");
                $res_id = M('resources')->where($w)->select();
                if (!$res_id) {
                    $res_id = array(0);
                } else {
                    foreach ($res_id as $key => $val) {
                        $arr[] = $val['id'];
                    }
                    $res_id = $arr;
                }
                $where['res_id'] = array('in', $res_id);
            }

            if (I('get.step')) {
                $where['step'] = array('eq', I('get.step'));
            }
            if (I('get.money_start')) {
                $where['money'] = array('egt', I('get.money_start'));
            }
            if (I('get.money_end')) {
                $where['money'] = array('elt', I('get.money_end'));
            }
            if (I('get.money_start') && I('get.money_end')) {
                $where['money'] = array('between', [I('get.money_start'), I('get.money_end')]);
            }
            $data = M('money_apply_log')->where($where)->order('id DESC')->select();
            foreach ($data as $key => $val) {
                $res = M('resources')->where('id=' . $val['res_id'])->find();
                $data[$key]['res'] = $res['code'];
                $data[$key]['cus'] = $res['name'];
                $data[$key]['order'] = M('orders')->where('id=' . $val['order_id'])->getField('code');
                $data[$key]['demand'] = M('demand')->where('id=' . $val['demand_id'])->find();
                $data[$key]['user'] = M('user')->where('uid=' . $val['user_id'])->getField('name');
                $data[$key]['part'] = M('part')->where('id=' . $val['part_id'])->getField('name');
                $data[$key]['ht_user'] = M('user')->where('uid=' . $val['accept_user'])->getField('name');
                $data[$key]['yj'] = $val['money'] - $val['cb_wai'];
                $data[$key]['lr'] = $val['money'] - $val['cb_wai'] - $val['cb_nei'];
                $data[$key]['step'] = $this->apply_step($val['step']);
            }
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = M('money_apply_log')->where($where)->count();
            echo json_encode($list, true);
        }

    }


}
