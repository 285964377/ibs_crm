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
		.layui-view-body{
			background: #fff;
		}
		.bz_title{
			background:#eff3f5;
			padding:10px;
			color:#000;
			font-size:14px;
			font-weight:bold;
		}
		.form_list{
			width:100%;
			overflow:hidden;
			margin-bottom:20px;
		}
		.form_list li{
			float:left;
			padding:10px;
			border:1px solid #eff3f5;
			margin-right:10px;
			margin-top:20px;
			font-size:12px;
			cursor: pointer;
		}
		.form_list li:hover{
			background:#eff3f5;
		}
		.gx_box{
			margin-bottom:20px;
		}
		.layui-textarea{
			min-height:0;
		}
	</style>
	<div class="layui-content">
	    <div class="layui-row">
				<div class="layui-card">
					<div class="gx_box">
						<h3 class="bz_title">上次记录
							<span style="font-weight: 100;margin-left:20px;color:#FF5722">商机阶段:<?php echo ($res["next_step"]); ?></span>
							<span style="font-weight: 100;margin-left:20px;color:#FF5722">时间:<?php echo ($res["next_time"]); ?></span>
							<span style="font-weight: 100;margin-left:20px;color:#FF5722">备注:<?php echo ($res["next_remark"]); ?></span>
						</h3>
					</div>
					<div class="form-box layui-form" style="margin-top:10px;">
					<div class="gx_box">
						<h3 class="bz_title">本次跟进</h3>
							<div class="" action="" style="margin-top:10px;">
								<label class="layui-form-label">商机阶段</label>
									<div class="layui-input-inline">
										<select name="stage" lay-verify="required" <?php if($res['status'] == 3): ?>disabled<?php endif; ?>>
												<option value="1">咨询</option>
												<option value="2">犹豫</option>
												<option value="3">意向</option>
												<option value="4">客户上门</option>
												<option value="5" <?php if($res['status'] == 3): ?>selected<?php endif; ?>>签约</option>
										</select>
									</div>
									<ul class="form_list">
										<?php if(is_array($label)): $i = 0; $__LIST__ = $label;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li onclick="fz(this)"><?php echo ($item["content"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>	
									</ul>
									<div class="layui-input-block" style="margin-left:0px;">
										<textarea name="remark" required="" style="width:100%;height:70px;resize: none;" lay-verify="required" placeholder="" class="layui-textarea "></textarea>
									</div>
							</div>	
				</div>	
					<div class="gx_box">
						<h3 class="bz_title">下次跟进</h3>
							<div class="" action="" style="margin-top:10px;">
								<label class="layui-form-label">商机阶段</label>
									<div class="layui-input-inline">
										<select name="next_step" lay-verify="required">
												<option value="1">咨询</option>
												<option value="2">犹豫</option>
												<option value="3">意向</option>
												<option value="4">客户上门</option>
												<option value="5">签约</option>
										</select>
									</div>
									<div class="layui-input-inline">
										<input type="text" id="step-date" style="position: relative;top: 1px;"  name="next_time" lay-verify="required" placeholder="请选择下次跟进时间" autocomplete="off" class="layui-input">
									</div>	
									<ul class="form_list">
										<?php if(is_array($label)): $i = 0; $__LIST__ = $label;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li onclick="fz(this)"><?php echo ($item["content"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>	
									</ul>
									<div class="layui-input-block" style="margin-left:0px;">
										<textarea name="next_remark" required="" style="width:100%;height:70px;resize: none;" lay-verify="required" placeholder="" class="layui-textarea "></textarea>
									</div>
							</div>	
					</div>
						<div class="layui-input-block" style="margin-left:0px;">
							<input type="hidden" name="id" value="<?php echo ($res["id"]); ?>"/>
							<button class="layui-btn layui-btn-blue" lay-submit lay-filter="get_my_goin">提交</button>
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
	  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="tj"><i class="layui-icon">&#xe608;</i>推荐</a>
	</script>
	<script type="text/html" id="sts">
	    <input type="checkbox" value="{{d.id}}" name="zzz" lay-skin="switch" {{ d.status == 1 ? 'checked' : '' }} lay-text="下架|上架" lay-filter="switchBtn">
	 </script>
	<script type="text/html" id="money">
		{{d.money_start}}万~{{d.money_end}}万
	</script>
	<script type="text/html" id="age">
		{{d.age_start}}~{{d.age_end}}
	</script>
	<script type="text/html" id="dk_time">
		{{d.dk_time_start}}~{{d.dk_time_end}}({{d.dk_time_type}})
	</script>
	<script type="text/html" id="loan_time">
		{{d.loan_time_start}}~{{d.loan_time_end}}({{d.loan_time_type}})
	</script>
	<script type="text/html" id="ratio">
		{{d.ratio_start}}%~{{d.ratio_end}}%({{d.ratio_type}})
	</script>
	<script type="text/javascript">
			layui.config({
				
				base: path+'/modules/table/',
			})
			var Ids ="<?php echo ($id); ?>";
			layui.use(['form','layer','table','laydate'],function(){
				var $ = layui.$,data,layer=layui.layer,form=layui.form,table=layui.table,laydate = layui.laydate;
				laydate.render({
					elem: '#step-date',
					type:'datetime',
					btns: ['clear', 'confirm'],
					min:"<?php echo date('Y-m-d H:i:s',time()+600); ?>"
				});
				form.on('submit(get_my_goin)', function(data){
					var datas = data.field;
					layer.confirm('是否提交跟进信息?', {icon: 3, title:'提示'},function(index){
						var index_o = layer.load();
						$.ajax({
							url:'go_in.html',
							type:'POST',
							data:datas,
							dataType:'json',
							success:function(res){
								layer.close(index_o);
									layer.msg(res.msg);
									if(res.code==200){
										setTimeout(function(){
											parent.location.reload();
											var index = parent.layer.getFrameIndex(window.name); 
											parent.layer.close(index);
										},500)
								}
							}
						})
					});  
					return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
				});
			})		
			function fz(obj){
				var oText = $(obj).parent().next().find('textarea').val()
				var Text = $(obj).text();
				oText+=Text;
				$(obj).parent().next().find('textarea').val(oText);
			}
	</script>
</body>
</html>