<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title><?php echo ($web_set["title"]); ?></title>
    <link href="/Application/Home/Common/css/login.css" rel="stylesheet" type="text/css">
    <script src="/Application/Home/Common/js/jquery.js" type="text/javascript"></script>
    <script src="/Application/Home/Common/js/jquery.supersized.min.js" type="text/javascript"></script>
    <script src="/Application/Home/Common/js/jquery.progressbar.js" type="text/javascript"></script>
</head>

<body>

<div class="login-layout">
    <div class="top">
        <h5>【兴百惠】 管理平台<em></em></h5>
        <h2>内部管理中心</h2>
        <h6>&nbsp;&nbsp;商机&nbsp;&nbsp;|&nbsp;&nbsp;客户&nbsp;&nbsp;|&nbsp;&nbsp;财务&nbsp;&nbsp;</h6>
    </div>
    <form  class="layui-form" id="form_login">
        <div class="lock-holder">
            <div class="form-group pull-left input-username" style="position:absolute;left:0;">
                <label>账号</label>
                <input name="login_id" autocomplete="off" type="text" class="input-text" lay-verify="required" value="" required>
            </div>
            <i class="fa fa-ellipsis-h dot-left"></i> <i class="fa fa-ellipsis-h dot-right"></i>
            <div class="form-group pull-right input-password-box"  style="position:absolute;right:0;">
                <label>密码</label>
                <input name="login_pwd" id="password" class="input-text" autocomplete="off" type="password" required lay-verify="required">
            </div>
        </div>
        <div class="avatar" style="position:absolute;left:50%;margin-left:-98px;">
		<img src="/Application/Home/Common/images/admin.png" alt="">
		</div>
				
				
		<div style="clear:both"></div>
        <div class="submit" style="position: absolute;top: 228px;left:50%;margin-left:-60px;">
            <span>
              <input name="" class="input-button btn-submit" id="login_btn_get" type="button" lay-submit lay-filter="login" value="登录">
            </span>
        </div>
        <div style="position: relative;top: 78px;" class="submit2"></div>
    </form>
    <div class="bottom">
    </div>
</div>
<script src="/Application/Home/Common/layui/layui.js" type="text/javascript" charset="utf-8"></script>
<!--页面JS脚本-->
    <script>
        $(function(){
            $.supersized({
                // 功能
                slide_interval     : 4000,
                transition         : 1,
                transition_speed   : 1000,
                performance        : 1,
                // 大小和位置
                min_width          : 0,
                min_height         : 0,
                vertical_center    : 1,
                horizontal_center  : 1,
                fit_always         : 0,
                fit_portrait       : 1,
                fit_landscape      : 0,
                // 组件
                slide_links        : 'blank',
                slides             : [
                    {image : '/Application/Home/Common/images/1.jpg'},
                    {image : '/Application/Home/Common/images/2.jpg'},
                    {image : '/Application/Home/Common/images/3.jpg'},
                    {image : '/Application/Home/Common/images/4.jpg'},
                    {image : '/Application/Home/Common/images/5.jpg'}
                ]
            });
			layui.use(['form', 'layedit', 'laydate'], function() {
				var form = layui.form,
					layer = layui.layer,
					jquery = layui.jquery;
				var off = true;
				var datas;
				$("#form_login").bind("keydown",function(e){
								// 兼容FF和IE和Opera    
						var theEvent = e || window.event;    
						var code = theEvent.keyCode || theEvent.which || theEvent.charCode;    
						if (code == 13) {    
								//回车执行查询
										$("#login_btn_get").click();
								}    
				});
				//监听提交
				form.on('submit(login)', function(data) {
					datas=  data.field;
					$('.input-username,dot-left').addClass('animated fadeOutRight');
					$('.input-password-box,dot-right').addClass('animated fadeOutLeft');
					$('.btn-submit').addClass('animated fadeOutUp');
					setTimeout(function () {
									$('.avatar').addClass('avatar-top');
									$('.submit').hide();
									$('.submit2').html('<div class="progress"><div class="progress-bar progress-bar-success" aria-valuetransitiongoal="100"></div></div>');
									$('.progress .progress-bar').progressbar({
										done:function(){
											$.ajax({
												url:"login.html",
												type:'post',
												data:datas,
												dataType:'json',
												success:function(res){
													layer.msg(res.msg)
													if(res.code==200){
														$('.input-username,dot-left').removeClass('animated fadeOutRight');
														$('.input-password-box,dot-right').removeClass('animated fadeOutLeft');
														$('.btn-submit').removeClass('animated fadeOutUp');
														$('.submit').show();
														$('.submit2').html('');
														window.location.href="<?php echo U('Index/index');?>";
													}else{
														$('.input-username,dot-left').removeClass('animated fadeOutRight');
														$('.input-password-box,dot-right').removeClass('animated fadeOutLeft');
														$('.btn-submit').removeClass('animated fadeOutUp');
														$('.submit').show();
														$('.submit2').html('');
													}
												}
											})
										}	
									})	
							},
							300);
					return false;
				});

			});
        });
    </script>
</body>
</html>