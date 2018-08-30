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


    <link href="/bipin/static/main/uploadify/uploadify.css" rel="stylesheet" type="text/css">
    <script src="/bipin/static/main/uploadify/jquery.uploadify.min.js"></script>
    <script>
        $(function(){

        });
    </script>


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
                <h3> &nbsp;&nbsp;添加银行卡</h3>
            </div>
        </div>
        <div class="fixed-empty"></div>
        <form id="edit_form" method="post" action="<?php echo U('Statistics/card_add');?>">
            <table class="table tb-type2">
                <tbody>
                <tr class="noborder">
                    <td class="required"><label class="validation" for="news_title">真实姓名</label></td>
                    <td class="vatop rowform">
                        <!--<input id="idd" name="idd" type="hidden" class="txt valid" value="<?php echo ($userinfo["id"]); ?>">-->
                        <input id="news_title" name="true_name" type="text" class="txt valid" placeholder="请输入银行卡预留姓名">
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label class="validation" for="content">身份证号：</label></td>
                    <td class="vatop rowform">
                        <input id="content" name="id_card" type="text" class="txt valid" placeholder="请输入身份证号码">
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td class="required"><label class="validation" for="addtime">银行卡号：</label></td>
                    <td class="vatop rowform">
                        <input id="addtime" name="card_number" type="text" class="txt valid" placeholder="请输入银行卡号">
                    <td class="vatop tips"></td>
                </tr>
                
                 <tr class="noborder">
                    <td class="required"><label class="validation" for="addtime">开户行：</label></td>
                    <td class="vatop rowform">
                        <input id="addtime" name="bank_name" type="text" class="txt valid" placeholder="请输入开户行">
                    <td class="vatop tips"></td>
                </tr>

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2" style="text-align: center;">
                       
                        <a id="submit" href="javascript:void(0)" class="btn"><span>添加银行卡</span></a>
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
    <script type="text/javascript" src="/bipin/static/a/resource/js/jquery-ui/jquery.ui.js"></script>
    <script type="text/javascript" src="/bipin/static/a/resource/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="/bipin/static/a/resource/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
    <script type="text/javascript">
        $(function(){



            $("#submit").click(function(){
               var title = $('#news_title').val();

                if(title==''){
                   alert('姓名不能为空');
                   return;
                }

                $('#edit_form').submit();
            });
           
        });
    </script>


<!-- 模板内容结束 -->
</body>
</html>