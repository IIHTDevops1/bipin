<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >

<meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <script type="text/javascript" src="/static/a/resource/js/jquery.js"></script>
    <script type="text/javascript" src="/static/a/resource/js/jquery.validation.min.js"></script>
    <script type="text/javascript" src="/static/a/resource/js/admincp.js"></script>
    <script type="text/javascript" src="/static/a/resource/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="/static/a/layer/layer.js"></script>
    <script type="text/javascript" src="/static/a/resource/js/common.js" charset="utf-8"></script>
    <!--<script type="text/javascript" src="/static/a/home/js/common.js" charset="utf-8"></script>-->
<!--<script type="text/javascript" src="http://www.jeasyui.net/Public/js/easyui/jquery.easyui.min.js"></script>不知道干啥的-->
    <link href="/static/a/default/css/skin_0.css" rel="stylesheet" type="text/css" id="cssfil2" />
    <link href="/static/a/default/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="/static/a/default/css/font/font-awesome/css/font-awesome-ie7.min.css">
    <![endif]-->
<link href="/static/a/resource/easyui.css" rel="stylesheet" type="text/css" id="cssfile2" />
<link href="/static/a/resource/icon.css" rel="stylesheet" type="text/css" id="cssfile" />
<!--<script type="text/javascript" src="/static/a/resource/jquery-1.4.4.min.js"></script>-->


    <link href="/static/main/uploadify/uploadify.css" rel="stylesheet" type="text/css">
    <script src="/static/main/uploadify/jquery.uploadify.min.js"></script>
    <script>
        $(function(){

        });
    </script>


<script src="/static/a/resource/lib/js/jquery.iDialog.js" ></script>
<script src="/static/a/resource/lib/js/drag.js"></script>

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
                <h3> &nbsp;&nbsp;密码管理</h3>
            </div>
        </div>
        <div class="fixed-empty"></div>
        <form id="edit_form13" method="post">
            <table class="table tb-type2">
                <tbody>
                <tr class="noborder">
                    <td class="required" style="width: 150px;"><label class="validation" for="pwds13" >修改登录密码：</label></td>
                    <td class="vatop rowform">
                        <!--<input id="idd" name="idd" type="hidden" class="txt valid" value="<?php echo ($userinfo["id"]); ?>">-->
                        <input id="pwds13" name="pwds13" type="text"  value="<?php echo ($pwds13); ?>">
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label class="validation" for="pwds1">修改登录密码确认密码：</label></td>
                    <td class="vatop rowform">
                        <!--<input id="idd" name="idd" type="hidden" class="txt valid" value="<?php echo ($userinfo["id"]); ?>">-->
                        <input id="pwds113" name="pwds113" type="text"  value="">
                    <td class="vatop tips"></td>
                </tr>

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <a id="back" href="javascript:void(0)" class="btn"><span>返回</span></a>
                        <a id="submit13" href="javascript:void(0)" class="btn"><span>提交</span></a>
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
        <div class="fixed-empty"></div>

    </div>
    <script type="text/javascript" src="/static/a/resource/js/jquery-ui/jquery.ui.js"></script>
    <script type="text/javascript" src="/static/a/resource/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="/static/a/resource/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
    <script type="text/javascript">
        $(function(){
            //VIP等级管理确认密码
            $("#submit13").click(function(){
                $('#edit_form13').submit();
            });

            $("#back").click(function(){
                history.go(-1);
            });
        });
    </script>


<!-- 模板内容结束 -->
</body>
</html>