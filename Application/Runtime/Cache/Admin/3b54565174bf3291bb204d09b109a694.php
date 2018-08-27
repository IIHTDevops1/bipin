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

    <link href="/bipin/static/main/uploadify/uploadify.css" rel="stylesheet" type="text/css">    <script src="/bipin/static/main/uploadify/jquery.uploadify.min.js"></script>    <script>        $(function(){            $("#file").change(function() {                var idd="<?php echo ($news["id"]); ?>";                    var $this = this.files[0];                    $("#img").attr("src", getObjectURL($this));//                alert("恭喜上传成功");                //    var data = new FormData();                    //console.log($(this)[0].files[0]);                //    data.append('logo',$(this)[0].files[0]);////                $.ajax({//                    type:'post',//                    url:"<?php echo U('Platform/get_url');?>",//                    data:data,//                    cache : false,//                    processData : false, // 不处理发送的数据，因为data值是Formdata对象，不需要对数据做处理//                    contentType : false, // 不设置Content-type请求头//                    success : function(r){//                        alert("2")//                        if(r.error){//                            alert(r.error);//                        }//                    }//                })            })            // file 创建url()            function getObjectURL(file) {                var url = null;                if (window.createObjectURL != undefined) {                    url = window.createObjectURL(file)                } else if (window.URL != undefined) {                    url = window.URL.createObjectURL(file)                } else if (window.webkitURL != undefined) {                    url = window.webkitURL.createObjectURL(file)                }                return url            }        });    </script>

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

    <style>        .required{width:100px;}    </style>    <div class="page">        <div class="fixed-bar">            <div class="item-title">                <h3> &nbsp;&nbsp;VIP特权</h3>            </div>        </div>        <div class="fixed-empty"></div>        <form id="edit_form" method="post" action="" enctype="multipart/form-data" >            <table class="table tb-type2">                <tbody>                <tr class="noborder">                    <td class="required"><label class="validation" for="thumb">广告位图片：</label></td>                    <td class="vatop rowform">                        <div id="thumb_preview" style="display: inline-block">                            <img src="<?php echo ($news["thumb"]); ?>" width="150">                        </div>                        <input type="file" class="" id="uploadbtn1" name="uploadbtn1"/>                        <input type="hidden" name="thumb" id="thumb" value="<?php echo ($news["thumb"]); ?>"/>                    </td>                    <!--<input id="thumb" name="thumb" type="file" class="txt valid" value="<?php echo ($news["thumb"]); ?>">-->                    <td class="vatop tips"></td>                </tr>                <tr class="noborder">                    <td class="required"><label class="validation" for="content">特权介绍：</label></td>                    <td class="vatop rowform">                        <textarea id="content" name="content" type="text" class="txt valid" style="height:300px;width:400px;"><?php echo ($news["content"]); ?></textarea>                    <td class="vatop tips"></td>                </tr>                </tbody>                <tfoot>                <tr>                    <td colspan="2" style="text-align: center;">                        <a id="back" href="javascript:void(0)" class="btn"><span>返回</span></a>                        <a id="submit" href="javascript:void(0)" class="btn"><span>提交</span></a>                    </td>                </tr>                </tfoot>            </table>        </form>    </div>    <script type="text/javascript" src="/bipin/static/a/resource/js/jquery-ui/jquery.ui.js"></script>    <script type="text/javascript" src="/bipin/static/a/resource/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>    <link rel="stylesheet" type="text/css" href="/bipin/static/a/resource/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />    <script type="text/javascript">$("#submit").click(function(){    var content = $('#content').val();    if(content.length<1){        alert('vip介绍不能为空');        return;    }    $('#edit_form').submit();});$("#back").click(function(){    history.go(-1);});    </script>

<!-- 模板内容结束 -->
</body>
</html>