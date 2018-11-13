<?php
/**
 * 订单
 */

namespace Home\Controller;

use Think\Db;

class OrdersController extends BackController
{
    public $page;
    public $num;
    public $where;
    public $see_tel;
    public $now_time;

    public function _initialize()
    {
        parent::_initialize();
        $this->now_time = date('Y-m-d H:i:s', time());
        $this->page = (I('get.page') != '') ? I('get.page') - 1 : 0;
        $this->num = (I('get.limit') != '') ? I('get.limit') : 10;
        //查看当前用户的数据查看权限
        $role = M('group_access')->where('uid=' . session('user'))->getField('group_id');
        $power = M('group_role')->where('id=' . $role)->getField('show_data');
        if ($power == 'self') {  //只能查看自己的数据
            $param['accept_user'] = array('eq', session('user'));
        }
        if ($power == 'part') {//查看部门数据
            $part_id = M('user')->where('uid=' . session('user'))->getField('part_id');
            $my_part_code = M('part')->where('id=' . $part_id)->getField('code');
            $param['accept_part_code'] = array('like', $my_part_code . "%");
        }
        //公共筛选条件

        //办理部门
        if (I('param.part_id')) {
            $param['accept_part_id'] = array('eq', I('param.part_id'));
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

        //订单编号
        if (I('get.code')) {
            $param['code'] = array('like', "%" . I('get.code') . "%");
        }

        //申请时间
        if (I('get.apply_time_start')) {
            $s_time = I('get.apply_time_start');
            $e_time = I('get.apply_time_end');
            $param['apply_time'] = array('between', array($s_time, $e_time));
        }


        $this->where = $param;
        $power = M('group_role')->where('id=' . $role)->getField('show_tel');
        if ($power == 1) {
            $this->see_tel = 1;
        } else {
            $this->see_tel = 2;
        }

    }

    //订单审核
    public function check()
    {
        $id = I('param.id');                            //订单ID
        $order = M('orders')->where('id=' . $id)->find();
        if ($order['status'] != 1) {
            $list['code'] = "error";
            $list['msg'] = '请勿重复审核';
            echo json_encode($list, true);
            exit;
        }
        $res_id = M('gr_res_orders')->where('order_id=' . $id)->getField('res_id');
        if (I('param.status') == 2) {
            $data['status'] = 2;
            $msg_content = "您的订单已经被拒收";
            $content = "审核拒绝";
        } else {
            $data['status'] = 3;
            $msg_content = "您的订单已通过审核";
            $content = "审核通过";
        }
        $data['check_remark'] = I('param.check_remark');
        $this->res_op_log($res_id, $content);
        M('orders')->where('id=' . $id)->save($data);
        //修改商机状态
        $order_status['order_status'] = $data['status'];
        M('resources')->where(['id=' . $res_id])->save($order_status);
        $res = M('resources')->where(['id' => $res_id])->getField('user_id');
        $this->res_op_log($res_id, $content . ":" . "{$data['check_remark']}");
        A('Workerman')->send_msg($res, '订单审核通知', $msg_content . ":" . "{$data['check_remark']}");
        $list['code'] = 200;
        $list['msg'] = '操作成功';
        echo json_encode($list, true);
        die;
    }

    //办理中订单
    public function ing()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            $where = $this->where;
            $where['status'] = 3;
            $data = M('orders')->where($where)->limit($this->page * $this->num, $this->num)->order('id DESC')->select();
            $data = $this->all($data);
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = M('orders')->where($where)->count();
            echo json_encode($list, true);
        }
    }

    //已完成订单
    public function over()
    {
        if ($_GET['index']) {
            $this->display();
        }

        if ($_GET['search_data']) {
            $where = $this->where;
            $where['status'] = 4;
            $data = M('orders')->where($where)->limit($this->page * $this->num, $this->num)->order('id DESC')->select();
            $data = $this->all($data);
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = M('orders')->where($where)->count();
            echo json_encode($list, true);
        }
    }

    //退单待审核
    public function tcheck()
    {
        if ($_GET['index']) {
            $this->display();
        }

        if ($_GET['search_data']) {
            $where = $this->where;
            if (I('get.accept_part_id')) {
                $where['accept_part_id'] = array('eq', I('get.accept_part_id'));
            }
            $where['status'] = 6;
            $data = M('orders')->where($where)->limit($this->page * $this->num, $this->num)->order('id DESC')->select();
            $data = $this->all($data);
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = M('orders')->where($where)->count();
            echo json_encode($list, true);
        }
    }

    //待接收订单（待审核）
    public function checking()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            $where = $this->where;
            if (I('get.accept_part_id')) {
                $where['accept_part_id'] = array('eq', I('param.accept_part_id'));
            }
            $where['status'] = 1;
            $data = M('orders')->where($where)->limit($this->num * $this->page, $this->num)->order('id DESC')->select();
            $data = $this->all($data);
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = $data = M('orders')->where($where)->count();
            echo json_encode($list, true);
            exit;
        }

    }

    //已退单列表
    public function order_tui()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            $where = $this->where;
            $where['status'] = 7;
            $data = M('orders')->where($where)->limit($this->num * $this->page, $this->num)->order('id DESC')->select();
            $data = $this->all($data);
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = $data = M('orders')->where($where)->count();
            echo json_encode($list, true);
            exit;
        }
    }

    //待审核订单详情
    public function check_details()
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
        $wfj['rc.res_id'] = array('eq', $res['id']);
        $fujian = M('fujian as c')
            ->field('c.*,rc.id as gid')
            ->join('left join gr_res_fujian as rc on rc.fujian_id=c.id')
            ->where($wfj)
            ->limit($this->page * $this->num, $this->num)
            ->select();
        $file = C('TMPL_PARSE_STRING')['__WWW__'] . '/';
        foreach ($fujian as $key => $val) {
            $fujian[$key]['url'] = "http://" . $_SERVER['HTTP_HOST'] . $file . '/' . $val['url'];
        }
        $this->assign('fujian', $fujian);//
        $this->assign('res', $res);
        $this->assign('cus', $cus);
        $this->display();
    }

    //退单
    public function tui()
    {
        
        $order = M('orders')->where('id=' . I('param.id'))->find();
        if ($order['status'] != 3) {
            $list['code'] = 'error';
            $list['msg'] = "无法退单";
            echo json_encode($list, true);
            exit;
        }
        $res_id = M('gr_res_orders')->where('order_id=' . I('param.id'))->getField('res_id');
        $data['status'] = 6;
        $data['check_time'] = $this->now_time;
        $data['check_user'] = session('user');
        $data['check_remark'] = I('param.check_remark');
        M('orders')->where('id=' . I('param.id'))->save($data);
        A('Workerman')->send_msg($order['user_id'], "退单通知", "你的订单编号为:"."{$order['code']}"."退单已经完成");
        $this->res_op_log($res_id, I('param.check_remark'));
        $list['code'] = 200;
        $list['msg'] = "退单成功";
        echo json_encode($list, true);
        exit;
    }

    //处理退单申请
    public function check_tui()
    {
        $order = M('orders')->where('id=' . I('param.id'))->find();
        if ($order['status'] != 6) {
            $list['code'] = 'error';
            $list['msg'] = "请勿重复审核";
            echo json_encode($list, true);
            exit;
        }
        $res_id = M('gr_res_orders')->where('order_id=' . I('param.id'))->getField('res_id');
        $res = M('resources')->where('id=' . $res_id)->find();
        //通过申请
        if (I('post.status') == 1) {
            $data['status'] = 7;                    //已退单
            $data['check_time'] = $this->now_time;
            $data['check_remark'] = I('param.check_remark');

            //订单掉库
            $res['status'] = 7;
            $res['out_type'] = 4;// 退单掉库
            $res['user_id'] = 0;
            $res['allot_user_id'] = 0;
            $res['real_out_time'] = $this->now_time;
            $res['guess_out_time'] = null;
            M('resources')->where('id=' . $res_id)->save($res);

            //掉库记录
            $log['part_id'] = $res['part_id'];
            $log['part_code'] = $res['part_code'];
            $log['user_id'] = $res['user_id'];
            $log['res_id'] = $res['id'];
            $log['type'] = $data['out_type'];
            $log['creat_time'] = $data['real_out_time'];
            M('res_dk_log')->add($log);
            //编辑文字
            $user_msg['content'] = "订单编号{$order['code']}" . "已经退单，请立即停止跟进。";
            A('Workerman')->send_msg($order['accept_user'], '订单退单通知', $user_msg['content']);//给做单人发消息
            $list['msg'] = '已同意';
            $user_msg['content'] = "退单已经通过审核。订单编号{$order['code']}";
        } else {
            $data['status'] = 3;            //办理中
            $list['msg'] = '已拒绝';
            $user_msg['content'] = "退单审核未通过。订单编号{$order['code']}";
        }
        $user_msg['title'] = "退单申请通知";
        M('orders')->where('id=' . I('param.id'))->save($data);
        $this->res_op_log($res_id, $list['msg'] . ":" . $data['check_remark']);
        A('Workerman')->send_msg($res['user_id'], $user_msg['title'], $user_msg['content']);
        $list['code'] = 200;
        echo json_encode($list, true);
        exit;
    }

    //获取订单列表 字段详情
    public function all($data)
    {
        foreach ($data as $key => $val) {
            //订单所属商机
            $res = M('resources as res')->field('res.code,res.name,res.id')->join('left join gr_res_orders as gr on gr.res_id=res.id')->where('gr.order_id=' . $val['id'])->find();
            $data[$key]['res_code'] = $res['code'];
            $data[$key]['res_name'] = $res['name'];
            $data[$key]['res_id'] = $res['id'];
            //下单人
            $creat_user = M('user')->where('uid=' . $val['user_id'])->find();
            //接单人
            $accept_user = M('user')->where('uid=' . $val['accept_user'])->find();
            $data[$key]['creat_user'] = $creat_user['name'] . "（" . $creat_user['code'] . "）";
            $data[$key]['accept_user'] = $accept_user['name'] . "（" . $accept_user['code'] . "）";
            //订单所属部门
            $data[$key]['part'] = M('part')->where('id=' . $val['accept_part_id'])->getField('name');
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
        return $data;
    }
    //订单详情里面有个工单列表，在页面是 以选项卡的形式展示
    //每个选项卡下面是工单的信息，跟进按钮，以及工单的跟进记录

//订单详情
    public function details()
    {
        $id = I('get.id');//订单ID
        $where['order_id'] = array('eq', $id);
        //订单信息
        $order = M('orders')->where(['id' => $id])->find();
        //借贷人信息
        $borrow = M('borrow')->where(['order_id' => $id])->select();

        //下单人
        $order['creat_user_name'] = M('user')->where(['uid' => $order['user_id']])->getField('name');
        $data['orders']['status'] = $this->order_status($order['orders']['status']);
        //商机信息
        $res = M('resources')->where($where)->find();
        //客户基础信息
        $customer = M('customer')->where(['phone' => $res['phone']])->find();
        if ($customer['sex'] == 1) {
            $customer['sex'] = "男";
        } else {
            $customer['sex'] = "女";
        }
        $customer['marriage'] = $this->cus_marry($customer['marriage']);
        $customer['education'] = $this->cus_educate($customer['education']);
        $this->assign('customer', $customer);
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
        $this->assign('wealth', $wealth);

        //商机来源
        $origin = M('origin')->where(['id' => $res['origin_id']])->find();
        //客户意向产品
        $gr_res_goods = M('gr_res_goods')->where(['res_id' => $res['id']])->select();
        foreach ($gr_res_goods as $k => $values) {
            $goods[$k] = M('goods')->where(['id' => $values['goods_id']])->find();
        }
        // var_dump($goods);
        $this->assign('goods', $goods);

        //财务查询
        $money = M('money_apply_log')->where(['order_id' => $id])->select();
        foreach ($money as $keys => $item) {
            //审核人
            $check_user = M('user')->where(['uid' => $item['check_user']])->find();
            $money[$keys]['check_user_name'] = $check_user['name'];
            //商务人
            $user = M('user')->where(['uid' => $item['user_id']])->getField('name');
            $money[$keys]['shangwu_name'] = $user;
            //后台
            $accept_user = M('user')->where(['uid' => $item['accept_user']])->getField('name');
            $money[$keys]['houtai_ren_name'] = $accept_user;
            //类型
            $type = M('money_rk_type')->where(['id' => $item['rk_type']])->find();
            $money[$keys]['type_name'] = $type['name'];
        }
        $this->assign('money', $money);
        //商机类型
        $res_type = M('restype')->where(['id' => $res['res_type_id']])->getField('name');
        //标签
        $label = M('label')->where(['status' => 1])->select();
        //$res.res.phone
        $data['res_type'] = $res_type;
        $data['order'] = $order;
        $data['res'] = $res;
        $data['res']['phone'] = substr($data['res']['phone'], 0, 4) . '*****' . substr($data['res']['phone'], 9);
        $data['origin'] = $origin;
        $this->assign('data', $data);
        $this->assign('label', $label);
        $this->assign('id', $id);
        $this->assign('res_id', $data['res']['id']);
        $this->assign('borrow', $borrow);
        //工单信息
        $demand = M('demand')->where(['order_id' => $id])->select();
        foreach ($demand as $j => $value) {
            //查看工单的费用信息
            $whe['demand_id'] = array('eq', $value['id']);
            $whe['step'] = array('eq', 5);
            $apply_log = M('money_apply_log')->where($whe)->select();
            foreach ($apply_log as $k => $v) {
                $arr['creat_time'] = $v['creat_time'];
                $arr['check_time'] = $v['check_time'];
                $arr['money'] = $v['money'];
                $arr['rk_type'] = $v['rk_type'];
                if ($v['type'] == 1) {
                    $arr['type'] = '认款';
                } else {
                    $arr['type'] = '费用申请';
                }
                $log[] = $arr;

            }
            //查看工单的附件
            $fujian = M('fujian as f')->field('f.*')->join('left join gr_order_fujian as gr on gr.fujian_id =f.id')->where('gr.demand_id=' . $value['id'])->select();
            $demand[$j]['fujian'] = $fujian;
            switch ($value['step']) {
                case 1;
                    $demand[$j]['step'] = "进件";
                    break;
                case 2;
                    $demand[$j]['step'] = "出件";
                    break;
                case 3;
                    $demand[$j]['step'] = "银行审批";
                    break;
                case 4;
                    $demand[$j]['step'] = "放款";
                    break;
            }

            switch ($value['status']) {
                case 1;
                    $demand[$j]['status'] = "办理暂缓";
                    break;
                case 2;
                    $demand[$j]['status'] = "办理超期";
                    break;
                case 3;
                    $demand[$j]['status'] = "正常进行中";
                    break;
                case 4;
                    $demand[$j]['status'] = "办理完毕";
                    break;
            }
            $demand[$j]['log'] = $log;
        }
        $this->assign('demand', $demand);
        $this->display();
    }

    //点击查看手机号码
    public function phone()
    {
        $where['id'] = $_GET['id'];
        $res = M('resources')->where($where)->field('phone')->find();
        echo json_encode($res);
    }

    //删除附件
    public function delete_fujian()
    {
        $id = $_GET['gid'];
        if ($id) {
            M('gr_order_fujian')->where(['fujian_id' => $id])->delete();
            M('fujian')->where(['id' => $id])->delete();
            $list['code'] = 200;
            $list['msg'] = '删除成功';
            echo json_encode($list, true);
        } else {
            $list['code'] = 'Error';
            $list['msg'] = '缺少参数 附件ID';
            echo json_encode($list, true);
        }
    }

    //附件上传
    public function add_fujian()
    {
        $id = $_GET['id'];
        if (IS_POST) {
            $group['demand_id'] = I('param.demand_id');
            if (!$group['demand_id']) {
                $list['code'] = 'error';
                $list['msg'] = '缺少参数:工单ID';
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
            M('gr_order_fujian')->add($group);
            $content = "附件添加";
            $this->dmd_op_log($id, $content);
            $list['code'] = 200;
            $list['msg'] = '添加成功';
            echo json_encode($list, true);
            exit;
        } else {
            $this->assign('id', $id);
            $this->display();
        }
    }

    //工单操作记录
    public function operator()
    {

        $where['demand_id'] = I('param.id');
        //操作时间
        if (I('get.create_time_start')) {
            $s_time = I('get.create_time_start');
            $e_time = I('get.create_time_end');
            $where['creat_time'] = array('between', array($s_time, $e_time));
        }
        $data = M('dmd_op_log')->where($where)->limit($this->num * $this->page, $this->num)->order('id DESC')->select();
        foreach ($data as $k => $values) {
            //操作人
            $user = M('user')->where(['uid' => $values['user_id']])->find();
            //操作人姓名
            $data[$k]['user_name'] = $user['name'];
            //操作工号
            $data[$k]['code'] = $user['code'];
            //操作人
            $data[$k]['controller_name'] = $this->op_log_trans($values['controler']);
        }
        $list['code'] = 200;
        $list['data'] = $data;
        $list['count'] = M('dmd_op_log')->where($where)->count();
        echo json_encode($list, true);
    }

    //数据库是什么名字 建控制器方法的时候就是什么名字， 不要乱取

//工单列表
    public function demand()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            if (I('get.status')) {
                $where['status'] = array('eq', I('get.status'));
            }
            if ($_GET['step']) {
                $where['step'] = array('eq', I('get.step'));
            }
            if ($_GET['money']) {
                $where['money'] = array('like', "%" . I('get.money') . "%");
            }
            if ($_GET['code']) {
                $where['code'] = array('like', "%" . I('get.code') . "%");
            }
            if (I('get.creat_time_start')) {
                $s_time = I('get.creat_time_start');
                $e_time = I('get.creat_time_end');
                $where['creat_time'] = array('between', array($s_time, $e_time));;
            }
            $demand = M('demand')->where($where)->limit($this->num * $this->page, $this->num)->order('id DESC')->select();
            foreach ($demand as $k => $value) {
                //创建人
                $user = M('user')->where(['uid' => $value['creat_user']])->getField('name');
                $demand[$k]['creat_user'] = $user;
                //状态
                $demand[$k]['status'] = $this->demand_status($value['status']);
                $demand[$k]['step'] = $this->demand_step($value['step']);
                //最新跟进记录
                $dmd_op_log = M('dmd_op_log')->where(['demd_id' => $value['id']])->order('id DESC')->find();
                //最新跟进记录人
                $user = M('user')->where(['uid' => $dmd_op_log['user_id']])->getField('name');
                $demand[$k]['new_use'] = $user;
                $demand[$k]['new_create_time'] = $dmd_op_log['create_time'];
                $demand[$k]['new_content'] = $dmd_op_log['content'];
            }
            $list['code'] = 200;
            $list['data'] = $demand;
            $list['count'] = M('demand')->count();
            echo json_encode($list, true);
        }
    }

    //工单详情
    public function demand_details()
    {
        $id = $_GET['id'];
        //工单信息
        $demand = M('demand')->where(['id' => $id])->find();
        //附件信息
        $gr = M('gr_order_fujian')->where(['demand_id' => $demand['id']])->select();
        $fujian = M('fujian as fj')->field('fj.*')->join('left join gr_order_fujian as gr on gr.fujian_id=fj.id')->where('gr.demand_id=' . $id)->select();

        //标签
        $label = M('label')->where(['status' => 1])->select();
        //查看工单的费用信息
        $whe['demand_id'] = array('eq', $demand['id']);
        $whe['step'] = array('eq', 5);
        $apply_log = M('money_apply_log')->where($whe)->select();
        foreach ($apply_log as $k => $v) {
            $arr['creat_time'] = $v['creat_time'];
            $arr['check_time'] = $v['check_time'];
            $arr['money'] = $v['money'];
            $arr['rk_type'] = $v['rk_type'];
            if ($v['type'] == 1) {
                $arr['type'] = '认款';
            } else {
                $arr['type'] = '费用申请';
            }
            $log[] = $arr;
        }
        switch ($demand['step']) {
            case 1;
                $demand['step'] = "进件";
                break;
            case 2;
                $demand['step'] = "出件";
                break;
            case 3;
                $demand['step'] = "银行审批";
                break;
            case 4;
                $demand['step'] = "放款 ";
                break;
        }
        switch ($demand['status']) {
            case 1;
                $demand['status'] = "办理暂缓";
                break;
            case 2;
                $demand['status'] = "办理超期 ";
                break;
            case 3;
                $demand['status'] = "正常进行中";
                break;
            case 4;
                $demand['status'] = "办理完毕 ";
                break;
        }
        //
        $this->assign('label', $label);
        $this->assign('demand', $demand);
        $this->assign('log', $log);
        $this->assign('id', $id);
        $this->assign('gd_id', $demand['id']);
        $this->assign('fujian', $fujian);
        $this->display();
    }

//工单添加
    public function demand_add()
    {
        $id = I('param.id');
        if (IS_POST) {
            //验证，  是否所有的订单都能添加工单，自己思考
            $id = I('post.id');//订单ID
			$order=M('order')->where('id='.$id)->find();
			if($order['status']!=3){
				$list['code'] = 'error';
				$list['msg'] = "只有办理中的订单才允许新增工单";
				echo json_encode($list, true);
				die;
			}
            $data['money'] = I('post.money');
            $data['lixi_way'] = I('post.lixi_way');
            $data['business_type'] = I('post.business_type');
            $data['dk_type'] = I('post.dk_type');
            $data['recharge'] = I('post.recharge');
            $data['channel'] = I('post.channel');
            $data['order_id'] = $id;
            $data['code'] = 'GD' . date('Ymd', $_SERVER['REQUEST_TIME']) . str_pad(mt_rand(0, 999), 3, "0", STR_PAD_LEFT) . session('user');
            $data['product'] = I('post.product');
            $data['creat_user'] = session('user');
            M('demand')->add($data);
            $demand_id = M('demand')->where(['order_id' => $id])->field('id');
            $content = "添加工单";
            $this->dmd_op_log($demand_id, $content);
            $list['code'] = 200;
            $list['msg'] = "添加工单成功";
			A('Workerman')->send_msg($order['user_id'], '新增工单通知', '您有新的工单可以进行认款,工单编号：'.$data['code']);
            echo json_encode($list, true);
            die;
        } else {
            //商机信息
            $res = M('resources')->where(['order_id' => $id])->find();
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
            //客户意向产品
            $gr_res_goods = M('gr_res_goods')->where(['res_id' => $res['id']])->select();
            foreach ($gr_res_goods as $k => $values) {
                $goods[$k] = M('goods')->where(['id' => $values['goods_id']])->find();
            }
            //合同信息
            $order = M('orders')->where(['id' => $id])->find();
            $this->assign('wealth', $wealth);
            $this->assign('goods', $goods);
            $this->assign('order', $order);
            $this->assign('id', $id);
            $this->display();
        }

    }


//工单删除
    public function demand_delete()
    {
        $id = I('param.id');
        if ($id) {
            $check = M('demand')->where(['id' => $id])->getField('step');
            if ($check == 0) {
                $list['code'] = 'Error';
                $list['msg'] = "无法删除处理中的工单";
                echo json_encode($list);
                die;
            }
            M('demand')->where(['id' => $id])->delete();
            $this->dmd_op_log($id, I('param.content'));
            $list['code'] = 200;
            $list['msg'] = "删除成功";
            echo json_encode($list, true);
        } else {
            $list['code'] = 'Error';
            $list['msg'] = "缺少参数工单ID";
            echo json_encode($list, true);
        }
    }

//工单跟进
    public function demand_gj()
    {
        $id = I('post.id');//订单ID
        $data['status'] = I('post.status');
        $data['step'] = I('post.step');
        if ($data['step'] == 4 && $data['status'] == 4) {
			//查找该订单下的所有工单，如果有其中一个正在办理中，就说明订单还在处理中，否则视为 订单完毕
			$demand = M('demand')->where(['id' => $id])->find();
			$ing=M('demand')->where('order_id='.$demand['order_id'])->select();
			foreach($ing as $key =>$val){
				if($val['status']!=4 || $val['step'] != 4){
					continue;
				}
				$order['status'] = 4;
			}
			if($order){
				M('orders')->where(['id' => $demand['order_id']])->save($order);
			}
        }
        M('demand')->where(['id' => $id])->save($data);
        //获取ID
        $dmd_id = M('demand')->where(['id' => $id])->getField('id');
        $content = "工单跟进:" . "备注:" . "{$_POST['content']}";
        $this->dmd_op_log($dmd_id, $content);
        $list['code'] = 200;
        $list['msg'] = "跟进处理完成";
        echo json_encode($list, true);
    }

    //费用申请
    public function rk_apply()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            $where = $this->where;
            $where['type'] = 1;
            //所属订单
            if (I('get.order')) {
                $wx['code'] = array('like', "%" . I('get.order') . "%");
                $order_id = M('orders')->where($wx)->select();
                if (!$order_id) {
                    $order_id = array(0);
                } else {
                    foreach ($order_id as $key => $val) {
                        $arr[] = $val['id'];
                    }
                    $order_id = $arr;
                }
                $where['order_id'] = array('in', $order_id);
            }
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
            if (I('get.status')) {
                if (I('get.status') == 1) {
                    $where['last_money'] = array('neq', 0);
                } else {
                    $where['last_money'] = array('eq', 0);
                }
            }

            $where['step'] = array('eq', 5);
            $where['cb_wai'] = array('gt', 0);
            $data = M('money_apply_log')->where($where)->limit($this->num * $this->page, $this->num)->order('id DESC')->select();

            foreach ($data as $key => $val) {
                $res = M('resources')->where('id=' . $val['res_id'])->find();
                $data[$key]['res'] = $res['code'];
                $data[$key]['cus'] = $res['name'];
                $data[$key]['order'] = M('orders')->where('id=' . $val['order_id'])->getField('code');
                $data[$key]['demand'] = M('demand')->where('id=' . $val['demand_id'])->find();
                $data[$key]['user'] = M('user')->where('uid=' . $val['user_id'])->getField('name');
                $data[$key]['part'] = M('part')->where('id=' . $val['accept_part_id'])->getField('name');
                $data[$key]['ht_user'] = M('user')->where('uid=' . $val['accept_user'])->getField('name');
                $data[$key]['step'] = $this->apply_step($val['step']);
            }
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = M('money_apply_log')->where($where)->count();
            echo json_encode($list, true);
        }
        if (IS_POST) {
            $apply = M('money_apply_log')->where('id=' . I('param.id'))->find();
            if (I('param.money') > $apply['cb_wai']) {
                echo json_encode(["code" => "error", "msg" => "费用超额:最高" . $apply['cb_wai']], true);
                exit;
            }
            $data = $apply;
            $data['money'] = I('param.money');
            $data['pid'] = I('param.id');
            $data['type'] = 2;
            $data['remark'] = I('param.remark');
            $data['rk_type'] = I('param.rk_type');
            $data['code'] = 'FY' . date('Ymd', $_SERVER['REQUEST_TIME']) . str_pad(mt_rand(0, 999), 3, "0", STR_PAD_LEFT) . session('user');
            $data['creat_user'] = session('user');
            if ($_FILES['img']['name']) {
                $path = 'uploader/upload/fy/' . date('Ymd');
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
            } else {
                echo json_encode(["code" => "error", "msg" => "请上传消费凭证"], true);
                exit;
            }

            //如果是费用申请， 扣除可用

            $p_data['last_money'] = $apply['last_money'] - I('param.money');
            if ($p_data['last_money'] < 0) {
                $list['code'] = 'error';
                $list['msg'] = '可用额度不足';
                echo json_encode($list, true);
                exit;
            } else {
                M('money_apply_log')->where('id=' . $apply['id'])->save($p_data);
            }

            unset($data['creat_time']);
            unset($data['id']);
            unset($data['over_user']);
            unset($data['check_user']);
            unset($data['check_time']);
            unset($data['check_remark']);
            unset($data['step']);
            unset($data['pay_way']);
            //添加记录
            $remark = I('param.remark');
            $this->res_op_log($data['res_id'], $remark);
            $this->dmd_op_log($data['demand_id'], $remark);
            M('money_apply_log')->add($data);
            echo json_encode(["code" => 200, "msg" => "已提交,等待初审"], true);
            exit;
        }
    }

    //申请记录
    public function rk_log()
    {
        if ($_GET['index']) {
            $this->display();
        }
        if ($_GET['search_data']) {
            $where = $this->where;
            $where['type'] = 2;


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

            if (I('get.creat_time_start')) {
                $s_time = I('get.creat_time_start');
                $e_time = I('get.creat_time_end');
                $where['creat_time'] = array('between', array($s_time, $e_time));
            }
            //所属订单
            if (I('get.order')) {
                $wx['code'] = array('like', "%" . I('get.order') . "%");
                $order_id = M('orders')->where($wx)->select();
                if (!$order_id) {
                    $order_id = array(0);
                } else {
                    foreach ($order_id as $key => $val) {
                        $arr[] = $val['id'];
                    }
                    $order_id = $arr;
                }
                $where['order_id'] = array('in', $order_id);
            }
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
            if (I('get.check_time_start')) {
                $check_star_time = I('get.check_time_start');
                $check_end_time = I('get.check_time_end');
                $where['check_time'] = array('between', array($check_star_time, $check_end_time));
            }
            $data = M('money_apply_log')->where($where)->limit($this->num * $this->page, $this->num)->order('id DESC')->select();
            foreach ($data as $key => $val) {
                $res = M('resources')->where('id=' . $val['res_id'])->find();
                $data[$key]['res'] = $res['code'];
                $data[$key]['cus'] = $res['name'];
                $data[$key]['order'] = M('orders')->where('id=' . $val['order_id'])->getField('code');
                $data[$key]['demand'] = M('demand')->where('id=' . $val['demand_id'])->find();
                $data[$key]['user'] = M('user')->where('uid=' . $val['user_id'])->getField('name');
                $data[$key]['part'] = M('part')->where('id=' . $val['accept_part_id'])->getField('name');
                $data[$key]['ht_user'] = M('user')->where('uid=' . $val['accept_user'])->getField('name');
                $data[$key]['step'] = $this->apply_step($val['step']);
            }
            $list['code'] = 200;
            $list['data'] = $data;
            $list['count'] = M('money_apply_log')->where($where)->count();
            echo json_encode($list, true);
        }

    }

}