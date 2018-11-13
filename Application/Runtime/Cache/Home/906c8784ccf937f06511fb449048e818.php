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

    input[type="number"] {
        -moz-appearance: textfield;
    }

    .layui-view-body {
        background: #fff;
    }

    .layui-table {
        margin-top: 0
    }

    .layui-table td, .layui-table th, .layui-table-col-set, .layui-table-fixed-r, .layui-table-grid-down, .layui-table-header, .layui-table-page, .layui-table-tips-main, .layui-table-tool, .layui-table-total, .layui-table-view, .layui-table[lay-skin=line], .layui-table[lay-skin=row] {
        border-width: 1px;
        border-style: solid;
        border-color: #c6d1d6;
    }

    .layui-table thead tr, .layui-table-click, .layui-table-header, .layui-table-hover, .layui-table-mend, .layui-table-patch, .layui-table-tool, .layui-table-total, .layui-table-total tr, .layui-table[lay-even] tr:nth-child(even) {
        background: url(/Application/Home/Common/images/t_bck.png) repeat-x;
        background-size: 100% 100%;
    }

    .layui-table td, .layui-table th {
        padding: 0;
        text-align: center;
        line-height: 28px;
        font-size: 12px;
        color: #000
    }

    .layui-form-item {
        clear: none;
    }

    .layui-form-mid {
        line-height: 12px;
    }

    .layui-form-label {
        width: auto;
    }

    .layui-table-view .layui-table {
        width: 100%;
    }

    .my_fj_list img {
        width: 100%;
        height: 138px;
        cursor: pointer;
    }

    .my_fj_list li {
        margin-bottom: 20px;
    }

    .my_fj_list li > div {
        border: 1px solid #eee;
        position: relative;
    }

    .my_fj_list p {
        font-size: 12px;
        padding: 10px 6px;
        background: #eff3f5;
        color: #000;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .my_fj_list li > div span {
        cursor: pointer;

        display: block;
        width: 36px;
        height: 36px;
        background: url(/crm/Application/Home/Common/images/del.png) no-repeat;
        background-size: 100% 100%;
        position: absolute;
        right: -18px;
        top: -15px;
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
<body class="layui-view-body">
<div class="layui-content" id="body_content">
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="my_style_table">
                <div class="head_top_table">
                    <li><p><span class="fwt">工单基础信息</span></p></li>
                </div>
                <ul class="my_style_table_body">
                    <li class="layui-row">
                        <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                            <p>
                                <span>编号：</span>
                                <span><?php echo ($demand["code"]); ?></span>
                            </p>
                        </div>
                        <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                            <p>
                                <span>贷款金额：</span>
                                <span><?php echo ($demand["money"]); ?></span>
                            </p>
                        </div>
                        <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                            <p>
                                <span>利息：</span>
                                <span><?php echo ($demand["lixi_way"]); ?></span>
                            </p>
                        </div>
                        <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                            <p>
                                <span>业务类型：</span>
                                <span><?php echo ($demand["business_type"]); ?></span>
                            </p>
                        </div>
                        <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                            <p>
                                <span>贷款类型：</span>
                                <span><?php echo ($demand["dk_type"]); ?></span>
                            </p>
                        </div>
                        <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                            <p>
                                <span>手续费：</span>
                                <span><?php echo ($demand["recharge"]); ?></span>
                            </p>
                        </div>
                        <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                            <p>
                                <span>渠道：</span>
                                <span><?php echo ($demand["channel"]); ?></span>
                            </p>
                        </div>
                        <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                            <p>
                                <span>进度：</span>
                                <span><?php echo ($demand["step"]); ?></span>
                            </p>
                        </div>
                        <div class="layui-col-xs12 layui-col-sm6 layui-col-md4">
                            <p>
                                <span>状态：</span>
                                <span><?php echo ($demand["status"]); ?></span>
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
            <!--备注和添加附件-->
            <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
        <ul class="layui-tab-title">
            <li class="layui-this">操作记录</li>
            <li>财务核款信息</li>
            <li>添加备注</li>
            <li>添加附件</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <!--操作记录-->
                <div class="layui-form" >
                    <div class="layui-form-item" style="margin-top:0">
                        <div class="my_form_box">
                            <label class="layui-form-label">操作时间</label>
                            <div class="layui-input-inline">
                                <input type="text"  class="layui-input" id="times" placeholder="请选择操作时间" autocomplete="off" name="create_time"/>
                            </div>
                        </div>
                        <div class="my_form_box">
                             <button class="layui-btn layui-btn-blue " lay-submit lay-filter="search"><i  class="layui-icon">&#xe615;</i>查询</button>
                        </div>
                    </div>
                </div>
                  <table id="hostry" lay-filter="hostry"></table>
            </div>
            <div class="layui-tab-item">
                <!--财务核款信息-->
                <div class="my_style_table">
                    <div class="head_top_table">
                        <li><p><span class="fwt">财务核款信息</span></p></li>
                    </div>
                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th>类型</th>
                            <th>款项</th>
                            <th>金额</th>
                            <th>申请时间</th>
                            <th>审核时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($log)): $i = 0; $__LIST__ = $log;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$logs): $mod = ($i % 2 );++$i;?><tr>
                                <td><?php echo ($logs["type"]); ?></td>
                                <td><?php echo ($logs["rk_type"]); ?></td>
                                <td><?php echo ($logs["money"]); ?></td>
                                <td><?php echo ($logs["creat_time"]); ?></td>
                                <td><?php echo ($logs["check_time"]); ?></td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="layui-tab-item">
                <div class="layui-form" >
                    <div class="layui-form-item" style="margin-top:0">
                        <div class="my_form_box">
                            <label class="layui-form-label">工单状态：</label>
                            <div class="layui-input-inline">
                                <select name="status" lay-verify="">
                                    <option value="1">办理暂缓</option>
                                    <option value="2">办理超期</option>
                                    <option value="3">正常进行中</option>
                                    <option value="4">办理完毕</option>
                                </select>
                            </div>
                        </div>
                        <div class="my_form_box">
                            <label class="layui-form-label">工单进度：</label>
                            <div class="layui-input-inline">
                                <select name="step" lay-verify="">
                                    <option value="1">进件</option>
                                    <option value="2">出件</option>
                                    <option value="3">银行审批</option>
                                    <option value="4">放款</option>
                                </select>
                            </div>
                        </div>
                        <div class="my_form_box">
                            <ul class="form_list">
                                <li onclick="fz(this)">假数据</li>
                                <?php if(is_array($label)): $i = 0; $__LIST__ = $label;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$labels): $mod = ($i % 2 );++$i;?><li onclick="fz(this)"><?php echo ($labels["content"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                            <div class="layui-input-block" style="margin-left:0px;">
                                <textarea name="content" style="width:500px;height:100px;resize: none;" lay-verify="required" placeholder="" class="layui-textarea "></textarea>
                            </div>
                        </div>
                        <div class="my_form_box">
                            <input type="hidden" name="id" value="<?php echo ($gd_id); ?>"/>
                            <button class="layui-btn layui-btn-blue " lay-submit lay-filter="get_my_goin">提交备注</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-tab-item">
                <ul class="head_top_table"
                    style="border: none;background: none;margin-bottom: -20px">
                    <li>
                        <button href="javascript:;" class="layui-btn layui-btn-blue"
                                id="add_img" style="margin-bottom:10px;">添加附件
                        </button>
                    </li>
                </ul>
                <ul class="my_fj_list layui-row layui-col-space30" style="" id="people_list_fj">
                    <?php if(is_array($fujian)): $i = 0; $__LIST__ = $fujian;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fujians): $mod = ($i % 2 );++$i;?><li class="layui-col-md2 layui-col-xs4">
                            <div>
                                <img src="/<?php echo ($fujians["url"]); ?>" alt=""/>
                                <p><?php echo ($fujians["title"]); ?></p>
                                <span onclick="del_fj(this)" data-id="<?php echo ($fujians["id"]); ?>"></span>
                            </div>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
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
<script>

    var tc_o, tc_t, tc_r, tc_f, add_box, Machine;
    var Ids = "<?php echo ($id); ?>";
    layui.config({
        base: path + '/modules/treeSelect/',
    })
    layui.use(['table', 'layer', 'jquery', 'form', 'element', 'treeSelect', 'laydate'], function () {
        var table = layui.table, layer = layui.layer, form = layui.form, $ = layui.jquery, laypage = layui.laypage,
            element = layui.element, treeSelect = layui.treeSelect, laydate = layui.laydate;
        laydate.render({
            elem: '#times',
            range: '~',
            type: 'datetime'
        });
        layer.photos({
            photos: '#imgs'
            , anim: 5
        });
        //提交备注
        var index=$("#body_content").html();
        form.on('submit(get_my_goin)', function(data){
            var datas = data.field;
            //方式二
            // var gd_id=<?php echo ($gd_id); ?>;
            // datas.gd_id;
            layer.confirm('是否提交备注信息?', {icon: 3, title:'提示'},function(){
                var index_o = layer.load();
                $.ajax({
                    url:'demand_gj.html',
                    type:'POST',
                    data:datas,
                    dataType:'json',
                    success:function(res){
                        layer.close(index_o);
                        layer.msg(res.msg);
                        if(res.code==200){
                            setTimeout(function(){
                                window.location.reload();
                            },500)
                        }
                    }
                })
            });
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
        $('#add_img').click(function () {
            layui.layer.open({
                title: "添加附件",
                type: 2,
                content: 'add_fujian.html?id=' + Ids,
                area: ["420px", "380px"]
            })
        })
        var cz_table = table.render({
            elem: '#hostry'
            , height: 312
            , url: "operator?&id=<?php echo ($res["id"]); ?>"
            , page: true
            , response: {
                statusCode: 200
            }
            , cols: [[
                {field: 'user_name', title: '操作人'}
                , {field: 'code', title: '工号'}
                , {field: 'controller_name', title: '操作类型'}
                , {field: 'content', title: '内容/备注'}
                , {field: 'creat_time', title: '操作时间'}
            ]]
        });
        layer.photos({
            photos: '#people_list_fj'
            , anim: 5
        });
        //搜索历史记录
        form.on('submit(search)', function(data){
            data=data.field;
            if($('#times').val()){
                var Nlast = data.create_time.split('~');
                data.create_time_start=Nlast[0];
                data.create_time_end=Nlast[1];
            }
            delete  data.create_time;
            cz_table.reload({
                where:data,
                page: {
                    curr: 1
                }
            });
            return false;
        });
    })
    //标签填入文本区
    function fz(obj){
        var oText = $(obj).parent().next().find('textarea').val()
        var Text = $(obj).text();
        oText+=Text;
        $(obj).parent().next().find('textarea').val(oText);
    }
</script>
</body>
</html>