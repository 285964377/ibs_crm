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
													<li class="" data-name="not_one">未首电</li>
													<li class="" data-name="today_gj">今日待跟进</li>
													<li class="" data-name="today_sm">今日预约上门</li>
													<li class="" data-name="over_gj">逾期跟进</li>
													<li class="" data-name="out_worning">掉库预警</li>
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
													<label class="layui-form-label">销售阶段：</label>
													<div class="layui-input-inline">
														<select name="stage">
															<option value="0">所有</option>
															<option value="5">未首电</option>
															<option value="1">咨询</option>
															<option value="2">犹豫</option>
															<option value="3">意向</option>
															<option value="4">已上门</option>
														</select>
													</div>
												</div>	
												<div class="my_form_box">	
													<label class="layui-form-label">最后跟进：</label>
													<div class="layui-input-inline">
														<input type="text" name="last_time"  id="last_time" placeholder="最后跟进时间" autocomplete="off" class="layui-input">
													</div>
												</div>
												<div class="my_form_box">	
													<label class="layui-form-label">下次跟进：</label>
													<div class="layui-input-inline">
														<input type="text" name="next_time" id="next_time" placeholder="下次跟进时间" autocomplete="off" class="layui-input">
													</div>
												</div>
												<input type="hidden" name="ing_type" id="top_name" value=""/>
												<div class="my_form_box">	
													<button class="layui-btn layui-btn-blue" id="get_serch_yes" lay-submit lay-filter="get_search"><i class="layui-icon">&#xe615;</i>查询</button>
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
	  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i>编辑</a>
	  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon">&#xe640;</i>删除</a>
	</script>
	<script id="cus" type="text/html">
			<p lay-event="name_link" style="color:#01AAED;cursor: pointer;">{{d.name}}</p>
			<p>{{d.phone}}</p>
	</script>
	<script id="allot" type="text/html">
			<p>{{d.allot_name?d.allot_name:''}}({{d.allot_code?d.allot_code:'暂无'}})</p>
			<p>{{d.allot_time?d.allot_time:''}}</p>
	</script>
	<script id="user" type="text/html">
			<p>{{d.user_name?d.user_name:''}}({{d.user_code?d.user_code:'暂无'}})</p>
			
	</script>
	<script id="next" type="text/html">
			<p>{{d.next_step?d.next_step:'暂无'}}</p>
			<p>{{d.next_time?d.next_time:''}}</p>
	</script>
	<script id="last_op" type="text/html">
			<p>{{d.resop_type}}-{{d.resop_time}}</p>
			<p>{{d.resop_user_name}}({{d.resop_user_code}})</p>
	</script>
	<script id="tabr" type="text/html">
			<div class="layui-btn-container">
					<button  class="layui-btn layui-btn-sm layui-btn-blue refresh" onclick="refresh()"><i class="layui-icon">&#xe669;</i></button>
					<button class="layui-btn layui-btn-blue layui-btn-sm" lay-event="get_fp" id="get_fp"><i class="layui-icon">&#xe667;</i>分配到个人</button>
					<button class="layui-btn layui-btn-blue layui-btn-sm" lay-event="get_fp_bm" id="get_fp_bm"><i class="layui-icon">&#xe667;</i>分配到部门</button>
					<button class="layui-btn layui-btn-blue layui-btn-sm" lay-event="get_fwx" id="get_fwx"><i class="layui-icon">&#xe667;</i>反无效</button>
					<button class="layui-btn layui-btn-blue layui-btn-sm" lay-event="get_tc" id="get_tc"><i class="layui-icon">&#xe667;</i>剔除</button>
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
		var my_style  = sessionStorage.getItem('going');
		if(my_style){
			$('.nav_list').find('li').eq(5).click();
			setTimeout(function(){
				$('#get_serch_yes').click();
			},50)
			sessionStorage.clear('going');
		}
		
		//最后跟进
		laydate.render({
			elem: '#last_time',
			range:'~',
			type:'datetime'
		});
		//下次跟进
		laydate.render({
			elem: '#next_time',
			range:'~',
			type:'datetime'
		});
		//商机类型
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
					}
			});
			//商机来源
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
						}
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
  //第一个实例
  var Machine = table.render({
    elem: '#Machine'
    ,url: 'ing.html?search_data=1' //数据接口
	,toolbar:'#tabr'
    ,page: true //开启分页
		,cellMinWidth:150
    ,cols: [[ //表头
      {type:'checkbox'},
			{width:160,field: 'code', title: '商机编号'},
      {width:118,templet:'#cus',title: '客户'},
      {width:120,field: 'dk_money', title: '贷款金额(万)'},
      {width:200,field: 'remark', title: '备注'},
      {width:120,field: 'zz', title: '资质'},
      {width:160,templet:'#allot',title: '分配人'},
	  {width:120,templet:'#user',title: '商机所属人'},
      {width:100,field: 'stage', title: '销售阶段'},
			{width:160,templet:'#next',title: '下次跟进'},
			{width:120,field: 'frequ', title: '跟进频率'},
			{width:120,field: 'part', title: '商机所属部门'},
      {width:160,field: 'last_time', title: '最后跟进时间'},
      {width:160,field: 'guess_out_time', title: '预计掉库时间'},
			{width:120,field: 'res_type', title: '商机类型'},
		{width:120,field: 'origin', title: '商机来源'},
      {width:120,templet:'#last_op',fixed: 'right', title: '最新操作',width:280},
      //{title: '操作',toolbar:'#cz',fixed: 'right',width:150}
    ]]
	  ,response: {
          statusCode: 200
      }
  });
form.on('submit(get_search)', function(data){
  data=data.field;
	if($('#last_time').val()){
		var Nlast = data.last_time.split('~');
		data.last_time_start=Nlast[0];
		data.last_time_end=Nlast[1];
	}
	if($('#next_time').val()){
		var Nnext = data.next_time.split('~');
		data.next_time_start=Nnext[0];
		data.next_time_end=Nnext[1];
	}
	delete  data.last_time;
	delete data.next_time;
	Machine.reload({
				where:data,
				page: {
					curr: 1 
				}
			});
  return false; 
});
var lengths,idstring;
//监听左侧表格
  table.on('toolbar(Machine)', function(obj){
		var checkStatus = table.checkStatus('Machine'); 
		lengths = checkStatus.data.length;//选中个数
		idstring='';
		for(var i=0;i<lengths;i++){
			idstring+=checkStatus.data[i].id+',';
		}
		nidstring = idstring.substr(0,idstring.length-1);//ID合集
		var event  = obj.event;
		if(event=='get_fp'){
				if(!lengths){
					layer.tips('请勾选商机，再点击这里哟', '#get_fp');
					return false;
				}else{ 
						layui.layer.open({
							title : "分配到个人",
							type : 2,
							content : "allot.html?id="+nidstring,
							area:["70%","90%"]
						})	
				}
			}else if(event=='get_fp_bm'){
				if(!lengths){
					layer.tips('请勾选商机，再点击这里哟', '#get_fp_bm');
					return false;
				}else{ 
						layui.layer.open({
							title : "分配到部门",
							type : 2,
							content : "allot_part.html?id="+nidstring,
							area:["400px","300px"]

						})	
				}
			}else if(event=='get_fwx'){
				if(lengths!=1){
					layer.tips('至少且只能勾选一个商机', '#get_fwx');
					return false;
				}else{
					layer.prompt({'formType':	0,'title':'返无效原因'},function(value, index, elem){
						var index_o = layer.load();
						$.ajax({
							url:"fan_res.html",
							type:'post',
							data:{'remark':value,'id':nidstring},
							dataType:"json",
							success:function(res){
								layer.close(index_o);
								layer.msg(res.msg);
								if(res.code==200){
									setTimeout(function(){
										layer.close(index);
										Machine.reload();
									},500)
								}
							}	
						})
					});
						layer.tips('请填写返无效原因，否则无法提交哟', '.layui-layer-btn0');
				}
			}else if(event=='get_tc'){
				if(lengths!=1){
					layer.tips('至少且只能勾选一个商机', '#get_tc');
					return false;
				}else{
					layer.prompt({'formType':	0,'title':'剔除原因'},function(value, index, elem){
						var index_o = layer.load();
						$.ajax({
							url:"tichu_res.html",
							type:'post',
							data:{'remark':value,'id':nidstring},
							dataType:"json",
							success:function(res){
								layer.close(index_o);
								layer.msg(res.msg);
								if(res.code==200){
									setTimeout(function(){
										layer.close(index);
										Machine.reload();
									},500)
								}
							}	
						})
					});
						layer.tips('请填写剔除原因，否则无法提交哟', '.layui-layer-btn0');
				}
			}
	})
	 //监听表格工具
	table.on('tool(Machine)', function(obj){ 
		var data = obj.data; //获得当前行数据
		var layEvent = obj.event;
		if(layEvent === 'edit'){ //编辑 
				/*打开时渲染数据*/
			var index = layui.layer.open({
			title : "添加角色",
			type : 2,
			content : "edit.html?id="+data.id,
			area:["90%","90%"]
		})	
		}
		if(layEvent === 'del'){ //删除
			layer.confirm('确认要删除吗？',{icon:3, title:'提示信息'}, function(index){
				var index_o = layer.load();
		    	$.ajax({
					url:'delete.html?id='+data.id,
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
		}else if(layEvent==='name_link'){
			var url="<?php echo U('Resources/details');?>?index=1&id="+data.id;
			var ids ='res_details'+data.id;
			get_url(this,ids,url,data.name);
		}

	});	
	
	
	
	
});

	</script>
</body>
</html>