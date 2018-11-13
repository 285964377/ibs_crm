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
	</style>
	<div class="layui-content">
	    <div class="layui-row">
				<div class="layui-card">
						<div class="layui-card-body">
								<div class="form-box">
									<div class="layui-form" action="">
										<div class="layui-input-inline">
											<input type="text" id="like" class="search_input layui-input"  placeholder="姓名/电话/工号" />
										</div>
										<div class="layui-input-inline">
											<input type="text"  id="tree" name="" lay-filter="tree" class="layui-input">
										</div>
										<button class="layui-btn layui-btn-blue" lay-submit id="search" lay-filter="search"><i class="layui-icon">&#xe615;</i>查询</button>
										<button class="layui-btn layui-btn-blue addBtn" id="red_get"><i class="layui-icon">&#xe654;</i>添加</button>
								</div>		
							</div>
							<hr/>
							<div class="table_box">
								<table id="Machine" lay-filter="Machine"></table>
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
	<!--存放默认的权限-->
	
	<script type="text/html" id="cz">
	  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i>编辑</a>
	  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="reset">重置密码</a>
	  <a class="layui-btn layui-btn-danger layui-btn-xs"  lay-event="del"><i class="layui-icon">&#xe640;</i>删除</a>
	</script>
	
	<script type="text/html" id="sts">
	    <input type="checkbox" value="{{d.id}}" name="zzz" lay-skin="switch" {{ d.status == 1 ? 'checked' : '' }} lay-text="冻结|激活" lay-filter="switchBtn">
	 </script>
	<script type="text/javascript">
			layui.config({
				base: path+'/modules/table/',
			})
			layui.use(['form','layer','table'],function(){
				var $ = layui.$,data,layer=layui.layer,form=layui.form,table=layui.table;
						//员工列表
						Machine= table.render({
								elem: '#Machine',
								url: "index.html?search_data=1" //数据接口
								,page: true //开启分页
								,response: {
										statusCode: 200 //规定成功的状态码，默认：0
								}
                            ,cellMinWidth:160
								,cols: [[
										{type: 'checkbox'}
										,{title: '姓名', field: 'name'}
										, {title: '电话', field: 'tel'}
										, {title: '工号', field: 'code'}
										, {title: '上级单位', field: 'part_name'}
										, {title: '登陆账号', field: 'login_id'}
										, {title: '角色', field: 'role'}
										, {title: 'sip账号', field: 'sip'}
										, {title: 'sip密码', field: 'sip_pwd'}
										,{ title: '状态',templet:"#sts"}
										,{toolbar: '#cz',title: '操作',width:260}
								]]
						});
						//监听搜索
						$("#search").click(function(){
								var part_id = $('#tree').val();
								var search =$('#like').val();
								data= {part_id:part_id,search:search};
								Machine.reload({
										where:data,
										page: {
												curr: 1
										}
								});
						})
						var add;
					//添加
					$('#red_get').click(function(){
						var index = layer.load();
						add = layui.layer.open({
							title :"添加员工",
							type :2,
							content:"add.html",
							area:["400px","550px"],
							closeBtn:2,
							success:function(){
								layer.close(index);
							}
						})	
					})
					//上下架
					form.on('switch(switchBtn)', function(obj){
							var id=this.value;
							if(obj.elem.checked){
							var status = 1;
							var text='激活';
								$(obj.elem).next().removeClass('layui-form-onswitch');
								$(obj.elem).next().find('em').html('激活');
								obj.elem.checked = false;
							}else{
								var status = 2;
								var text='冻结';
								$(obj.elem).next().addClass('layui-form-onswitch');
								$(obj.elem).next().find('em').html('冻结');
								obj.elem.checked = 'checked';
							}
							layer.confirm('确认'+text+'该员工吗?',{icon: 3, title:text}, function(index){
								$.ajax({
									url:"status.html",
									type:'post',
									data:{id:data.uid,status:status},
									dataType:"json",
									success:function(data){
										layer.close(index);
										layer.msg(data.msg);
										if(data.code == 200){
											if(status == 1){
												$(obj.elem).next().addClass('layui-form-onswitch');
												$(obj.elem).next().find('em').html('冻结');
												obj.elem.checked = 'checked';
											}else{
												$(obj.elem).next().removeClass('layui-form-onswitch');
												$(obj.elem).next().find('em').html('激活');
												obj.elem.checked = false;
											}
										}
									}
								})
							});
					});
				//监听表格
				table.on('tool(Machine)', function(obj){
						var data = obj.data;
						var layEvent = obj.event;
						if(layEvent === 'del'){
								layer.confirm('确认删除员工：'+data.name+'?', {icon: 3, title:'删除员工'}, function(index){
										$.ajax({
												url:'delete.html',
												dataType:'json',
												data:{'id':data.uid},
												type:'post',
												success:function(res){
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
						}
						if(layEvent === 'edit'){
								var index = layer.load();
								add = layui.layer.open({
									title :"编辑员工",
									type :2,
									content:"edit.html?id="+data.uid,
									area:["400px","550px"],
									closeBtn:2,
									success:function(){
										layer.close(index);
									}
								})	
						}
						if(layEvent==='reset'){
							layer.confirm('确认重置：'+data.name+'的密码吗?',{icon: 3, title:'重置密码'}, function(index){
								$.ajax({
									url:"reset.html",
									type:'post',
									data:{'id':data.uid},
									dataType:"json",
									success:function(data){
										layer.msg(data.msg);
										if(data.code == 200){
											layer.close(index);
										}
									}	
								})
							});
					}
				})	
			})			
			layui.config({
					base: path+'/modules/treeSelect/',
				})
				layui.use(['treeSelect','form','layer'],function(){
					var treeSelect= layui.treeSelect;
			
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
							//                选中节点，根据id筛选
							//                treeSelect.checkNode('tree', 3);
			
							//                获取zTree对象，可以调用zTree方法
							//                var treeObj = treeSelect.zTree('tree');
							//                console.log(treeObj);
			
							//                刷新树结构
							//                treeSelect.refresh();
						}
					});
				})
	</script>
</body>
</html>