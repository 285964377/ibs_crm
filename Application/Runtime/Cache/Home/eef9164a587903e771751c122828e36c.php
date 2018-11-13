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
							<li class="" data-name="1">待初审</li>
							<li class="" data-name="2">待复审</li>
							<li class="" data-name="3">初审被拒</li>
							<li class="" data-name="4">复审被拒</li>
							<li class="" data-name="5">审核通过</li>
						</ul>
						<div class="my_form_box">
							<label class="layui-form-label">申请编号：</label>
							<div class="layui-input-inline">
								<input type="text" name="code"  placeholder="申请编号" autocomplete="off" class="layui-input">
							</div>
						</div>	
						<div class="my_form_box">
							<label class="layui-form-label">商机编号：</label>
							<div class="layui-input-inline">
								<input type="text" name="sj"  placeholder="商机编号" autocomplete="off" class="layui-input">
							</div>
						</div>	

						<div class="my_form_box">	
							<label class="layui-form-label">申请金额：</label>
							<div class="layui-input-inline">
								<input type="text" name="money_start" style="display: inline-block;width:79px;" onkeyup="je(this)"    placeholder="最小金额" autocomplete="off" class="layui-input">
								<span style="clear:both">-</span>
								<input type="text" name="money_end" style="display: inline-block;width:79px;" onkeyup="je(this)"    placeholder="最大金额" autocomplete="off" class="layui-input">
								<span style="font-size:12px">元</span>
							</div>
						</div>	
					
						<div class="my_form_box">	
							<label class="layui-form-label">申请时间：</label>
							<div class="layui-input-inline">
								<input type="text" name="creat_time"  id="creat_time" placeholder="申请时间" autocomplete="off" class="layui-input">
							</div>
						</div>
						<div class="my_form_box">	
							<label class="layui-form-label">审核时间：</label>
							<div class="layui-input-inline">
								<input type="text" name="check_time" id="check_time" placeholder="审核时间" autocomplete="off" class="layui-input">
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
	<script id="money" type="text/html">
		<p>{{d.money}}</p>
		<p>{{d.rk_type}}</p>
	</script>
<script id="cz" type="text/html">
	{{#  if(d.step=='待初审'){  }}
	<a lay-event='dcs' href="javascript:;"  class="layui-btn layui-btn-primary layui-btn-xs">初审</a>
	{{# }else if(d.step=='待复审'){ }}
	<a lay-event='dfs' href="javascript:;" class="layui-btn layui-btn-primary layui-btn-xs">复审</a>
	{{# }else if(d.step=='复审被拒'){  }}
	<a lay-event='dcs' href="javascript:;"  class="layui-btn layui-btn-primary layui-btn-xs">修改</a>
	{{# }else{ }}
	<p>已审核</p>
	{{# } }}
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
	

  //第一个实例
  var Machine = table.render({
    elem: '#Machine'
    ,url: 'money_out.html?search_data=1' //数据接口
    ,page: true //开启分页
    ,cols: [[ //表头
		  {width:160,field: 'code', title: '申请编号'},
		  {width:160,templet:'#res_cus', title: '客户'},
		  {width:160,field:'order', title: '订单编号'},
		  {width:160,templet:'#order_xd',title: '生产子订单'},
		  {width:160,templet: '#money', title: '申请金额'},
		  {width:160,field:'ht_user', title: '做单人'},
		  {width:160,field:'creat_time', title: '申请时间'},
		  {width:160,field:'check_time', title: '审核时间'},
		  {width:160,field: 'step', title: '状态'},
		  {title: '操作',toolbar:'#cz',fixed: 'right',width:150}
    ]]
	  ,response: {
          statusCode: 200
      }
  });
form.on('submit(get_search)', function(data){
  data=data.field;
	if($('#creat_time').val()){
		var Nlast = data.creat_time.split('~');
		data.creat_time_start=Nlast[0];
		data.creat_time_end=Nlast[1];
	}
	if($('#check_time').val()){
		var Nnext = data.check_time.split('~');
		data.check_time_start=Nnext[0];
		data.check_time_end=Nnext[1];
	}
	delete  data.creat_time;
	delete data.check_time;
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
            //待初审
            if(layEvent==='dcs'){
                layui.layer.open({
                    title : "初审审核",
                    type : 2,
                    content : "check_first.html?id="+data.id,
                    area:["60%","60%"]
                })
            }
            //待复审
            if(layEvent==='dfs'){
                layui.layer.open({
                    title : "复审审核",
                    type : 2,
                    content : "check_last.html?id="+data.id,
                    area:["90%","90%"]
                })
            }

        });




    });

	</script>
</body>
</html>