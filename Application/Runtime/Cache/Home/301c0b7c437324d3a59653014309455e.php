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
										<input type="text" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input search_input">
									</div>
									<div class="layui-input-inline">
										<input type="text" required  lay-verify="required" placeholder="请选择时间范围" autocomplete="off" id="time_start" class="layui-input">
									</div>
									<button class="layui-btn layui-btn-blue search_btn "><i class="layui-icon">&#xe615;</i>查询</button>
									<button class="layui-btn layui-btn-blue" id="add"><i class="layui-icon">&#xe654;</i>添加</button>
							</div>
					</div>		
					<hr/>
					<div class="table_box">
						<table id="article" lay-filter="article"></table>
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
	<script>
			$("body").bind("keydown",function(event){
			   if (event.keyCode == 116) {
				 event.preventDefault(); //阻止默认刷新
				 location=location;
				}
			})
	</script>
	<!--操作-->
	<script id="cz" type="text/html">
		<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i>编辑</a>
		<a  class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon">&#xe640;</i>删除</a>
	</script>
	<script id="bt" type="text/html">
		<a data-id="{{d.id}}" lay-event="t_details" style="color:#1E9FFF" href="javascript:;">{{d.title}}</a>
	</script>
	<script type="text/html" id="sts">
    <input type="checkbox" value="{{d.id}}" name="zzz" lay-skin="switch" {{ d.status == 1 ? 'checked' : '' }} lay-text="下架|上架" lay-filter="switchBtn">
  </script>
	<script>
        layui.config({
            base: path+'/modules/table/',
        })
		layui.use(['table','layer','jquery','laydate','form'], function(){
			var table = layui.table,layer= layui.layer,$ = layui.jquery,laydate=layui.laydate,form=layui.form;
			laydate.render({
				elem: '#time_start',
				range:'~'
		  	});

            Machine= table.render({
                elem:'#article',
                url: "index.html?search_data=1" //数据接口
                ,page: true //开启分页
                ,response: {
                    statusCode: 200 //规定成功的状态码，默认：0
                }
                ,cols: [[
                    {field: 'title', title: '标题',templet: '#bt'}
                    ,{field: 'username', title: '创建人'}
                    ,{field: 'creat_time', title: '创建时间'}
					 ,{ title: '状态',templet:"#sts"}
                    ,{title: '操作',toolbar:'#cz'}
                ]]
            });

            //搜索
            $('.search_btn').click(function(){
                var time_start = $('#time_start').val();
                var Ntime = time_start.split('~');
                data= {title:$(".search_input").val(),time_start:Ntime[0],time_end:Ntime[1]};
                Machine.reload({
                    where:data,
                    page: {
                        curr: 1
                    }
                });
            })

			//刷新
			$('#red_get').click(function(){
				location=location;
			})
			//添加
			$('#add').click(function(){
				layui.layer.open({
					title : "添加",
					type : 2,
					content:'add.html',
					area:['80%','80%'],
				})
			})
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
				layer.confirm('确认'+text+'该FAQ吗?',{icon: 3, title:text}, function(index){
                    var index_o = layer.load();
					$.ajax({
						url:"status.html",
						type:'post',
						data:{id:id,status:status},
						dataType:"json",
						success:function(data){
                           layer.close(index_o);
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
			table.on('tool(article)', function(obj){
			  var data = obj.data; //获得当前行数据
			  var layEvent = obj.event;
			  if(layEvent === 'del'){ //删除
				layer.confirm('是否删除该内容?',{icon: 3, title:'删除FAQ'}, function(index){
					var index_o = layer.load();
					$.ajax({
						url:'delete.html?id='+data.id,
						type:"get", //
						dataType:"json",
						success:function(res){
							layer.close(index_o);
							layer.msg(res.msg);
							if(res.code==200){
								setTimeout(function(){
									obj.del();
									layer.close(index);
									arTable.reload();
								},500)
							}
						}
					})
				});
			  }else if(layEvent === 'edit'){ //编辑
				layui.layer.open({
					title : "编辑",
					type : 2,
					content:'edit.html?id='+data.id,
					area:['80%','80%'],
				})

			  }else if(layEvent==='t_details'){
				layui.layer.open({
					title : "详情",
					type : 2,
					content:'details.html?id='+data.id,
					area:['80%','80%'],
				})
			  }
			});
		});
	</script>
</body>
</html>