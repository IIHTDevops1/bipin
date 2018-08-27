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


	<style>
		.required{width:100px;}
	</style>
	<div class="page">
		<div class="fixed-bar">
			<div class="item-title">
				<h3> &nbsp;&nbsp;普通用户等级调整</h3>

			</div>
		</div>
		<div class="fixed-empty"></div>
		<form onsubmit="return false;"  id="edit_form" method="post" action="">
			<table class="table tb-type2">
				<tbody>
				<tr class="noborder">
					<td class="required"><label class="validation">用户id：</label></td>
					<td class="vatop rowform" colspan="2">
						<?php echo ($info["user_id"]); ?>
						<!--<input disabled id="addr" name="addr" value="<?php echo ($info["addr"]); ?>">-->
					</td>
				</tr>
				<tr class="noborder">
					<td class="required"><label class="validation">手机号：</label></td>
					<td class="vatop rowform" colspan="2">
						<!--<?php echo ($info["mobile"]); ?>-->
						<input id="mobile" name="mobile" value="<?php echo ($info["mobile"]); ?>">
					</td>
				</tr>
				<tr class="noborder">
					<td class="required"><label class="validation">注册地：</label></td>
					<td class="vatop rowform" colspan="2">
						<!--<?php echo ($info["addr"]); ?>-->
						<input id="addr" name="addr" value="<?php echo ($info["addr"]); ?>">
					</td>
				</tr>



				<tr class="noborder">
					<td class="required"><label class="validation">昵称：</label></td>
					<td class="vatop rowform" colspan="2">
						<input placeholder="昵称" id="username" name="username" value="<?php echo ($info["username"]); ?>">
						<input type="hidden"  id="idd" name="idd" value="<?php echo ($info["user_id"]); ?>">

					</td>
				</tr>
				<tr class="noborder">
					<td class="required"><label class="validation">真实姓名：</label></td>
					<td class="vatop rowform" colspan="2">
						<input placeholder="真实姓名" id="truename" name="truename" value="<?php echo ($info["truename"]); ?>">
					</td>
				</tr>

				<tr class="noborder">
					<td class="required"><label class="bobi">邮箱：</label></td>
					<td class="vatop rowform" colspan="2">
						<input placeholder="邮箱" id="email" name="email" value="<?php echo ($info["email"]); ?>">
					</td>
				</tr>
				<tr class="noborder">
					<td class="required"><label class="validation">微信账户名：</label></td>
					<td class="vatop rowform" colspan="2">
						<?php if($info['wechat_name'] != 1): echo ($info["wechat_name"]); endif; ?>
						<!--<?php echo ($info["wechat_name"]); ?>-->
						<!--<input id="addr" name="addr" value="<?php echo ($info["addr"]); ?>">-->
					</td>
				</tr>
				<tr class="noborder">
					<td class="required"><label class="validation">微信账户：</label></td>
					<td class="vatop rowform" colspan="2">
						<?php if($info['wechat'] != 1): echo ($info["wechat"]); endif; ?>

						<!--<input id="addr" name="addr" value="<?php echo ($info["addr"]); ?>">-->
					</td>
				</tr>
				<tr class="noborder">
					<td class="required"><label class="validation">支付宝账户名：</label></td>
					<td class="vatop rowform" colspan="2">
						<?php if($info['alipay_name'] != 1): echo ($info["alipay_name"]); endif; ?>
						<!--<?php echo ($info["alipay_name"]); ?>-->
						<!--<input id="addr" name="addr" value="<?php echo ($info["addr"]); ?>">-->
					</td>
				</tr>
				<tr class="noborder">
					<td class="required"><label class="validation">支付宝账户：</label></td>
					<td class="vatop rowform" colspan="2">
						<?php if($info['alipay'] != 1): echo ($info["alipay"]); endif; ?>
						<!--<?php echo ($info["alipay"]); ?>-->
						<!--<input id="addr" name="addr" value="<?php echo ($info["addr"]); ?>">-->
					</td>
				</tr>
				<tr class="noborder">
					<td class="required"><label class="bobi">性别：</label></td>
					<td class="vatop rowform" colspan="2">

						<?php echo ($info["sex"]); ?>
						<!--<input placeholder="性别" id="sex" name="email" value="<?php echo ($info["email"]); ?>">-->
					</td>
				</tr>
				<tr class="noborder">
					<td class="required"><label class="bobi">身份证号码：</label></td>
					<td class="vatop rowform" colspan="2">
						<?php echo ($info["idcards"]); ?>
						<!--<input placeholder="邮箱" id="email" name="email" value="<?php echo ($info["email"]); ?>">-->
					</td>
				</tr>

				<tr class="noborder">
					<td class="required"><label class="bobi">身份证正：</label></td>
					<td class="vatop rowform" colspan="2">
						<!--<?php echo ($info["idcards"]); ?>-->
						<img src="<?php echo ($info["zheng"]); ?>" style="height: 150px;width: 250px;"/>
						<!--<input placeholder="邮箱" id="email" name="email" value="<?php echo ($info["email"]); ?>">-->
					</td>
				</tr>
				<tr class="noborder">
					<td class="required"><label class="bobi">身份证号码：</label></td>
					<td class="vatop rowform" colspan="2">
						<img src="<?php echo ($info["fan"]); ?>" style="height: 150px;width: 250px;"/>
						<!--<?php echo ($info["idcards"]); ?>-->
						<!--<input placeholder="邮箱" id="email" name="email" value="<?php echo ($info["email"]); ?>">-->
					</td>
				</tr>




				</tbody>
				<tfoot>
				<tr>
					<td colspan="2" style="text-align: center;">
                        <!--<input type="submit" value="点击开通" class="group_btn" id="tj"/>-->
						<a id="back" href="javascript:void(0)" class="btn"><span>返回</span></a>
						<a id="but1" class="btn"><span>提交</span></a>
					</td>
				</tr>
				</tfoot>
			</table>
		</form>
	</div>


	<script type="text/javascript" src="/bipin/static/a/resource/js/jquery-ui/jquery.ui.js"></script>
	<script type="text/javascript" src="/bipin/static/a/resource/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="/bipin/static/a/resource/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
	<!--<script type="text/javascript" src="/bipin/static/a/home/js/jquery.min.js"></script>-->
	<script>
        $(function(){
            $("#back").click(function(){
                history.go(-1);
            });
            $("#but1").click(function(){
                var idd=$("#idd").val();
//
                var addr=$("#addr").val();
                var mobile=$("#mobile").val();
                var truename=$("#truename").val();
                var username=$("#username").val();
                var email=$("#email").val();

                $.post("<?php echo U('Admin/Users/member_add');?>",{idd:idd,addr:addr,mobile:mobile,truename:truename,username:username,email:email},function(sb){

                    if (sb.status==200) {
                        layer.msg('操作成功',{icon:6});
                        setTimeout(function () {
                            window.location.href="<?php echo U('Users/member');?>";
                        }, 2000);

                    }else{
                        layer.msg(sb.info,{icon:2,time:2000});return false;
                    }
                });
            });
        });

	</script>


<!-- 模板内容结束 -->
</body>
</html>