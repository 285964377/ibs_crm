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
    table {
        font-size: 12px;
        text-align: center;
    }

    .layui-table-view .layui-table td, .layui-table-view .layui-table th {
        text-align: center;
    }

    .hide {
        display: none;
    }

    .layui-form-item .layui-input-block {
        margin-right: 20px;
    }

    .layui-table-view .layui-table td {
        height: 23px;
        line-height: 23px;
    }

    .layui-table-main .layui-table-cell {
        height: auto;
    }

    .layui-table-fixed .layui-table-cell {
        height: auto;
    }

    .layui-table-view .layui-table td, .layui-table-view .layui-table th {
        padding: 0;
    }

    .layui-form-label {
        width: auto;
    }

    .my_form_box {
        float: left;
        display: inline-block;
    }

    .nav_list {
        overflow: hidden;
        background: #eff3f5;
        border: 1px solid #c6d1d6;
        padding: 7px 10px;
    }

    .nav_list li {
        padding: 6px 20px;
        float: left;
        margin-right: 20px;
        cursor: pointer;
    }

    .nav_list li.active {
        background: url(/Application/Home/Common/images/top_bck.png) no-repeat;
        background-size: 100% 100%;
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
                <div class="layui-form">
                    <div class="layui-form-item" style="margin-top:0">
                        <?php if(in_array('search_cus/name',$search_power)): ?><div class="my_form_box">
                                <label class="layui-form-label">客户姓名：</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="name" placeholder="客户姓名" autocomplete="off"
                                           class="layui-input">
                                </div>
                            </div><?php endif; ?>
                        <?php if(in_array('search_cus/phone',$search_power)): ?><div class="my_form_box">
                                <label class="layui-form-label">手机号码：</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="phone" placeholder="手机号码" autocomplete="off"
                                           class="layui-input">
                                </div>
                            </div><?php endif; ?>
                        <?php if(in_array('search_cus/creat_time',$search_power)): ?><div class="my_form_box">
                                <label class="layui-form-label">创建时间：</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="creat_time" id="creat_time" placeholder="创建时间"
                                           autocomplete="off" class="layui-input">
                                </div>
                            </div><?php endif; ?>
                        <input type="hidden" name="ing_type" id="top_name" value=""/>
                        <div class="my_form_box">
                            <button class="layui-btn layui-btn-blue" lay-submit lay-filter="get_search"><i
                                    class="layui-icon">&#xe615;</i>查询
                            </button>
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
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i>编辑</a>
</script>
<script id="cus" type="text/html">
    <p lay-event="name_link" style="color:#01AAED;cursor: pointer;">{{d.name}}</p>
    <p>{{d.phone}}</p>
</script>
<script id="allot" type="text/html">
    <p>{{d.allot_name?d.allot_name:''}}({{d.allot_code?d.allot_code:'暂无'}})</p>
    <p>{{d.allot_time?d.allot_time:''}}</p>
</script>
<script id="user" type="text/html">
    <p>{{d.user_name?d.user_name:''}}({{d.user_code?d.user_code:'暂无'}})</p>

</script>
<script id="next" type="text/html">
    <p>{{d.next_step?d.next_step:'暂无'}}</p>
    <p>{{d.next_time?d.next_time:''}}</p>
</script>
<script id="last_op" type="text/html">
    <p>{{d.resop_type}}-{{d.resop_time}}</p>
    <p>{{d.resop_user_name}}({{d.resop_user_code}})</p>
</script>
<script id="tabr" type="text/html">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm layui-btn-blue refresh" onclick="refresh()"><i
                class="layui-icon">&#xe669;</i></button>
        <button class="layui-btn layui-btn-blue layui-btn-sm" lay-event="get_fp" id="get_fp"><i class="layui-icon">&#xe667;</i>分配
        </button>
        <button class="layui-btn layui-btn-blue layui-btn-sm" lay-event="get_fl" id="get_fl"><i class="layui-icon">&#xe667;</i>修改分类
        </button>
    </div>
</script>
<script>
    var Top_name;
    layui.config({
        base: path + '/modules/treeSelect/',
    })
    layui.use(['table', 'layer', 'jquery', 'form', 'laydate', 'treeSelect'], function () {
        var table = layui.table;
        var layer = layui.layer;
        var form = layui.form;
        var $ = layui.jquery;
        var laypage = layui.laypage;
        var laydate = layui.laydate;
        var treeSelect = layui.treeSelect;
        $('.nav_list li').click(function () {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            Top_name = $(this).attr('data-name');
            $('#top_name').val(Top_name);
        })
        //下次跟进
        laydate.render({
            elem: '#creat_time',
            range: '~',
            type: 'datetime'
        });
        //第一个实例
        var Machine = table.render({
            elem: '#Machine'
            , url: 'index.html?search_data=1' //数据接口
            , toolbar: '#tabr'
            , page: true //开启分页
            , cols: [[ //表头
                {type: 'checkbox'},
                {field: 'id', title: 'ID'},
                {field: 'code', title: '客户编号'},
                {field: 'name', title: '姓名'},
                {field: 'phone', title: '联系方式'},
                {field: 'idcard', title: '身份证'},
                {field: 'age', title: '年龄'},
                {field: 'money', title: '贷款金额'},
                {field: 'remark', title: '备注'},
                {field: 'custype', title: '分类'},
                {field: 'creat_time', title: '创建时间'},
                {field: 'creat_user', title: '导入人'},
                {title: '操作', toolbar: '#cz', fixed: 'right', width: 80}
            ]]
			,limit:20
			,limits:[20,50,100,200,500,1000]
            , response: {
                statusCode: 200
            }
        });
        form.on('submit(get_search)', function (data) {
            data = data.field;
            if ($('#creat_time').val()) {
                var Nnext = data.creat_time.split('~');
                data.creat_time_start = Nnext[0];
                data.creat_time_end = Nnext[1];
            }
            delete data.creat_time;
            Machine.reload({
                where: data,
                page: {
                    curr: 1
                }
            });
            return false;
        });
        table.on('tool(Machine)', function (obj) {
            var data = obj.data;
            var layEvent = obj.event;
            if (layEvent == 'edit') {
                layui.layer.open({
                    title: "修改",
                    type: 2,
                    content: "edit.html?id=" + data.id,
                    area: ["70%", "60%"]
                })
            }
        })
        var lengths, idstring;
//监听左侧表格
        table.on('toolbar(Machine)', function (obj) {
            var checkStatus = table.checkStatus('Machine');
            lengths = checkStatus.data.length;//选中个数
            idstring = '';
            for (var i = 0; i < lengths; i++) {
                idstring += checkStatus.data[i].id + ',';
            }
            nidstring = idstring.substr(0, idstring.length - 1);//ID合集
            var event = obj.event;
            if (event == 'get_fp') {
                if (!lengths) {
                    layer.tips('请勾选客户，再点击这里哟', '#get_fp');
                    return false;
                } else {
                    layui.layer.open({
                        title: "分配",
                        type: 2,
                        content: "allot.html?id=" + nidstring,
                        area: ["70%", "90%"]
                    })
                }
            }
            if (event == 'get_fl') {
                if (!lengths) {
                    layer.tips('请勾选客户，再点击这里哟', '#get_fl');
                    return false;
                } else {
                    layui.layer.open({
                        title: "修改分类",
                        type: 2,
                        content: "change_type.html?id=" + nidstring,
                        area: ["400px", "300px"]
                    })
                }
            }
        })
    });
</script>
</body>
</html>