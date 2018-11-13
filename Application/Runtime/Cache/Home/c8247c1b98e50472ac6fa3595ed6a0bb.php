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
				<div class="layui-form">
					<div class="layui-form-item">
						<label class="layui-form-label" style="font-weight:bold;">标题：</label>
						<div class="layui-input-block">
							<h4 id="title"><?php echo ($data["title"]); ?></h4>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label" style="font-weight:bold;">创建时间：</label>
						<div class="layui-input-block">
							<h4 id="create-time"><?php echo ($data["creat_time"]); ?></h4>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label" style="font-weight:bold;">内容：</label>
						<div class="layui-input-block">
							<div id="content"><?php echo ($data["content"]); ?></div>
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
    $("body").bind("keydown",function(event){
        if (event.keyCode == 116) {
            event.preventDefault(); //阻止默认刷新
            location=location;
        }
    })
</script>
<script>
    layui.config({
        base: path+'/modules/table/',
    })
    layui.use(['table','layer','jquery','layedit','form'], function(){
        var table = layui.table,layer= layui.layer,$ = layui.jquery,layedit=layui.layedit,form=layui.form;
        var edit=layedit.build('editor',{
            tool: ['strong', 'italic', 'underline', 'del','|', 'left','center','right','image'],
            height:480
        })
    });
</script>
</body>
</html>