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
                            <li class="" data-name="1">可申请</li>
                            <li class="" data-name="2">消费完毕</li>
                        </ul>
                        <div class="my_form_box">
                            <label class="layui-form-label">商机编号：</label>
                            <div class="layui-input-inline">
                                <input type="text" name="sj"  placeholder="请输入商机编号" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="my_form_box">
                            <label class="layui-form-label">订单编号：</label>
                            <div class="layui-input-inline">
                                <input type="text" name="order"  placeholder="请输入订单编号" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <input type="hidden" name="status" id="top_name" value=""/>
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
<div id="fy_apply" style="display: none">
    <div class="layui-content">
        <form class="layui-form" id="fy_form" action="">
            <div id="form" class="layui-form layui-row">
				<div class="layui-form-item sj_form layui-col-md12 layui-col-xs12">
					<label class="layui-form-label">申请金额<span style="color:#FF5722">*</span></label>
					<div class="layui-input-inline">
						<input type="text"  name="money"  class="layui-input" placeholder="请输入申请金额" required lay-verify="required" onkeyup="je(this)" >
					</div>
				</div>
				<div class="layui-form-item sj_form layui-col-md12 layui-col-xs12">
					<label class="layui-form-label">消费类型<span style="color:#FF5722">*</span></label>
					<div class="layui-input-inline">
						<input type="text"  name="rk_type"   class="layui-input" placeholder="请输入申请金额类型" required lay-verify="required" >
					</div>
				</div>
				<div class="layui-form-item sj_form layui-col-md12 layui-col-xs12">
					<label class="layui-form-label">消费凭证<span style="color:#FF5722">*</span></label>
					<div class="layui-input-inline">
						<img style="width:228px;height:228px;" id="imgs" src="/Application/Home/Common/images/get_img.png">
						<input id="my_imgs" style="position:absolute;top:0;left:0;width:100%;height:100%; filter:alpha(opacity=0);-moz-opacity:0;-khtml-opacity:0;opacity:0;" name="img" type="file" onchange="photo(this,'imgs')" data-path="">
					</div>
				</div>
				<div class="layui-form-item sj_form layui-col-md12 layui-col-xs12">		
					<label class="layui-form-label" style="width: 60px">备注信息</label>
						<div class="layui-input-inline">
							<textarea  	 style="width:228px;height:110px;"   name="remark" class="layui-textarea"></textarea>
					</div>
				</div>
                    
				<div style="clear:both"></div>
				<div class="layui-form-item">
					<div class="layui-input-block">
						<input type="hidden" name="id" id="apply_id" />
						<button class="layui-btn layui-btn-blue" lay-submit lay-filter="fy_apply">立即提交</button>
					</div>
				</div>
			</div>
        </form>
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
<script id="order_xd" type="text/html">
    <p>{{d.demand.code}}</p>
    <p>{{d.dk_type}}/{{d.channel}}</p>
</script>
<script id="cz" type="text/html">
    {{#  if(d.last_money>0){  }}
    <a lay-event='fy_apply' href="javascript:;"  class="layui-btn layui-btn-primary layui-btn-xs">费用申请</a>
    {{# }else{ }}
    <p>消费完毕</p>
    {{# } }}
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
        $('.nav_list li').click(function(){
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            Top_name=$(this).attr('data-name');
            $('#top_name').val(Top_name);
        })

        laydate.render({
            elem: '#creat_time',
            range:'~',
            type:'datetime'
        });
        laydate.render({
            elem: '#check_time',
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
                console.log(d);
            }
        });
        var index_table = layer.load();
        //第一个实例
        var Machine = table.render({
            elem: '#Machine'
            ,url: 'rk_apply.html?search_data=1' //数据接口
            ,page: true //开启分页
            ,cellMinWidth:160
            ,cols: [[ //表头
                {field:'res',title: '商机编号'},
                {field:'cus', title: '客户'},
                {field:'order', title: '订单编号'},
                {templet:'#order_xd',title: '生产子订单'},
                {field: 'last_money', title: '可用额度'},
                {title: '操作',toolbar:'#cz',fixed: 'right',width:180}
            ]]
            ,response: {
                statusCode: 200
            },done:function(){

                        layer.close(index_table);

            }
        });
        form.on('submit(get_search)', function(data){
            data=data.field;
            if($('#creat_time').val()){
                var Nlast = data.creat_time.split('~');
                data.creat_time_start=Nlast[0];
                data.creat_time_end=Nlast[1];
            }
            if($('#check_time').val()){
                var Nnext = data.check_time.split('~');
                data.check_time_start=Nnext[0];
                data.check_time_end=Nnext[1];
            }
            delete  data.creat_time;
            delete data.check_time;
            Machine.reload({
                where:data,
                page: {
                    curr: 1
                }
            });
            return false;
        });
        //监听表格工具

        table.on('tool(Machine)', function(obj){
            var data = obj.data; //获得当前行数据
            var layEvent = obj.event;
            //费用申请
            if(layEvent==='fy_apply'){
				$('#apply_id').val(data.id);
                var index=layui.layer.open({
                    title : "费用申请",
                    type : 1,
                    content :$('#fy_apply'),
                    area:["400px","600px"]
                })
                form.on('submit(fy_apply)', function(data){
                    var data = new FormData($('#fy_form')[0]);

                    if($('#my_imgs').val()==''){
                        layer.tips('请点击上传图片再提交', '#my_imgs',{ tips:1});
                        return false;
                    }
                    var index_o = layer.load();
                    var img="/Application/Home/Common/images/get_img.png";
                    $.ajax({
                        url:'rk_apply.html',
                        type:'POST',
                        data:data,
                        dataType:'json',
                        processData: false,
                        contentType: false,
                        success:function(res) {
                            layer.close(index_o);
                            layer.msg(res.msg);
                            if(res.code==200){
                                setTimeout(function(){
                                    $("#fy_apply input").val("");
                                    $("#fy_apply textarea").val("");
                                    $("#fy_apply img").attr('src',img);
                                    layer.close(index);
                                    Machine.reload();
                                },500)
                            }
                        }
                    })

                    return false;
                })
            } else
                if(layEvent==='name_link'){
                var url="<?php echo U('Resources/details');?>?index=1&id="+data.id;
                var ids ='res_details'+data.id;
                get_url(this,ids,url,data.name);
            }

        });

    });
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