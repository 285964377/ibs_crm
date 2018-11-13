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
		.layui-view-body{
			background:#fff;
		}
		.layui-table{
			margin-top:0
		}
		.layui-table td, .layui-table th, .layui-table-col-set, .layui-table-fixed-r, .layui-table-grid-down, .layui-table-header, .layui-table-page, .layui-table-tips-main, .layui-table-tool, .layui-table-total, .layui-table-view, .layui-table[lay-skin=line], .layui-table[lay-skin=row]{
			border-width: 1px;
			border-style: solid;
			border-color: #c6d1d6;
		}
		.layui-table thead tr, .layui-table-click, .layui-table-header, .layui-table-hover, .layui-table-mend, .layui-table-patch, .layui-table-tool, .layui-table-total, .layui-table-total tr, .layui-table[lay-even] tr:nth-child(even){
			background: url(/Application/Home/Common/images/t_bck.png) repeat-x;
			background-size:100% 100%;
		}
		.layui-table td, .layui-table th{
			padding:0;
			text-align:center;
			line-height: 28px;
			font-size:12px;
			color:#000
		}
		.layui-form-item{
			margin-top:0
		}
		.sj_form{
			margin-bottom:10px;
		}
		.layui-form-label{
			width:auto;
		}
		.layui-form-mid{
				padding: 0px 0px !important;
		}
		.layui-form-radio{
			margin:0;
		}
			.layui-form-item{
				clear:none;
			}
		.layui-form-mid {
				line-height: 12px;
			}
			.layui-form-label{
				width:auto;
			}
</style>
<div class="layui-content">
	<form class="layui-form layui-row" style="padding:10px;" lay-filter="car_form">
			<div class="layui-form-item layui-col-sm12">
				<label class="layui-form-label">联系人姓名<span style="color:#FF5722">*</span></label>
				<div class="layui-input-block">
					<input type="text" name="name" required  value="" lay-verify="required" placeholder="请输入联系人姓名" autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item layui-col-sm12">
				<label class="layui-form-label">联系人电话<span style="color:#FF5722">*</span></label>
				<div class="layui-input-block">
					<input type="text" name="tel" required  value="" lay-verify="number" placeholder="请输入联系人电话" autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item  layui-col-sm12">
				<label class="layui-form-label">联系人类型</label>
				<div class="layui-input-block">
					<select name="type" >
							<option value="0">其他</option>
							<option value="1">配偶</option>
							<option value="2">直系亲属</option>
							<option value="3">本人</option>
					</select>
				</div>
			</div>
			<div class="layui-form-item layui-col-sm12">
				<label class="layui-form-label">联系人工作</label>
				<div class="layui-input-block">
					<input type="text" name="job"   value=""  placeholder="请输入联系人工作" autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item layui-col-sm12">
				<label class="layui-form-label">联系人关系</label>
				<div class="layui-input-block">
					<input type="text" name="ship"   value=""  placeholder="请输入联系人关系" autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item layui-col-sm12">
				<label class="layui-form-label">联系人住址</label>
				<div class="layui-input-block">
					<input type="text" name="address"   value=""  placeholder="请输入联系人住址" autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item  layui-col-sm12" style="margin-top:10px;">
				<div class="layui-input-block">
					<input type="hidden" value="<?php echo ($id); ?>" name="res_id" />
					<button class="layui-btn layui-btn-blue" lay-submit lay-filter="addlxr_from">立即提交</button>
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
	<script>
		var Ids = "<?php echo ($id); ?>";
	layui.use(['table','layer','jquery','form','element'],function(){
			var table = layui.table,layer= layui.layer,form = layui.form,$ = layui.jquery,laypage = layui.laypage,element = layui.element;
			form.on('submit(addlxr_from)', function(data){
			 var fields =  data.field;
			 layer.confirm('是否添加该联系人?', {icon: 3, title:'提示'},function(index){
			 	var index_o = layer.load();
			 	$.ajax({
			 		url:'add_contact.html',
			 		type:'POST',
			 		data:fields,
			 		dataType:'json',
			 		success:function(res){
			 			layer.close(index_o);
			 				layer.msg(res.msg);
			 				if(res.code==200){
			 					setTimeout(function(){
			 						parent.layui.table.reload('contacts');
			 						var index = parent.layer.getFrameIndex(window.name); 
			 						parent.layer.close(index);
			 					},500)
			 			}
			 		}
			 	})
			 });   
			  return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
			});
	});
	</script>
</body>
</html>