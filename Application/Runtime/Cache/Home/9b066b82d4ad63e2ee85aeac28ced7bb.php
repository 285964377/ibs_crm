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
</style>
<div class="layui-content">
    <div class="layui-row">
        <div class="layui-card" style="background:#eff3f5;border:1px solid #c6d1d6;">
            <div class="layui-card-body">
					<div class="layui-form" action="">
						<div class="layui-form-item">
							<label class="layui-form-label" style="width:42px;">手机号</label>
							<div class="layui-input-inline">
								<input type="text" name="title" value="<?php echo $_GET['tel'];?>" required  lay-verify="required" placeholder="请输入手机号" autocomplete="off" class="layui-input search_input">
							</div>
							<button class="layui-btn layui-btn-blue search_btn " id="get_serch"><i class="layui-icon">&#xe615;</i>查询</button>
						</div>	
					</div>	
			</div>
		</div>
	</div>
	<form class="layui-form" id="js_adds" action="">
	<ul class="layui-row layui-col-space10">
		<li class="layui-col-md6 my_sj_list">
			<?php if($cus): ?><div class="layui-col-md6" style="position:relative;">
					<h3>姓名：<?php echo ($cus["name"]); ?></h3>
					<h3>电话：<?php echo ($cus["phone"]); ?></h3>
					<h3>编号：<?php echo ($cus["code"]); ?></h3>
					<h3>性别：<?php echo ($cus["sex"]); ?></h3>
					<h3>年龄：<?php echo ($cus["age"]); ?></h3>
					<h3>创建时间：<?php echo ($cus["creat_time"]); ?></h3>
					<?php if(!$res): ?><a href="javascript:;" style="position:absolute;right:20px;top:10px;" class="layui-btn layui-btn-blue add">新建商机</a><?php endif; ?>
				</div><?php endif; ?>
			<?php if($res): ?><div class="layui-col-md6">
				<h3>商机编号：<a href="javascript:;"style="color:#01AAED;" onclick="get_sj(this)" data-id="<?php echo ($res["id"]); ?>"><?php echo ($res["code"]); ?></a></h3>
				<h3>商机类型：<?php echo ($res["res_type"]); ?></h3>
				<h3>商机来源：<?php echo ($res["origin"]); ?></h3>
				<h3>贷款金额：<?php echo ($res["dk_money"]); ?></h3>
				<h3>商机所属人：<?php echo ($res["user_name"]); ?>（<?php echo ($res["user_code"]); ?>）-<?php echo ($res["part_name"]); ?></h3>
				<h3>销售阶段：<?php echo ($res["stage"]); ?></h3>
				<a href="javascript:;" style="position:absolute;right:20px;top:10px;" id="yj" class="layui-btn layui-btn-blue">移交</a>
			</div><?php endif; ?>
		</li>
	</ul>
	<?php if($_GET['tel'] && !$res): ?><div id="form" class="layui-form layui-row" <?php if($cus): ?>style="display:none;"<?php endif; ?> >
		<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
			<label class="layui-form-label">联系电话<span style="color:#FF5722">*</span></label>
			<div class="layui-input-inline">
				<input type="text" name="phone" disabled required  value="<?php echo $_GET['tel'];?>" lay-verify="required" placeholder="请输入手机号码" autocomplete="off" class="layui-input ">
			</div>
		</div>
		<?php if(!$cus): ?><div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
			<label class="layui-form-label">客户名称<span style="color:#FF5722">*</span></label>
			<div class="layui-input-inline">
				<input type="text" name="name" required  lay-verify="required" placeholder="请输入客户名称" autocomplete="off" class="layui-input ">
			</div>
		</div><?php endif; ?>
		<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
			<label class="layui-form-label">贷款金额<span style="color:#FF5722">*</span></label>
			<div class="layui-input-inline">
				<input type="number" name="dk_money" required  lay-verify="required" placeholder="请输入贷款金额" autocomplete="off" class="layui-input ">
			</div>
			<div class="layui-form-mid layui-word-aux">万</div>
		</div>	
			
		<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
			<label class="layui-form-label">商机类型<span style="color:#FF5722">*</span></label>
			<div class="layui-input-inline">
				<input type="number" name="res_type_id" id="tree" required  lay-verify="required" placeholder="请选择商机类型" autocomplete="off" class="layui-input ">
			</div>
		</div>	
		<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
			<label class="layui-form-label">商机来源<span style="color:#FF5722">*</span></label>
			<div class="layui-input-inline">
				<input type="number" name="origin_id" id="get_ly" required  lay-verify="required" placeholder="请选择商机来源" autocomplete="off" class="layui-input ">
			</div>
		</div>
		<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
			<label class="layui-form-label">来源网址&nbsp;</label>
			<div class="layui-input-inline">
				<input type="text" name="url"  placeholder="请输入来源网址" autocomplete="off" class="layui-input ">
			</div>
		</div>
		<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
			<label class="layui-form-label">关键词&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<div class="layui-input-inline">
				<input type="text" name="key_word"  placeholder="请输入关键词" autocomplete="off" class="layui-input ">
			</div>
		</div>
		<?php if(!$cus): ?><div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
			<label class="layui-form-label">身份证号&nbsp;</label>
			<div class="layui-input-inline">
				<input type="number" name="idcard"   placeholder="请输入身份证号码" autocomplete="off" class="layui-input ">
			</div>
		</div>	
		<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
			<label class="layui-form-label">客户生日&nbsp;</label>
			<div class="layui-input-inline">
				<input type="text" name="birth" id="birth"   placeholder="请选择客户生日" autocomplete="off" class="layui-input ">
			</div>
		</div>	
		<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
			<label class="layui-form-label">客户年龄&nbsp;</label>
			<div class="layui-input-inline">
				<input type="number" name="age"   placeholder="请输入客户年龄" autocomplete="off" class="layui-input ">
			</div>
		</div>	
		<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
			<label class="layui-form-label">客户性别&nbsp;</label>
			<div class="layui-input-inline">
			<select name="sex" lay-filter="aihao">
				<option value="1">男</option>
				<option value="2">女</option>
				<option value="0">未知</option>
			</select>
			</div>
		</div>
		<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
			<label class="layui-form-label">户口所在&nbsp;</label>
			<div class="layui-input-inline">
				<input type="text" name="huji"   placeholder="请输入户口所在" autocomplete="off" class="layui-input ">
			</div>
		</div>	
		<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
			<label class="layui-form-label">客户地址&nbsp;</label>
			<div class="layui-input-inline">
				<input type="text" name="address"   placeholder="请输入客户地址" autocomplete="off" class="layui-input ">
			</div>
		</div>	
		<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
			<label class="layui-form-label">客户邮箱&nbsp;</label>
			<div class="layui-input-inline">
				<input type="text" name="email"   placeholder="请输入邮箱" autocomplete="off" class="layui-input ">
			</div>
		</div>
		<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
			<label class="layui-form-label">婚姻状况&nbsp;</label>
			<div class="layui-input-inline">
			  <select name="marriage">
					<option value="0">未知</option>
					<option value="1">已婚</option>
					<option value="2">未婚</option>
					<option value="3">离异</option>
					<option value="4">丧偶</option>
					<option value="5">再婚</option>
			  </select>
			</div>
		</div>
		<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
			<label class="layui-form-label">客户学历&nbsp;</label>
			<div class="layui-input-inline">
			<select name="education" >
				<option value="0">未知</option>
				<option value="1">高中以下</option>
				<option value="2">大专</option>
				<option value="3">本科</option>
				<option value="4">硕士及以上</option>
			</select>
			</div>
		</div>
		<div class="layui-form-item sj_form layui-col-md3 layui-col-xs12">
			<label class="layui-form-label">子女数量&nbsp;</label>
			<div class="layui-input-inline">
				<select name="child">
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
				</select>
			</div>
		</div><?php endif; ?>
		<div class="layui-form-item sj_form layui-col-xs12">
			<label class="layui-form-label">客户属性&nbsp;</label>
			<div class="layui-input-block" style="margin-left:80px;position:relative;"> 
				<p style="padding:10px 10px;background:#eff3f5;height:20px" class="my_sx"></p>
				<a href="javascript:;" class="layui-btn layui-btn-blue layui-btn-sm" id="get_bj" style="position:absolute;top:4px;right:20px;">编辑</a>
			</div>
		</div>
		<ul class="form_list">
			<?php if(is_array($label)): $i = 0; $__LIST__ = $label;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li onclick="fz(this)"><?php echo ($item["content"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>	
		</ul>
		<div class="layui-form-item layui-form-text sj_form layui-col-xs12">
			<label class="layui-form-label">备注信息</label>
			<div class="layui-input-block" style="margin-left:80px;">
			  <textarea name="remark" placeholder="请输入内容" class="layui-textarea"></textarea>
			</div>
		</div>
		<div class="yc_input"></div>
		<div style="clear:both"></div>
		<div class="layui-form-item">
			<div class="layui-input-block">
			  <button class="layui-btn layui-btn-blue" lay-submit lay-filter="*">立即提交</button>
			</div>
		</div>
	</div><?php endif; ?>
</div>	
</form>	
	<!-- 属性 -->
	<div id="attribute_box" style="display:none;padding:0 20px;">
		<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
			<ul class="layui-tab-title">
				<?php if(is_array($tables)): $i = 0; $__LIST__ = $tables;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li <?php if($i == 1): ?>class="layui-this"<?php endif; ?>> <?php echo ($item["name"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			<div class="layui-tab-content" style="margin-top:20px;">
			<?php if(is_array($tables)): $i = 0; $__LIST__ = $tables;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class='layui-tab-item <?php if($i == 1): ?>layui-show<?php endif; ?>'>
					<div class="layui-form layui-row">
						<?php if(is_array($item["fields"])): $i = 0; $__LIST__ = $item["fields"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fields): $mod = ($i % 2 );++$i;?><div  class="layui-form-item sj_form layui-col-md3 layui-col-xs12 my_style_input">
							<label class="layui-form-label"><?php echo ($fields["field_name"]); ?></label>
							<div class="layui-input-inline">
								<input type="text" name="<?php echo ($fields["table"]); ?>_<?php echo ($fields["field"]); ?>[]" value=""  <?php if($key == 0): ?>lay-verify="required"<?php endif; ?>  placeholder="请输入<?php echo ($fields["field_name"]); ?>" autocomplete="off" class="layui-input ">
							</div>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
						<div style="clear:both"></div>
						<div class="layui-form-item">
							<div class="layui-input-block">
								<input type="hidden" name="weal_table[]" value="<?php echo ($item["table"]); ?>">
								<button class="layui-btn layui-btn-blue" lay-submit data-name="<?php echo ($item["name"]); ?>" data-id="<?php echo ($item["id"]); ?>" onclick="get(this)">保存</button>
							</div>
						</div>
					</div>		
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
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
		function fz(obj){
			var oText = $(obj).parent().next().find('textarea').val()
			var Text = $(obj).text();
			oText+=Text;
			$(obj).parent().next().find('textarea').val(oText);
		}
		var tc_box;
	layui.config({
		base: path+'/modules/treeSelect/',
	})
	layui.use(['table','layer','jquery','form','treeSelect','element','laydate'],function(){
		var table = layui.table;
		var layer= layui.layer;
		var form = layui.form;
		var $ = layui.jquery;
		var laypage = layui.laypage;
		var treeSelect= layui.treeSelect;
		var element = layui.element;
		var laydate = layui.laydate;
		laydate.render({
			elem: '#birth' 
		});
		//回车监听
		$(".layui-card-body").bind("keydown",function(e){
						// 兼容FF和IE和Opera    
				var theEvent = e || window.event;    
				var code = theEvent.keyCode || theEvent.which || theEvent.charCode;    
				if (code == 13) {    
						//回车执行查询
								$("#get_serch").click();
						}    
		});
	 //搜索
		$('.search_btn').click(function(){
			var data= $(".search_input").val();
			if(data==''){
				layer.msg('请输入电话号码再查询');
				return false;
			}
			if(!(/^1[34578]\d{9}$/.test(data))){ 
				layer.msg("手机号码有误，请重填");  
				return false; 
			} 
			window.location.href="add.html?tel="+data;
		})
		
		$('.add').click(function(){
			$("#form").show();
		})
		//编辑
		$('#get_bj').click(function(){
		tc_box= 	layui.layer.open({
				title : "编辑属性",
				type : 1,
				content :$('#attribute_box'),
				area:["96%","96%"]
			})
			
		})
		var yjId = "<?php echo ($res["id"]); ?>";
		//移交
		$('#yj').click(function(){
			layui.layer.open({
				title : "移交",
				type : 2,
				content : "allot.html?id="+yjId,
				area:["70%","90%"]
			})	
		})
		treeSelect.render({
				// 选择器
				elem: '#tree',
				// 数据
				data: "<?php echo U('Back/select_restype');?>",
				// 异步加载方式：get/post，默认get
				type: 'get',
				// 占位符
				placeholder: '选择商机类型',
				search: false,
				// 点击回调
				click: function(d){
						$('#tree').val(d.current.id);
				},
				// 加载完成后的回调函数
				success: function (d) {
						console.log(d);
				}
		});
		treeSelect.render({
				// 选择器
				elem: '#get_ly',
				// 数据
				data:"<?php echo U('Back/select_origin');?>",
				// 异步加载方式：get/post，默认get
				type:'get',
				// 占位符
				placeholder: '选择商机类型',
				search: false,
				// 点击回调
				click: function(d){
						$('#get_ly').val(d.current.id);
				},
				// 加载完成后的回调函数
				success: function (d) {
						console.log(d);
				}
		});
		form.on('submit(*)', function(data){
			console.log(data.field) 
			layer.confirm('是否添加商机?', function(index){
				var index_two = layer.load();
				$.ajax({
					url:'add.html',
					type:"post", 
					dataType:"json",
					data:data.field,
					success:function(res){
						layer.msg(res.msg);
						layer.close(index_two);
						if(res.code==200){
							parent.layui.table.reload('Machine');
							layer.close(index);
							var my_index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
							parent.layer.close(my_index);
						}
					}
				})
			});    
			return false; 
		});
	});
	function get(obj){
		var IDs = $('.my_sx').find('span').length;
		var Oinput = $(obj).parents('.layui-tab-item').find('.layui-input-inline');
		var names = '<span data-id="my'+IDs+'" style="cursor: pointer;position:relative;" class="layui-btn layui-btn-xs layui-btn-blue" onclick="clear_sx(this)">'+$(obj).attr('data-name')+'<i  style="color:#FF5722;position:absolute;top:0;right:-2px;top: -10px;right: -9px;font-weight: bold;" class="layui-icon">&#x1006;</i> </span>';
		var datas='';
		if(Oinput.eq(0).find('input').val()==''){
			return;
		}
		$('.my_sx').append(names);
		var doms = '<div class="my'+IDs+'"></div>';
		$('.yc_input').append(doms);
	 	for(var i=0;i<Oinput.length;i++){
				var Value = Oinput.eq(i).find('input').val();
				var Name = Oinput.eq(i).find('input').attr('name');
				Name=Name.replace("0","");
				$(".my"+IDs).append('<input type="hidden" name="'+Name+'" value="'+Value+'"/>')
		} 
		var Tdom = '<input type="hidden" name="'+$(obj).prev().attr("name")+'" value="'+$(obj).prev().val()+'"/>';
		$(".my"+IDs).append(Tdom);
		layui.use(['layer'],function(){
			var layer= layui.layer;
			layer.close(tc_box);
			setTimeout(function(){
				$('.my_style_input').find('input').val('');
			},500)
		})
	}
	function clear_sx(obj){
		var El = $(obj).attr('data-id');
		layui.use('layer', function(){
			var layer = layui.layer;
			layer.confirm('是否删除该属性?', function(index){
				$(obj).remove();
				$('.'+El).remove();
				layer.close(index);
			});    
		});     
	
	}
	var myIds = "<?php echo ($res["id"]); ?>";
	var mIname = "<?php echo ($res["name"]); ?>";
	function get_sj(obj){
		if(myIds!=''){
			var url="<?php echo U('Resources/details');?>?index=1&id="+myIds;
			var ids ='res_details'+myIds;
			get_url(this,ids,url,mIname);
		}
	}
	</script>
</body>
</html>