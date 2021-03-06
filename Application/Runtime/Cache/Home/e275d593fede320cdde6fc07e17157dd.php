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
		table{
			font-size:12px;
			text-align:center;
		}
		.layui-table-view .layui-table td, .layui-table-view .layui-table th{
			text-align:center;
		}
		.hide{
        display:none;
    }
    .layui-form-item .layui-input-block{
        margin-right: 20px;
    }
		
		.layui-table-view .layui-table td {
			height:56px;
			line-height:56px;
		}
		.layui-table-main .layui-table-cell {
			height:auto;
		}
		.layui-table-fixed  .layui-table-cell{
			height:auto;
		}
		.layui-table-view .layui-table td, .layui-table-view .layui-table th{
			padding:0;
			}
			.layui-form-label{
				width:auto;
			}
			.my_form_box{
				float:left;
				display: inline-block;
				margin-top:10px;
			}
			.nav_list{
				overflow: hidden;
				background:#eff3f5;
				border:1px solid #c6d1d6;
				padding:7px 10px;
			}
			.nav_list li{
				padding:6px 20px;
				float:left;
				margin-right:20px;
				cursor: pointer;
			}
			.nav_list li.active{
				background:url(/Application/Home/Common/images/top_bck.png) no-repeat;
				background-size:100% 100%;
			}
			.layui-treeSelect .ztree li span.button.switch {
					position: relative;
					top: -7px;
			}
</style>
<div class="layui-content">
    <div class="layui-row">
        <div class="layui-card">
            <div class="layui-card-body">
				<div class="layui-form" >
					<div class="layui-form-item" style="margin-top:0">
						<div class="my_form_box">
							<label class="layui-form-label">员工：</label>
							<div class="layui-input-inline">
								<input type="text" name="user"  placeholder="姓名/工号/电话" autocomplete="off" class="layui-input">
							</div>
						</div>	
						<div class="my_form_box">	
							<label class="layui-form-label">部门：</label>
							<div class="layui-input-inline">
								<input type="text" name="part_code" id="tree"  placeholder="选择部门" autocomplete="off" class="layui-input">
							</div>
						</div>	
						<div class="my_form_box">	
							<label class="layui-form-label">金额：</label>
							<div class="layui-input-inline">
								<input type="text" name="money_start" style="display: inline-block;width:79px;" onkeyup="je(this)"    placeholder="最小金额" autocomplete="off" class="layui-input">
								<span style="clear:both">-</span>
								<input type="text" name="money_end" style="display: inline-block;width:79px;" onkeyup="je(this)"    placeholder="最大金额" autocomplete="off" class="layui-input">
								<span style="font-size:12px">元</span>
							</div>
						</div>	
						<div class="my_form_box">	
							<label class="layui-form-label">核算时间：</label>
							<div class="layui-input-inline">
								<input type="text" name="creat_time"  id="creat_time" placeholder="核算时间" autocomplete="off" class="layui-input">
							</div>
						</div>
						<input type="hidden" name="step" id="top_name" value=""/>
						<div class="my_form_box">	
							<button class="layui-btn layui-btn-blue" lay-submit lay-filter="get_search"><i class="layui-icon">&#xe615;</i>查询</button>
						</div>	
					</div>
				</div>	
				<table id="Machine" lay-filter="Machine"></table>
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
		<script id="res_cus" type="text/html">
		<p>{{d.cus}}</p>
		<p>{{d.res}}</p>
	</script>
	<script id="order_xd" type="text/html">
		<p>{{d.demand.code}}</p>
		<p>{{d.demand.dk_type}}/{{d.demand.channel}}</p>
	</script>
	<script id="user_part" type="text/html">
		<p>{{d.user}}</p>
		<p>{{d.part}}</p>
	</script>
	<script id="money" type="text/html">
		<p>{{d.money}}/{{d.pay_way}}</p>
		<p>{{d.rk_type}}</p>
	</script>
	<script id="tabr" type="text/html">
		<div class="layui-btn-container">
				<button  class="layui-btn layui-btn-sm layui-btn-blue refresh" onclick="refresh()"><i class="layui-icon">&#xe669;</i></button>
				<button class="layui-btn layui-btn-sm layui-btn-primary mn">加载中...</button>
		</div>	
	</script>
	<script id="cz" type="text/html">
		<a lay-event='gyj' href="javascript:;"  class="layui-btn layui-btn-primary layui-btn-xs">更正业绩</a>
		<a lay-event='yjzy' href="javascript:;" class="layui-btn layui-btn-primary layui-btn-xs">业绩转移</a>
		<a lay-event='yjhf' href="javascript:;"  class="layui-btn layui-btn-primary layui-btn-xs">业绩划分</a>
	</script>
	<script>
		var Top_name;
		layui.config({
			base: path+'/modules/treeSelect/',
		})
	layui.use(['table','layer','jquery','form','laydate','treeSelect'],function(){
    var table = layui.table;
  	var layer= layui.layer;
  	var form = layui.form;
  	var $ = layui.jquery;
  	var laypage = layui.laypage;
		var laydate = layui.laydate;
		var treeSelect = layui.treeSelect;
		$('.nav_list li').click(function(){
			$(this).siblings().removeClass('active');
			$(this).addClass('active');
			Top_name=$(this).attr('data-name');
			$('#top_name').val(Top_name);
		})
	
		laydate.render({
			elem: '#creat_time',
			range:'~',
			type:'datetime'
		});
		laydate.render({
			elem: '#check_time',
			range:'~',
			type:'datetime'
		});
	
	//所属部门
			treeSelect.render({
				// 选择器
				elem: '#tree',
				// 数据
				data: "<?php echo U('Back/select_part');?>",
				// 异步加载方式：get/post，默认get
				type: 'get',
				// 占位符
				placeholder: '选择部门',
				// 是否开启搜索功能：true/false，默认false
				search: false,
				// 点击回调
				click: function(d){
					$('#tree').val(d.current.id);
	
				},
				// 加载完成后的回调函数
				success: function (d) {
					console.log(d);
				}
			});
			
	var my_serch;		
	form.on('submit(get_search)', function(data){
	  my_serch=data.field;
		if($('#creat_time').val()){
			var Nlast = my_serch.creat_time.split('~');
			my_serch.creat_time_start=Nlast[0];
			my_serch.creat_time_end=Nlast[1];
		}
		delete  my_serch.creat_time;
		Machine.reload({
					where:my_serch,
					page: {
						curr: 1 
					}
				});
	  return false; 
	});		
			
			var index_table = layer.load();
  //第一个实例
  var Machine = table.render({
    elem: '#Machine'
    ,url: 'yj.html?search_data=1' //数据接口
	,toolbar:'#tabr'
    ,page: true //开启分页
    ,cols: [[ //表头
		   {field: 'user', title: '商务'},
		  {field:'part', title: '所属部门'},
		  {field:"money" ,title:'金额'},
		  {field:'creat_time',title: '日期'},
		  {title: '操作',toolbar:'#cz',fixed: 'right',width:240}
    ]]
	 ,response: {
          statusCode: 200
    },done:function(){
			$.ajax({
				url:'yj.html?count=1',
				type:"get", 
				dataType:"json",
				data:my_serch,
				success:function(res){
					layer.close(index_table);  
					if(res.code==200){
						
						$('.mn').text('总业绩：'+res.data+'元');
					}
				}
			})
		}
  });
	 //监听表格工具
	table.on('tool(Machine)', function(obj){ 
		var data = obj.data; //获得当前行数据
		var layEvent = obj.event;
		//更正业绩
		if(layEvent==='gyj'){
			layui.layer.open({
				title : "更正业绩",
				type : 2,
				content : "edit.html?id="+data.id,
				area:["300px","180px"]
			})	
		}
		//业绩划分
		if(layEvent=='yjhf'){
			layui.layer.open({
				title : "业绩划分",
				type : 2,
				content : "share.html?id="+data.id,
				area:["1200px","500px"]
			})	
		}
		//业绩转移
		if(layEvent==='yjzy'){
			layui.layer.open({
				title : "业绩转移",
				type : 2,
				content:"exchange.html?id="+data.id,
				area:["400px","300px"]
			})	
		}

	});	
});

	</script>
</body>
</html>