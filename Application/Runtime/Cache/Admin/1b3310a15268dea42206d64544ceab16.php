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
        <h3>实名认证</h3>
        <ul class="tab-base">
            <!--<li><a href="JavaScript:void(0);" ><span>全部成员</span></a></li>-->

            <!--<li><a href="<?php echo U('agent');?>"><span>代理商</span></a></li>-->
            <!--<li><a href="<?php echo U('merchant');?>"><span>商户</span></a></li>-->
            <!--<li><a href="<?php echo U('broker');?>"><span>经纪人</span></a></li>-->
            <!--<li><a href="<?php echo U('member');?>" class="current"><span>普通用户</span></a></li>-->

        </ul>
    </div>
</div>
<div class="fixed-empty"></div>
    <form method="post" name="formSearch" action="<?php echo U('istrue');?>" id="formSearch">

        <table class="tb-type1 noborder search">
            <tbody>
            <tr>
                <th><label for="user_id"> 用户ID</label></th>
                <td><input type="text" value="<?php echo ($user_id); ?>" name="user_id" id="user_id" class="txt"></td>
                <th><label for="idcards"> 身份证号</label></th>
                <td><input type="text" value="<?php echo ($idcards); ?>" name="idcards" id="idcards" class="txt"></td>
                <th><label for="truename">会员姓名</label></th>
                <td><input type="text" value="<?php echo ($truename); ?>" name="truename" id="truename" class="txt" /></td>

                <td ><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="查询">&nbsp;</a></td>
            </tr>

            </tbody>
        </table>
    </form>


<form method='post' id="form_goods" action="">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type3">
        <thead>
        <tr class="thead">
            <th class="w24 align-center"></th>

            <th class="w60">用户id</th>
            <th class="w60">真实姓名</th>
            <th class="w60">身份证号</th>
            <th class="w60">性别</th>
            <th class="w60">身份证正面</th>
            <th class="w60">身份证反面</th>

            <th class="w108 align-center">操作</th>
        </tr>
        </thead>
        <tbody>
        <tr class="" style="">
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><tr>
            <td><input type="checkbox" name="id[]" value="<?php echo ($user["id"]); ?>" class="checkitem"></td>
            <td><?php echo ($user["user_id"]); ?></td>
            <td><?php echo ($user["truename"]); ?></td>
            <td><?php echo ($user["idcards"]); ?></td>
            <td><?php echo ($user["sex"]); ?></td>
            <td><img src="<?php echo ($user["zheng"]); ?>" style="height: 150px;width: 250px;"/></td>
            <td><img src="<?php echo ($user["fan"]); ?>" style="height: 150px;width: 250px;"/></td>


            <td>
<?php if(($user["is_true"]) == "2"): ?><a  href="<?php echo U('shenhe',array('user_id'=>$user['user_id'],'is_true'=>3));?>">驳回</a>&nbsp;&nbsp;<?php endif; ?>
<?php if(($user["is_true"]) == "2"): ?>|&nbsp;<a  href="<?php echo U('shenhe',array('user_id'=>$user['user_id'],'is_true'=>4));?>">通过</a>&nbsp;&nbsp;<?php endif; ?>
<?php if(($user["is_true"]) == "3"): ?><a  href="#">已驳回</a>&nbsp;&nbsp;<?php endif; ?>
<?php if(($user["is_true"]) == "4"): ?><a  href="#">已通过认证</a>&nbsp;&nbsp;<?php endif; ?>

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
            <td colspan="16"><label for="checkallBottom">全选</label>
                &nbsp;&nbsp;
                <?php echo ($pages); ?>

            </td>
        </tr>
        </tfoot>
    </table>
</form>
</div>

<script type="text/javascript" src="/bipin/static/a/resource/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="/bipin/static/a/resource/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="/bipin/static/a/resource/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="/bipin/static/a/resource/js/common_select.js" charset="utf-8"></script>

<script type="text/javascript">
    function quota_style(e){

        var tj_id=$("#tj_id"+ e ).val();
        var pwd=$("#pwd"+ e ).val();
        $.ajax({
            type:'post',
            url:"<?php echo U('Admin/Users/order_style');?>",
            data:{id:e,tj_id:tj_id,pwd16:pwd},
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

    // 获得选中ID
    function getId() {
        var str = '';
        $('#form_goods').find('input[name="id[]"]:checked').each(function(){
            id = parseInt($(this).val());
            if (!isNaN(id)) {
                str += id + ',';
            }
        });
        if (str == '') {
            return false;
        }
        str = str.substr(0, (str.length - 1));
        return str;
    }

</script>




<!-- 模板内容结束 -->
</body>
</html>