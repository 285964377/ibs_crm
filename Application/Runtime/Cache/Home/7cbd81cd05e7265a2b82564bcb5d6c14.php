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
			background: url(/Application/Home/Common/images/del.png) no-repeat;
			background-size: 100% 100%;
			position: absolute;
			right: -18px;
			top: -15px;
		}
		.my_box_input input{
			text-align:center;
			border:none;
			padding-left:0;
		}
		.my_box_input .layui-form-select .layui-input {
			padding-right:0;
		}
		.layui-form-item .layui-input-inline{
			width:auto;
		}
		.user_input .my_input{
			display: inline-block;
			width:41%;
		}
		.user_input .layui-form-select{
			    width: 70px;
			display: inline-block;
		}
		.user_input .layui-form-item .layui-input-inline{
			width:264px;
		}
		.user_input .my_input_sec{
			width: 88px;
			display: inline;
		}
	</style>
<body class="layui-view-body">
	<div class="layui-content">
		<div class="my_style_table">
			<div class="head_top_table">
				<li>
					<p>
					<span class="fwt">基本信息</span>：<span class="blue"><?php echo ($res["name"]); ?></span>( <?php echo ($cus["code"]); ?> )
					<span style="margin-left:10px;" class="fwt" id="edit_base" href="javascript:;">签单时间：<span style="color:#FF5722"><?php echo ($res["over_time"]); ?></span></span>
					<span style="margin-left:10px;" class="fwt" id="edit_base" href="javascript:;">下单时间：<span style="color:#FF5722"><?php echo ($order["creat_time"]); ?></span></span>
					<span style="margin-left:10px;" class="fwt" id="edit_base" href="javascript:;">订单编号：<span style="color:#FF5722"><?php echo ($order["code"]); ?></span></span>
				</p>
				</li>
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
								<span data-tel="<?php echo ($res["phone"]); ?>">查看</span>
							<?php else: ?>
								<span><?php echo ($res["phone"]); ?></span><?php endif; ?>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>身份证号码：</span>
							<span><?php echo ($cus["idcard"]); ?></span>
						</p>	
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
							<span>签单人：<?php echo ($res["user_name"]); ?>（<?php echo ($res["user_code"]); ?>）</span>
							<span></span>
						</p>	
					</div>
				</li>
				<li>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>商机类型：</span>
							<span><?php echo ($res["res_type"]); ?> </span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>商机来源：</span>
							<span><?php echo ($res["origin"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>贷款金额（万）：</span>
							<span><?php echo ($res["dk_money"]); ?></span>
						</p>	
					</div>
					
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
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
				<li><p><span class="fwt">客户属性</span></p></li>
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
						<td style="border-left:none;"></td>
					</tr><?php endif; ?>
			  </tbody>
			</table>
		</div>	
		<div class="my_style_table">
			<form class="layui-form" enctype="multipart/form-data" id="fj_form" lay-filter="car_form">
				<ul class="head_top_table">
					<li><p>合同信息</p></li>
				
				</ul>
				<ul class="my_style_table_body">
				<li class="layui-row">
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
						<p>
							<span>合同编号：</span>
							<span><?php echo ($order["contract"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
						<p>
							<span>贷款金额：</span>
							<span><?php echo ($order["dk_money"]); ?>万</span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
						<p>
							<span>贷款时长：</span>
							<span><?php echo ($order["dk_time"]); echo ($order["dk_time_type"]); ?></span>
						</p>	
					</div>
				</li>
				<li>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
						<p>
							<span>贷款利率：</span>
							<span><?php echo ($order["dk_ratio"]); ?>%<?php echo ($order["dk_ratio_type"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
						<p>
							<span>定金：</span>
							<span><?php echo ($order["ding_money"]); ?>元</span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
						<p>
							<span>服务费：</span>
							<span><?php echo ($order["fuwu_money"]); ?>%</span>
						</p>	
					</div>
				</li>
			</ul>
				
			<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
				<div class="layui-form-item layui-col-sm12">
					<label class="layui-form-label">合同文件</label>
					<div class="layui-form-item layui-col-sm12"  id="imgs" style="position:relative;width:120px;height:122px;left:20px;">
							<img style="width:100%;height:100%;" src="/<?php echo ($order["contract_img"]); ?>">
					</div>
				</div>
			</div>
			<div class="layui-form-item sj_form layui-col-md9 layui-col-xs12">
				<div class="layui-form-item layui-col-sm12">
					<label class="layui-form-label">附件</label>
					<ul class="my_fj_list layui-row layui-col-space30" style="" id="people_list_fj">
					<?php if(is_array($fujian)): $i = 0; $__LIST__ = $fujian;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li class="layui-col-xs3">
							<div  class="img_fj">
								<img src="<?php echo ($item["url"]); ?>"  alt=""/>
								<p style="text-align: center;"><?php echo ($item["title"]); ?></p>
							</div>	
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				</div>
			</div>
				<div style="clear:both"></div>
				<div class="head_top_table" style="margin-top:10px;">
					<li><p><span class="fwt">借贷人</span></p></li>
				</div>
				<table class="layui-table">
				  <thead>
					<tr>
					  <th>身份</th>
					  <th>姓名</th>
					  <th>身份证号码</th>
					  <th>联系电话</th>
					  <th>婚姻状况</th>
					  <th>子女情况</th>
					  <th>家属是否知晓</th>
					  <th>与主借贷人关系</th>
					  <th>是否是客户本人</th>
					</tr> 
				  </thead>
				  <tbody class="my_box_input">
				  <?php if(is_array($borrow)): $i = 0; $__LIST__ = $borrow;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
							<td>
							<?php if($item['type'] == 1): ?><input class="layui-input" disabled value="主借贷人"  />
							<?php else: ?>
								<input class="layui-input" disabled value="次借贷人"  /><?php endif; ?>
							</td>
							<td><input class="layui-input" disabled value="<?php echo ($item["name"]); ?>" /></td>
							<td><input class="layui-input" disabled value="<?php echo ($item["id_number"]); ?>"  /></td>
							<td><input class="layui-input" disabled value="<?php echo ($item["tel"]); ?>"  /></td>
							<td><input class="layui-input" disabled value="<?php echo ($item["marriage"]); ?>"  /></td>
							<td><input class="layui-input" disabled value="<?php echo ($item["child"]); ?>"  /></td>
							<td><input class="layui-input" disabled value="<?php echo ($item["family"]); ?>"  /></td>
							<td><input class="layui-input" disabled value="<?php echo ($item["ships"]); ?>"  /></td>
							<td><input class="layui-input" disabled value="<?php echo ($item["is_self"]); ?>"  /></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				  </tbody>
				</table>
			</form>	
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
<script>
	layui.use('layer', function(){
		var layer = layui.layer;
		layer.photos({
			photos: '#imgs'
			,anim: 5 
		}); 
		layer.photos({
			photos:'.img_fj'
			,anim: 5 
		}); 
	});   
</script>
</body> 
</html>