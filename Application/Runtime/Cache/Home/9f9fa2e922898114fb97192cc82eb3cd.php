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

	<style>
.wrapper {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 200px;
  height: 200px;
  -webkit-transform: translate(-50%, -50%) scale(1.2);
          transform: translate(-50%, -50%) scale(1.2);
}
.wrapper .pole {
  position: absolute;
  width: 5px;
  height: 250px;
  left: 50%;
  -webkit-transform-origin: center top;
          transform-origin: center top;
  -webkit-transform: translateX(-50%) rotate(-25deg);
          transform: translateX(-50%) rotate(-25deg);
  color: silver;
  background: currentColor;
}
.wrapper .pole.two {
  -webkit-transform: translateX(-50%) rotateY(-180deg) rotate(-25deg);
          transform: translateX(-50%) rotateY(-180deg) rotate(-25deg);
}
.wrapper .pole:before {
  content: "";
  position: absolute;
  top: -10px;
  left: -7px;
  width: 20px;
  height: 20px;
  border-radius: 100%;
  background: currentColor;
}
.wrapper .pole:after {
  content: "";
  position: absolute;
  left: 0;
  bottom: 0;
  width: 20px;
  height: 5px;
  -webkit-transform: translateX(-50%) rotate(25deg);
          transform: translateX(-50%) rotate(25deg);
  background: currentColor;
}
.wrapper .swing {
  position: absolute;
  width: 40px;
  height: 100%;
  left: calc(50% - 20px);
  -webkit-transform-origin: center top;
          transform-origin: center top;
  -webkit-animation-duration: 0.8s;
          animation-duration: 0.8s;
  -webkit-animation-iteration-count: infinite;
          animation-iteration-count: infinite;
  -webkit-animation-timing-function: ease-in-out;
          animation-timing-function: ease-in-out;
  -webkit-animation-direction: alternate;
          animation-direction: alternate;
}
.wrapper .swing .human {
  position: absolute;
  width: 40px;
  height: 80px;
  bottom: 5px;
  z-index: -1;
}
.wrapper .swing .human .top-part {
  position: absolute;
  width: 40px;
  height: 80px;
  bottom: 5px;
  -webkit-transform-origin: center bottom;
          transform-origin: center bottom;
  -webkit-animation-name: body-animation;
          animation-name: body-animation;
  -webkit-animation-duration: 0.8s;
          animation-duration: 0.8s;
  -webkit-animation-iteration-count: infinite;
          animation-iteration-count: infinite;
  -webkit-animation-timing-function: ease-in-out;
          animation-timing-function: ease-in-out;
  -webkit-animation-direction: alternate;
          animation-direction: alternate;
}
.wrapper .swing .human .top-part .head {
  position: absolute;
  bottom: 40px;
  left: 50%;
  -webkit-transform: translateX(-50%);
          transform: translateX(-50%);
  width: 20px;
  height: 20px;
  background: #d59e7b;
  border-radius: 100%;
  z-index: 2;
}
.wrapper .swing .human .top-part .head .hair {
  position: absolute;
  top: -5px;
  left: -10px;
  background: black;
  width: 22px;
  height: 44px;
  border-top-right-radius: 0%;
  border-top-left-radius: 100%;
  border-bottom-right-radius: 75%;
  border-bottom-left-radius: 10%;
  z-index: 2;
}
.wrapper .swing .human .top-part .head .fringe {
  position: absolute;
  top: -5px;
  left: 0;
  width: 0px;
  height: 0px;
  border-top: 10px solid black;
  border-bottom: 10px solid black;
  border-left: 10px solid transparent;
  border-right: 10px solid transparent;
  border-radius: 100%;
  -webkit-transform: rotate(45deg);
          transform: rotate(45deg);
}
.wrapper .swing .human .top-part .head .eye {
  content: "";
  position: absolute;
  top: 6px;
  right: 2px;
  width: 2px;
  height: 2px;
  background: black;
  border-radius: 100%;
}
.wrapper .swing .human .top-part .head .mouth {
  position: absolute;
  top: 10px;
  right: 0px;
  width: 0px;
  height: 0px;
  border-top: 3px solid transparent;
  border-bottom: 3px solid transparent;
  border-left: 3px solid transparent;
  border-right: 3px solid white;
  border-radius: 100%;
  -webkit-transform: rotate(28deg);
          transform: rotate(28deg);
}
.wrapper .swing .human .top-part .body {
  position: absolute;
  bottom: 0px;
  left: 50%;
  -webkit-transform: translateX(-50%);
          transform: translateX(-50%);
  background: #ee5130;
  width: 20px;
  height: 40px;
  border-top-left-radius: 20px;
  border-top-right-radius: 20px;
}
.wrapper .swing .human .top-part .body .hand {
  position: absolute;
  top: 20%;
  left: 10%;
}
.wrapper .swing .human .top-part .body .hand .hand-one {
  position: absolute;
  -webkit-transform: rotate(30deg);
          transform: rotate(30deg);
  width: 5px;
  height: 15px;
  background: #ee5130;
  box-shadow: 0 -1px 0px 1px rgba(0, 0, 0, 0.2);
  border-top-right-radius: 100%;
  border-top-left-radius: 100%;
}
.wrapper .swing .human .top-part .body .hand .hand-two {
  background: #d59e7b;
  position: absolute;
  top: 14px;
  left: -6px;
  width: 4px;
  height: 15px;
  -webkit-transform-origin: center top;
          transform-origin: center top;
  -webkit-transform: rotate(-60deg);
          transform: rotate(-60deg);
  border-top-left-radius: 15px;
}
.wrapper .swing .human .leg-one {
  position: absolute;
  bottom: 0;
  left: 10px;
  width: 40px;
  height: 10px;
  background: #1973ad;
  border-bottom-left-radius: 20px;
  border-top-right-radius: 20px;
  z-index: -1;
}
.wrapper .swing .human .leg-two {
  position: absolute;
  width: 40px;
  height: 10px;
  bottom: 5px;
  right: -5px;
  border-top-right-radius: 50%;
  border-bottom-right-radius: 20px;
  background: #1973ad;
  -webkit-transform-origin: right center;
          transform-origin: right center;
  -webkit-transform: rotate(-90deg);
          transform: rotate(-90deg);
  -webkit-animation-name: leg-animation;
          animation-name: leg-animation;
  -webkit-animation-duration: 0.8s;
          animation-duration: 0.8s;
  -webkit-animation-iteration-count: infinite;
          animation-iteration-count: infinite;
  -webkit-animation-timing-function: ease-in-out;
          animation-timing-function: ease-in-out;
  -webkit-animation-direction: alternate;
          animation-direction: alternate;
}
.wrapper .swing .human .leg-two:after {
  content: "";
  position: absolute;
  left: -5px;
  top: -1px;
  background: silver;
  height: 18px;
  width: 5px;
  border-top-left-radius: 3px;
  border-bottom-right-radius: 50%;
}
.wrapper .swing .swing-rod {
  position: absolute;
  width: 5px;
  height: 200px;
  left: 50%;
  -webkit-transform: translateX(-50%);
          transform: translateX(-50%);
  background: #323232;
}
.wrapper .swing .bottom {
  position: absolute;
  width: 100%;
  height: 5px;
  bottom: 0;
  background: saddlebrown;
}
.wrapper .swing:nth-of-type(1) {
  -webkit-animation-name: swing-1;
          animation-name: swing-1;
}
.wrapper .swing:nth-of-type(4) {
  -webkit-animation-name: swing-2;
          animation-name: swing-2;
}

@-webkit-keyframes swing-1 {
  from {
    -webkit-transform: rotate(-35deg);
            transform: rotate(-35deg);
  }
  to {
    -webkit-transform: rotate(35deg);
            transform: rotate(35deg);
  }
}

@keyframes swing-1 {
  from {
    -webkit-transform: rotate(-35deg);
            transform: rotate(-35deg);
  }
  to {
    -webkit-transform: rotate(35deg);
            transform: rotate(35deg);
  }
}
@-webkit-keyframes body-animation {
  from {
    -webkit-transform: rotate(-25deg);
            transform: rotate(-25deg);
  }
  to {
    -webkit-transform: rotate(20deg);
            transform: rotate(20deg);
  }
}
@keyframes body-animation {
  from {
    -webkit-transform: rotate(-25deg);
            transform: rotate(-25deg);
  }
  to {
    -webkit-transform: rotate(20deg);
            transform: rotate(20deg);
  }
}
@-webkit-keyframes leg-animation {
  from {
    bottom: 2px;
    right: -8px;
    -webkit-transform: rotate(-55deg);
            transform: rotate(-55deg);
  }
  to {
    bottom: 2px;
    right: 5px;
    -webkit-transform: rotate(-170deg);
            transform: rotate(-170deg);
  }
}
@keyframes leg-animation {
  from {
    bottom: 2px;
    right: -8px;
    -webkit-transform: rotate(-55deg);
            transform: rotate(-55deg);
  }
  to {
    bottom: 2px;
    right: 5px;
    -webkit-transform: rotate(-170deg);
            transform: rotate(-170deg);
  }
}
</style>
	<body style="position: relative;">
		<div class="my_box">
			<div class="wrapper">
			<div class="swing">
				<div class="human">
				<div class="top-part">
					<div class="head">
					<div class="hair"></div>
					<div class="fringe"></div>
					<div class="eye"></div>
					<div class="mouth"></div>
					</div>
					<div class="body">
					<div class="hand">
						<div class="hand-one"></div>
						<div class="hand-two"></div>
					</div>
					</div>
				</div>
				<div class="leg-one"></div>
				<div class="leg-two"></div>
				</div>
				<div class="swing-rod"></div>
				<div class="bottom"></div>
			</div>
			<div class="pole one"></div>
			<div class="pole two"></div>
			</div>
			<p style="width:200px;position:absolute;left:50%;margin-left:-100px;top:100px;font-size:20px;text-align:center;"><?php echo ($tis); ?></p>
		</div>	
	</body>
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
		var a="<?php echo ($flash); ?>";
		if(a=='yes'){
			setTimeout(function(){
				top.location.reload();
			},3000)
		}
	</script>