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

<!--js-->

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

    <style>        .required{width:100px;}    </style>    <div class="page">        <div class="fixed-bar">            <div class="item-title">                <h3> &nbsp;&nbsp;修改公告</h3>            </div>        </div>        <div class="fixed-empty"></div>        <form id="edit_form" method="post" action="">            <table class="table tb-type2">                <tbody>                <tr class="noborder">                    <td class="required"><label for="news_title" class="validation">公告标题：</label></td>                    <td class="vatop rowform">                        <input id="news_title" name="news_title" type="text" class="txt valid" value="<?php echo ($infos["news_title"]); ?>">                        <input id="idd" name="idd" type="hidden" class="txt valid" value="<?php echo ($infos["id"]); ?>">                    </td>                    <td class="vatop tips"></td>                </tr> <tr class="noborder">                    <td class="required"><label for="content1" class="validation">简介：</label></td>                    <td class="vatop rowform">                        <!--<textarea name="jianjie" id="jianjie" style="width:500px;height:200px;"><?php echo ($infos["jianjie"]); ?></textarea>-->                        <input id="content1" name="content1" type="text" class="txt valid" value="<?php echo ($infos["content1"]); ?>">                    </td>                    <td class="vatop tips"></td>                </tr>                <tr class="noborder">                    <td class="required"><label for="content" class="validation">详情：</label></td>                    <td class="vatop rowform">                        <textarea name="content" id="content" style="width:500px;height:300px;"><?php echo ($infos["content"]); ?></textarea>                        <script src="/static/kindeditor/kindeditor.js" charset="utf-8"></script>                        <script src="/static/kindeditor/lang/zh_CN.js" charset="utf-8"></script>                        <script>                            KindEditor.ready(function(K) {                                var editor1 = K.create('textarea[name="content"]', {                                    uploadJson : '/static/kindeditor/php/upload_json.php',                                    fileManagerJson : '/static/kindeditor/php/file_manager_json.php',                                    allowFileManager : true,                                    filterMode:false,                                    syncType:"form",                                    urlType:'domain',                                    afterCreate : function() {                                        var self = this;                                        self.sync();                                    },                                    afterChange : function() {                                        var self = this;                                        self.sync();                                    },                                    afterBlur : function() {                                        var self = this;                                        self.sync();                                    }                                });                            });                        </script>                    </td>                    <td class="vatop tips"></td>                </tr>                </tbody>                <tfoot>                <tr>                    <td colspan="2" style="text-align: center;">                        <a id="back" href="javascript:void(0)" class="btn"><span>返回</span></a>                        <a id="submit" href="javascript:void(0)" class="btn"><span>提交</span></a>                    </td>                </tr>                </tfoot>            </table>        </form>    </div>    <script type="text/javascript" src="/static/a/resource/js/jquery-ui/jquery.ui.js"></script>    <script type="text/javascript" src="/static/a/resource/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>    <link rel="stylesheet" type="text/css" href="/static/a/resource/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />    <script src="/static/a/resource/js/laydate/laydate.js"></script>    <script>        //执行一个laydate实例        laydate.render({            elem: '#times'            ,range: true        });    </script>    <script type="text/javascript">        $(function(){            $("#submit").click(function(){                $('#edit_form').submit();            });            $("#back").click(function(){                history.go(-1);            });        });    </script>

<!-- 模板内容结束 -->
</body>
</html>