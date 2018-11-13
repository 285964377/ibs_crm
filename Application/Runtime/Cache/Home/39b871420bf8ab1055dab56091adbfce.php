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
											<input type="text" class="search_input layui-input"  placeholder="姓名/电话/工号" />
										</div>
										<div class="layui-input-inline">
											<input type="text"  id="tree" name="" lay-filter="tree" class="layui-input">
										</div>
										<button class="layui-btn layui-btn-blue" lay-submit id="search" lay-filter="search"><i class="layui-icon">&#xe615;</i>查询</button>
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
	
	<script type="text/html" id="cz">
	  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="choose">选择</a>
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
							url: "<?php echo U('Back/get_user');?>" //数据接口
							,page: true //开启分页
							,response: {
								statusCode: 200 //规定成功的状态码，默认：0
							}
							,cols: [[
								 {title: '上级单位', field: 'name'}
								, {title: '工号', field: 'user_code'}
								, {title: '姓名', field: 'user_name'}
								, {title: '电话', field: 'tel'}
								,{title: '操作',toolbar:'#cz',fixed: 'right',width:150}
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
				
				//监听表格
				var my_id="<?php echo ($id); ?>";
				table.on('tool(Machine)', function(obj){
						var data = obj.data;
						var layEvent = obj.event;
						
						if(layEvent==='choose'){
							layer.confirm('确认分配给：'+data.user_name+'的吗?',{icon: 3, title:'分配'}, function(index){
								var index_o = layer.load();
								$.ajax({
									url:"allot.html",
									type:'post',
									data:{'id':my_id,'accept_id':data.uid},
									dataType:"json",
									success:function(res){
										layer.close(index_o);
										layer.msg(res.msg);
										if(res.code==200){
											setTimeout(function(){
												var my = parent.layer.getFrameIndex(window.name); 
												parent.layer.close(my);
												layer.close(index);
												parent.layui.table.reload('Machine');
											},500)
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
						}
					});
				})
	</script>
</body>
</html>