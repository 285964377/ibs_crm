<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
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

<body class="layui-layout-body">
	<style>
		a{
			font-style: normal;
		}
		body{
			font-style: none;
		}
		#input_nav_list li{
			line-height:28px;
			margin-left: 34px;
			height:28px;
			font-size:12px;
		}
		#input_nav_list li input{
			display: inline-block;
			width:200px;
			height:100%;
			padding-left:10px;
			margin-top:10px;
			margin-right:10px;
		}
	</style>
	<audio src="/Application/Home/Common/audio/get_msg.mp3" id="msg_ts"></audio>	
	<audio src="/Application/Home/Common/audio/get_my_msg.mp3" id="get_my_msg"></audio>	
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header custom-header">
					<ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item slide-sidebar" lay-unselect>
                    <a href="javascript:;" class="icon-font"><i class="ai ai-menufold"></i></a>
                </li>
            </ul>

			<ul class="layui-nav layui-layout-left" id="input_nav_list">
				<li>
					<input type="text" placeholder="请输入您想知道的问题">
					<button style="position: relative;top:-2px" id="index_search" class="layui-btn layui-btn-blue"><i class="layui-icon">&#xe615;</i>
						<i style="font-style: normal">搜索</i></button>
				</li>
			</ul>
			<ul class="layui-nav layui-layout-right">
				<li class="layui-nav-item">
						<a href="javascript:;"><?php echo ($user["role"]); ?>:<?php echo ($user["name"]); ?>（<?php echo ($user["code"]); ?>）-<?php echo ($user["part_name"]); ?></a>
						<dl class="layui-nav-child">
							<dd><a href="javascript:;" id="faq">FAQ</a></dd>
							<dd><a href="javascript:;" id="edit_pwd">修改登陆密码</a></dd>
							<dd><a href="javascript:;">登陆坐席</a></dd>
							<dd><a href="<?php echo U('Login/login_out');?>">登出</a></dd>
							<?php if($rush): ?><dd><a href="javascript:;" id="get_off">开启/关闭抢单	</a></dd><?php endif; ?>
						</dl>
				</li>
			</ul>
		</div>
		<div class="my_off" style="display:none;">
			<form class="layui-form">
				<div class="layui-form-item">
					<?php if($rush['rush'] == 1): ?><label class="layui-form-label" style="position: relative;top:6px;">关闭</label>
						<div class="layui-input-inline" style="width:56px;">
							<input type="checkbox" checked  lay-skin="switch" lay-filter="switchs">
						</div>
					<?php else: ?>
						<label class="layui-form-label" style="position: relative;top:6px;">开启</label>
						<div class="layui-input-inline" style="width:56px;">
							<input type="checkbox"  lay-skin="switch" lay-filter="switchs">
						</div><?php endif; ?>
				</div>
			</form>
		</div>	
		<div style="display:none;">
		</div>
        <div class="layui-side custom-admin">
          <div class="layui-side-scroll">
					<div class="custom-logo">
							<img src="/Application/Home/Common/images/logo.png" alt="" style="height:28px"/>
							<h1 style="margin-left:0;font-style: normal"><?php echo ($web_set["title"]); ?></h1>
					</div>
				 <ul id="Nav" class="layui-nav layui-nav-tree">
				  <li class="layui-nav-item layui-nav-itemed">
						<a href="javascript:;">
							<i class="layui-icon layui-icon-app"></i>
							<em>管理中心</em>
						</a>
						<dl class="layui-nav-child">
								<dd><a href="<?php echo U('Index/welcome');?>?index=1">工作台</a></dd>
						</dl>
					</li>
					<?php if(in_array('Customer/alloted',$power)): ?><li class="layui-nav-item">
						<a href="javascript:;">
							<i class="layui-icon layui-icon-group"></i>
							<em>客户</em>
						</a>
						<?php if(in_array('Customer/index',$power)): ?><dl class="layui-nav-child">
                            <dd><a href="<?php echo U('Customer/index');?>?index=1">待管理员分配</a></dd>
                        </dl><?php endif; ?>
						<?php if(in_array('Customer/alloted',$power)): ?><dl class="layui-nav-child">	
                            <dd><a href="<?php echo U('Customer/alloted');?>?index=1">我的客户</a></dd>
                        </dl><?php endif; ?>
						<?php if(in_array('Customer/import',$power)): ?><dl class="layui-nav-child">
                            <dd><a href="<?php echo U('Customer/import');?>?index=1">导入客户</a></dd>
                        </dl><?php endif; ?>
					</li><?php endif; ?>
					<?php if(in_array('Resources/index',$power)): ?><li class="layui-nav-item">
						<a href="javascript:;">
							<i class="layui-icon layui-icon-dollar"></i>
							<em>商机</em>
						</a>
						<?php if(in_array('Resources/add',$power)): ?><dl class="layui-nav-child">
                            <dd><a href="<?php echo U('Resources/add');?>?index=1">新增商机</a></dd>
                        </dl><?php endif; ?>
						<?php if(in_array('Resources/ing',$power)): ?><dl class="layui-nav-child">
							<dd><a href="<?php echo U('Resources/ing');?>?index=1">跟进中</a></dd>
						</dl><?php endif; ?>
						<?php if(in_array('Resources/over',$power)): ?><dl class="layui-nav-child">
							<dd><a href="<?php echo U('Resources/over');?>?index=1">已签单</a></dd>
						</dl><?php endif; ?>
						<?php if(in_array('Resources/checking',$power)): ?><dl class="layui-nav-child">
							<dd><a href="<?php echo U('Resources/checking');?>?index=1">待审核</a></dd>
						</dl><?php endif; ?>
						<?php if(in_array('Resources/checked',$power)): ?><dl class="layui-nav-child">
							<dd><a href="<?php echo U('Resources/checked');?>?index=1">审核被拒</a></dd>
						</dl><?php endif; ?>
						<?php if(in_array('Resources/white',$power)): ?><dl class="layui-nav-child">
							<dd><a href="<?php echo U('Resources/white');?>?index=1">白名单</a></dd>
						</dl><?php endif; ?>
						<?php if(in_array('Resources/out',$power)): ?><dl class="layui-nav-child">
							<dd><a href="<?php echo U('Resources/out');?>?index=1">事业部库</a></dd>
						</dl><?php endif; ?>
						<?php if(in_array('Resources/res_order',$power)): ?><dl class="layui-nav-child">
							<dd><a href="<?php echo U('Resources/res_order');?>?index=1">订单列表</a></dd>
						</dl><?php endif; ?>
						<?php if(in_array('Resources/res_order',$power)): ?><dl class="layui-nav-child">
							<dd><a href="<?php echo U('Resources/rk_log');?>?index=1">认款列表</a></dd>
						</dl><?php endif; ?>
					</li><?php endif; ?>
					<?php if(in_array('Orders/index',$power)): ?><li class="layui-nav-item">
                         <a href="javascript:;">
                             <i class="layui-icon layui-icon-form"></i>
                             <em>订单</em>
                         </a>
						  <?php if(in_array('Orders/checking',$power)): ?><dl class="layui-nav-child">
                             <dd><a href="<?php echo U('Orders/checking');?>?index=1">待接收订单</a></dd>
                         </dl><?php endif; ?>
						  <?php if(in_array('Orders/ing',$power)): ?><dl class="layui-nav-child">
                             <dd><a href="<?php echo U('Orders/ing');?>?index=1">办理中订单</a></dd>
                         </dl><?php endif; ?>
						  <?php if(in_array('Orders/over',$power)): ?><dl class="layui-nav-child">
                             <dd><a href="<?php echo U('Orders/over');?>?index=1">已完成订单</a></dd>
                         </dl><?php endif; ?>
						  <?php if(in_array('Orders/tcheck',$power)): ?><dl class="layui-nav-child">
                             <dd><a href="<?php echo U('Orders/tcheck');?>?index=1">退单待审核</a></dd>
                         </dl><?php endif; ?>
						  <?php if(in_array('Orders/order_tui',$power)): ?><dl class="layui-nav-child">
                             <dd><a href="<?php echo U('Orders/order_tui');?>?index=1">已退订单</a></dd>
                         </dl><?php endif; ?>
						  <?php if(in_array('Orders/rk_apply',$power)): ?><dl class="layui-nav-child">
							 <dd><a href="<?php echo U('Orders/rk_apply');?>?index=1">费用申请</a></dd>
						 </dl><?php endif; ?>
						  <?php if(in_array('Orders/rk_log',$power)): ?><dl class="layui-nav-child">
							 <dd><a href="<?php echo U('Orders/rk_log');?>?index=1">申请记录</a></dd>
						 </dl><?php endif; ?>
						  <?php if(in_array('Orders/demand',$power)): ?><dl class="layui-nav-child">
							 <dd><a href="<?php echo U('Orders/demand');?>?index=1">工单列表</a></dd>
						 </dl><?php endif; ?>
                     </li><?php endif; ?>
					 <?php if(in_array('Finance/index',$power)): ?><li class="layui-nav-item">
                         <a href="javascript:;">
                             <i class="layui-icon layui-icon-rmb"></i>
                             <em>财务</em>
                         </a>
						 <?php if(in_array('Finance/rk_log',$power)): ?><dl class="layui-nav-child">
                             <dd><a href="<?php echo U('Finance/rk_log');?>?index=1">认款列表</a></dd>
                         </dl><?php endif; ?>
						  <?php if(in_array('Finance/money_out',$power)): ?><dl class="layui-nav-child">
                             <dd><a href="<?php echo U('Finance/money_out');?>?index=1">费用申请</a></dd>
                         </dl><?php endif; ?>
						  <?php if(in_array('Finance/yj',$power)): ?><dl class="layui-nav-child">
                             <dd><a href="<?php echo U('Finance/yj');?>?index=1">业绩管理</a></dd>
                         </dl><?php endif; ?>
                     </li><?php endif; ?>
				    <?php if($basic_menu_power == 1): ?><li class="layui-nav-item">
						<a href="javascript:;">
							<i class="layui-icon layui-icon-set-fill"></i>
							<em>系统管理</em>
						</a>
						<dl class="layui-nav-child">
							<?php if(in_array('Part/index',$power)): ?><dd><a href="<?php echo U('Part/index');?>?index=1">部门管理</a></dd><?php endif; ?>
							<?php if(in_array('User/index',$power)): ?><dd><a href="<?php echo U('User/index');?>?index=1">员工管理</a></dd><?php endif; ?>
							<?php if(in_array('Orgin/index',$power)): ?><dd><a href="<?php echo U('Orgin/index');?>?index=1">商机来源管理</a></dd><?php endif; ?>
							<?php if(in_array('Wealth/index',$power)): ?><dd><a href="<?php echo U('Wealth/index');?>?index=1">商机资质管理</a></dd><?php endif; ?>
							<?php if(in_array('Restype/index',$power)): ?><dd><a href="<?php echo U('Restype/index');?>?index=1">商机类型管理</a></dd><?php endif; ?>
							<?php if(in_array('Custype/index',$power)): ?><dd><a href="<?php echo U('Custype/index');?>?index=1">客户分类管理</a></dd><?php endif; ?>
							<?php if(in_array('Label/index',$power)): ?><dd><a href="<?php echo U('Label/index');?>?index=1">标签管理</a></dd><?php endif; ?>
							<?php if(in_array('Role/index',$power)): ?><dd><a href="<?php echo U('Role/index');?>?index=1">角色管理</a></dd><?php endif; ?>
							<?php if(in_array('Faq/index',$power)): ?><dd><a href="<?php echo U('Faq/index');?>?index=1">FAQ管理</a></dd><?php endif; ?>
							<?php if(in_array('Faq/index',$power)): ?><dd><a href="<?php echo U('Article/index');?>?index=1">系统公告管理</a></dd><?php endif; ?>
							<?php if(in_array('Msg/index',$power)): ?><dd><a href="<?php echo U('Msg/index');?>?index=1">站内信管理</a></dd><?php endif; ?>
							<?php if(in_array('Goods/index',$power)): ?><dd><a href="<?php echo U('Goods/index');?>?index=1">产品管理</a></dd><?php endif; ?>
							<?php if(in_array('Change/index',$power)): ?><dd><a href="<?php echo U('Change/index');?>?index=1">流转规则设置</a></dd><?php endif; ?>
							<?php if(in_array('Operlog/index',$power)): ?><dd><a href="<?php echo U('Operlog/index');?>?index=1">系统操作日志</a></dd><?php endif; ?>
						</dl>
					</li><?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="layui-body " >
             <div class="layui-tab app-container" lay-allowClose="true" lay-filter="tabs">
                <ul id="appTabs" class="layui-tab-title custom-tab" ></ul>
                <div id="appTabPage" class="layui-tab-content"></div>
            </div>
        </div>
        <div class="layui-footer">
            <p><?php echo ($web_set["copyright"]); echo ($web_set["ipc"]); ?></p>
        </div>

        <div class="mobile-mask"></div>
    </div>
		<div class="edit_pwd" style="display:none;">
			<div class="layui-form" action="" >
				<div class="layui-form-item">
					<label class="layui-form-label" style="font-style: normal">新密码</label>
					<div class="layui-input-inline">
						<input type="password" style="font-style: normal" id="pwd_1" name="pwd" required  lay-verify="required" placeholder="请输入新密码" autocomplete="off" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label" style="font-style: normal">确认密码</label>
					<div class="layui-input-inline">
						<input type="password" style="font-style: normal" id="pwd_2" name="pwd" required  lay-verify="required" placeholder="请再次输入确认密码" autocomplete="off" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<div class="layui-input-block">
						<button class="layui-btn layui-btn-blue" lay-submit lay-filter="get_pwd" style="font-style: normal">提交</button>
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
    <script src="/Application/Home/Common/app/index.js" data-main="home"></script>
		<script>
			layui.config({
				base: '/Application/Home/Common/app/'
			}).use(['notice','layer'],function(){
				var notice=layui.notice;
				var layer= layui.layer;
				//发送消息处理
				var socket = new WebSocket('ws://172.16.1.78:7272');
				//连接成功时触发
				socket.onopen = function(){
						// 登录
						var login_data={
							type:'init',
							id:<?php echo ($user["uid"]); ?>,
						};
							login_data=JSON.stringify(login_data);
							socket.send(login_data);
				};
				//监听收到的消息
				socket.onmessage = function(res){
					var data=JSON.parse(res.data);
							switch(data['message_type']){
									// 服务端ping客户端
									case 'ping':
										socket.send('{"type":"ping"}');
											break;
									// 登录 更新用户列表
									case 'init':
											break;
									// 检测聊天数据
									case 'chatMessage':
										notice.init({
											type:'default	',
											align:'left',
											autoClose: false,
											title: data.title,
											id:data.id
										});
										document.getElementById('get_my_msg').play();
										msg_table.reload();
											break;
							}
				};
				//聊天服务器没有启动
				socket.onclose = function(){ 
					// 关闭 websocket
					notice.init({
						type:'default	',
						align:'left',
						autoClose: false,
						title: "已断开远程连接"
					});
				};
			});
		</script>
		<script>
			function msg(obj){
						layui.use(['jquery'],function(){
				var $=layui.jquery;
				var T_id = $(obj).attr('data-id');
				if(T_id){
					layer.open({
						type:2,
						content:"<?php echo U('Index/msg_details');?>?id="+T_id,
						area:['500px','198px']
					});  
				}
				})
			}		
		</script>
	<script>
		layui.use(['jquery','form','layer'],function(){
var $=layui.jquery,form= layui.form,layer=layui.layer;
var Index_tc;
    $('#get_off').click(function(){
		 Index_tc = 	layui.layer.open({
					title: "开启/关闭抢单",
					type: 1,
					content: $('.my_off'),
					area: ["200px", "100px"],
					shade: 0,
					offset:['80px','86%']
					
			})
		})
		form.on('switch(switchs)', function(data){
			var statuss = data.elem.checked;
			if(statuss){
				$.ajax({
					url:'change_rush.html',
					type:'post',
					dataType:'json',
					data:{'status':1},
					success:function(res){
						if(res.code==200){
						layer.msg(res.msg);
							
							layer.close('Index_tc')
						}
						
					}
				})
			}else{
				$.ajax({
					url:'change_rush.html',
					type:'post',
					dataType:'json',
					data:{'status':2},
					success:function(res){
						if(res.code==200){
							layer.msg(res.msg);
							layer.close('Index_tc')
						}
						
					}
				})
			}
		});  
		$('#index_search').click(function(){
			var obj = $(this);
			var text = obj.prev().val();
			if(text==''){
				layer.tips('请输入您的问题', obj.prev());
				return false;
			}
			search_url('0',"<?php echo U('Index/faq');?>?index=1&keywords="+text,'搜索结果')
		})
		
		$('#faq').click(function(){
			search_url('0',"<?php echo U('Index/faq');?>?index=1",'FAQ')
		})
		var my_pwd_box;
		$('#edit_pwd').click(function(){
			layui.use(['layer', 'element', 'jquery','form'], function() {
				var layer = layui.layer,form=layui.form;
				my_pwd_box=layer.open({
					title:'修改登陆密码',
					type: 1,
					content: $('.edit_pwd'),
					area: ['auto', 'auto']
				});
				form.on('submit(get_pwd)', function(data){
					if($('#pwd_1').val().length<6){
						layer.msg('密码不得少于6位!')
						return false;
					}
					if($('#pwd_1').val()!=$('#pwd_2').val()){
						layer.msg('两次输入密码不一致!')
						return false;
					}
					var index_o = layer.load();
					datas = data.field;
					$.ajax({
						url:'change_pwd.html',
						type:'POST',
						data:datas,
						dataType:'json',
						success:function(res){
							layer.msg(res.msg);
							layer.close(index_o);
							if(res.code==200){
								layer.close(my_pwd_box);
							}
						}
					})
					return false; 
				});
			})	
		})
	});	
		function search_url(id,url,text){
				var id = id;
				var url = url;
				var text = text;
			layui.use(['layer', 'element', 'jquery'], function() {
				var layer = layui.layer;
				var element = layui.element;
				var $ = layui.jquery;
				var isActive = $('#appTabs').find("li[lay-id="+id+"]");
				if(isActive.length>0){
						//切换到选项卡
						element.tabDelete('tabs',id);
						element.tabAdd('tabs',{
							title: text,	
							content:'<iframe  src="' + url + '" name="iframe' + id + '" class="iframe" framborder="0" data-id="' + id + '" scrolling="auto" width="100%"  height="100%"></iframe>',
							id:id
						})
						element.tabChange('tabs',id);
					}else{
						element.tabAdd('tabs',{
							title: text,	
							content:'<iframe  src="' + url + '" name="iframe' + id + '" class="iframe" framborder="0" data-id="' + id + '" scrolling="auto" width="100%"  height="100%"></iframe>',
							id:id
						})
						element.tabChange('tabs',id);
					}
					element.init();
			})
		}
		
	
	</script>
</body>
</html>