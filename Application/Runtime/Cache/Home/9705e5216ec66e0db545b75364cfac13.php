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
								<button class="layui-btn layui-btn-blue layui-btn-sm add-depart"><i class="layui-icon">&#xe654;</i>新增上级类型</button>
								<button class="layui-btn layui-btn-primary up-all layui-btn-sm"><i class="layui-icon">&#xe619;</i>全部收起</button>
								<button class="layui-btn layui-btn-primary down-all layui-btn-sm"><i class="layui-icon">&#xe61a;</i>全部展开</button>
					</div>		
                </div>
				<hr/>
				<div class="table_box">
					<div class="test-tree-table" lay-filter="test1"></div>
				</div>	
            </div>
        </div>

    </div>
</div>
<!--添加上级部门-->
<div  class="" id="add-department" style="display: none;">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">类型名称</label>
            <div class="layui-input-inline">
                <input type="text" name="name" required  lay-verify="required" placeholder="请输入类型名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block"	>
                <button class="layui-btn layui-btn-blue" lay-submit lay-filter="Add">立即提交</button>
            </div>
        </div>
    </form>
</div>

<!--添加下级部门-->
<div  class="" id="add-child-department" style="display: none;">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">上级商机</label>
            <div class="layui-input-inline">
                <input type="text"  id="child-p-name"  disabled autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">商机名称</label>
            <div class="layui-input-inline">
                <input type="text" name="name" required  lay-verify="required" placeholder="请输入商机名称" autocomplete="off" class="layui-input">
                <input  id="child-p-id" name="pid"   type="hidden" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-blue" lay-submit lay-filter="Add_child">立即提交</button>
            </div>
        </div>
    </form>
</div>

<!--编辑部门-->
<div  class="" id="edit-department" style="display: none;">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">商机名称</label>
            <div class="layui-input-inline">
                <input type="text" id="edit-input-name" name="name" value="" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                <input  id="edit-input-id" name="id" type="hidden" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-blue" lay-submit lay-filter="Edit">立即提交</button>
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
<script type="text/javascript">
    layui.config({
        base: path+'/modules/table/',
    })
    layui.use(['treetable','form','layer'],function(){
        var o = layui.$,treetable = layui.treetable,data,layer=layui.layer,form=layui.form;
        o.ajax({
            url:'index.html?search_data=1',
            dataType:'json',
            async:false,
            success:function(res){
                data=res.data;
            }
        })
        parttable = treetable.render({
            elem: '.test-tree-table',
            data: data,
            field: 'name',
            cols: [
                {
                    field: 'name',
                    title: '商机类型名称',
                    width: '35%',
                },
                {
                    field: 'creat_time',
                    title: '创建时间',
                    width: '30%',
                },
                {
                    field: 'actions',
                    title: '操作',
                    width: '35%',
                    data: [
                        '<button style="border: none;background: none" onclick="add_child(this)"><i class="layui-icon">&#xe654;</i>添加</button>',
                        '<button style="border: none;background: none"  onclick="edit(this)"><i class="layui-icon">&#xe642;</i>编辑</button>',
                    ],
                },
            ]
        });



        //添加上级部门
        o('.add-depart').click(function(){
            ADD=layer.open({
                title: '新增分类',
                type: 1,
                content: o('#add-department'),
                area: ['330px', '140px']
            })
        })


        o('.up-all').click(function(){
            treetable.all('up');
        })

        o('.down-all').click(function(){
            treetable.all('down');
        })

        //提交添加上级部门内容
        form.on('submit(Add)', function(data){
            var index_o = layer.load();
            var datas = data.field;
            o.ajax({
                url:'add.html',
                data:datas,
                type:'post',
                dataType:'json',
                success:function(res){
                    layer.close(index_o);
                    layer.msg(res.msg);
                    if(res.code==200){
                        setTimeout(function(){
                            layer.closeAll();
                            location.reload();
                        },500)
                    }
                }
            })
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });

        //提交添加下级部门内容
        form.on('submit(Add_child)', function(data){
            var index_o = layer.load();
            var datas = data.field;
            o.ajax({
                url:'add.html',
                data:datas,
                type:'post',
                dataType:'json',
                success:function(res){
                    layer.close(index_o);
                    layer.msg(res.msg);
                    if(res.code==200){
                        setTimeout(function(){
                            layer.closeAll();
                            location.reload();
                        },500)
                    }
                }
            })
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });

        //提交编辑内容
        form.on('submit(Edit)', function(data){
            var index_o = layer.load();
            var datas = data.field;
            o.ajax({
                url:'edit.html',
                data:datas,
                type:'post',
                dataType:'json',
                success:function(res){
                    layer.close(index_o);
                    layer.msg(res.msg);
                    if(res.code==200){
                        setTimeout(function(){
                            layer.closeAll();
                            location.reload();
                        },500)
                    }
                }
            })
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
    });

    function  add_child(obj){
        layui.use(['form','layer'],function(){
            var o = layui.$,layer=layui.layer,form=layui.form;
            layer.open({
                title: '新增下级类型',
                type: 1,
                content: o('#add-child-department'),
                area: ['330px', '180px']
            })
            var tr =o(obj).parents('tr');
            var id=o(tr).attr('data-tb-id');
            var name=o(tr).attr('data-name');
            document.getElementById("child-p-id").value=id;
            document.getElementById("child-p-name").value=name;
        })
    }

    function  edit(obj){
        layui.use(['form','layer'],function(){
            var o = layui.$,layer=layui.layer,form=layui.form;
            edit_depart=layer.open({
                title:'编辑类型',
                type:1,
                content:o('#edit-department'),
                area:['330px','140px']
            })
            //     console.log(obj);
            var tr =o(obj).parents('tr');
            var name=o(tr).attr('data-name');
            var id=o(tr).attr('data-tb-id');
            document.getElementById("edit-input-name").value=name;
            document.getElementById("edit-input-id").value=id;
        })
    }
</script>
</body>
</html>