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
						<?php if(in_array('search_order/order_code ',$search_power)): ?><div class="my_form_box">
							<label class="layui-form-label">订单编号：</label>
							<div class="layui-input-inline">
								<input type="text" name="code"  placeholder="订单编号" autocomplete="off" class="layui-input">
							</div>
						</div><?php endif; ?>
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
							<label class="layui-form-label">所属部门：</label>
							<div class="layui-input-inline">
								<input type="text" name="part_id" id="tree"  placeholder="订单所属部门" autocomplete="off" class="layui-input">
							</div>
						</div><?php endif; ?>
						<?php if(in_array('search_order/creat_time ',$search_power)): ?><div class="my_form_box">
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
	<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="add"><i class="layui-icon">&#xe657;</i>新增工单</a>
	<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="tui"><i class="layui-icon">&#xe640;</i>退单</a>
</script>
<script id="res" type="text/html">
	<p lay-event="res_link" style="color:#01AAED;cursor: pointer;">{{d.res_name}}</p>
	<p>{{d.res_code?d.res_code:''}}</p>
</script>
<script id="order" type="text/html">
	<p lay-event="order_link" style="color:#01AAED;cursor: pointer;">{{d.code}}</p>
	<p>{{d.apply_time?d.apply_time:'未下单'}}</p>
</script>
<script id="demand" type="text/html">
	{{#  layui.each(d.demand, function(index, item){ }}
	<p><span  lay-event="demand_link" data-code="{{item.demand_code}}" data-id="{{item.demand_id}}" style="color:#01AAED;cursor: pointer;">
		{{item.demand_code}}</span>-{{item.demand_step?item.demand_step:''}}-{{item.demand_status?item.demand_status:''}}</p>
	{{#  }); }}
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
        //第一个实例
        var Machine = table.render({
            elem: '#Machine'
            ,url: 'ing.html?search_data=1' //数据接口
            ,page: true //开启分页
            ,cellMinWidth:180
            ,cols: [[ //表头
                {templet:'#order',title: '订单'},
                {templet:'#res',title: '所属商机'},
                {field: 'contract', title: '合同编号'},
                {field: 'dk_money', title: '合同金额(万)'},
                {width:280,templet:'#demand', title: '工单'},
                {field:'creat_user',title: '下单人'},
                {field: 'part', title: '订单所属部门'},
                {field: 'accept_user', title: '接单人'},
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

//监听左侧表格
        table.on('tool(Machine)', function(obj){
            var layEvent  = obj.event;
            var data  = obj.data;

            if(layEvent=='add'){
                layui.layer.open({
                    title : "新增工单",
                    type : 2,
                    content :"demand_add.html?id="+data.id,
                    area:["90%","90%"],
                });
            }

            if(layEvent=='tui'){
                layer.prompt({'formType':	0,'title':'退单原因'},function(value, index, elem){
                    var index_o = layer.load();
                    $.ajax({
                        url:"tui.html",
                        type:'post',
                        data:{'check_remark':value,'id':data.id},
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
                layer.tips('请填写退单原因，否则无法提交哟', '.layui-layer-btn0');
            }
            if(layEvent==='order_link'){
                var url="<?php echo U('Orders/details');?>?index=1&id="+data.id;
                var ids ='Orders_details'+data.id;
                get_url(this,ids,url,"办理中订单："+data.code);
            }
            //工单详情
            if(layEvent==='demand_link'){
                var num=$(this).attr("data-id");
                var code=$(this).attr("data-code");
                var url="<?php echo U('Orders/demand_details');?>?index=1&id="+num;
                var ids ='Orders_demand_details'+num;
                get_url(this,ids,url,"工单："+code);
            }
            if(layEvent==='res_link'){
                var url="<?php echo U('Resources/details');?>?index=1&id="+data.res_id;
                var ids ='res_details'+data.res_id;
                get_url(this,ids,url,data.res_name);
            }
        })


    });

</script>
</body>
</html>