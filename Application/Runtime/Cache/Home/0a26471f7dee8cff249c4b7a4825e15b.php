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
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
				-webkit-appearance: none;
		}
		input[type="number"]{
				-moz-appearance: textfield;
		}
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
			clear:none;
		}
	.layui-form-mid {
			line-height: 12px;
		}
		.layui-form-label{
			width:auto;
		}
		.layui-table-view .layui-table{
			width:100%;
		}
		.my_fj_list img{
			width:100%;
			height:138px;
			cursor: pointer;
		}
		.my_fj_list li{
			margin-bottom:20px;	
		}
		.my_fj_list li>div{
			border:1px solid #eee;
			position:relative;
		}
		.my_fj_list p{
			font-size:12px;
			padding:10px 6px;
			background:#eff3f5;
			color:#000;
			overflow: hidden;
			text-overflow:ellipsis;
			white-space: nowrap;
		}
		.my_fj_list li>div span{
			cursor: pointer;

			display: block;
			width: 36px;
			height: 36px;
			background: url(/Application/Home/Common/images/del.png) no-repeat;
			background-size: 100% 100%;
			position: absolute;
			right: -18px;
			top: -15px;
		}
		.my_box_input input{
			text-align:center;
			border:none;
			padding-left:0;
		}
		.my_box_input .layui-form-select .layui-input {
			padding-right:0;
		}
		.layui-form-item .layui-input-inline{
			width:auto;
		}
		.user_input .my_input{
			display: inline-block;
			width:41%;
		}
		.user_input .layui-form-select{
			    width: 70px;
			display: inline-block;
		}
		.user_input .layui-form-item .layui-input-inline{
			width:264px;
		}
		.user_input .my_input_sec{
			width: 88px;
			display: inline;
		}
	</style>
<body class="layui-view-body">
	<div class="layui-content">
		<div class="my_style_table">
			<div class="head_top_table">
				<li><p>
				<span class="fwt">客户</span>：<span class="blue"><?php echo ($res["name"]); ?></span>( <?php echo ($cus["code"]); ?> )
				<span style="margin-left:10px;" class="fwt" id="edit_base" href="javascript:;">签单时间：<span style="color:#FF5722"><?php echo ($res["over_time"]); ?></span></span></p></li>
			</div>
			<ul class="my_style_table_body">
				<li class="layui-row">
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>客户名称：</span>
							<span><?php echo ($res["name"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>手机号码：</span>
							<?php if($res['tel']): ?><span><?php echo ($res["tel"]); ?></span>
								<a id="see_tel" class="layui-btn layui-btn-blue layui-btn-xs"
								   style="position:relative;top:-2px;left:4px" data-tel="<?php echo ($res["phone"]); ?>" href="javascript:;">查看</a>
							<?php else: ?>
								<span><?php echo ($res["phone"]); ?></span><?php endif; ?>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>身份证号码：</span>
							<span><?php echo ($cus["idcard"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>客户性别：</span>
							<span><?php echo ($cus["sex"]); ?></span>
						</p>	
					</div>
				</li>
				<li>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>客户年龄：</span>
							<span><?php echo ($cus["age"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>户口所在地：</span>
							<span><?php echo ($cus["huji"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>客户学历：</span>
							<span><?php echo ($cus["education"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>客户婚姻状况：</span>
							<span><?php echo ($cus["marriage"]); ?></span>
						</p>	
					</div>
				</li>
				<li>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>客户子女个数：</span>
							<span><?php echo ($cus["child"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>客户地址：</span>
							<span><?php echo ($cus["address"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>邮箱：</span>
							<span><?php echo ($cus["email"]); ?><span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>签单人：<?php echo ($res["user_name"]); ?>（<?php echo ($res["user_code"]); ?>）</span>
							<span></span>
						</p>	
					</div>
				</li>
				<li>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>商机类型：</span>
							<span><?php echo ($res["res_type"]); ?> </span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>商机来源：</span>
							<span><?php echo ($res["origin"]); ?></span>
						</p>	
					</div>
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>贷款金额（万）：</span>
							<span><?php echo ($res["dk_money"]); ?></span>
						</p>	
					</div>
					
					<div class="layui-col-xs12 layui-col-sm6 layui-col-md3">
						<p>
							<span>备注：</span>
							<span><?php echo ($res["remark"]); ?></span>
						</p>	
					</div>
				</li>
			</ul>
		</div>
		
		<div class="my_style_table">
			<form class="layui-form" enctype="multipart/form-data" id="fj_form" lay-filter="car_form">
				<ul class="head_top_table">
					<li><p>合同信息</p></li>
				</ul>
					<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
						<label class="layui-form-label">合同编号<span style="color:#FF5722">*</span></label>
						<div class="layui-input-inline">
							<input type="text" name="contract"    value="" lay-verify="required" placeholder="请输入合同编号" autocomplete="off" class="layui-input ">
						</div>
					</div>
					<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
						<label class="layui-form-label">贷款金额<span style="color:#FF5722">*</span></label>
						<div class="layui-input-inline">
							<input type="text" name="dk_money" onkeyup="je(this)"   lay-verify="required" placeholder="请输入贷款金额" autocomplete="off" class="layui-input ">
						</div>
						<div class="layui-form-mid layui-word-aux">万</div>
					</div>	
					<div class="layui-form-item user_input layui-col-md3 layui-col-xs12">
						<label class="layui-form-label">贷款时长<span style="color:#FF5722;font-size:22px">*</span>：</label>
						<div class="layui-input-inline">
							<input type="text" name="dk_time"  onblur="blur_one(this)"   lay-verify="required" placeholder="贷款时长" autocomplete="off" class="layui-input my_select my_input_sec">
							<select name="dk_time_type" lay-verify="required"  class="my_select">
								<option value="天">天</option>
								<option value="月">月</option>
								<option value="年">年</option>
							</select>
						</div>
					</div>
					<div class="layui-form-item user_input layui-col-md3 layui-col-xs12layui-col-md3 layui-col-xs12" style="display: inline-block;">
						<label class="layui-form-label">贷款利率<span style="color:#FF5722;font-size:22px">*</span>：</label>
						<div class="layui-input-inline">
							<input type="text" name="dk_ratio"  onblur="blur_one(this)"   lay-verify="required" placeholder="贷款利率" autocomplete="off" class="layui-input my_select my_input_sec">
							<select name="dk_ratio_type" lay-verify="required"  class="my_select">
								<option value="日息">日息(%)</option>
								<option value="月息">月息(%)</option>
								<option value="年息">年息(%)</option>
							</select>
						</div>
					</div>
					<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
						<label class="layui-form-label">定金<span style="color:#FF5722">*</span></label>
						<div class="layui-input-inline">
							<input type="text" name="ding_money" onkeyup="je(this)"   lay-verify="required" placeholder="请输入定金" autocomplete="off" class="layui-input ">
						</div>
						<div class="layui-form-mid layui-word-aux">元</div>
					</div>
					<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
						<label class="layui-form-label">服务费<span style="color:#FF5722">*</span></label>
						<div class="layui-input-inline">
							<input type="text" name="fuwu_money" onkeyup="je(this)"   lay-verify="required" placeholder="请输入服务费" autocomplete="off" class="layui-input ">
						</div>
						<div class="layui-form-mid layui-word-aux">%</div>
					</div>
					<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
						<label class="layui-form-label">接单人<span style="color:#FF5722">*</span></label>
						<div class="layui-input-inline">
							<input type="text"  id="contract" onclick="jdr(this)"  value="" lay-verify="required" placeholder="请选择接单人" autocomplete="off" class="layui-input ">
						</div>
						<input type="hidden" name="accept_user" id="accept_id" value="" />
					</div>
					<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
						<div class="layui-form-item layui-col-sm12">
							<label class="layui-form-label">合同文件</label>
							<div class="layui-form-item layui-col-sm12" style="position:relative;width:120px;height:122px;left:20px;">
									<img style="width:100%;height:100%;" id="imgs" src="/Application/Home/Common/images/get_img.png">
									<input id="imgs_get" style="position:absolute;top:0;left:0;width:100%;height:100%; filter:alpha(opacity=0);-moz-opacity:0;-khtml-opacity:0;opacity:0;"  name="img" type="file" onchange="photo(this,'imgs')" data-path="">
							</div>
						</div>
					</div>
					<div style="clear:both"></div>
				<div class="head_top_table" style="margin-top:10px;">
					<li><p><span class="fwt">借贷人</span><a style="margin-left:10px" id="addJd" href="javascript:;" class="layui-btn layui-btn-blue layui-btn-xs">添加</a></p></li>
				</div>
				<table class="layui-table">
				  <thead>
					<tr>
					  <th>身份</th>
					  <th>姓名</th>
					  <th>身份证号码</th>
					  <th>联系电话</th>
					  <th>婚姻状况</th>
					  <th>子女情况</th>
					  <th>家属是否知晓</th>
					  <th>与主借贷人关系</th>
					  <th>是否是客户本人</th>
					  <th>操作</th>
					</tr> 
				  </thead>
				  <tbody class="my_box_input">
						<tr data-zjd='yes'>
							<td>
								<!-- <option value="2">次借贷人</option> -->
								<select  name="type[]">
									<option  value="1">主借贷人</option>
								</select>
							</td>
							<td><input  type="text" lay-verify="required" class="layui-input" name="name[]" value="" placeholder="姓名" /></td>
							<td><input type="number" lay-verify="required" class="layui-input" name="id_number[]" value="" placeholder="身份证号码" /></td>
							<td><input type="number" lay-verify="required" class="layui-input" name="tel[]" value="" placeholder="联系电话" /></td>
							<td> 
								<select name="marriage[]" lay-verify="required">
									<option value="未知">未知</option>
									<option value="已婚">已婚</option>
									<option value="未婚">未婚</option>
									<option value="离异">离异</option>
									<option value="丧偶">丧偶</option>
									<option value="再婚">再婚</option>
								</select>
							</td>
							<td>
								<select name="child[]" lay-verify="required">
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								</select>

							</td>
							<td>
								<select name="family[]" lay-verify="required">
									<option value="知晓">知晓</option>
									<option value="不知晓">不知晓</option>
								</select>
							</td>
							<td>
								<select name="ships[]" lay-verify="required">
									<option value="夫妻">夫妻</option>
									<option value="子女">子女</option>
									<option value="朋友">朋友</option>
									<option value="同事">同事</option>
								</select>
							</td>
							<td>
								<select name="is_self[]" lay-verify="required">
									<option value="是">是</option>
									<option value="否">否</option>
								</select>	
							</td>
							<td><a href="javascript:;" style="margin:0 14px" class="layui-btn layui-btn-danger layui-btn-xs" onclick="del_yx(this)" >删除</a></td>
						</tr>
				  </tbody>
				</table>
				
					<div class="layui-form-item" >
						<div class="layui-input-inline">
						 <button class="layui-btn layui-btn-danger" lay-submit lay-filter="get_cgx">保存草稿箱</button>
						  <button class="layui-btn layui-btn-blue" lay-submit lay-filter="get_order">立即下单</button>
						</div>
					</div>
			</form>	
		</div>	
	</div>			
		
	<!-- 接单人 -->
	<div id="sj_jdr" style="display:none;">
		<div class="layui-content">
			<div class="layui-row">
				<div class="layui-card">
					<div class="layui-card-body">
						<div class="form-box">
							<div class="layui-inline" style="width: 150px">
								<input type="text"  id="tree" name="" lay-filter="tree" class="layui-input">
							</div>
							<div class="layui-inline">
								<input type="text" style="width: 150px" name="" placeholder="姓名/电话" autocomplete="off" class="layui-input" id="like">
							</div>

							<button style="margin-left: 20px;" class="layui-btn layui-btn-normal" lay-submit id="search" lay-filter="search">搜索</button>
						</div>
						<div class="layui-form">
							<table id="department_table" class="layui-hide" lay-filter="department_table"></table>
						</div>
					</div>
					<div class="form-box" style="text-align: center">
						<button class="layui-btn layui-btn-blue" id="choose" lay-submit >选择</button>
						<button type="reset" id="close" class="layui-btn layui-btn-primary ">关闭</button>
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
	<script type="text/html" id="cz_lxr">
		<a href="javascript:;"  class='layui-btn layui-btn-danger layui-btn-xs' lay-event="del_lxr">删除</a>
	</script>
	<script>
		
		var tc_o,tc_t,tc_r,tc_f,add_box,Machine;
		var Ids = "<?php echo ($res["id"]); ?>";
		layui.config({
			base: path+'/modules/treeSelect/',
		})
		layui.use(['table','layer','jquery','form','element','treeSelect','laydate'],function(){
			var table = layui.table,layer= layui.layer,form = layui.form,$ = layui.jquery,laypage = layui.laypage,element = layui.element,treeSelect=layui.treeSelect,laydate=layui.laydate;
			 laydate.render({
				elem: '#times',
				range:'~',
				type:'datetime'
			});
			treeSelect.render({
			            // 选择器
			            elem: '#tree',
			            // 数据
			            data: "<?php echo U('Back/select_all_part');?>",
			            // 异步加载方式：get/post，默认get
			            type: 'get',
			            // 占位符
			            placeholder: '选择部门',
			            // 是否开启搜索功能：true/false，默认false
			            search: false,
			            // 点击回调
			            click: function(d){
			                console.log(d);
			                $('#tree').val(d.current.id);
			
			            },
			            // 加载完成后的回调函数
			            success: function (d) {
			                console.log(d);
			                //                选中节点，根据id筛选
			                //                treeSelect.checkNode('tree', 3);
			
			                //                获取zTree对象，可以调用zTree方法
			                //                var treeObj = treeSelect.zTree('tree');
			                //                console.log(treeObj);
			
			                //                刷新树结构
			                //                treeSelect.refresh();
			            }
			        });
		form.on('submit(get_order)',function(data){
			if($('#imgs_get').val()==''){
				layer.tips('请上传合同截图', '#imgs_get');
				return false;
			}
			var index_o = layer.load();
			var data = new FormData($('#fj_form')[0]);
			data.append('res_id',Ids);
			data.append('status',1);
			$.ajax({
				url:'xd.html',
				type:'POST',
				data:data,
				dataType:'json',
				processData: false,
				contentType: false,
				success:function(res){
						layer.msg(res.msg);
						layer.close(index_o);
						if(res.code==200){
							setTimeout(function(){
								var index = parent.layer.getFrameIndex(window.name); 
								parent.layer.close(index);
								parent.layui.table.reload('Machine');
							},500)
					}
				}
			})
			return false;
		})
            var off = true;
            $('#see_tel').click(function () {
                var that = this;
                if (off) {
                    off = false;
                    var Tel=$(that).attr('data-tel');
                    layer.msg(Tel, {
                        icon: 4,
                        time: 5000
                    }, function () {
                        off = true;
                    });
                }
            })
		form.on('submit(get_cgx)',function(data){
			if($('#imgs_get').val()==''){
				layer.tips('请上传合同截图', '#imgs_get');
				return false;
			}
			var index_o = layer.load();
			var data = new FormData($('#fj_form')[0]);
			data.append('res_id',Ids);
			data.append('status',0);
			$.ajax({
				url:'xd.html',
				type:'POST',
				data:data,
				dataType:'json',
				processData: false,
				contentType: false,
				success:function(res){
						layer.msg(res.msg);
						layer.close(index_o);
						if(res.code==200){
							setTimeout(function(){
								var index = parent.layer.getFrameIndex(window.name); 
								parent.layer.close(index);
								parent.layui.table.reload('Machine');
							},500)
					}
				}
			})
			return false;
		})
		$('#addJd').click(function(){
			for(var i = 0;i<$('.my_box_input').find('input').length;i++){
                    if($('.my_box_input tr').find('input').eq(i).val()==''){
                        layer.msg('请填写完整再添加');
                        return false;
                    }
                }
			var dom = '<tr>'+
						'<td>'+
							'<select  name="type[]">'+
								'<option value="2">次借贷人</option>'+
							'</select>'+
						'</td>'+
						'<td><input  type="text" class="layui-input" name="name[]" value="" placeholder="姓名" /></td>'+
						'<td><input type="number" class="layui-input" name="id_number[]" value="" placeholder="身份证号码" /></td>'+
						'<td><input type="number" class="layui-input" name="tel[]" value="" placeholder="联系电话" /></td>'+
						'<td> '+
							'<select name="marriage[]">'+
								'<option value="未知">未知</option>'+
								'<option value="已婚">已婚</option>'+
								'<option value="未婚">未婚</option>'+
								'<option value="离异">离异</option>'+
								'<option value="丧偶">丧偶</option>'+
								'<option value="再婚">再婚</option>'+
							'</select>'+
						'</td>'+
						'<td>'+
							'<select name="child[]" lay-verify="">'+
								'<option value="0">0</option>'+
								'<option value="1">1</option>'+
								'<option value="2">2</option>'+
								'<option value="3">3</option>'+
								'<option value="4">4</option>'+
							'</select>'+
						'</td>'+
						'<td>'+
							'<select name="family[]" lay-verify="">'+
								'<option value="知晓">知晓</option>'+
								'<option value="不知晓">不知晓</option>'+
						'</select>'+
						'</td>'+
						'<td>'+
							'<select name="ships[]" lay-verify="">'+
								'<option value="夫妻">夫妻</option>'+
								'<option value="子女">子女</option>'+
								'<option value="朋友">朋友</option>'+
								'<option value="同事">同事</option>'+
							'</select>'+
						'</td>'+
						'<td>'+
							'<select name="is_self[]" lay-verify="">'+
								'<option value="夫妻">是</option>'+
								'<option value="子女">否</option>'+
							'</select>'+	
						'</td>'+
						'<td><a href="javascript:;" style="margin:0 14px" class="layui-btn layui-btn-danger layui-btn-xs" onclick="del_yx(this)" data-id="<?php echo ($item["gid"]); ?>">删除</a></td>'+
					'</tr>';
				$('.my_box_input').append(dom);
				form.render();
		})
});	
		function del_yx(obj){
			if($(obj).parents('tr').attr('data-zjd')=='yes'){
				layer.msg('主借贷人不可删除!')
				return false;
			}
			$(obj).parents('tr').remove();
		}
		var jdr_tc;
	function jdr(){
		jdr_tc =  layer.open({
			title: '选择接单人',
			type: 1,
			content:$('#sj_jdr'),
			area: ['800px', '500px']
		})
		  layui.config({
        base: path+'/modules/table/',
    })
    var datass;
    layui.use(['treetable','form','table','layer'],function() {
        var $ = layui.$, treetable = layui.treetable,form=layui.form, table = layui.table,layer=layui.layer;
        //渲染表格
        Machine= table.render({
            elem: '#department_table',
            url:"<?php echo U('Back/get_all_user');?>"//数据接口
            ,page: true //开启分页
            ,response: {
                statusCode: 200 //规定成功的状态码，默认：0
            }
            ,cols: [[
                {type: 'radio'}
                , {title: '上级单位', field: 'name'}
                , {title: '工号', field: 'user_code'}
                , {title: '姓名', field: 'user_name'}
								, {title: '电话', field: 'tel'}
            ]]
        });

        $("#search").click(function(){
            var part_id = $('#tree').val();
            var search =$('#like').val();
            data= {part_id:part_id,search:search};
            Machine.reload({
                where:data,
                page: {
                    curr: 1
                }
            });

        })
        //监听表格选中
       var lengths,leader_name,leader_id;
        table.on('radio(department_table)', function(obj){
            leader_name=obj.data.user_name;
			leader_id=obj.data.uid;
        });
        $('#choose').click(function() {
			$("#contract").val(leader_name);
			$("#accept_id").val(leader_id);
             layer.close(jdr_tc);
        });
        //点击关闭弹层

       $('#close').click(function () {
           layer.close(jdr_tc);
        })



    })
    /*
     treetable.on('treetable(test1)',function(data){
         console.dir(o(data.elem).html());
     })

     treetable.on('treetable(add)',function(data){
         console.dir(data);
     })*/

	}	
	
		// 图片预览
		function photo(elem,imgElem){
      var f=elem.files[0];
      var r= new FileReader();
      r.readAsDataURL(f);
        r.onload=function  (e) {
            document.getElementById(imgElem).src=this.result;
        };
        imgFile=f;
    }
	</script>
</body> 
</html>