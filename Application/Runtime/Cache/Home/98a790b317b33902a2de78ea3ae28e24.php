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
</style>
<div class="layui-content">
    <div class="layui-row">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="form-box">
									<div class="layui-form" action="">
											<div class="layui-input-inline">
												<input type="text" name="title" required  lay-verify="required" placeholder="请输入角色名" autocomplete="off" class="layui-input search_input">
											</div>
											<button class="layui-btn layui-btn-blue search_btn " id="get_serch"><i class="layui-icon">&#xe615;</i>查询</button>
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
	<!--存放默认的权限-->
	<input type="hidden" name="roleID" id="roleID" value="<?php echo ($role[0]['id']); ?>" />
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
	<script>
	layui.use(['table','layer','jquery','form'],function(){
    var table = layui.table;
  	var layer= layui.layer;
  	var form = layui.form;
  	var $ = layui.jquery;
  	var laypage = layui.laypage;
  //第一个实例
  var Machine = table.render({
    elem: '#Machine'
    ,url: 'index.html?search_data=1' //数据接口
    ,page: true //开启分页
    ,cols: [[ //表头
      {field: 'title', title: '角色名称', height:'200px'},
      {field: 'descript', title: '角色描述', height:'200px'},
		{field: 'creat_time', title: '添加时间', height:'200px'},
      {title: '操作', height:'200px',toolbar:'#cz'},
    ]]
    ,limit:15
    ,limits:[15,30,45,60]
  });
 //搜索
  $('.search_btn').click(function(){
	  	data= {search:$(".search_input").val()};
		Machine.reload({
			where:data,
			page: {
				curr: 1 
			}
		});
  })
  //添加
	$(".addBtn").click(function(){
		var index = layui.layer.open({
			title : "添加角色",
			type : 2,
			content : "add.html",
			area:["90%","90%"]
		})	
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
						if(res.code==0){
							Machine.reload();
						}
					}
				})
		    })
		}
	
	});	
	
	
	
	
});

	</script>
</body>
</html>