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

    <link href="/static/main/uploadify/uploadify.css" rel="stylesheet" type="text/css">    <script src="/static/main/uploadify/jquery.uploadify.min.js"></script>    <script>        $(function(){            $("#file").change(function() {                var idd="<?php echo ($news["id"]); ?>";                var $this = this.files[0];                $("#img").attr("src", getObjectURL($this));            })            // file 创建url()            function getObjectURL(file) {                var url = null;                if (window.createObjectURL != undefined) {                    url = window.createObjectURL(file)                } else if (window.URL != undefined) {                    url = window.URL.createObjectURL(file)                } else if (window.webkitURL != undefined) {                    url = window.webkitURL.createObjectURL(file)                }                return url            }        });    </script>

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

    <style>        .required{width:100px;}    </style>    <div class="page">        <div class="fixed-bar">            <div class="item-title">                <h3> &nbsp;&nbsp;修改广告位</h3>            </div>        </div>        <div class="fixed-empty"></div>        <form id="edit_form" method="post" action="" enctype="multipart/form-data">            <table class="table tb-type2">                <tbody>                <tr class="noborder">                    <td class="required"><label for="web_title" class="">广告标题：</label></td>                    <td class="vatop rowform">                        <input id="web_title" name="web_title" type="text" class="txt valid" value="<?php echo ($news["web_title"]); ?>">                    </td>                    <td class="vatop tips"></td>                </tr>                <tr class="noborder">                    <td class="required"><label for="web_title" class="">广告链接：</label></td>                    <td class="vatop rowform">                        <input id="url" name="url" type="text" class="txt valid" value="<?php echo ($news["url"]); ?>">                    </td>                    <td class="vatop tips"></td>                </tr>                <tr class="noborder">                    <td class="required"><label class="validation" for="cad_id">广告位置：</label></td>                    <td class="vatop rowform">                        <select style="width:100px; " id="cad_id" style="width:115px" name="cad_id">                            <?php if($news["id"] != ''): ?><option value="<?php echo ($news["cad_id"]); ?>"><?php echo (get_parent($news['cad_id'])); ?></option>                                <?php else: ?>                                <option value="0">请选择广告投放位置</option><?php endif; ?>                            <?php if(is_array($position)): $i = 0; $__LIST__ = $position;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><option value="<?php echo ($m["id"]); ?>"><?php echo ($m["cad_name"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($m["size_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>                        </select>                        <input id="idd" name="idd" type="hidden" class="txt valid" value="<?php echo ($news["id"]); ?>">                    <td class="vatop tips"></td>                </tr>                <tr class="noborder">                    <td class="required"><label for="thumb" class="validation">广告图：</label></td>                    <td class="vatop rowform">                        <div id="thumb_preview" style="display: inline-block">                            <img src="<?php echo ($news["thumb"]); ?>" width="150">                        </div>                        <input type="file" class="" id="uploadbtn1" name="uploadbtn1"/>                        <input type="hidden" name="thumb" id="thumb" value="<?php echo ($news["thumb"]); ?>"/>                    </td>                    <td class="vatop tips"></td>                </tr>                <tr class="noborder">                    <td class="required"><label class="" for="sort">排序：</label></td>                    <td class="vatop rowform">                        <input id="sort" name="sort" type="text" class="txt valid" value="<?php echo ($news["sort"]); ?>">                    <td class="vatop tips"></td>                </tr>                </tbody>                <tfoot>                <tr>                    <td colspan="2" style="text-align: center;">                        <a id="back" href="javascript:void(0)" class="btn"><span>返回</span></a>                        <a id="submit" href="javascript:void(0)" class="btn"><span>提交</span></a>                    </td>                </tr>                </tfoot>            </table>        </form>    </div>    <script type="text/javascript" src="/static/a/resource/js/jquery-ui/jquery.ui.js"></script>    <script type="text/javascript" src="/static/a/resource/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>    <link rel="stylesheet" type="text/css" href="/static/a/resource/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />    <script type="text/javascript">        $(function(){            $("#submit").click(function(){                var cad_id = $('#cad_id').val();                if(cad_id==0){                    alert('选择广告投放位置');                    return;                }                $('#edit_form').submit();            });            $("#back").click(function(){                history.go(-1);            });        });    </script>

<!-- 模板内容结束 -->
</body>
</html>