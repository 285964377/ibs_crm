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
    table{
        font-size:12px;
        text-align:center;
    }
    .layui-table-view .layui-table td, .layui-table-view .layui-table th{
        text-align:center;
    }
    .hide{
        display:none;
    }
    .layui-form-item .layui-input-block{
        margin-right: 20px;
    }

    .layui-table-view .layui-table td {
        height:56px;
        line-height:normal;
    }
    .layui-table-main .layui-table-cell {
        height:auto;
    }
    .layui-table-fixed  .layui-table-cell{
        height:auto;
    }
    .layui-table-view .layui-table td, .layui-table-view .layui-table th{
        padding:0;
    }
    .layui-form-label{
        width:auto;
    }
    .my_form_box{
        float:left;
        display: inline-block;
        margin-top:10px;
    }
    .nav_list{
        overflow: hidden;
        background:#eff3f5;
        border:1px solid #c6d1d6;
        padding:7px 10px;
    }
    .nav_list li{
        padding:6px 20px;
        float:left;
        margin-right:20px;
        cursor: pointer;
    }
    .nav_list li.active{
        background:url(/Application/Home/Common/images/top_bck.png) no-repeat;
        background-size:100% 100%;
    }
    .layui-treeSelect .ztree li span.button.switch {
        position: relative;
        top: -7px;
    }
</style>
<div class="layui-content">
    <div class="layui-row">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="layui-form" >
                    <div class="layui-form-item" style="margin-top:0">
						<?php if(in_array('search_order/money',$search_power)): ?><div class="my_form_box">	
							<label class="layui-form-label">合同金额：</label>
							<div class="layui-input-inline">
								<input type="text" name="dk_money_start" style="display: inline-block;width:79px;" onkeyup="je(this)"    placeholder="最小金额" autocomplete="off" class="layui-input">
								<span style="clear:both">-</span>
								<input type="text" name="dk_money_end" style="display: inline-block;width:79px;" onkeyup="je(this)"    placeholder="最大金额" autocomplete="off" class="layui-input">
								<span style="font-size:12px">万</span>
							</div>
						</div><?php endif; ?>
						<?php if(in_array('search_order/part',$search_power)): ?><div class="my_form_box">	
							<label class="layui-form-label">接单人所属部门：</label>
							<div class="layui-input-inline">
								<input type="text" name="accept_part_id" id="tree"  placeholder="接单人所属部门" autocomplete="off" class="layui-input">
							</div>
						</div><?php endif; ?>
						<?php if(in_array('search_order/creat_time',$search_power)): ?><div class="my_form_box">
							<label class="layui-form-label">下单时间：</label>
							<div class="layui-input-inline">
								<input type="text" name="apply_time"  id="apply_time" placeholder="下单时间" autocomplete="off" class="layui-input">
							</div>
						</div><?php endif; ?>
						<div class="my_form_box">	
							<button class="layui-btn layui-btn-blue" lay-submit lay-filter="get_search"><i class="layui-icon">&#xe615;</i>查询</button>
						</div>	
                    </div>
                </div>
                <table id="Machine" lay-filter="Machine"></table>
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
   <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="yes"><i class="layui-icon">&#xe679;</i>同意</a>
	  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon">&#x1006;</i>拒绝</a>
</script>
<script id="code" type="text/html">
    <p lay-event="order_link" style="color:#01AAED;cursor: pointer;">{{d.code}}</p>
</script>
<script id="res" type="text/html">
		<p lay-event="res_link" style="color:#01AAED;cursor: pointer;">{{d.res_name}}</p>
		<p>{{d.res_code?d.res_code:''}}</p>
</script>
<script>
	layui.config({
		base: path+'/modules/treeSelect/',
	})
	layui.use(['table','layer','jquery','form','laydate','treeSelect'],function(){
		var table = layui.table;
		var layer= layui.layer;
		var form = layui.form;
		var $ = layui.jquery;
		var laypage = layui.laypage;
		var laydate = layui.laydate;
		var treeSelect = layui.treeSelect;
		//下单时间
		laydate.render({
			elem: '#apply_time',
			range:'~',
			type:'datetime'
		});
        //第一个实例
        var Machine = table.render({
            elem: '#Machine'
            ,url: 'checking.html?search_data=1' //数据接口
            ,page: true //开启分页
            ,cellMinWidth:180
            ,cols: [[ //表头
                {templet:'#code', title: '订单编号'},
				{field:'apply_time',title: '下单时间'},
				{field:'creat_user',title: '下单人'},
				{field:'accept_user',title: '接单人'},
				{field:'part',title: '接单人部门'},
                {templet: '#res', title: '商机'},
                {field: 'dk_money', title: '贷款金额(万)'},
                {width:180,title: '操作',toolbar:'#cz',fixed: 'right'}
            ]]

            ,response: {
                statusCode: 200
            }
        });
		form.on('submit(get_search)', function(data){
		  data=data.field;
			if($('#apply_time').val()){
				var Nlast = data.apply_time.split('~');
				data.apply_time_start=Nlast[0];
				data.apply_time_end=Nlast[1];
			}
			delete  data.apply_time;
			Machine.reload({
						where:data,
						page: {
							curr: 1 
						}
					});
		  return false; 
		});
		//所属部门
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
			}
		});


        //监听表格工具
        table.on('tool(Machine)', function(obj){
            var data = obj.data; //获得当前行数据
            var layEvent = obj.event;
         
            if(layEvent === 'res_link'){ //删除
				var url="<?php echo U('Resources/details');?>?index=1&id="+data.res_id;
				var ids ='res_details'+data.res_id;
                get_url(this,ids,url,data.res_name);
            }if(layEvent==='order_link'){
                var url="<?php echo U('Orders/check_details');?>?id="+data.id;
                var ids ='check_details'+data.id;
                get_url(this,ids,url,data.code);
            }
			
			if(layEvent === 'del'){ 
			layer.prompt({'formType':	0,'title':'拒绝原因'},function(value, index, elem){
				var index_o = layer.load();
				$.ajax({
					url:'check.html',
					type:'post',
					data:{'status':2,'id':data.id,'check_remark':value},
					dataType:"json",
					success:function(res){
						layer.close(index_o);
						layer.msg(res.msg);
						if(res.code==200){
							setTimeout(function(){
								layer.close(index);
								Machine.reload();
							},500)
						}
					}	
				})
			});
			layer.tips('请填写拒绝原因，否则无法提交哟', '.layui-layer-btn0');
		}
		if(layEvent==='yes'){
			layer.confirm('确认要受理吗？',{icon:3, title:'提示信息'}, function(index){
				var index_o = layer.load();
		    	$.ajax({
					url:'check.html',
					type:"post", 
					data:{'status':3,'id':data.id},
					dataType:"json",
					success:function(res){
						layer.close(index_o);
						layer.close(index);
						layer.msg(res.msg);
						if(res.code==200){
							setTimeout(function(){
								layer.close(index);
								Machine.reload();
							},500)
						}
					}
				})
		    })
		}
        });




    });

</script>
</body>
</html>