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
                        <ul class="nav_list">
                            <li class="active" data-name="">全部</li>
                            <li class="" data-name="1">进件</li>
                            <li class="" data-name="2">出件</li>
                            <li class="" data-name="3">银行审批</li>
                            <li class="" data-name="4">放款</li>
                        </ul>
                        <div class="my_form_box">
                            <label class="layui-form-label">工单编号：</label>
                            <div class="layui-input-inline">
                                <input type="text" name="code"  placeholder="请输入工单编号" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="my_form_box">
                            <label class="layui-form-label">贷款金额：</label>
                            <div class="layui-input-inline">
                                <input type="text" name="money" onkeyup="je(this)"   placeholder="请输入贷款金额" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">万</div>
                        </div>
                        <div class="my_form_box">
                            <label class="layui-form-label">工单状态：</label>
                            <div class="layui-input-inline">
                                <select name="status" lay-verify="">
                                    <option value="">请选择</option>
                                    <option value="1">办理暂缓</option>
                                    <option value="2">办理超期</option>
                                    <option value="3">正常进行中</option>
                                    <option value="4">办理完毕</option>
                                </select>
                            </div>
                        </div>
                        <div class="my_form_box">
                            <label class="layui-form-label">创建时间：</label>
                            <div class="layui-input-inline">
                                <input type="text" name="creat_time"  id="apply_time" placeholder="请选择创建时间" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <input type="hidden" name="step" id="top_name" value=""/>
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
<script id="last_op" type="text/html">
    {{# if(!d.new_create_time&&!d.new_use){  }}
    <p>暂无</p>
    {{#  }else {    }}
    <p>{{d.new_create_time?d.new_create_time:'暂无时间'}}</p>
    <p>{{d.new_use?d.new_use:'暂无操作人'}}</p>
    {{# }   }}
</script>
<script id="order" type="text/html">
    <p lay-event="order_link" style="color:#01AAED;cursor: pointer;">{{d.code}}</p>
    <!--<p>{{d.apply_time?d.apply_time:'未下单'}}</p>-->
</script>

<script>
    var Top_name;
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
        //顶部进度分类
        $('.nav_list li').click(function(){
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            Top_name=$(this).attr('data-name');
            $('#top_name').val(Top_name);
        })
        //下单时间
        laydate.render({
            elem: '#apply_time',
            range:'~',
            type:'datetime'
        });

        //第一个实例
        var Machine = table.render({
            elem: '#Machine'
            ,url: 'demand.html?search_data=1' //数据接口
            ,page: true //开启分页
            ,cellMinWidth:160
            ,cols: [[ //表头
                {templet:'#order',title: '工单编号'},
                {field:'money',title: '贷款金额'},
                {field:'dk_type',title: '贷款类型'},
                {field:'creat_user',title: '创建人'},
                {field: 'channel', title: '渠道'},
                {field: 'lixi_way', title: '利息'},
                {field: 'recharge', title: '手续费'},
                {field: 'status', title: '状态'},
                {field:'step',title: '进度'},
                {width:180,templet:'#last_op', title: '最新操作'},

                // {title: '操作',toolbar:'#cz',fixed: 'right',width:180}
            ]]
            ,response: {
                statusCode: 200
            }
        });
        form.on('submit(get_search)', function(data){
            data=data.field;
            if($('#apply_time').val()){
                var Nlast = data.creat_time.split('~');
                data.creat_time_start=Nlast[0];
                data.creat_time_end=Nlast[1];
            }
            delete  data.creat_time;
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
            if(layEvent==='order_link'){
                var url="<?php echo U('Orders/demand_details');?>?index=1&id="+data.id;
                var ids ='demand_details'+data.id;
                get_url(this,ids,url,"工单订单："+data.code);
            }
        })


    });

</script>
</body>
</html>