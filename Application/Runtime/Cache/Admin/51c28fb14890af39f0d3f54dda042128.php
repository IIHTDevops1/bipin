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
                <h3> &nbsp;&nbsp;填写资料</h3>
            </div>
        </div>
        <div class="fixed-empty"></div>
        <form id="edit_form" method="post" action="" enctype="multipart/form-data">
            <table class="table tb-type2">
                <tbody>
				
				<tr class="noborder">
                    <td class="required"><label class="validation" for="store_name">名店名称：</label></td>
                    <td class="vatop rowform">
                        <input width="400px" id="store_name" name="store_name" type="text" class="txt valid" value="" >
                    
                    <td class="vatop tips"></td>
                </tr>
				

				<tr class="noborder">
                    <td class="required"><label class="validation" for="store_name">联系人姓名：</label></td>
                    <td class="vatop rowform">
                        
                    <input id="contact_name" name="contact_name" type="text" class="txt valid" value="">     
                       
                    
                    <td class="vatop tips"></td>
                </tr>

		      <tr class="noborder">
                    <td class="required"><label class="validation" for="store_name">联系人电话：</label></td>
                    <td class="vatop rowform">
                  <input id="contact_phone" name="contact_phone" type="text" class="txt valid" value="">      
                    
                    <td class="vatop tips"></td>
                </tr>

			  <tr class="noborder">
                    <td class="required"><label class="validation" for="type_name">门店分类：</label></td>
                    <td class="vatop rowform">
                        <select name="type_name" width="80px">
                        
                        <option value="0">其他分类</option>
                        </select>
                    
                    <td class="vatop tips"></td>
                </tr>


			 <tr class="noborder">
                    <td class="required"><label class="validation" for="type_name">门店地址：</label></td>
                    <td class="vatop rowform" width="600px">
                    
                      <!-- 省 -->
				    <select name="pro" id="pro">
				     <option value="0" checked>--请选择省--</option>
					<?php if(is_array($region)): foreach($region as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["region_name"]); ?></option><?php endforeach; endif; ?>
				     </select>
                        
                        <!-- 城市 -->
                        <select name="city" id="city">                        
                        <option value="0">--请选择市区--</option>
                        </select>
                        
                        <!--县/区  -->
                        <select name="area" id="area">                       
                        <option value="0">--请选择市区--</option>
                        </select>
                        
                    
                    <td class="vatop tips"></td>
                </tr>


             <tr class="noborder">
                    <td class="required"><label class="validation" for="store_name">详细地址：</label></td>
                    <td class="vatop rowform">
                        <input id="address_detail" name="address_detail" type="text" class="txt valid" value="">
                    
                    <td class="vatop tips"></td>
                </tr>

		
		      <tr class="noborder">
                    <td class="required"><label class="validation" for="thumb">门脸照片：</label></td>
                    <td class="vatop rowform">

                        <div id="thumb_preview" style="display: inline-block">
                            <img src="<?php echo ($news["thumb"]); ?>" width="150">
                        </div>
                        <input type="file" class="" id="uploadbtn1" name="uploadbtn1"/>
                        <input type="hidden" name="thumb" id="thumb" value="<?php echo ($news["thumb"]); ?>"/>
                    </td>                  
                    <td class="vatop tips"></td>
                </tr>
                
                
                <tr class="noborder">
                    <td class="required"><label class="validation" for="thumb">店内照片：</label></td>
                    <td class="vatop rowform">

                        <div id="thumb_preview" style="display: inline-block">
                            <img src="<?php echo ($news["thumb"]); ?>" width="150">
                        </div>
                        <input type="file" class="" id="uploadbtn2" name="uploadbtn2"/>
                        <input type="hidden" name="thumb" id="thumb" value="<?php echo ($news["thumb"]); ?>"/>
                    </td>                 
                    <td class="vatop tips"></td>
                </tr>
                
                
                <tr class="noborder">
                    <td class="required"><label class="validation" for="thumb">店铺logo：</label></td>
                    <td class="vatop rowform">

                        <div id="thumb_preview" style="display: inline-block">
                            <img src="<?php echo ($news["thumb"]); ?>" width="150">
                        </div>
                        <input type="file" class="" id="uploadbtn3" name="uploadbtn3"/>
                        <input type="hidden" name="thumb" id="thumb" value="<?php echo ($news["thumb"]); ?>"/>
                    </td>
                    
                    <td class="vatop tips"></td>
                </tr>
                
                
                <tr class="noborder">
                    <td class="required"><label class="validation" for="thumb">身份证照片：</label></td>
                    <td class="vatop rowform">

                        <div id="thumb_preview" style="display: inline-block">
                            <img src="<?php echo ($news["thumb"]); ?>" width="150">
                        </div>
                        <input type="file" class="" id="uploadbtn4" name="uploadbtn4"/>
                        <input type="hidden" name="thumb" id="thumb" value="<?php echo ($news["thumb"]); ?>"/>
                    </td>
                 
                    <td class="vatop tips"></td>
                </tr>
                
                
                <tr class="noborder">
                    <td class="required"><label class="validation" for="thumb">营业执照：</label></td>
                    <td class="vatop rowform">

                        <div id="thumb_preview" style="display: inline-block">
                            <img src="<?php echo ($news["thumb"]); ?>" width="150">
                        </div>
                        <input type="file" class="" id="uploadbtn5" name="uploadbtn5"/>
                        <input type="hidden" name="thumb" id="thumb" value="<?php echo ($news["thumb"]); ?>"/>
                    </td>
                 
                    <td class="vatop tips"></td>
                </tr>
                
                
                <tr class="noborder">
                    <td class="required"><label class="validation" for="thumb">行业许可证：</label></td>
                    <td class="vatop rowform">

                        <div id="thumb_preview" style="display: inline-block">
                            <img src="<?php echo ($news["thumb"]); ?>" width="150">
                        </div>
                        <input type="file" class="" id="uploadbtn6" name="uploadbtn6"/>
                        <input type="hidden" name="thumb" id="thumb" value="<?php echo ($news["thumb"]); ?>"/>
                    </td>
                  
                    <td class="vatop tips"></td>
                </tr>
		 
		 
            <tr class="noborder">
                    <td class="required"><label class="validation" for="store_name">淘宝店铺地址：</label></td>
                    <td class="vatop rowform">
                        <input id="taobao_address" name="taobao_address" type="text" class="txt valid" value="">
                    
                    <td class="vatop tips"></td>
                </tr>







                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        
                        <a id="submit" href="javascript:void(0)" class="btn"><span>提交审核</span></a>
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
        
        
        
        
        			<!--dom结构部分-->
<!-- <div id="uploader-demo">
    用来存放item
    <div id="fileList" class="uploader-list"></div>
    <div id="filePicker">选择图片</div>
</div>
         -->
        
        
        
        
        
        
    </div>
    <script type="text/javascript" src="/bipin/static/a/resource/js/jquery-ui/jquery.ui.js"></script>
    <script type="text/javascript" src="/bipin/static/a/resource/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
    <script type="text/javascript" src="http://cdn.staticfile.org/webuploader/0.1.0/webuploader.js"> </script>  
    <link rel="stylesheet" type="text/css" href="/bipin/static/a/resource/webuploader.css">
    <link rel="stylesheet" type="text/css" href="/bipin/static/a/resource/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
    
    
    
  <script>
  
  var $ = jQuery,
  $list = $('#fileList'),

  ratio = window.devicePixelRatio || 1,


  thumbnailWidth = 100 * ratio,
  thumbnailHeight = 100 * ratio,

  
  uploader;
  
  var uploader = WebUploader.create({

	    // 选完文件后，是否自动上传。
	    auto: true,

	    // swf文件路径
	    swf:'http://cdn.staticfile.org/webuploader/0.1.0/Uploader.swf',

	    // 文件接收服务端。
	    server: "<?php echo U('Admin/Store/upload_img');?>",

	    // 选择文件的按钮。可选。
	    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
	    pick: '#filePicker',

	    // 只允许选择图片文件。
	    accept: {
	        title: 'Images',
	        extensions: 'gif,jpg,jpeg,bmp,png',
	        mimeTypes: 'image/*'
	    }
	});
  
  uploader.on( 'fileQueued', function( file ) {
	    var $li = $(
	            '<div id="' + file.id + '" class="file-item thumbnail">' +
	                '<img>' +
	                '<div class="info">' + file.name + '</div>' +
	            '</div>'
	            ),
	        $img = $li.find('img');


	    // $list为容器jQuery实例
	    $list.append( $li );

	    // 创建缩略图
	    // 如果为非图片文件，可以不用调用此方法。
	    // thumbnailWidth x thumbnailHeight 为 100 x 100
	    uploader.makeThumb( file, function( error, src ) {
	        if ( error ) {
	            $img.replaceWith('<span>不能预览</span>');
	            return;
	        }

	        $img.attr( 'src', src );
	    }, thumbnailWidth, thumbnailHeight );
	});
  
  
//文件上传过程中创建进度条实时显示。
  uploader.on( 'uploadProgress', function( file, percentage ) {
      var $li = $( '#'+file.id ),
          $percent = $li.find('.progress span');

      // 避免重复创建
      if ( !$percent.length ) {
          $percent = $('<p class="progress"><span></span></p>')
                  .appendTo( $li )
                  .find('span');
      }

      $percent.css( 'width', percentage * 100 + '%' );
  });

  // 文件上传成功，给item添加成功class, 用样式标记上传成功。
  uploader.on( 'uploadSuccess', function( file ) {
      $( '#'+file.id ).addClass('upload-state-done');
  });

  // 文件上传失败，显示上传出错。
  uploader.on( 'uploadError', function( file ) {
      var $li = $( '#'+file.id ),
          $error = $li.find('div.error');

      // 避免重复创建
      if ( !$error.length ) {
          $error = $('<div class="error"></div>').appendTo( $li );
      }

      $error.text('上传失败');
  });

  // 完成上传完了，成功或者失败，先删除进度条。
  uploader.on( 'uploadComplete', function( file ) {
      $( '#'+file.id ).find('.progress').remove();
  });
  </script>  
    
       
 <script type="text/javascript">           	
        	
 $(function(){


     $("#submit").click(function(){

         $('#edit_form').submit();
     });
     $("#back").click(function(){
         history.go(-1);
     });
 });
    </script>   
    
    <script>
    $('#pro').change(function(){
        $.ajax({
            type:"post",
            url:"<?php echo U('Store/add_region');?>",
            data:'pro_id='+$('#pro').val(),
            dataType:"json",
            success:function(data){
            	 $('#city').html(data);
            }
        });
    });
    
    $('#city').change(function(){
        $.ajax({
            type:"post",
            url:"<?php echo U('Store/add_region');?>",
            data:'pro_id='+$('#city').val(),
            dataType:"json",
            success:function(data){
                $('#area').html(data);
            }
        });
    });
</script>


<!-- 模板内容结束 -->
</body>
</html>