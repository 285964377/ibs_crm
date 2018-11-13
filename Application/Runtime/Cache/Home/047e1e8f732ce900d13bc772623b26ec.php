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
												<ul class="nav_list">
													<li class="active" data-name="">全部</li>
													<li class="" data-name="0">抢单库</li>
													<li class="" data-name="1">超期未首电</li>
													<li class="" data-name="2">超期未跟进</li>
													<li class="" data-name="3">反无效掉库</li>
													<li class="" data-name="4">退单掉库</li>
													<li class="" data-name="5">成单保护过期</li>
												</ul>
												<div class="my_form_box">
													<label class="layui-form-label">客户姓名：</label>
													<div class="layui-input-inline">
														<input type="text" name="name"  placeholder="客户姓名" autocomplete="off" class="layui-input">
													</div>
												</div>	
												<div class="my_form_box">
													<label class="layui-form-label">商机编号：</label>
													<div class="layui-input-inline">
														<input type="text" name="code"  placeholder="商机编号" autocomplete="off" class="layui-input">
													</div>
												</div>	
												<div class="my_form_box">	
													<label class="layui-form-label">商机来源：</label>
													<div class="layui-input-inline">
														<input type="text" name="origin_id" id="get_ly" placeholder="商机来源" autocomplete="off" class="layui-input">
													</div>
												</div>	
												<div class="my_form_box">	
													<label class="layui-form-label">商机类型：</label>
													<div class="layui-input-inline">
														<input type="text" name="res_type_id" id="get_lx" placeholder="商机类型" autocomplete="off" class="layui-input">
													</div>
												</div>	
												<div class="my_form_box">	
													<label class="layui-form-label">所属部门：</label>
													<div class="layui-input-inline">
														<input type="text" name="part_id" id="tree"  placeholder="商机所属部门" autocomplete="off" class="layui-input">
													</div>
												</div>	
												<div class="my_form_box">	
													<label class="layui-form-label">贷款金额：</label>
													<div class="layui-input-inline">
														<input type="text" name="dk_money_start" style="display: inline-block;width:79px;" onkeyup="je(this)"    placeholder="最小金额" autocomplete="off" class="layui-input">
														<span style="clear:both">-</span>
														<input type="text" name="dk_money_end" style="display: inline-block;width:79px;" onkeyup="je(this)"    placeholder="最大金额" autocomplete="off" class="layui-input">
														<span style="font-size:12px">万</span>
													</div>
												</div>	
												<div class="my_form_box">	
													<label class="layui-form-label">掉库时间：</label>
													<div class="layui-input-inline">
														<input type="text" name="real_out_time"  id="real_out_time" placeholder="掉库时间" autocomplete="off" class="layui-input">
													</div>
												</div>
										
												<input type="hidden" name="out_type" id="top_name" value=""/>
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
	<script type="text/html" id="cz">
	  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="qd"><i class="layui-icon">&#xe657;</i>抢单</a>
	</script>
	<script id="cus" type="text/html">
			<p lay-event="name_link" style="color:#01AAED;cursor: pointer;">{{d.name}}</p>
			<p>{{d.phone}}</p>
	</script>

	<script id="next" type="text/html">
			<p>{{d.next_step?d.next_step:'暂无'}}</p>
			<p>{{d.next_time?d.next_time:''}}</p>
	</script>
	
	<script id="tabr" type="text/html">
			<div class="layui-btn-container">
					<button  class="layui-btn layui-btn-sm layui-btn-blue refresh" onclick="refresh()"><i class="layui-icon">&#xe669;</i></button>
			</div>	
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
		//掉库时间
		laydate.render({
			elem: '#real_out_time',
			range:'~',
			type:'datetime'
		});
	
		//商机类型
		treeSelect.render({
					elem: '#get_lx',
					data: "<?php echo U('Back/select_restype');?>",
					type: 'get',
					placeholder: '选择商机类型',
					search: false,
					click: function(d){
							$('#get_lx').val(d.current.id);
					},
					success: function (d) {
					}
			});
			//商机来源
		treeSelect.render({
					elem: '#get_ly',
					data:"<?php echo U('Back/select_origin');?>",
					type:'get',
					placeholder: '选择商机来源',
					search: false,
					click: function(d){
							$('#get_ly').val(d.current.id);
					},
					success: function (d) {
					}
			});
			//所属部门
					treeSelect.render({
						elem: '#tree',
						data: "<?php echo U('Back/select_part');?>",
						type: 'get',
						placeholder: '选择部门',
						search: false,
						click: function(d){
							$('#tree').val(d.current.id);
			
						},
						success: function (d) {
						}
					});
  var Machine = table.render({
    elem: '#Machine'
    ,url: 'out.html?search_data=1'
	//,toolbar:'#tabr'
    ,page: true //开启分页
	  ,cellMinWidth:160
    ,cols: [[ //表头
	  {field: 'code', title: '商机编号',width:180},
      {templet:'#cus',title: '客户'},
      {field: 'dk_money', title: '贷款金额(万)'},
	  {width:120,field: 'res_type', title: '商机类型'},
	  {width:120,field: 'origin', title: '商机来源'},
	  {width:320,field: 'remark', title: '备注'},
      {width:120,field: 'zz', title: '资质'},
	  {width:120,field: 'part', title: '商机所属部门'},
	  {field:'real_out_time',title: '掉库时间',width:180},
	  {field: 'out_type', title: '掉库类型'},
		{toolbar:'#cz',fixed:'right',title:'操作'}
    ]]
	  ,response: {
          statusCode: 200
      }
		,cellMinWidth:150	
  });
form.on('submit(get_search)', function(data){
  data=data.field;
	if($('#real_out_time').val()){
		var Nlast = data.real_out_time.split('~');
		data.real_out_time_start=Nlast[0];
		data.real_out_time_end=Nlast[1];
	}
	delete  data.real_out_time;
	Machine.reload({
				where:data,
				page: {
					curr: 1 
				}
			});
  return false; 
});
	 //监听表格工具
	table.on('tool(Machine)', function(obj){ 
		var data = obj.data; //获得当前行数据
		var layEvent = obj.event;
		if(layEvent === 'qd'){ 
			layer.confirm('确认要抢单吗？',{icon:3, title:'提示信息'}, function(index){
				var index_o = layer.load();
		    	$.ajax({
					url:'qiang.html?id='+data.id,
					type:"get", 
					dataType:"json",
					success:function(res){
						layer.close(index_o);
						layer.close(index);
						layer.msg(res.msg);
						if(res.code==200){
							Machine.reload();
						}
					}
				})
		    })
		}
		if(layEvent === 'name_link'){ 
			var url="<?php echo U('Resources/details');?>?index=1&id="+data.id;
			var ids ='res_details'+data.id;
			get_url(this,ids,url,data.name);
		}
	
	});	
	
	
	
	
});

	</script>
</body>
</html>