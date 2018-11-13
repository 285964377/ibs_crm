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
		input[type="number"]{
				-moz-appearance: textfield;
		}
		.layui-view-body{
			background:#fff;
		}
		.layui-table{
			margin-top:0
		}
		.layui-table td, .layui-table th, .layui-table-col-set, .layui-table-fixed-r, .layui-table-grid-down, .layui-table-header, .layui-table-page, .layui-table-tips-main, .layui-table-tool, .layui-table-total, .layui-table-view, .layui-table[lay-skin=line], .layui-table[lay-skin=row]{
			border-width: 1px;
			border-style: solid;
			border-color: #c6d1d6;
		}
		.layui-table thead tr, .layui-table-click, .layui-table-header, .layui-table-hover, .layui-table-mend, .layui-table-patch, .layui-table-tool, .layui-table-total, .layui-table-total tr, .layui-table[lay-even] tr:nth-child(even){
			background: url(/Application/Home/Common/images/t_bck.png) repeat-x;
			background-size:100% 100%;
		}
		.layui-table td, .layui-table th{
			padding:0;
			text-align:center;
			line-height: 28px;
			font-size:12px;
			color:#000
		}
		.layui-form-item{
			clear:none;
		}
	.layui-form-mid {
			line-height: 12px;
		}
		.layui-form-label{
			width:auto;
		}
		.layui-table-view .layui-table{
			width:100%;
		}
		.my_fj_list img{
			width:100%;
			height:138px;
			cursor: pointer;
		}
		.my_fj_list li{
			margin-bottom:20px;	
		}
		.my_fj_list li>div{
			border:1px solid #eee;
			position:relative;
		}
		.my_fj_list p{
			font-size:12px;
			padding:10px 6px;
			background:#eff3f5;
			color:#000;
			overflow: hidden;
			text-overflow:ellipsis;
			white-space: nowrap;
		}
		.my_fj_list li>div span{
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
	</style>
<body class="layui-view-body">
	<div class="layui-content">
		<ul class="head_top_table">
			<li><p><span class="fwt">客户</span>：<span class="blue"><?php echo ($res["name"]); ?></span>( <?php echo ($cus["code"]); ?> )</p></li>
			<li><p><span class="fwt">商机</span>：<?php echo ($res["res_type"]); ?> ( <?php echo ($res["code"]); ?> )</p></li>
			<li><p><span class="fwt">状态</span>：<span class="yellow"><?php echo ($res["status"]); ?> </span></p></li>
			<li><p><span class="fwt">销售阶段</span>：<span class="yellow"><?php echo ($res["stage"]); ?></span></p></li>
			<li><p><span class="fwt">所属人</span>：<?php if($res['user_name']): echo ($res["user_name"]); ?>(<?php echo ($res["user_code"]); ?>)( <?php echo ($res["part_name"]); ?> )<?php else: ?>未分配<?php endif; ?></p></li>
			<li><p><span class="fwt">预计掉库时间</span>：<?php echo ($res["guess_out_time"]); ?></p></li>
			<li><p><span class="fwt">接收时间</span>：<?php if($res['allot_time']): echo ($res["allot_time"]); else: ?>未分配<?php endif; ?></p></li>
		</ul>
		<div class="my_style_table">
			<div class="head_top_table">
				<li><p><span class="fwt">基础信息</span><a style="margin-left:10px;" id="edit_base" href="javascript:;" class="layui-btn layui-btn-xs layui-btn-blue">编辑</a></p></li>
			</div>
			<ul class="my_style_table_body">
				<li class="layui-row">
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>客户名称：</span>
							<span><?php echo ($res["name"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>手机号码：</span>
							<?php if($res['tel']): ?><span><?php echo ($res["tel"]); ?></span>
								<a id="see_tel" class="layui-btn layui-btn-blue layui-btn-xs"
									style="position:relative;top:-2px;left:4px" data-tel="<?php echo ($res["phone"]); ?>" href="javascript:;">查看</a>
							<?php else: ?>
								<span><?php echo ($res["phone"]); ?></span><?php endif; ?>
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>身份证号码：</span>
							<span><?php echo ($cus["idcard"]); ?></span>
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>客户性别：</span>
							<span><?php echo ($cus["sex"]); ?></span>
						</p>	
					</div>
				</li>
				<li>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>客户年龄：</span>
							<span><?php echo ($cus["age"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>户口所在地：</span>
							<span><?php echo ($cus["huji"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>客户学历：</span>
							<span><?php echo ($cus["education"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>客户婚姻状况：</span>
							<span><?php echo ($cus["marriage"]); ?></span>
						</p>	
					</div>
				</li>
				<li>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>客户子女个数：</span>
							<span><?php echo ($cus["child"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>客户地址：</span>
							<span><?php echo ($cus["address"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>邮箱：</span>
							<span><?php echo ($cus["email"]); ?><span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>商机阶段：</span>
							<span><?php echo ($res["stage"]); ?></span>
						</p>	
					</div>
				</li>
				<li>
					
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>贷款金额（万）：</span>
							<span><?php echo ($res["dk_money"]); ?></span>
						</p>	
					</div>
					
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>关键词：</span>
							<span><?php if($res['key_word']): echo ($res["key_word"]); else: ?>暂无<?php endif; ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>URL：</span>
							<span><?php if($res['url']): echo ($res["url"]); else: ?>暂无<?php endif; ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>录入人：<?php echo ($res["creat_user"]); ?></span>
							<span></span>
						</p>	
					</div>
				</li>
			
				<li>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>商机类型：</span>
							<span><?php echo ($res["res_type"]); ?> <a href="javascript:;" id="edit_sjlxs"  class="layui-btn layui-btn-xs layui-btn-blue" style="position:relative;top:-2px">修改</a></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>商机来源：</span>
							<span><?php echo ($res["origin"]); ?> <a href="javascript:;" id="edit_sjlys" class="layui-btn layui-btn-xs layui-btn-blue" style="position:relative;top:-2px">修改</a></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>商机内部成本：</span>
							<span><?php echo ($res["cb_nei"]); ?> <a href="javascript:;" id="edit_nbcb" class="layui-btn layui-btn-xs layui-btn-blue" style="position:relative;top:-2px">修改</a></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>商机外部成本：</span>
							<span><?php echo ($res["cb_wai"]); ?> <a href="javascript:;" id="edit_wbcb" class="layui-btn layui-btn-xs layui-btn-blue" style="position:relative;top:-2px">修改</a></span>
						</p>	
					</div>
				
				</li>
				<li>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>商机创建时间：</span>
							<span><?php echo ($res["creat_time"]); ?></span>
						</p>	
					</div>
					
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>最新跟进时间：</span>
							<span><?php echo ($res["last_time"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>下次跟进时间：</span>
							<span><?php echo ($res["next_time"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>下次跟进阶段：</span>
							<span><?php echo ($res["next_step"]); ?></span>
						</p>	
					</div>
				</li>
				<li>
					<div class="layui-col-xs12 layui-col-sm12 layui-col-md12">
						<p>
							<span>备注：</span>
							<span><?php echo ($res["remark"]); ?></span>
						</p>	
					</div>
				</li>	
			</ul>
		</div>
		<div class="my_style_table">
			<div class="head_top_table">
				<li><p><span class="fwt">客户属性</span> <a style="margin-left:10px"  id="get_bj"  href="javascript:;" class="layui-btn layui-btn-blue layui-btn-xs">添加</a></p></li>
			</div>
			<ul class="my_style_table_body">
			
			<?php if(is_array($wealth)): $i = 0; $__LIST__ = $wealth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li class="layui-row">
					<div class="layui-col-xs1" style="text-align: right;padding-right:20px;">
						<p>
							<span><?php echo ($item["table"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs11"  style="text-align: left;padding-left:20px;position:relative;">
						<p>
							<span>
							<?php if(is_array($item["fields"])): $i = 0; $__LIST__ = $item["fields"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fields): $mod = ($i % 2 );++$i; if($fields['value']): echo ($fields["field_name"]); ?>：<?php echo ($fields["value"]); ?>；<?php endif; endforeach; endif; else: echo "" ;endif; ?>
							</span>
							<a href="javascript:;" class="layui-btn layui-btn-danger layui-btn-xs" onclick="del_sx(this)" style="position:absolute;right:20px;top:2px;" data-id="<?php echo ($item["gid"]); ?>">删除</a>
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
		<div class="my_style_table">
			<div class="head_top_table">
				<li><p><span class="fwt">客户意向</span><a style="margin-left:10px" onclick="yx()" href="javascript:;" class="layui-btn layui-btn-blue layui-btn-xs">添加</a></p></li>
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
				  <th>操作</th>
				</tr> 
			  </thead>
			  <tbody>
				<?php if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
					  <td><?php echo ($item["code"]); ?></td>
					  <td><?php echo ($item["type"]); ?></td>
					  <td><?php echo ($item["origin"]); ?></td>
					  <td><?php echo ($item["money_start"]); ?>~<?php echo ($item["money_end"]); ?>万元</td>
					  <td><?php echo ($item["ratio_start"]); ?>%~<?php echo ($item["ratio_end"]); ?>%(<?php echo ($item["ratio_type"]); ?>息)</td>
					  <td><?php echo ($item["dk_time_start"]); ?>~<?php echo ($item["dk_time_end"]); ?>（<?php echo ($item["dk_time_type"]); ?>）</td>
					  <td><?php echo ($item["loan_time_start"]); ?>~<?php echo ($item["loan_time_end"]); ?>（<?php echo ($item["loan_time_type"]); ?>）</td>
					  <td><?php echo ($item["age_start"]); ?>~<?php echo ($item["age_end"]); ?></td>
					  <td><?php echo ($item["jinjian"]); ?></td>
					  <td><a href="javascript:;" class="layui-btn layui-btn-danger layui-btn-xs" onclick="del_yx(this)" data-id="<?php echo ($item["gid"]); ?>">删除</a></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				<?php if(!$goods): ?><tr>
						<td style="border-right:none;"></td>
						<td style="border-right:none;border-left:none;"></td>
						<td style="border-right:none;border-left:none;"></td>
						<td style="border-right:none;border-left:none;"></td>
						<td style="border-right:none;border-left:none;text-align:right;padding-right:25px;">暂无</td>
						<td style="border-right:none;border-left:none;"></td>
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
		<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
		  <ul class="layui-tab-title">
			<li class="layui-this">历史记录</li>
			<li>联系人</li>
			<li>资料附件</li>
		  </ul>
		  <div class="layui-tab-content">
			  <!-- 历史记录 -->
			<div class="layui-tab-item layui-show">
				<div class="form-box">
						<div class="layui-form" action="">
							<div class="layui-form-item">
								<label class="layui-form-label">操作类型</label>
								<div class="layui-input-inline">
									<select  name="controler" id="cz_lx">
										<option value="0">所有</option>
										<option value="Resources/go_in">仅跟进</option>
									</select>
								</div>
								<div class="layui-input-inline">
									<input type="text" value="" class="layui-input" id="times" name=""/>
								</div>
								<button class="layui-btn layui-btn-blue search_btn " id="get_serch"><i class="layui-icon">&#xe615;</i>查询</button>
								<button class="layui-btn layui-btn-blue addBtn" id="red_goin"><i class="layui-icon">&#xe66f;</i>跟进</button>
							</div>	
							</div>
						</div>	
						<table id="hostry" lay-filter="hostry"></table>
				</div>
			<div class="layui-tab-item">
				<a href="javascript:;" class="layui-btn layui-btn-blue" id="add_lxr">添加</a>
				<table id="contacts" lay-filter="contacts"></table>
			</div>
			<div class="layui-tab-item">
				<a href="javascript:;" class="layui-btn layui-btn-blue" id="add_img" style="margin-bottom:10px;">添加</a>
				<ul class="my_fj_list layui-row layui-col-space30" style="" id="people_list_fj">
					<?php if(is_array($fujian)): $i = 0; $__LIST__ = $fujian;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li class="layui-col-md2 layui-col-xs4">
							<div>
								<img src="<?php echo ($item["url"]); ?>"  alt=""/>
								<p><?php echo ($item["title"]); ?></p>
								<span onclick="del_fj(this)" data-id="<?php echo ($item["gid"]); ?>"></span>
							</div>	
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
		  </div>
		</div>    
	</div>			
		
	<!-- 商机类型 -->
	<div id="sj_lx" style="display:none;">
		<div class="layui-form layui-row">
			<div class="layui-form-item sj_form ">
				<div class="layui-input-inline" style="margin-left:20px;">
					<input type="number" name="res_type_id" value="<?php echo ($res["res_type_id"]); ?>" id="get_lx" lay-filter="get_lx" required  lay-verify="required" placeholder="请选择商机类型" autocomplete="off" class="layui-input ">
				</div>
					<input type="hidden" value="<?php echo ($res["id"]); ?>"  name="id"/>
				<button class="layui-btn layui-btn-blue" style="float:left;" lay-submit lay-filter="edit_sjlx">修改</button>
			</div>
		</div>	
	</div>	
	<!-- 商机来源 -->	
	<div id="sj_ly" style="display:none;">
		<div class="layui-form layui-row">
			<div class="layui-form-item sj_form ">
				<div class="layui-input-inline" style="margin-left:20px;">
					<input type="number" name="origin_id"  value="<?php echo ($res["origin_id"]); ?>" id="get_ly" lay-filter="get_ly" required  lay-verify="required" placeholder="请选择商机来源" autocomplete="off" class="layui-input ">
				</div>
					<input type="hidden" value="<?php echo ($res["id"]); ?>"  name="id"/>
				<button class="layui-btn layui-btn-blue" style="float:left;" lay-submit lay-filter="edit_sjly">修改</button>
			</div>
		</div>	
	</div>
	<!-- 内部成本 -->
	<div id="sj_nbcb" style="display:none;">
		<div class="layui-form layui-row">
			<div class="layui-form-item sj_form ">
				<div class="layui-input-inline" style="margin-left:20px;">
					<input type="number" name="cb_nei" onkeyup="je(this)" value="<?php echo ($res["cb_nei"]); ?>"  required  lay-verify="required" placeholder="请输入内部成本" autocomplete="off" class="layui-input ">
				</div>
					<input type="hidden" value="<?php echo ($res["id"]); ?>"  name="id"/>
				<button class="layui-btn layui-btn-blue" style="float:left;" lay-submit lay-filter="edit_nei">修改</button>
			</div>
		</div>	
	</div>	
	<!-- 外部成本 -->
	<div id="sj_wbcb" style="display:none;">
		<div class="layui-form layui-row">
			<div class="layui-form-item sj_form ">
				<div class="layui-input-inline" style="margin-left:20px;">
					<input type="number" name="cb_wai" onkeyup="je(this)" value="<?php echo ($res["cb_wai"]); ?>" required  lay-verify="required" placeholder="请输入外部成本" autocomplete="off" class="layui-input ">
				</div>
					<input type="hidden" value="<?php echo ($res["id"]); ?>"  name="id"/>
				<button class="layui-btn layui-btn-blue" style="float:left;" lay-submit lay-filter="edit_wai">修改</button>
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
		<a href="javascript:;"  class='layui-btn layui-btn-danger layui-btn-xs' lay-event="del_lxr">删除</a>
	</script>
	<script>
		
		var tc_o,tc_t,tc_r,tc_f,add_box,Machine;
		var Ids = "<?php echo ($res["id"]); ?>";
		layui.config({
			base: path+'/modules/treeSelect/',
		})
		layui.use(['table','layer','jquery','form','element','treeSelect','laydate'],function(){
			var table = layui.table,layer= layui.layer,form = layui.form,$ = layui.jquery,laypage = layui.laypage,element = layui.element,treeSelect=layui.treeSelect,laydate=layui.laydate;
			 laydate.render({
				elem: '#times',
				range:'~',
				type:'datetime'
			});
			$('.search_btn').click(function(){
				var times = $('#times').val().split('~');
				data= {'controler':$("#cz_lx").val(),'time_start':times[0],'time_end':times[1]};
				cz_table.reload({
					where:data,
					page: {
						curr: 1 
					}
				});
			})
			//查看电话号码
			var off = true;
			$('#see_tel').click(function () {
					var that = this;
					if (off) {
							off = false;
							var Tel=$(that).attr('data-tel');
							layer.msg(Tel, {
									icon: 4,
									time: 5000
							}, function () {
									off = true;
							});
							/* $.ajax({
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
							}) */
					}
			})
		var cz_table  = 	table.render({
				elem: '#hostry'
				,height: 312
				,url: "details?op_log=1&id=<?php echo ($res["id"]); ?>"
				,page: true 
				,response: {
					  statusCode: 200
				  }
				,cols: [[ 
				  {field: 'name', title: '操作人'}
				  ,{field: 'code', title: '工号'}
				  ,{field: 'controler', title: '操作类型'}
				  ,{field: 'content', title: '内容/备注'} 
				  ,{field: 'creat_time', title: '操作时间'}
				]]
			});
			layer.photos({
				photos: '#people_list_fj'
				,anim: 5
			}); 
			var lxr_table = table.render({
				elem: '#contacts'
				,height: 312
				,url: "details?contacts=1&id=<?php echo ($res["id"]); ?>"
				,page: true 
				,response: {
					  statusCode: 200
				  }
				,cols: [[ 
				  {field: 'name', title: '联系人'}
				  ,{field: 'tel', title: '电话'}
				  ,{field: 'type', title: '联系人类型'}
				  ,{field: 'ship', title: '与客户关系'}
				  ,{field: 'job', title: '工作'} 
				  ,{field: 'address', title: '住址'}
					,{title:'操作',toolbar:'#cz_lxr',width:100,fixed:'right'}
				]]
			});
			table.on('tool(contacts)', function(obj){
				  var data = obj.data; 
					var layEvent = obj.event;
					if(layEvent === 'del_lxr'){
						layer.confirm('是否删除该联系人?', {icon: 3, title:'提示'},function(index){
							var index_o = layer.load();
							$.ajax({
								url:'delete_contact.html',
								type:'POST',
								data:{'gid':data.gid},
								dataType:'json',
								success:function(res){
										layer.msg(res.msg);
										layer.close(index_o);
										if(res.code==200){
											setTimeout(function(){
												lxr_table.reload()
											},500)
									}
								}
							})
						});  
					}
			})
			$('#red_goin').click(function(){
				layui.layer.open({
						title : "跟进",	
						type :2,
						content:'go_in.html?id='+Ids,
						area:["96%","96%"]
					})
			})
			$('#edit_nbcb').click(function(){
				tc_r=layui.layer.open({
						title : "编辑商机内部成本",	
						type :1,
						content :$('#sj_nbcb'),
						area:["300px",'100px']
					})
			})
			$('#edit_wbcb').click(function(){
				tc_f=layui.layer.open({
						title : "编辑商机外部成本",
						type :1,
						content :$('#sj_wbcb'),
						area:["300px",'100px']
					})
			})
			$('#edit_base').click(function(){
				layui.layer.open({
						title : "编辑基础信息",
						type :2,
						content :'edit.html?id='+Ids,
						area:["70%","80%"]
					})
			})
			$('#edit_sjlxs').click(function(){
			tc_o=layui.layer.open({
						title : "修改商机类型",
						type :1,
						content :$('#sj_lx'),
						area:["360px",'300px'],
						success:function(layero, index){
							treeSelect.render({
										// 选择器
										elem: '#get_lx',
										// 数据
										data: "<?php echo U('Back/select_restype');?>",
										// 异步加载方式：get/post，默认get
										type: 'get',
										// 占位符
										placeholder: '选择商机类型',
										search: false,
										// 点击回调
										click: function(d){
												$('#get_lx').val(d.current.id);
										},
										// 加载完成后的回调函数
										success: function (d) {
												treeSelect.checkNode('get_lx', <?php echo ($res["res_type_id"]); ?>);
										}
								});
						}
					})
			})
			$('#edit_sjlys').click(function(){
				tc_t=layui.layer.open({
						title : "修改商机来源",
						type :1,
						content :$('#sj_ly'),
						area:["360px",'300px'],
						success:function(layero, index){
							treeSelect.render({
										// 选择器
										elem: '#get_ly',
										// 数据
										data:"<?php echo U('Back/select_origin');?>",
										// 异步加载方式：get/post，默认get
										type:'get',
										// 占位符
										placeholder: '选择商机来源',
										search: false,
										// 点击回调
										click: function(d){
												$('#get_ly').val(d.current.id);
										},
										// 加载完成后的回调函数
										success: function (d) {
												treeSelect.checkNode('get_ly', <?php echo ($res["origin_id"]); ?>);
										}
								});
						}
					})
			})
		form.on('submit(edit_sjlx)',function(data){
			var data=data.field;
			var index_o = layer.load();
			$.ajax({
				url:'change_type.html',
				type:'POST',
				data:data,
				dataType:'json',
				success:function(res){
						layer.msg(res.msg);
						layer.close(index_o);
						if(res.code==200){
							setTimeout(function(){
								layer.close(tc_o);
								location.reload()
							},500)
					}
				}
			})
			return false;
		})
		
		form.on('submit(edit_sjly)',function(data){
			var data=data.field;
			var index_o = layer.load();
			$.ajax({
				url:'change_orgin.html',
				type:'POST',
				data:data,
				dataType:'json',
				success:function(res){
						layer.msg(res.msg);
						layer.close(index_o);
						if(res.code==200){
							setTimeout(function(){
								layer.close(tc_t);
								location.reload()
							},500)
					}
				}
			})
			return false;
		})
		
		form.on('submit(edit_nei)',function(data){
			var data=data.field;
			var index_o = layer.load();
			$.ajax({
				url:'change_cb_nei.html',
				type:'POST',
				data:data,
				dataType:'json',
				success:function(res){
						layer.msg(res.msg);
						layer.close(index_o);
						if(res.code==200){
							setTimeout(function(){
								layer.close(tc_r);
								location.reload()
							},500)
					}
				}
			})
			return false;
		})
		
		form.on('submit(edit_wai)',function(data){
			var data=data.field;
			var index_o = layer.load();
			$.ajax({
				url:'change_cb_wai.html',
				type:'POST',
				data:data,
				dataType:'json',
				success:function(res){
						layer.msg(res.msg);
						layer.close(index_o);
						if(res.code==200){
							setTimeout(function(){
								layer.close(tc_f);
								location.reload()
							},500)
					}
				}
			})
			return false;
		})
		$('#get_bj').click(function(){
			add_box= 	layui.layer.open({
					title : "添加属性",
					type : 2,
					content :'add_wealth.html?id='+Ids,
					area:["96%","96%"]
				})
		})
		//添加联系人
		$('#add_lxr').click(function(){
				layui.layer.open({
					title :"添加联系人",
					type : 2,
					content :'add_contact.html?id='+Ids,
					area:["420px","380px"]
				})
		})
		$('#add_img').click(function(){
			layui.layer.open({
				title :"添加附件",
				type : 2,
				content :'add_fujian.html?id='+Ids,
				area:["420px","380px"]
			})
		})
	});
	function del_sx(obj){
		var ids = $(obj).attr('data-id');
		layer.confirm('是否删除该属性?', {icon: 3, title:'提示'},function(index){
			var index_o = layer.load();
			$.ajax({
				url:'delete_wealth.html',
				type:'POST',
				data:{'gid':ids},
				dataType:'json',
				success:function(res){
						layer.msg(res.msg);
						layer.close(index_o);
						if(res.code==200){
							setTimeout(function(){
								location.reload()
							},500)
					}
				}
			})
		});    
	}
	function yx(){
		layui.use(['table','layer','jquery','form','element','treeSelect'],function(){
			var table = layui.table,layer= layui.layer,form = layui.form,$ = layui.jquery,laypage = layui.laypage,element = layui.element,treeSelect=layui.treeSelect;
			add_box= 	layui.layer.open({
					title : "添加客户意向",
					type : 2,
					content :'add_goods.html?index=1&id='+Ids,
					area:["96%","96%"]
				})
		})		
	}
	function del_yx(obj){
		var ids = $(obj).attr('data-id');
		layer.confirm('是否删除该产品?', {icon: 3, title:'提示'},function(index){
			var index_o = layer.load();
			$.ajax({
				url:'delete_goods.html',
				type:'POST',
				data:{'gid':ids},
				dataType:'json',
				success:function(res){
						layer.msg(res.msg);
						layer.close(index_o);
						if(res.code==200){
							setTimeout(function(){
								location.reload()
							},500)
					}
				}
			})
		});    
	}
	function del_fj(obj){
		var ids = $(obj).attr('data-id');
		layer.confirm('是否删除该附件?', {icon: 3, title:'提示'},function(index){
			var index_o = layer.load();
			$.ajax({
				url:'delete_fujian.html',
				type:'POST',
				data:{'gid':ids},
				dataType:'json',
				success:function(res){
						layer.msg(res.msg);
						layer.close(index_o);
						if(res.code==200){
							setTimeout(function(){
								location.reload()
							},500)
					}
				}
			})
		});    
	}
	</script>
</body> 
</html>