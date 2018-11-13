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
									<form class="layui-form" action="">
											<div class="layui-form-item">
												<label class="layui-form-label">超时未首电</label>
												<div class="layui-input-inline">
													<select name="first_time" lay-verify="required">
														<?php $__FOR_START_9592__=5;$__FOR_END_9592__=21;for($i=$__FOR_START_9592__;$i < $__FOR_END_9592__;$i+=1){ ?><option value="<?php echo ($i); ?>" <?php if($data['first_time'] == $i): ?>selected<?php endif; ?>><?php echo ($i); ?></option><?php } ?>
													</select>
												</div>
												<div class="layui-form-mid layui-word-aux">分钟</div>
												<div class="layui-form-mid layui-word-aux">（说明：商务获得商机后，X分钟内没有打电话或者跟进）</div>
											</div>
											<div class="layui-form-item">
												<label class="layui-form-label">超期未跟进</label>
												<div class="layui-input-inline">
													<select name="over_time" lay-verify="required">
														<?php $__FOR_START_28153__=1;$__FOR_END_28153__=11;for($i=$__FOR_START_28153__;$i < $__FOR_END_28153__;$i+=1){ ?><option value="<?php echo ($i); ?>"  <?php if($data['over_time'] == $i): ?>selected<?php endif; ?> ><?php echo ($i); ?></option><?php } ?>
													</select>
												</div>
												<div class="layui-form-mid layui-word-aux">天</div>
												<div class="layui-form-mid layui-word-aux">（说明：首电之后在X天内未跟进）</div>
											</div>
											<div class="layui-form-item">
												<label class="layui-form-label">成单保护期</label>
												<div class="layui-input-inline">
													<input type="text" name="success_time" value="<?php echo ($data["success_time"]); ?>" required lay-verify="required" placeholder="请输入成单保护期" autocomplete="off" class="layui-input">
												</div>
												<div class="layui-form-mid layui-word-aux">天</div>
												<div class="layui-form-mid layui-word-aux">（说明：签单之后在X天内不掉库）</div>
											</div>
											<div class="layui-form-item" style="margin-left:20px">
												<div class="layui-input-inline">
													<button class="layui-btn layui-btn-blue" lay-submit lay-filter="Edit">保存</button>
												</div>
											</div>
										</form>
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
	<script type="text/javascript">
			layui.use(['form','layer'],function(){
				var $ = layui.$,data,layer=layui.layer,form=layui.form;
				//提交编辑内容
				form.on('submit(Edit)', function(data){
						var index_o = layer.load();
						var datas = data.field;
						$.ajax({
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
		</script>
</body>
</html>