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

<body class="layui-view-body">
	<style>
		.layui-form-label{
			width:auto;
		}
		.form-box{
			padding:0
		}
		.layui-table, .layui-table-view{
			margin-top:0;
		}
		.layui-treeSelect .ztree li span.button.switch{
			position: relative;
			top:-7px;
		}
		.head_bg_list li{
			height:300px;
		}
		#base_one{
				box-shadow: 20px 20px 20px #eee;
				height:340px;
				background: #fff;
				margin-bottom:40px;
			}
			.base_one_list li{
				height:112px;
			}
			#base_one_y{
				height:340px;
			}
			.base_title{
				font-size:16px;
				color:#2b3245;
				padding-left:12px;
				border-left:4px solid #03a9f4;
				margin:20px 0;
				font-weight:bold;
				margin-bottom:30px;
			}
			#base_one_r div{
				width:100%;
				border-radius:8px;
				height:308px;
				background:url(images/base_get.png) no-repeat;
				background-size:100% 100%;
				box-shadow: -10px 8px 14px #ccc;
				position:relative;
				overflow: hidden;
			}
			.titel_img{
				display: block;
				position: absolute;
				left:0;
				top:25px;
				width:153px;
				height:45px;
				background:url(images/titles.png) no-repeat;
				background-size:100% 100%;
			}
			.base_sj_list{
				width:280px;
				margin:0 auto;
				margin-top:60px;
			}
			.base_sj_list li{
				width:50%;
				float:left;
				text-align:center;
				color:#fff;
			}
			.base_sj_list li h2{
				font-size:36px;
				margin-top:38px;
			}
			.base_sj_list li p{
				font-size:12px;
			}
			.base_db>div{
				width:100%;
				height:38px;
				line-height:38px;
				background:#dee3f0;
			}
			.base_db>div h3{
				display:inline-block;
				float:left;
				margin-left:18px;
				font-size:14px;
			}
			.base_db>div h3 span{
				display:inline-block;
				margin-left:6px;
				padding:2px 8px;
				background:#f08f90;
				line-height: normal;
				border-radius:50%;
				color:#fff;
			}
			.base_db>div a{
				float:right;
				margin-right:20px;
				margin-top:22px;
			}
			.base_110{
				width:100%;
				background: #fff;
				height:118px;
				overflow:hidden;
				
			}
			.base_110 li{
				width:49%;
				text-align:center;
				float:left;	
				border-right:1px solid #e0e7ed;
				margin-top:30px;
				padding-bottom:4px;
				cursor: pointer;
			}
			.base_110 li:nth-last-of-type(1){
				border:none;
			}
			.base_110 li h3{
				margin-top:6px;
				font-size:26px;
			}
			.base_110 li p{
				margin-top:6px;
				font-size:12px;
				color:#999;
			}
			.msg_list_get{
				background:#fff;
				padding:0 20px;
			}
			.msg_list_get li{
				cursor: pointer;
				line-height:50px;
				color:#666666;
				font-size:12px;
				border-bottom:1px solid #eff3f5;
				overflow:hidden;
			}
			.msg_list_get li span:nth-of-type(1){
				float:left;
			}
			.msg_list_get li span:nth-of-type(2){
				float:right;
			}
			.zw_box li{
				width:100%;
				height:226px;
				background:#fff;
				padding-bottom:16px;
			}
			.no_title{
				color:#666666;
				font-size:12px;
				padding-top:17px;
				border-top:1px solid #eee;
				padding-left:20px;
				background:#fff;
				padding-bottom:23px;
			}
			.no_title span{
				color:#e80010;
			}
			.layui-table-view .layui-table{
				text-align: center;
			}
			
			.hot_list{
				border:1px solid #a1adcf;
				border-radius:4px;
			}
			.hot_list li{
				overflow: hidden;
				background: #a1adcf;
				border-bottom:1px solid #eee;
				color:#fff;
			}	
			.hot_list li:nth-of-type(2n){
				background: #dee3f0;

			}
			.hot_text{
				width:33.3%;
				float:left;
				text-align:center;
				font-size:14px;
				padding:6px 0;
			}
	</style>
	<div class="layui-content layui-row">
	    <div class="layui-fluid"> 
			<div class="layui-row"  style="background:none;">
				<div class="layui-col-md12  layui-col-space30">
					<li class="layui-col-lg4 layui-col-md6" style="margin-bottom:20px;"> 
						<h2 class="base_title" style="margin-top:20px;margin-bottom:20px;">数据报警</h2>
						<ul class="base_110">
							<li onclick="dk(this)" data-href="<?php echo U('Resources/ing');?>?index=1">
								<h3 style="color:#03a9f4;" ><?php echo ($out_worning["today"]); ?></h3>
								<p>今日即将掉库</p>
							</li>
							<li onclick="dk(this)" data-href="<?php echo U('Resources/ing');?>?index=1">
								<h3 style="color:#20c7a9;"><?php echo ($out_worning["tomarrow"]); ?></h3>
								<p>明日即将掉库</p>
							</li>
						</ul>
					</li>	
					<li class="layui-col-lg4 layui-col-md6" style="margin-bottom:20px;"> 
						<h2 class="base_title" style="margin-top:20px;margin-bottom:20px;">我的业绩（合计：<span class="money_span"></span>元）</h2>
						<div class="layui-form">
							<div class="my_form_box" style="display:inline-block;margin-right:10px;">	
								<label class="layui-form-label">时间：</label>
								<div class="layui-input-inline">
									<input type="text" name="creat_time"  id="creat_time" placeholder="选择时间" autocomplete="off" class="layui-input">
								</div>
							</div>
							<button class="layui-btn layui-btn-blue" lay-submit lay-filter="get_search"><i class="layui-icon">&#xe615;</i>查询</button>
						</div>	
						<table id="creat_time_table" style="margin-top:10px;" lay-filter="creat_time_table"></table>
					</li>	
					<li class="layui-col-lg4 layui-col-md12" style="margin-bottom:20px;"> 
						<h2 class="base_title" style="margin-top:20px;margin-bottom:20px;">当月业绩排名</h2>
						<ul class="hot_list">
						<?php if(is_array($yj_order)): $i = 0; $__LIST__ = $yj_order;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li>
								<h2 class="hot_text"><?php echo ($key+1); ?></h2>
								<h3 class="hot_text"><?php echo ($item["user"]); ?></h3>
								<h4 class="hot_text"><?php echo ($item["money"]); ?>元</h4>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</li>	
					<li class="layui-row layui-col-space20">
						<div class="layui-col-md6" >
							<h2 class="base_title" style="margin-top:0px;margin-bottom:20px;">系统公告</h2>
							<!--消息列表-->
							<table id="xt_gg"  lay-filter="xt_gg"></table>
						</div>
						<div class="layui-col-md6">
							<h2 class="base_title" style="margin-top:0px;margin-bottom:20px;">消息通知</h2>
							<!--消息列表-->
							<table id="msg_tz" lay-filter="msg_tz"></table>
						</div>
					</li>
					<li class="layui-row layui-col-space20"> 
						<div class="layui-col-md12  layui-col-space20">
							<h2 class="base_title" style="margin-bottom:0;margin:10px 0;padding:0;padding-left:12px;margin-left:10px;">数据分布</h2>
							<?php if(in_array('count/res_step',$count_power)): ?><div class="layui-col-md6  layui-col-xs12  base_db" style="box-shadow:none;">
								<div>
									<h3 style="color:#2b3245;">商机状态分布</h3>
									</div>
								<ul class="zw_box" style="background: #fff;">
									<li id="res_step"  style="background: #fff;">
									</li>
								</ul>
							</div><?php endif; ?>
							<?php if(in_array('count/res_next',$count_power)): ?><div class="layui-col-md6  layui-col-xs12  base_db" style="box-shadow:none;">
								<div style="background: #a1adcf;">
									<h3 style="color:#fff;">今日待跟进分布</h3>
									</div>
								<ul class="zw_box" style="background: #fff;">
									<li id="res_next"  style="background: #fff;">
									</li>
								</ul>
							</div><?php endif; ?>
							<?php if(in_array('count/res_type',$count_power)): ?><div class="layui-col-md6  layui-col-xs12  base_db" style="box-shadow:none;">
								<div>
									<h3 style="color:#2b3245">贷款类型分布</h3>
								</div>
								<ul class="zw_box" style="background: #fff;">
									<li id="res_type" style="background: #fff;">
									</li>
								</ul>
							</div><?php endif; ?>
							<?php if(in_array('count/res_regin',$count_power)): ?><div class="layui-col-md6  layui-col-xs12 base_db" style="box-shadow:none;">
								<div style="background: #a1adcf;">
									<h3 style="color:#fff;">商机来源分布</h3>
									</div>
								<ul class="zw_box" style="background: #fff;">
									<li id="res_regin"  style="background: #fff;">
									</li>
								</ul>
							</div><?php endif; ?>
							
							<?php if(in_array('count/order_status',$count_power)): ?><div class="layui-col-md6  layui-col-xs12 base_db" style="box-shadow:none;">
								<div style="background: #a1adcf;">
									<h3 style="color:#fff;">订单状态分布</h3>
									</div>
								<ul class="zw_box" style="background: #fff;">
									<li id="order_status"  style="background: #fff;">
									</li>
								</ul>
							</div><?php endif; ?>
							<?php if(in_array('count/demand_status',$count_power)): ?><div class="layui-col-md6  layui-col-xs12  base_db" style="box-shadow:none;">
								<div>
									<h3 style="color:#2b3245">工单状态分布</h3>
								</div>
								<ul class="zw_box" style="background: #fff;">
									<li id="demand_status" style="background: #fff;">
									</li>
								</ul>
							</div><?php endif; ?>
							
							<?php if(in_array('count/demand_step',$count_power)): ?><div class="layui-col-md6  layui-col-xs12 base_db" style="box-shadow:none;">
								<div style="background: #a1adcf;">
									<h3 style="color:#fff;">工单进度分布</h3>
									</div>
								<ul class="zw_box" style="background: #fff;">
									<li id="demand_step"  style="background: #fff;">
									</li>
								</ul>
							</div><?php endif; ?>
						</div>
					</li>
				
				</ul>
				<div class="layui-col-md3"></div>
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
	<script type="text/html" id="my_status">
		{{# if(d.status=='1'){  }}
			<a class="" style="cursor:pointer;color:#ccc" lay-event="get_link">{{d.title}}</a>
		{{# }else{  }}
			<span class="layui-badge-dot"></span> <a class="" style="cursor:pointer;" lay-event="get_link">{{d.title}}</a>
		{{# }}}
	</script>
	<script type="text/html" id="artice_title">
		<a class="" style="cursor:pointer;color:#1E9FFF" lay-event="get_link">{{d.title}}</a>
	</script>
	<script src="/Application/Home/Common/app/echarts.simple.min.js"></script>
	<script>
		layui.config({
			base: '/Application/Home/Common/app/'
		}).use(['form','table','layer','laydate','form'],function(){
			var table = layui.table;
			var layer= layui.layer;
			var laydate = layui.laydate;
			var form = layui.form;
							form.on('submit(get_search)', function(data){
								data=data.field;
								if($('#creat_time').val()){
									var Nlast = data.creat_time.split('~');
									data.creat_time_start=Nlast[0];
									data.creat_time_end=Nlast[1];
								}
								delete data.creat_time;
								creats_time_table.reload({
										where:data,
										page: {
											curr: 1 
										}
									});
								return false; 
							});
							laydate.render({
								elem: '#creat_time',
								range:'~',
								type:'datetime'
							});
							table.render({
								elem: '#xt_gg'
								,url: 'get_article.html' //数据接口
								,page: true //开启分页
								,response:{
									statusCode: 200
								}
								,cols: [[ //表头
									{templet:'#artice_title',title:'标题'}
									,{field: 'creat_time', title:'时间'}
								]]
							});
							var msg_table =  table.render({
								elem: '#msg_tz'
								,url: 'get_msg.html' //数据接口
								,page: true //开启分页
								,response:{
									statusCode: 200
								}
								,cols: [[ //表头
									{templet:'#my_status', title: '标题'}
									,{field: 'creat_time', title:'时间'}
								]]
							});
							var creats_time_table = table.render({
									elem: '#creat_time_table'
									,url: 'my_yj.html?search_data=1' //数据接口
									,page: true //开启分页
									,limit:5
									,limits:[5,10]
									,response:{
										statusCode: 200
									}
									,cols: [[ //表头
										{field:'money', title: '金额'}
										,{field: 'creat_time', title:'时间'}
									]],
									done:function(){
										var datas={};
										if($('#creat_time').val()){
											var Nlast =$('#creat_time').val().split('~');
											datas.creat_time_start=Nlast[0];
											datas.creat_time_end=Nlast[1];
										}
										$.ajax({
											url:'my_yj.html?count=1',
											type:'get',
											data:datas,
											dataType:'json',
											success:function(res){
												$('.money_span').text(res.data);
											}
										})
									}
							});
							table.on('tool(xt_gg)', function(obj){
								var data = obj.data; 
								var layEvent = obj.event; 
								if(layEvent === 'get_link'){
									layer.open({
										type:2,
										content: 'article_details.html?id='+data.id,
										area:['800px','600px']
									});   
								} 
							})
							table.on('tool(msg_tz)', function(obj){
							var data = obj.data; 
							var layEvent = obj.event; 
							if(layEvent === 'get_link'){
								layer.open({
									type:2,
									content: 'msg_details.html?id='+data.id,
									area:['800px','600px'],
									cancel:function(){
										msg_table.reload();
									}
								});   
								} 
							})
						})		
						
					//掉库
					
					function dk(obj){
						var that = obj;
						layui.use(['table','layer','laydate','form'], function(){
							var Urls ="<?php echo U('Resources/ing');?>?index=1";
							get_url(that,Urls,Urls,'跟进中')		
							sessionStorage.setItem('going',true);
						})	
					}
					
	</script>
	<script type="text/javascript">
		//实例化
		<?php if(in_array('count/res_type',$count_power)){?>
			var my_res_type = echarts.init(document.getElementById('res_type')); //商机分类
		<?php }?>
		<?php if(in_array('count/res_regin',$count_power)){?>
			var my_res_regin = echarts.init(document.getElementById('res_regin')); //商机来源
		<?php }?>
		<?php if(in_array('count/res_step',$count_power)){?>
			var my_res_step = echarts.init(document.getElementById('res_step')); //商机状态
		<?php }?>
		<?php if(in_array('count/res_next',$count_power)){?>
			var my_res_next = echarts.init(document.getElementById('res_next')); //待跟进
		<?php }?>
		<?php if(in_array('count/order_status',$count_power)){?>
			var my_order_status = echarts.init(document.getElementById('order_status')); //订单状态
		<?php }?>
		<?php if(in_array('count/demand_status',$count_power)){?>
			var my_demand_status = echarts.init(document.getElementById('demand_status')); //工单状态
		<?php }?>
		<?php if(in_array('count/demand_step',$count_power)){?>
			var my_demand_step = echarts.init(document.getElementById('demand_step')); //工单进度
		<?php }?>
		
		//商机来源分布配置项
			res_type = {
				series : [
				  {
					type: 'pie',
					data:[
						<?php echo ($res_type); ?>
					]
				  }
				]
			};	
			res_regin = {
				series : [
					{
						type: 'pie',
						data:[
							<?php echo ($res_regin); ?>
						],
					}
				]
			};	
			res_step = {
				series : [
					{
						type: 'pie',
						data:[
							<?php echo ($res_step); ?>
						],
					}
				]
			};
			res_next = {
				series : [
					{
						type: 'pie',
						data:[
							<?php echo ($res_next); ?>
						],
					}
				]
			};
			order_status = {
				series : [
					{
						type: 'pie',
						data:[
							<?php echo ($order_status); ?>
						],
					}
				]
			};
			demand_status = {
				series : [
					{
						type: 'pie',
						data:[
							<?php echo ($demand_status); ?>
						],
					}
				]
			};
			demand_step = {
				series : [
					{
						type: 'pie',
						data:[
							<?php echo ($demand_step); ?>
						],
					}
				]
			};
			//自适应屏幕大小
			window.addEventListener("resize", function(){ 
					<?php if(in_array('count/res_type',$count_power)){?>
						my_res_type.resize();   //商机分类
					<?php }?>
					<?php if(in_array('count/res_regin',$count_power)){?>
						var my_res_regin = echarts.init(document.getElementById('res_regin')); //商机来源
					<?php }?>
					<?php if(in_array('count/res_step',$count_power)){?>
						my_res_step.resize(); //商机状态
					<?php }?>
					<?php if(in_array('count/res_next',$count_power)){?>
						my_res_next.resize(); //待跟进
					<?php }?>
					<?php if(in_array('count/order_status',$count_power)){?>
						my_order_status.resize(); //订单状态
					<?php }?>
					<?php if(in_array('count/demand_status',$count_power)){?>
						my_demand_status.resize(); //工单状态
					<?php }?>
					<?php if(in_array('count/demand_step',$count_power)){?>
						my_demand_step.resize(); //工单进度
					<?php }?>
			});
			
			//加载配置
			<?php if(in_array('count/res_type',$count_power)){?>
					my_res_type.setOption(res_type);   //商机分类
			<?php }?>
			<?php if(in_array('count/res_regin',$count_power)){?>
					my_res_regin.setOption(res_regin); //商机来源
			<?php }?>
			<?php if(in_array('count/res_step',$count_power)){?>
				    my_res_step.setOption(res_step); //商机状态
					my_res_step.on('click',function(params){
					var that = this;
					layui.use(['table','layer','laydate','form'], function(){
						var my_name = params.data.name.replace(/([^)]*)/g,"");
							if(my_name=='掉库'){
								var Urls ="{:U('Resources/out')}?index=1";
								get_url(that,Urls,Urls,'事业部库');		
							}
							if(my_name=='跟进中'){
								var Urls ="<?php echo U('Resources/ing');?>?index=1";
								get_url(that,Urls,Urls,'跟进中');		
							}
							if(my_name=='已签单'){
								var Urls ="<?php echo U('Resources/over');?>?index=1";
								get_url(that,Urls,Urls,'已签单');		
							}
							if(my_name=='审核被拒'){
								var Urls ="<?php echo U('Resources/checked');?>?index=1";
								get_url(that,Urls,Urls,'审核被拒');		
							}
							if(my_name=='白名单'){
								var Urls ="<?php echo U('Resources/white');?>?index=1";
								get_url(that,Urls,Urls,'白名单');		
							}
					})	
				})
			<?php }?>
			<?php if(in_array('count/res_next',$count_power)){?>
				    my_res_next.setOption(res_next); //待跟进
			<?php }?>
			<?php if(in_array('count/order_status',$count_power)){?>
				    my_order_status.setOption(order_status);//订单状态
			<?php }?>
			<?php if(in_array('count/demand_status',$count_power)){?>
					my_demand_status.setOption(demand_status); //工单状态
			<?php }?>
			<?php if(in_array('count/demand_step',$count_power)){?>
					my_demand_step.setOption(demand_step);//工单进度
			<?php }?>
			
			
			
			
			
			
			
			
			
	</script>
</body>
</html>