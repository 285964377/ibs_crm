<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/Application/Home/Common/layui/css/layui.css">
    <link rel="stylesheet" href="/Application/Home/Common/layui/css/admin.css">
	<link rel="stylesheet" href="/Application/Home/Common/layui/css/view.css">
    <link rel="stylesheet" href="/Application/Home/Common/css/style.css"/>
    <link rel="icon" href="/Application/Home/Common/favicon.ico">
    <title>兴百惠CRM</title>
</head>

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    .layui-view-body {
        background: #fff;
    }

    .layui-table {
        margin-top: 0
    }

    .layui-table td, .layui-table th, .layui-table-col-set, .layui-table-fixed-r, .layui-table-grid-down, .layui-table-header, .layui-table-page, .layui-table-tips-main, .layui-table-tool, .layui-table-total, .layui-table-view, .layui-table[lay-skin=line], .layui-table[lay-skin=row] {
        border-width: 1px;
        border-style: solid;
        border-color: #c6d1d6;
    }

    .layui-table thead tr, .layui-table-click, .layui-table-header, .layui-table-hover, .layui-table-mend, .layui-table-patch, .layui-table-tool, .layui-table-total, .layui-table-total tr, .layui-table[lay-even] tr:nth-child(even) {
        background: url(/Application/Home/Common/images/t_bck.png) repeat-x;
        background-size: 100% 100%;
    }

    .layui-table td, .layui-table th {
        padding: 0;
        text-align: center;
        line-height: 28px;
        font-size: 12px;
        color: #000
    }

    .layui-form-item {
        clear: none;
    }

    .layui-form-mid {
        line-height: 12px;
    }

    .layui-form-label {
        width: auto;
    }

    .layui-table-view .layui-table {
        width: 100%;
    }

    .my_fj_list img {
        width: 100%;
        height: 138px;
        cursor: pointer;
    }

    .my_fj_list li {
        margin-bottom: 20px;
    }

    .my_fj_list li > div {
        border: 1px solid #eee;
        position: relative;
    }

    .my_fj_list p {
        font-size: 12px;
        padding: 10px 6px;
        background: #eff3f5;
        color: #000;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .my_fj_list li > div span {
        cursor: pointer;

        display: block;
        width: 36px;
        height: 36px;
        background: url(/crm/Application/Home/Common/images/del.png) no-repeat;
        background-size: 100% 100%;
        position: absolute;
        right: -18px;
        top: -15px;
    }
    .form_list{
        width:100%;
        overflow:hidden;
        margin-bottom:20px;
    }
    .form_list li{
        float:left;
        padding:10px;
        border:1px solid #eff3f5;
        margin-right:10px;
        margin-top:20px;
        font-size:12px;
        cursor: pointer;
    }
    .form_list li:hover{
        background:#eff3f5;
    }
</style>
<body class="layui-view-body">
<div class="layui-content">
    <ul class="head_top_table">
        <li><p><span class="fwt">客户</span>：<?php echo ($data["res"]["name"]); ?></p></li>
        <li><p><span class="fwt">订单编号</span>：<?php echo ($data["order"]["code"]); ?></p></li>
        <li><p><span class="fwt">下单时间</span>：<?php echo ($data["order"]["creat_time"]); ?></p></li>
        <li><p><span class="fwt">签单人</span>：<?php echo ($data["order"]["creat_user_name"]); ?></p></li>
        <!--<li><p><span class="fwt">判断</span>：<?php if($res['allot_time']): echo ($res["allot_time"]); else: ?>未分配<?php endif; ?></p></li>-->
    </ul>
    <div class="my_style_table">
        <div class="head_top_table">
            <li><p>
                <span class="fwt">基础信息</span>
                <!--<a style="margin-left:10px;" id="edit_base" href="javascript:;" class="layui-btn layui-btn-xs layui-btn-blue">编辑</a>-->
                <!--<a style="margin-left:10px;" id="send_msg" href="javascript:;" class="layui-btn layui-btn-xs layui-btn-blue">发短信</a>-->
                <!--<a style="margin-left:10px;" id="remark" href="javascript:;" class="layui-btn layui-btn-xs layui-btn-blue">备注</a>-->
            </p></li>
        </div>
        <ul class="my_style_table_body">
            <li class="layui-row">
                <div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
                    <p>
                        <span>客户名称：</span>
                        <span><?php echo ($customer["name"]); ?></span>
                    </p>
                </div>
                <div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
                    <p>
                        <span>客户电话：</span>
                        <?php if($data['res']['tel']): ?><span><?php echo ($customer["phone"]); ?></span>
                            <a id="see_tel" class="layui-btn layui-btn-blue layui-btn-xs"
                               style="position:relative;top:-2px;left:4px" href="javascript:;">查看</a>
                            <?php else: ?>
                            <span><?php echo ($customer["phone"]); ?></span><?php endif; ?>
                </div>
                <div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
                    <p>
                        <span>星级：</span>
                        <span>暂无</span>
                    </p>
                </div>
                <div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
                    <p>
                        <span>客户身份证号码：</span>
                        <span><?php echo ($customer["idcard"]); ?></span>
                </div>
            </li>
            <li>
                <div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
                    <p>
                        <span>客户性别：</span>
                        <span><?php echo ($customer["sex"]); ?></span>
                    </p>
                </div>
                <div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
                    <p>
                        <span>客户年龄：</span>
                        <span><?php echo ($customer["age"]); ?></span>
                    </p>
                </div>
                <div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
                    <p>
                        <span>客户婚姻状况：</span>
                        <span><?php echo ($customer["marriage"]); ?></span>
                    </p>
                </div>
                <div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
                    <p>
                        <span>客户子女个数：</span>
                        <span><?php echo ($customer["child"]); ?></span>
                    </p>
                </div>
            </li>
            <li>
                <div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
                    <p>
                        <span>客户学历：</span>
                        <span>无</span>
                    </p>
                </div>
                <div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
                    <p>
                        <span>商机来源：</span>
                        <span><?php echo ($data["origin"]["name"]); ?></span>
                    </p>
                </div>
                <div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
                    <p>
                        <span>商机：</span>
                        <span><?php echo ($data["res_type"]); ?></span>
                    </p>
                </div>
                <div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
                    <p>
                        <span>业务区域：</span>
                        <span>无??</span>
                    </p>
                </div>
            </li>
        </ul>
    </div>
    <div class="my_style_table">
        <div class="head_top_table">
            <li><p><span class="fwt">客户属性</span></p></li>
        </div>
        <ul class="my_style_table_body">

            <?php if(is_array($wealth)): $i = 0; $__LIST__ = $wealth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$wealths): $mod = ($i % 2 );++$i;?><li class="layui-row">
                    <div class="layui-col-xs1" style="text-align: right;padding-right:20px;">
                        <p>
                            <span><?php echo ($wealths["table"]); ?></span>
                        </p>
                    </div>
                    <div class="layui-col-xs11" style="text-align: left;padding-left:20px;position:relative;">
                        <p>
							<span>
							<?php if(is_array($wealths["fields"])): $i = 0; $__LIST__ = $wealths["fields"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i; if($field.value): echo ($field["field_name"]); ?>：<?php echo ($field["value"]); ?>;<?php endif; endforeach; endif; else: echo "" ;endif; ?>
							</span>
                        </p>
                    </div>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(!$wealth): ?><li class="layui-row">
                    <div class="layui-col-xs12" style="text-align: center;">
                        <p>
                            <span>暂无</span>
                        </p>
                    </div>

                </li><?php endif; ?>
        </ul>
    </div>
    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
        <ul class="layui-tab-title">
            <li class="layui-this">订单详情</li>
            <li>生产订单</li>
        </ul>
        <div class="layui-tab-content">
            <!-- 订单详情 -->
            <div class="layui-tab-item layui-show">
                <!-- 借贷人 -->
                <div class="my_style_table">
                    <div class="head_top_table">
                        <li><p><span class="fwt">借贷人</span></p></li>
                    </div>
                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th>姓名</th>
                            <th>身份证号</th>
                            <th>联系电话</th>
                            <th>婚姻状况</th>
                            <th>子女数量</th>
                            <th>家人是否知晓</th>
                            <!--<th>与主借贷人关系</th>-->
                            <th>是否客户本人</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($borrow)): $i = 0; $__LIST__ = $borrow;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$borrows): $mod = ($i % 2 );++$i;?><tr>
                                <td><?php echo ($borrows["name"]); ?></td>
                                <td><?php echo ($borrows["id_number"]); ?></td>
                                <td><?php echo ($borrows["tel"]); ?></td>
                                <td><?php echo ($borrows["marriage"]); ?></td>
                                <td><?php echo ($borrows["child"]); ?></td>
                                <td><?php echo ($borrows["ships"]); ?></td>
                                <td><?php echo ($borrows["is_self"]); ?></td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="my_style_table">
                    <div class="head_top_table">
                        <li><p><span class="fwt">客户意向</span></p></li>
                    </div>
                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th>产品编号</th>
                            <th>产品名称</th>
                            <th>渠道名称</th>
                            <th>贷款金额</th>
                            <th>贷款利率</th>
                            <th>贷款年限</th>
                            <th>放款周期</th>
                            <th>年龄要求</th>
                            <th>进件条件</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php  foreach ($goods as $k=>$v):?>
                        <tr>
                            <td><?=$v['code']?></td>
                            <td><?=$v['name']?></td>
                            <td><?=$v['origin']?></td>
                            <td><?=$v['money_start']?>~<?=$v['money_end']?>万元</td>
                            <td><?=$v['ratio_start']?>%~ <?=$v['ratio_end']?>%(<?=$v['ratio_type']?>息)</td>
                            <td><?=$v['dk_time_start']?> ~<?=$v['dk_time_end']?> (<?=$v['dk_time_type']?>)</td>
                            <td><?=$v['loan_time_start']?>~<?=$v['loan_time_end']?> (<?=$v['loan_time_type']?>)</td>
                            <td><?=$v['age_start']?>~<?=$v['age_end']?> </td>
                            <td><?=$v['jinjian']?></td>
                        </tr>
                        <?php  endforeach; ?>

                        <?php if(!$goods): ?><tr>
                                <td style="border-right:none;"></td>
                                <td style="border-right:none;border-left:none;"></td>
                                <td style="border-right:none;border-left:none;"></td>
                                <td style="border-right:none;border-left:none;"></td>
                                <td style="border-right:none;border-left:none;text-align:right;padding-right:25px;">
                                    暂无
                                </td>
                                <td style="border-right:none;border-left:none;"></td>
                                <td style="border-right:none;border-left:none;"></td>
                                <td style="border-right:none;border-left:none;"></td>
                                <td style="border-right:none;border-left:none;"></td>
                                <td style="border-right:none;border-left:none;"></td>
                                <td style="border-left:none;"></td>
                            </tr><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- 贷款合同 -->
                <div class="my_style_table">
                    <div class="head_top_table">
                        <li><p><span class="fwt">贷款合同</span></p></li>
                    </div>
                    <table class="layui-table">
                        <tbody>
                        <tr style="background: #FFFFFF">
                            <td style="padding: 16px">
                                <ul class="head_top_table" style="border: none;background: none;margin-bottom: -20px">
                                    <li><p>合同编号：<?php echo ($data["order"]["contract"]); ?></p></li>
                                    <li><p>贷款金额：<?php echo ($data["order"]["dk_money"]); ?>万</p></li>
                                    <li><p>贷款时长：<?php echo ($data["order"]["dk_time"]); echo ($data["order"]["dk_time_type"]); ?></p></li>
                                    <li><p>贷款利率：<?php echo ($data["order"]["dk_ratio"]); echo ($data["order"]["dk_ratio_type"]); ?></p></li>
                                    <li><p>定金：<?php echo ($data["order"]["ding_money"]); ?>元</p></li>
                                    <li><p>服务费：<?php echo ($data["order"]["fuwu_money"]); ?>%</p></li>
                                    </br>
                                    <li style="margin-top:20px;" id="imgs"><p>合同文件：<img style="cursor: pointer;"
                                                                                        src="/<?php echo ($data["order"]["contract_img"]); ?>"/>
                                    </p></li>
                                </ul>
                            </td>
                        </tr>

                        </tbody>
                    </table>

                </div>
                <!-- 借贷人 -->

            </div>
            <!--工单-->
            <div class="layui-tab-item">
                <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                    <ul class="layui-tab-title">
                        <?php if(is_array($demand)): $i = 0; $__LIST__ = $demand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i; if($i == 1): ?><li class="layui-this"><?php echo ($item["code"]); ?>_<?php echo ($item["dk_type"]); ?></li>
                                <?php else: ?>
                                <li><?php echo ($item["code"]); ?>_<?php echo ($item["dk_type"]); ?></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </ul>

                    <div class="layui-tab-content">
                        <?php if(is_array($demand)): $i = 0; $__LIST__ = $demand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class='layui-tab-item  <?php if($i==1){ ?> layui-show <?php } ?>' >
                                    <!-- 生产订单 -->
                                    <div class="my_style_table">
                                        <div class="head_top_table">
                                            <li><p><span class="fwt">工单基础信息</span></p></li>
                                        </div>
                                        <ul class="my_style_table_body">
                                            <li class="layui-row">
                                                <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                                                    <p>
                                                        <span>编号：</span>
                                                        <span><?php echo ($item["code"]); ?></span>
                                                    </p>
                                                </div>
                                                <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                                                    <p>
                                                        <span>贷款金额：</span>
                                                        <span><?php echo ($item["money"]); ?></span>
                                                    </p>
                                                </div>
                                                <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                                                    <p>
                                                        <span>利息：</span>
                                                        <span><?php echo ($item["lixi_way"]); ?></span>
                                                    </p>
                                                </div>
                                                <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                                                    <p>
                                                        <span>业务类型：</span>
                                                        <span><?php echo ($item["business"]); ?></span>
                                                    </p>
                                                </div>
                                                <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                                                    <p>
                                                        <span>贷款类型：</span>
                                                        <span><?php echo ($item["dk_type"]); ?></span>
                                                    </p>
                                                </div>
                                                <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                                                    <p>
                                                        <span>手续费：</span>
                                                        <span><?php echo ($item["recharge"]); ?></span>
                                                    </p>
                                                </div>
                                                <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                                                    <p>
                                                        <span>渠道：</span>
                                                        <span><?php echo ($item["channel"]); ?></span>
                                                    </p>
                                                </div>
                                                <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                                                    <p>
                                                        <span>进度：</span>
                                                        <span><?php echo ($item["step"]); ?></span>
                                                    </p>
                                               </div>
                                                <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                                                    <p>
                                                        <span>状态：</span>
                                                        <span><?php echo ($item["status"]); ?></span>
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--备注和添加附件-->
                                    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                                        <ul class="layui-tab-title">
                                            <li class="layui-this">操作记录</li>
                                            <li>财务核款信息</li>
                                            <li>添加备注</li>
                                            <li>添加附件</li>
                                        </ul>
                                        <div class="layui-tab-content">
                                            <div class="layui-tab-item layui-show">
                                                <!--操作记录-->
                                                <div class="form-box">
                                                    <div class="layui-form" action="">
                                                        <div class="layui-form-item">
                                                            <label class="layui-form-label">操作时间</label>
                                                            <div class="layui-input-inline">
                                                                <input type="text"  class="layui-input" id="times" placeholder="请选择操作时间" autocomplete="off" name="create_time"/>
                                                            </div>
                                                            <button class="layui-btn layui-btn-blue " lay-submit lay-filter="search">
                                                                <i
                                                                        class="layui-icon">&#xe615;</i>查询
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table id="hostry" lay-filter="hostry"></table>
                                            </div>
                                            <div class="layui-tab-item">
                                                <!--财务核款信息-->
                                                <div class="my_style_table">
                                                    <div class="head_top_table">
                                                        <li><p><span class="fwt">财务核款信息</span></p></li>
                                                    </div>
                                                    <table class="layui-table">
                                                        <thead>
                                                        <tr>
                                                            <th>类型</th>
                                                            <th>款项</th>
                                                            <th>金额</th>
                                                            <th>申请时间</th>
                                                            <th>审核时间</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php if(is_array($item["log"])): $i = 0; $__LIST__ = $item["log"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$log): $mod = ($i % 2 );++$i;?><tr>
                                                            <td><?php echo ($log["type"]); ?></td>
                                                            <td><?php echo ($log["rk_type"]); ?></td>
                                                            <td><?php echo ($log["money"]); ?></td>
                                                            <td><?php echo ($log["creat_time"]); ?></td>
                                                            <td><?php echo ($log["check_time"]); ?></td>
                                                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="layui-tab-item">
                                                <div class="layui-form" >
                                                    <div class="layui-form-item" style="margin-top:0">
                                                        <div class="my_form_box">
                                                            <label class="layui-form-label">工单状态：</label>
                                                            <div class="layui-input-inline">
                                                                <select name="status" lay-verify="">
                                                                    <option value="1">办理暂缓</option>
                                                                    <option value="2">办理超期</option>
                                                                    <option value="3">正常进行中</option>
                                                                    <option value="4">办理完毕</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="my_form_box">
                                                            <label class="layui-form-label">工单进度：</label>
                                                            <div class="layui-input-inline">
                                                                <select name="step" lay-verify="">
                                                                    <option value="1">进件</option>
                                                                    <option value="2">出件</option>
                                                                    <option value="3">银行审批</option>
                                                                    <option value="4">放款</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="my_form_box">
                                                            <ul class="form_list">
                                                                <li onclick="fz(this)">假数据</li>
                                                                <?php if(is_array($label)): $i = 0; $__LIST__ = $label;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$labels): $mod = ($i % 2 );++$i;?><li onclick="fz(this)"><?php echo ($labels["content"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
                                                            </ul>
                                                            <div class="layui-input-block" style="margin-left:0px;">
                                                                <textarea name="content" style="width:500px;height:100px;resize: none;" lay-verify="required" placeholder="" class="layui-textarea "></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="my_form_box">
                                                            <input type="hidden" name="id" value="<?php echo ($item["id"]); ?>"/>
                                                            <button class="layui-btn layui-btn-blue " lay-submit lay-filter="get_my_goin">提交备注</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="layui-tab-item">
                                                <ul class="head_top_table"
                                                    style="border: none;background: none;margin-bottom: -20px">
                                                    <li>
                                                        <button href="javascript:;" class="layui-btn layui-btn-blue add_img"
                                                             style="margin-bottom:10px;" data-id="<?php echo ($item["id"]); ?>">添加附件
                                                        </button>
                                                    </li>
                                                </ul>
                                                <ul class="my_fj_list layui-row layui-col-space30 people_list_fj" style="" >
                                                    <?php if(is_array($item["fujian"])): $i = 0; $__LIST__ = $item["fujian"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fujians): $mod = ($i % 2 );++$i;?><li class="layui-col-md2 layui-col-xs4">
                                                            <div>
                                                                <img src="/<?php echo ($fujians["url"]); ?>" alt=""/>
                                                                <p><?php echo ($fujians["title"]); ?></p>
                                                                <span onclick="del_fj(this)" data-id="<?php echo ($fujians["id"]); ?>"></span>
                                                            </div>
                                                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="/Application/Home/Common/layui/layui.js"></script>
<script src="/Application/Home/Common/js/jquery.js"></script>
<script>
		$("body").bind("keydown",function(event){  
           if (event.keyCode == 116) {  
	         event.preventDefault(); //阻止默认刷新  
	         location=location;  
            }  
        })
		var path = "/Application/Home/Common";
		function Ajax(url,type,datas,fun){
			$.ajax({
				url:url,
				type:type,
				data:datas,
				dataType:'json',
				success:fun
			})
		}
		function refresh(){
			location=location;
		}
		function je(obj){
			var num=$(obj).val();
			if(num==""){
				num=0;
				$(obj).val(num);
				return;
			}
			if(num=='NaN'){
				num=0;
				$(obj).val(num);
				return;
			}
			var len=num.split(".");
			if(len[1]==0){
				return;
			}
			if(len.length>1&& len[1].length>1){
				num=parseFloat(num);
				num=num.toFixed(2);
			}else{
				num=parseFloat(num);
			}
			$(obj).val(num);
		}
		//商机跳转
		function get_url(obj,id,url,text){
				var id = id;
				var url = url;
				var text = text;
			layui.use(['layer', 'element', 'jquery'], function() {
				var layer = layui.layer;
				var element = layui.element;
				var $ = layui.jquery;
				var isActive = $('#appTabs', parent.document).click().find('li[lay-id="'+id+'"]');
				if(isActive.length>0){
						//切换到选项卡
						parent.layui.element.tabChange('tabs', id);
					}else{
						parent.layui.element.tabAdd('tabs',{
							title: text,	
							content:'<iframe  src="' + url + '" name="iframe' + id + '" class="iframe" framborder="0" data-id="' + id + '" scrolling="auto" width="100%"  height="100%"></iframe>',
							id:id
						})
						parent.layui.element.tabChange('tabs',id);
					}
					parent.layui.element.init();
			})
		}
		
</script>
<script type="text/html" id="cz_lxr">
    <a href="javascript:;" class='layui-btn layui-btn-danger layui-btn-xs' lay-event="del_lxr">删除</a>
</script>
<script>

    var tc_o, tc_t, tc_r, tc_f, add_box, Machine;
    var Ids = "<?php echo ($id); ?>";
    var telID = "<?php echo ($res_id); ?>";
    layui.config({
        base: path + '/modules/treeSelect/',
    })
    layui.use(['table', 'layer', 'jquery', 'form', 'element', 'treeSelect', 'laydate'], function () {
        var table = layui.table, layer = layui.layer, form = layui.form, $ = layui.jquery, laypage = layui.laypage,
            element = layui.element, treeSelect = layui.treeSelect, laydate = layui.laydate;
        laydate.render({
            elem: '#times',
            range: '~',
            type: 'datetime'
        });
        layer.photos({
            photos: '#imgs'
            , anim: 5
        });
        //搜索历史记录
        form.on('submit(search)', function(data){
            data=data.field;
            if($('#times').val()){
                var Nlast = data.create_time.split('~');
                data.create_time_start=Nlast[0];
                data.create_time_end=Nlast[1];
            }
            delete  data.create_time;
            cz_table.reload({
                where:data,
                page: {
                    curr: 1
                }
            });
            return false;
        });
        $('.add_img').click(function () {
            var demand_id=$(this).attr('data-id');
            layui.layer.open({
                title: "添加附件",
                type: 2,
                content: 'add_fujian.html?id=' + demand_id,
                area: ["420px", "380px"]
            })
        })
        //查看电话号码
        var off = true;
        $('#see_tel').click(function () {
            if (off) {
                off = false;
                $.ajax({
                    url: "<?php echo U('orders/phone');?>",
                    type: 'GET',
                    data: {'id': telID},
                    dataType: 'json',
                    success: function (res) {
                        layer.msg(res.phone, {
                            icon: 4,
                            time: 5000
                        }, function () {
                            off = true;
                        });
                    }
                })
            }
        })
        var cz_table = table.render({
            elem: '#hostry'
                , height: 312
            , url: "operator?&id=<?php echo ($res["id"]); ?>"
            , page: true
            , response: {
            statusCode: 200
        }
    , cols: [[
                {field: 'user_name', title: '操作人'}
                , {field: 'code', title: '工号'}
                , {field: 'controller_name', title: '操作类型'}
                , {field: 'content', title: '内容/备注'}
                , {field: 'creat_time', title: '操作时间'}
            ]]
        });
        layer.photos({
            photos: '.people_list_fj'
            , anim: 5
        });

        //提交备注
        form.on('submit(get_my_goin)', function(data){
            var datas = data.field;
            //方式二
            // var gd_id=<?php echo ($gd_id); ?>;
            // datas.gd_id;
            layer.confirm('是否提交备注信息?', {icon: 3, title:'提示'},function(){
                var index_o = layer.load();
                $.ajax({
                    url:'demand_gj.html',
                    type:'POST',
                    data:datas,
                    dataType:'json',
                    success:function(res){
                        layer.close(index_o);
                        layer.msg(res.msg);
                        if(res.code==200){
                            setTimeout(function(){
                                window.location.reload();
                            },500)
                        }
                    }
                })
            });
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
    })
    //标签填入文本区
    function fz(obj){
        var oText = $(obj).parent().next().find('textarea').val()
        var Text = $(obj).text();
        oText+=Text;
        $(obj).parent().next().find('textarea').val(oText);
    }

    function del_fj(obj) {
        var ids = $(obj).attr('data-id');
        layer.confirm('是否删除该附件?', {icon: 3, title: '提示'}, function (index) {
            var index_o = layer.load();
            $.ajax({
                url: 'delete_fujian.html',
                type: 'GET',
                data: {'id': ids},
                dataType: 'json',
                success: function (res) {
                    layer.msg(res.msg);
                    layer.close(index_o);
                    if (res.code == 200) {
                        setTimeout(function () {
                            location.reload()
                        }, 500)
                    }
                }
            })
        });
    }
</script>
</body>
</html>