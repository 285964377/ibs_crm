//打电话
	function tel(obj){
		var tel = $(obj).attr('data-num');
		tc(tel,'否','拨打',function(){
			$('.poup-dw').fadeOut('slow');
		},function(){
			window.location.href="tel:"+tel;
		})
		$('.poup-tc').find('p').css('color','#548efd');
	}

//参数说明(title为你需要提示的内容)
function msg(title){
	var obj = '<p class="pop_one" style="display:none;">'+title+'</p>'
	$('.pop_one').remove();
	$('body').append(obj);
	$('.pop_one').fadeIn();
	setTimeout(function(){
		$('.pop_one').fadeOut();
	},1500)
}
//禁止键盘弹出
	function getBlur(){
		document.activeElement.blur();
	}
//双按钮弹窗
//参数说明(1.弹窗内容,2.左按钮内容,3.有按钮内容,4,左按钮回调,5.右按钮回调,关闭窗口调用:$('.poup-dw').fadeOut('slow');)
function tc(title,left,right,fnLeft,fnRight){
	var tcBox = '<div style="z-index:999;" class="poup-dw"><div class="poup-tc" style="display:block;"><p style="color:#000;font-weight:bold">'+title+'</p><div style=" display: -webkit-flex;display: flex;flex-direction:row;justify-content:space-between;"><a class="clear-get" href="javascript:;" style="float:left;color:#999999">'+left+'</a><a style="float:left;color:#000" class="yes-get" href="javascript:;">'+right+'</a></div></div>';
	$('.poup-dw').remove();
	$('body').append(tcBox);
	$('.poup-tc').fadeIn('slow');
	$(".clear-get").click(fnLeft);
	$(".yes-get").click(fnRight);
}
//单按钮弹窗
//参数说明(1.弹窗内容，2.按钮回调,关闭窗口调用:$('.poup-dw').fadeOut('slow');)
function tc_Two(title,text,fn){
	var tcBox = '<div style="z-index:999;" class="poup-dw"><div class="poup-tc" style="display:block;"><p>'+title+'</p><a style="color:#000;border-right:0" class="yes-get" href="javascript:;">'+text+'</a></div></div>';
	$('.poup-dw').remove();
	$('body').append(tcBox);
	$('.poup-tc').fadeIn('slow');
	$(".yes-get").click(fn);
}
//倒计时
function downS(elem,func){
	var s,noff=false,timeT,obj;
	obj=$(elem);
	timeT=setInterval(function(){
		var timeS=obj.text();
		s=parseInt(timeS); 
		if(s==0){
			s=0;
			noff=true;
		}
		if(noff){
			clearInterval(timeT);
			func();
		}else{
			s--;
		}
		obj.text(s+'S')
	},1000);
	
}
//数组中找到指定元素置顶
function addShift(arr,str){
	 //循环数组，找到该值删除
	 for (var i = 0; i < arr.length; i++) {
		if (arr[i] === str) {
			arr.splice(i, 1);
			break;
		}
	}
//再给开始部分添加该值	
	arr.unshift(str);
}
//限制字数  onkeydown="onInput(this,3)"
function onInput(obj, len) {  
    var value = $(obj).val(),  
      	vLen = value.length;  
    	vLen >= len ? $(obj).val(value.slice(0, len - 1)) : "";  
}  
//加载
function loading(color,img){
	var Dom = "<div class='"+color+"'><div class='"+img+"'></div></div>";
	$('body').append(Dom);
}
//API提交
function GetApi(url,type,data,success,error){
	$.ajax({
		url:url,
		type:type,
		data:data,
		dataType:'json',
		success:success,
		error:error
	})
}

//////////////////////////////////////////////////////////////////////////////
//正则
var mobile = /^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/;//手机号码
var identity_card = /^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|[xX])$/;// 身份证
var moeny_zz = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;