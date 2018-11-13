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
	.layui-treeSelect .ztree li span.button.switch{
		position: relative;
		top:-7px;
	}
</style>
<div class="layui-content">
	<div class="layui-row">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="layui-form" id="e-form">
                    <div class="layui-form-item">
                        <label class="layui-form-label" style="font-weight:bold;">标题：</label>
                        <div class="layui-input-block">
                            <input type="text"  name="title" required  value="<?php echo ($data["title"]); ?>" lay-verify="required" placeholder="请输入标题" maxlength="20"  autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label" style="font-weight:bold;">内容：</label>
                        <div class="layui-input-block">
                            <textarea id="editor" name="content" class="layui-textarea" style="display: none;"><?php echo ($data["content"]); ?></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 30px">
                        <div class="layui-input-block">
							<input name="id" value="<?php echo ($data["id"]); ?>" type="hidden" />
                            <button class="layui-btn  layui-btn-primary layui-btn-blue" style="color: white" lay-submit lay-filter="get_add">发布</button>
                        </div>
                    </div>
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
	var post_img = ""+"/uploader/fileupload.php";
    layui.config({
        base: path+'/modules/table/',
    })
    layui.use(['table','layer','jquery','layedit','form'], function(){
        var table = layui.table,layer= layui.layer,$ = layui.jquery,layedit=layui.layedit,form=layui.form;
		layedit.set({
		  uploadImage: {
			url: post_img, //接口url
		  }
		});
        var edit=layedit.build('editor',{
            tool: ['strong', 'italic', 'underline', 'del','|', 'left','center','right','image'],
            height:480
        })
     
		
        form.on('submit(get_add)', function(data){
            content = layedit.getContent(edit);
            if(content==''){
                layer.msg('内容不能为空！')
                return false;
            }
            data.field.content = content;
            var index_o = layer.load();
            $.ajax({
                url:"edit.html",
                type:"post",
                data:data.field,
                dataType:"json",
                success:function(res){
                    layer.close(index_o);
                    top.layer.msg(res.msg);
                    if(res.code==200){
                        setTimeout(function(){
                            var page = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                            parent.layer.close(page); //再执行关闭
                            parent.location.reload();
                        },500)
                    }
                }
            })
            return false;
        });
    });
</script>
</body>
</html>