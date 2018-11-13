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
	</style>
	<div class="layui-content">
	    <div class="layui-row">
			<div class="layui-card">
				<div class="layui-card-body">
					<div class="form-box">
						<div class="layui-form" action="">
							<div class="layui-form-item">
								<label class="layui-form-label">姓名<span style="color:#FF5722;font-size:22px">*</span>：</label>
								<div class="layui-input-inline">
								  <input type="text" name="name" required  value="<?php echo ($data["name"]); ?>" ay-verify="required" placeholder="请输入姓名" autocomplete="off" class="layui-input">
								</div>
							</div>
							<div class="layui-form-item">
								<label class="layui-form-label">工号<span style="color:#FF5722;font-size:22px">*</span>：</label>
								<div class="layui-input-inline">
								<input type="text" name="code" required value="<?php echo ($data["code"]); ?>"  lay-verify="required" placeholder="请输入工号" autocomplete="off" class="layui-input">
								</div>
							</div>
							<div class="layui-form-item">
								<label class="layui-form-label">部门<span style="color:#FF5722;font-size:22px">*</span>：</label>
								<div class="layui-input-inline">
								<input type="text" name="part_id" id="tree"  value="<?php echo ($data["part_id"]); ?>" lay-filter="tree" required  lay-verify="required" placeholder="请选择部门" autocomplete="off" class="layui-input">
								</div>
							</div>
							<input type="hidden" value="" />
							<div class="layui-form-item">
								<label class="layui-form-label">登陆账号<span style="color:#FF5722;font-size:22px">*</span>：</label>
								<div class="layui-input-inline">
								<input type="text" name="login_id" value="<?php echo ($data["login_id"]); ?>" required  lay-verify="required" placeholder="请输入登陆账号" autocomplete="off" class="layui-input">
								</div>
							</div>
							<div class="layui-form-item">
								<label class="layui-form-label">角色</label>
								<div class="layui-input-inline">
								<select name="role_id" lay-verify="required">
									<?php if(is_array($role)): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option value="<?php echo ($item["id"]); ?>" <?php if($data['role_id'] == $item['id']): ?>selected<?php endif; ?> ><?php echo ($item["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
								</select>
								</div>
							</div>
							<div class="layui-form-item">
								<label class="layui-form-label">sip账号：</label>
								<div class="layui-input-inline">
								<input type="text" name="sip" value="<?php echo ($data["sip"]); ?>" placeholder="请输入sip账号" autocomplete="off" class="layui-input">
								</div>
							</div>
							<div class="layui-form-item">
								<label class="layui-form-label">sip密码：</label>
								<div class="layui-input-inline">
								<input type="text" name="sip_pwd"  value="<?php echo ($data["sip_pwd"]); ?>" placeholder="请输入sip密码" autocomplete="off" class="layui-input">
								</div>
							</div>
							<div class="layui-form-item">
								<label class="layui-form-label">身份证<span style="color:#FF5722;font-size:22px">*</span>：</label>
								<div class="layui-input-inline">
								<input type="text" name="idcard" value="<?php echo ($data["idcard"]); ?>" required  lay-verify="required" placeholder="请输入身份证号码" autocomplete="off" class="layui-input">
								</div>
							</div>
							<div class="layui-form-item">
								<label class="layui-form-label">电话号码<span style="color:#FF5722;font-size:22px">*</span>：</label>
								<div class="layui-input-inline">
								<input type="text" name="tel" value="<?php echo ($data["tel"]); ?>" required  lay-verify="required" placeholder="请输入电话号码" autocomplete="off" class="layui-input">
								</div>
							</div>
							<div class="layui-form-item">
								<div class="layui-input-block">
									<input type="hidden" name="id" value="<?php echo ($data["uid"]); ?>" />
								  <button class="layui-btn layui-btn-blue" lay-submit lay-filter="eidt" >保存</button>
								</div>
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
	<!--存放默认的权限-->
	<input type="hidden" name="roleID" id="roleID" value="<?php echo ($role[0]['id']); ?>" />
	<script type="text/html" id="cz">
	  <a class="layui-btn layui-btn-sm" lay-event="edit"><i class="layui-icon">&#xe642;</i>编辑</a>
	  <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="reset">重置密码</a>
	  <a class="layui-btn layui-btn-sm" style="background-color:#393D49;" lay-event="del"><i class="layui-icon">&#xe640;</i>删除</a>
	</script>
	<script type="text/javascript">
		layui.config({
			base: path+'/modules/table/',
		})
	layui.use(['form','layer','table'],function(){
		var $ = layui.$,data,layer=layui.layer,form=layui.form,table=layui.table;
	//监听发送	
		form.on('submit(eidt)',function(data){
			var data=data.field;
			var index_o = layer.load();
			$.ajax({
				url:'edit.html',
				type:'POST',
				data:data,
				dataType:'json',
				success:function(res){
						layer.msg(res.msg);
						layer.close(index_o);
						if(res.code==200){
							setTimeout(function(){
								var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
								parent.layer.close(index); //再执行关闭  
								parent.layui.table.reload('Machine');
							},500)
					}
				}
			})
			return false;
		})		
		
	})		
	
	 layui.config({
			base: path+'/modules/treeSelect/',
		})
		layui.use(['treeSelect','form','layer'],function(){
			var treeSelect= layui.treeSelect;
	
			treeSelect.render({
				// 选择器
				elem: '#tree',
				// 数据
				data: "<?php echo U('Back/select_part');?>",
				// 异步加载方式：get/post，默认get
				type: 'get',
				// 占位符
				placeholder: '选择部门',
				// 是否开启搜索功能：true/false，默认false
				search: false,
				// 点击回调
				click: function(d){
					$('#tree').val(d.current.id);
	
				},
				// 加载完成后的回调函数
				success: function (d) {
					//console.log(d);
					//                选中节点，根据id筛选
					treeSelect.checkNode('tree', <?php echo ($data["part_id"]); ?>);
	
					//                获取zTree对象，可以调用zTree方法
					//                var treeObj = treeSelect.zTree('tree');
					//                console.log(treeObj);
	
					//                刷新树结构
					//                treeSelect.refresh();
				}
			});
		})
	</script>
</body>
</html>