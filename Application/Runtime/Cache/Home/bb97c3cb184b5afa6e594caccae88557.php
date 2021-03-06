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
                <div class="layui-form">
                        <div class="layui-input-inline" style="width:100px">
                            <select id="step" name="type" lay-verify="required">
                                <option value="1">客户备注</option>
                             <!--   <option value="2" style="display:none;"> 商机备注</option> -->
                                <option value="3"> 商机跟进</option>
                                <option value="4">订单办理</option>
                            </select>
                        </div>
						<button style="position: relative;top:1px"  class="layui-btn layui-btn-blue" lay-submit id="search" lay-filter="search"><i class="layui-icon">&#xe615;</i>查询</button>
						<button style="position: relative;top:1px" class="layui-btn layui-btn-blue layui-btn-sm add-depart"><i class="layui-icon">&#xe654;</i>新增标签</button>
                </div>
							</div>	
							<hr/>
							<div class="table_box">
                <table id="department_table" class="layui-hide" lay-filter="department_table"></table>
							</div>	
            </div>
        </div>
    </div>
</div>
<!--新增标签-->
<div id="add_zz" style="display:none;">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">类型</label>
			 <div class="layui-input-inline">
				<select name="type" lay-verify="required">
						<option value="1">客户备注</option>
				<!--	<option value="2"> 商机备注</option> -->
						<option value="3"> 商机跟进</option>
						<option value="4">订单办理</option>
				</select>
			</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">内容</label>
            <div class="layui-input-inline">
                <input type="text" name="content" required  lay-verify="required" placeholder="请输入内容" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-blue" lay-submit lay-filter="add_form">立即提交</button>
            </div>
        </div>
    </form>
</div>
<!--编辑-->
<div id="edit_zz" style="display:none;">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">类型</label>
             <div class="layui-input-inline">
				<select id="select" name="type" lay-verify="required">
						<option value="1">客户备注</option>
						<option value="2"> 商机备注</option>
						<option value="3"> 商机跟进</option>
						<option value="4">订单办理</option>
				</select>
			</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">内容</label>
            <div class="layui-input-inline">
                <input type="text" name="content" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
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
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script type="text/html" id="sts">
    <input type="checkbox" value="{{d.id}}" name="zzz" lay-skin="switch" {{ d.status == 1 ? 'checked' : '' }} lay-text="下架|上架" lay-filter="switchBtn">
  </script>
<script type="text/javascript">
    layui.config({
        base: path+'/modules/table/',
    })
    var datass;
    layui.use(['form','table','layer'],function() {
        var $ = layui.$,form=layui.form, table = layui.table,layer=layui.layer;

        //渲染表格
        Machine= table.render({
            elem: '#department_table',
            url: "index.html?search_data=1" //数据接口
            ,page: true //开启分页
            ,response: {
                statusCode: 200 //规定成功的状态码，默认：0
            }
            ,cellMinWidth:160
            ,cols: [[

                 {title: '类型', field: 'type'}
                , {title: '内容', field: 'content'}
                , {title: '创建时间', field: 'creat_time'}
				 ,{ title: '状态',templet:"#sts"}
                ,{toolbar: '#barDemo',title: '操作'}
            ]]
        });

        //搜索
        $("#search").click(function(){
            var type = $('#step').val();
            data= {type:type};
            Machine.reload({
                where:data,
                page: {
                    curr: 1
                }
            });

        })

        //添加标签
        $('.add-depart').click(function(){
            ADD=layer.open({
                title: '新增新增标签',
                type: 1,
                content: $('#add_zz'),
                area: ['330px', '180px']
            })
        })
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
				layer.confirm('确认'+text+'该标签吗?',{icon: 3, title:text}, function(index){
					$.ajax({
						url:"status.html",
						type:'post',
						data:{id:id,status:status},
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
                            Machine.reload();
                            $('.layui-input').val('');
                        },500)
                    }
                }
            })
            return false;
        });

        //提交修改
        form.on('submit(edit_form)', function(data){
            var index_o = layer.load();
            $.ajax({
                url:'edit.html',
                data:data.field,
                type:'post',
                dataType:'json',
                success:function(res){
                   layer.close(index_o);
                    layer.msg(res.msg);
                    if(res.code==200){
                        setTimeout(function(){
                            layer.close(ADD);
                            Machine.reload();
                            $('.layui-input').val('');
                        },500)
                    }
                }
            })
            return false;
        });

        //监听表格
        table.on('tool(department_table)', function(obj){
            var data = obj.data;
            var layEvent = obj.event;
            if(layEvent === 'del'){
                layer.confirm('确认删除标签：'+data.content+'吗', {icon: 3, title:'删除标签'}, function(index){
                    $.ajax({
                        url:'delete.html?id='+data.id,
                        dataType:'json',
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
                $('#id').val(data.id);
                $('#select').val(data.type_id);
                $('#edit_zz').find('input').eq(1).val(data.content);
                ADD=layer.open({
                    title: '修改标签',
                    type: 1,
                    content: $('#edit_zz'),
                    area: ['330px', '180px']
                })
				form.render();
            }
        })



    })
</script>
</body>
</html>