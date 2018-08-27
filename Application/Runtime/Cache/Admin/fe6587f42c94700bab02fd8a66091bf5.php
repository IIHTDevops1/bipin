<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >

<meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <script type="text/javascript" src="/bipin/static/a/resource/js/jquery.js"></script>
    <script type="text/javascript" src="/bipin/static/a/resource/js/jquery.validation.min.js"></script>
    <script type="text/javascript" src="/bipin/static/a/resource/js/admincp.js"></script>
    <script type="text/javascript" src="/bipin/static/a/resource/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="/bipin/static/a/layer/layer.js"></script>
    <script type="text/javascript" src="/bipin/static/a/resource/js/common.js" charset="utf-8"></script>
    <!--<script type="text/javascript" src="/bipin/static/a/home/js/common.js" charset="utf-8"></script>-->
<!--<script type="text/javascript" src="http://www.jeasyui.net/Public/js/easyui/jquery.easyui.min.js"></script>不知道干啥的-->
    <link href="/bipin/static/a/default/css/skin_0.css" rel="stylesheet" type="text/css" id="cssfil2" />
    <link href="/bipin/static/a/default/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="/bipin/static/a/default/css/font/font-awesome/css/font-awesome-ie7.min.css">
    <![endif]-->
<link href="/bipin/static/a/resource/easyui.css" rel="stylesheet" type="text/css" id="cssfile2" />
<link href="/bipin/static/a/resource/icon.css" rel="stylesheet" type="text/css" id="cssfile" />
<!--<script type="text/javascript" src="/bipin/static/a/resource/jquery-1.4.4.min.js"></script>-->

<!--js-->

<script src="/bipin/static/a/resource/lib/js/jquery.iDialog.js" ></script>
<script src="/bipin/static/a/resource/lib/js/drag.js"></script>

<script>


    $(function(){

        $('.drag-box-3 .drag').each(function(index){
            $(this).myDrag({
                randomPosition:true,
                direction:'all',
                handler:false
            });
        });

    });
</script>
</head>
<body>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<!-- 模板内容开始 -->




<link href="/bipin/static/a/default/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
<link rel="stylesheet" href="/bipin/static/a/default/css/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<div class="page">
<div class="fixed-bar">
    <div class="item-title">
        <h3>提现记录</h3>
        <ul class="tab-base">
            <li><a href="<?php echo U('tixian');?>" <?php if(empty($status)): ?>class="current"<?php endif; ?>><span>全部提款记录</span></a></li>
            <li><a href="<?php echo U('tixian',array('status'=>'1'));?>" <?php if(($status) == "1"): ?>class="current"<?php endif; ?>><span>待处理</span></a></li>
            <li><a href="<?php echo U('tixian',array('status'=>'2'));?>" <?php if(($status) == "2"): ?>class="current"<?php endif; ?>><span>打款成功</span></a></li>
            <!--<li><a href="<?php echo U('tixian',array('status'=>'3'));?>" <?php if(($status) == "3"): ?>class="current"<?php endif; ?>><span>被驳回</span></a></li>-->
            <li><a href="#" ><span>总交易数量&nbsp;&nbsp;<?php echo ($zongjie); ?></span></a></li>
        </ul>
    </div>
</div>
<div class="fixed-empty"></div>
<form method="post" name="formSearch" action="<?php echo U('tixian');?>" id="formSearch">

    <table class="tb-type1 noborder search">
        <tbody>
        <!--<tr>-->
            <!--<th><label for="mobile"> 手机号码</label></th>-->
            <!--<td><input type="text" value="<?php echo ($mobile); ?>" name="mobile" id="mobile" class="txt"></td>-->
            <!--<th><label for="truename">会员姓名</label></th>-->
            <!--<td><input type="text" value="<?php echo ($truename); ?>" name="truename" id="truename" class="txt" /></td>-->

            <!--<td ><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="查询">&nbsp;</a></td>-->
        <!--</tr>-->

        </tbody>
    </table>
</form>

<form method='post' id="form_goods" action="">

    <table class="table tb-type3">
        <thead>
        <tr class="thead">
            <th class="w60">序号</th>
            <th class="w60">客户姓名</th>
            <th class="w60">头像</th>
            <th class="w60">手机号</th>
            <th class="w150">收款卡号</th>
            <th class="w60">账户名称</th>
            <th class="w60">提现戏币</th>
            <th class="w60">手续费</th>
            <th class="w160">申请时间</th>
            <th class="w60">状态</th>
            <th class="w60">打款时间</th>
            <th class="w60">实际入账金额</th>
            <th class="w60">备注</th>
            <th class="w108 align-center">操作</th>
        </tr>
        </thead>
        <tbody>
        <tr class="" style="">
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?><tr>
                              <!--<?php echo U('Index/bank_information_details');?>?id=<?php echo ($rr["id"]); ?>-->
            <td><?php echo ($order["id"]); ?></td>
                    <td><a href="<?php echo U('Member/edit');?>?id=<?php echo ($order["user_id"]); ?>"></a><?php echo (get_truename($order["user_id"])); ?></td>
            <td><img src="<?php echo (get_thumb($order["user_id"])); ?>" style="height:50px;width: 50px;"></td>
                    <td><?php echo (get_mobile($order["user_id"])); ?></td>
                    <td><?php echo ($order["card_number"]); ?></td>
                    <td><?php echo ($order["card_type"]); ?></td>
                    <td><?php echo ($order["xibi"]); ?></td>
                    <td>
                        <?php echo ($order["proportion"]); ?>

                    </td>

                    <td><?php echo (dateformat($order["addtime"])); ?></td>
                    <td><?php if(($order["status"]) == "1"): ?>待处理<?php endif; if(($order["status"]) == "2"): ?>打款成功<?php endif; if(($order["status"]) == "3"): ?>申请被驳回<?php endif; ?></td>
                    <td><?php echo (dateformat($order["endtime"])); ?></td>
                    <td><?php echo ($order["jine1"]); ?>元</td>
            <td>
                <?php if(($order["type"]) == "1"): ?>戏币提现<?php endif; ?>
                <!--<?php if(($order["type"]) == "2"): ?>碳积分提现<?php endif; ?>-->

            </td>


                    <td>
                        <!--<input id="pwd<?php echo ($order["id"]); ?>" value="" placeholder="请先输入操作密码"/>-->
                        <!--<?php if(($order["status"]) == "1"): ?><a class="btn" onclick="quota_style(<?php echo ($order['id']); ?>)" href="<?php echo U('dakuan',array('id'=>$order['id']));?>"><span>确定打款</span></a><?php endif; ?>-->
                        <?php if(($order["status"]) == "1"): ?><a class="btn" onclick="quota_style(<?php echo ($order['id']); ?>)"><span>确定打款</span></a><?php endif; ?>
                        <?php if(($order["status"]) == "2"): ?><a class="btn" onclick="alert('不能重复打款')"><span>已完成打款</span></a><?php endif; ?>
                       | <a href="<?php echo U('yongjinxq',array('benefit_id'=>$order['user_id']));?>"><span>戏币收益记录</span></a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tr>
        <tr style="display:none;">
            <td colspan="20"><div class="ncsc-goods-sku ps-container"></div></td>
        </tr>
        </tbody>
        <tfoot>
        <tr class="tfoot">
            <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
            <td colspan="16">
                &nbsp;&nbsp;
                <?php echo ($pages); ?>

            </td>
        </tr>
        </tfoot>
    </table>
</form>
</div>
    <script type="text/javascript">
        function quota_style(e){
//            var pwd=$("#pwd"+ e ).val();
            $.ajax({
                type:'post',
                url:"<?php echo U('Order/dakuan');?>",
                data:{id:e},
                success:function(msg){

                    if(msg.status==200){
                        layer.msg(msg.info,{icon:6,time:2000});
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    }else{
                        layer.msg(msg.info,{icon:2,time:2000});return false;

                    }
                }
            });
        };
        var SITEURL = "/";
        $(function(){

            $('#ncsubmit').click(function(){
                $('input[name="op"]').val('goods');$('#formSearch').submit();
            });

        });


    </script>

<script type="text/javascript" src="/bipin/static/a/resource/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="/bipin/static/a/resource/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="/bipin/static/a/resource/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="/bipin/static/a/resource/js/common_select.js" charset="utf-8"></script>





<!-- 模板内容结束 -->
</body>
</html>