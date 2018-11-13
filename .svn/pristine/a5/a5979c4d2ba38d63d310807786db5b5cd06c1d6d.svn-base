<?php

namespace Home\Controller;
//工单
class DemandController extends BackController
{
    public function add()
    {
        $data['money'] = I('post.money');
        $data['lixi_way'] = I('post.lixi_way');//利息计算方式  年息/月息
        $data['business_type'] = I('post.business_type');//业务类型
        $data['dk_type'] = I('post.dk_type');
        $data['recharge'] = I('post.recharge');
        $data['channel'] = I('post.channel');
        $data['order_id'] = I('post.order_id');
        $data['product'] = I('post.product');
        $data['code'] = 'GD' . date('Ymd', $_SERVER['REQUEST_TIME']) . str_pad(mt_rand(0, 999), 3, "0", STR_PAD_LEFT) . session('user');
        M('demand')->add($data);
        $user = M('user')->where(['uid' => session('user')])->find();
        $content = "{$user['name']}" . ',' . "创建工单:" . "工单号:" . "{$data['code']}";
        $this->op_log($content);
        $list['code'] = 200;
        $list['msg'] = '工单生成完毕';
        echo json_encode($list, true);
        die;
    }
}