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
												<button class="layui-btn layui-btn-blue layui-btn-sm add-depart"><i class="layui-icon">&#xe654;</i>新增资质</button>
										</div>		
									</div>
									<hr/>
									<div class="table_box">
                    <table id="demo" lay-filter="test"></table>
									</div>		
                </div>
            </div>
						
        </div>
    </div>
	<div id="add_zz" style="display:none;">
		<form class="layui-form" action="">
		    <div class="layui-form-item">
				<label class="layui-form-label">资质名</label>
				<div class="layui-input-inline">
				  <input type="text" name="table" required  lay-verify="english" placeholder="请输入资质名" autocomplete="off" class="layui-input">
				</div>
		    </div>
		    <div class="layui-form-item">
				<label class="layui-form-label">资质别名</label>
				<div class="layui-input-inline">
					<input type="text" name="name" required  lay-verify="required" placeholder="请输入资质别名" autocomplete="off" class="layui-input">
				</div>
		    </div>
		  <div class="layui-form-item">
			<div class="layui-input-block">
			  <button class="layui-btn layui-btn-blue" lay-submit lay-filter="add_form">立即提交</button>
			</div>
		  </div>
		</form>
	</div>
	<div id="edit_zz" style="display:none;">
		<form class="layui-form" action="">
		    <div class="layui-form-item">
				<label class="layui-form-label">资质名</label>
				<div class="layui-input-inline">
				  <input type="text" name="table" required  lay-verify="english" placeholder="请输入资质名" autocomplete="off" class="layui-input">
				</div>
		    </div>
		    <div class="layui-form-item">
				<label class="layui-form-label">资质别名</label>
				<div class="layui-input-inline">
					<input type="text" name="name" required  lay-verify="required" placeholder="请输入资质别名" autocomplete="off" class="layui-input">
					<input type="hidden" name="id" id="id" >
				</div>
		    </div>
		  <div class="layui-form-item">
			<div class="layui-input-block">
			  <button class="layui-btn layui-btn-blue" lay-submit lay-filter="edit_form">立即提交</button>
			</div>
		  </div>
		</form>
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
	<script type="text/html" id="sts">
	    <input type="checkbox" value="{{d.id}}" name="zzz" lay-skin="switch" {{ d.status == 1 ? 'checked' : '' }} lay-text="下架|上架" lay-filter="switchBtn">
	 </script>
	<script type="text/html" id="barDemo">
	  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="details">详情</a>
	  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">编辑</a>
	  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
	</script>
		<script>
		layui.use(['table','jquery','form'], function(){
		  var table = layui.table,$=layui.jquery,form=layui.form;
		  form.verify({
			  english:[
				 /^[A-Za-z]+$/,
				 '只能输入英文字母'
			  ]
			});  
		  var zz_table =   table.render({
			elem: '#demo'
			,url: 'index?search_data=1'
			,page: true
              ,cellMinWidth:160
			,cols: [[ //表头
			   {field: 'table', title: '资质名'}
			  ,{field: 'name', title: '资质别名'}
			  ,{field: 'creat_time', title: '创建时间'}
			  ,{title:'状态',templet:"#sts"}
			  ,{toolbar: '#barDemo',title: '操作'}
			]]
			,response: {
                statusCode: 200
            }
		  });
		  var ADD;
		  //添加资质
		  $('.add-depart').click(function(){
			  ADD=layer.open({
			  	title: '新增资质',
			  	type: 1,
			  	content: $('#add_zz'),
			  	area: ['330px', '180px']
			  })
		  })
		   form.on('submit(add_form)', function(data){
               var index_o = layer.load();
			  $.ajax({
				  url:'add.html',
				  data:data.field,
				  type:'post',
				  dataType:'json',
				  success:function(res){
				      layer.close(index_o);
					layer.msg(res.msg);
					if(res.code==200){
						setTimeout(function(){
							layer.close(ADD);
							zz_table.reload();
							$('.layui-input').val('');
						},500)
					}
				  }
			  })
			  return false;
		   });
		   		//上下架
					form.on('switch(switchBtn)', function(obj){
							var id=this.value;
							if(obj.elem.checked){
							var status = 1;
							var text='上架';
								$(obj.elem).next().removeClass('layui-form-onswitch');
								$(obj.elem).next().find('em').html('上架');
								obj.elem.checked = false;
							}else{
								var status = 2;
								var text='下架';
								$(obj.elem).next().addClass('layui-form-onswitch');
								$(obj.elem).next().find('em').html('下架');
								obj.elem.checked = 'checked';
							}
							layer.confirm('确认'+text+'该产品吗?',{icon: 3, title:text}, function(index){
								$.ajax({
									url:"status.html",
									type:'post',
									data:{'id':id,'status':status},
									dataType:"json",
									success:function(data){
										layer.close(index);
										layer.msg(data.msg);
										if(data.code == 200){
											if(status == 1){
												$(obj.elem).next().addClass('layui-form-onswitch');
												$(obj.elem).next().find('em').html('下架');
												obj.elem.checked = 'checked';
											}else{
												$(obj.elem).next().removeClass('layui-form-onswitch');
												$(obj.elem).next().find('em').html('上架');
												obj.elem.checked = false;
											}
										}
									}
								})
							});
					});
		   //修改资质
		   form.on('submit(edit_form)', function(data){
               var index_o = layer.load();
			  $.ajax({
				  url:'edit_table.html',
				  data:data.field,
				  type:'post',
				  dataType:'json',
				  success:function(res){
                    layer.close(index_o);
					layer.msg(res.msg);
					if(res.code==200){
						setTimeout(function(){
							layer.close(ADD);
							zz_table.reload();
							$('.layui-input').val('');
						},500)
					}
				  }
			  })
			  return false;
		   });
		   //监听表格
		   table.on('tool(test)', function(obj){
			  var data = obj.data;
			  var layEvent = obj.event; 
			  if(layEvent === 'del'){
				   layer.confirm('确认删除资质：'+data.table+'吗', {icon: 3, title:'删除资质'}, function(index){
					$.ajax({
						url:'delete_table.html',
						data:{'id':data.id},
						type:'post',
						dataType:'json',
						success:function(res){
							layer.msg(res.msg);
							if(res.code==200){
								setTimeout(function(){
									layer.close(index);
									zz_table.reload();
								},500)
							}
						}
					})
				  });
			  }
			  if(layEvent === 'edit'){
				  var data = obj.data;
				  $('#id').val(data.id);
				  $('#edit_zz').find('input').eq(0).val(data.table);
				  $('#edit_zz').find('input').eq(1).val(data.name);
				  ADD=layer.open({
					title: '修改资质',
					type: 1,
					content: $('#edit_zz'),
					area: ['330px', '180px']
				  })
			  }
			  
			  if(layEvent === 'details'){
				  ADD=layer.open({
					title: '资质详情',
					type: 2,
					content: "details.html?index=1&id="+data.id,
					area: ['90%', '80%']
				  })
			  }
			})  
		});
		</script>
</body>
</html>