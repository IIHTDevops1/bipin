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
                <ul class="tab-base">
            <li><a href="<?php echo U('mer_list');?>"><span>商品管理</span></a></li>

            <li><a href="<?php echo U('mer_add');?>"<?php if(empty($classification)): ?>class="current"<?php endif; ?>><span>添加商品</span></a></li>
            
             <li><a href="<?php echo U('mer_add');?>"><span>预览</span></a></li>
        </ul>
            </div>
        </div>
        <div class="fixed-empty"></div>
        <form id="edit_form" method="post" action="<?php echo U('Merchandise/mer_edit');?>" enctype="multipart/form-data">
            <table class="table tb-type2">
                <tbody>
				
				<tr class="noborder">
                    <td class="required"><label class="validation" for="store_name">商品名称：</label></td>
                    <td class="vatop rowform">
                        <input width="400px"  name="pro_name" type="text" class="txt valid" placeholder="请输入商品名称" >
                    
                    <td class="vatop tips"></td>
                </tr>
                
                	<tr class="noborder">
                    <td class="required"><label class="validation" for="store_name">商品价格：</label></td>
                    <td class="vatop rowform">
                        <input width="400px"  name="price" type="text" class="txt valid" placeholder="请输入商品价格" >
                    
                    <td class="vatop tips"></td>
                </tr>
                
                  <tr class="noborder">
                    <td class="required"><label class="validation" for="type_name">所属分类：</label></td>
                    <td class="vatop rowform">
                        <select name="type_name" width="80px">
                        
                        <option value="0">请选择所属分类</option>
                        <foeach name="pro_cate" item="v">
                          <option value="<?php echo ($v["id"]); ?>"><?php echo ($v["type_name"]); ?></option>
                        </foeach>
                        </select>
                    
                    <td class="vatop tips"></td>
                </tr>
                
				

				<tr class="noborder">
                    <td class="required"><label class="validation" for="store_name">运费：</label></td>
                    <td class="vatop rowform">
                        
                    <input id="contact_name" name="express_fee" type="text" class="txt valid" placeholder="请输入运费">     
                       
                    
                    <td class="vatop tips"></td>
                </tr>

		      <tr class="noborder">
                    <td class="required"><label class="validation" for="store_name">重量：</label></td>
                    <td class="vatop rowform">
                  <input id="contact_phone" name="weight" type="text" class="txt valid" placeholder="请输入重量"> kg     
                    
                    <td class="vatop tips"></td>
                </tr>

			

		

             
				
				 <tr class="noborder">
                    <td class="required"><label class="validation" for="thumb">缩略图：</label></td>
                    <td class="vatop rowform">

                        <div id="thumb_preview" style="display: inline-block">
                            <img src="<?php echo ($news["thumb"]); ?>" width="150">
                        </div>
                        <input type="file" class="" id="uploadbtn1" name="uploadbtn1[]"/>
                        <input type="hidden" name="thumb" id="thumb" value="<?php echo ($news["thumb"]); ?>"/>
                    </td>                 
                    <td class="vatop tips"></td>
                </tr>
		
		      <tr class="noborder">
                    <td class="required"><label class="validation" for="thumb">商品图片：</label></td>
                    <td class="vatop rowform">

                        <div id="thumb_preview" style="display: inline-block">
                            <img src="<?php echo ($news["thumb"]); ?>" width="150">
                        </div>
                        <input type="file" class="" id="uploadbtn2" name="uploadbtn2[]" multiple="multiple" />
                        <input type="hidden" name="thumb" id="thumb" value="<?php echo ($news["thumb"]); ?>"/>
                    </td>                  
                    <td class="vatop tips"></td>
                </tr>
                
                
                <tr class="noborder">
                    <td class="required"><label class="validation" for="store_name">商品规格：</label></td>
                    <td class="vatop rowform">
                       <table id="standard">
                       
                        <tr>
                        <th style="text-align:center">名称</th>
                       <th style="text-align:center">大小</th>
                       <th style="text-align:center">颜色</th>
                       <th style="text-align:center">价格</th>
                       <th style="text-align:center">库存</th>
                       </tr>
                       
                       <tr>
                        <td><input type="text" name="standard_pro_name[]"/></td>
                       <td><input type="text" name="standard1[]"/></td>
                       <td><input type="text" name="standard2[]"/></td>
                       <td><input type="text" name="standard_price[]"/></td>
                       <td><input type="text" name="standard_nums[]"/></td>                       
                       </tr>
                       
                       
                       </table>
                      <table>
                        <tr>
                       <td><input id="add_standard" type="button" value="添加规格"/></td>
                       </tr>
                      </table>
                     
                    
                    <td class="vatop tips"></td>
                </tr>
               

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        
                        <a id="submit" href="javascript:void(0)" class="btn"><span>上架</span></a>
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


     $("#add_standard").click(function(){
			
         $("#standard").append("<tr><td><input type=\"text\" name=\"standard_pro_name[]\"/></td><td><input type=\"text\" name=\"standard1[]\"/></td><td><input type=\"text\" name=\"standard2[]\"/></td><td><input type=\"text\" name=\"standard_price[]\"/></td><td><input type=\"text\" name=\"standard_nums[]\"/></td></tr>");
     });
    
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
    



<!-- 模板内容结束 -->
</body>
</html>