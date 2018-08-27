<?php
return array(
    'URL_CASE_INSENSITIVE' =>true, //表示URL访问不区分大小写

    //'DEFAULT_MODULE'     => 'Mobile', //默认模块
    'URL_MODEL'          => '1', //URL模式
    //'URL_MODEL'          => '1', //URL模式
    'SESSION_AUTO_START' => true, //是否开启session
	'URL_ROUTER_ON'   => true,//开启路由
	'DEVELOP_MODE' => true,

    'PUBLISH'=>'1',
	
   
	'NOT_AUTH_MODULE' => 'Public,Index', // 默认无需认证模块
	
    //超级管理员id,拥有全部权限,只要用户uid在这个角色组里的,就跳出认证.可以设置多个值,如array('1','2','3')
    'ADMINISTRATOR'=>array('1'),
	'SESSION_OPTIONS' =>  array('expire'=>36000),
//	'SESSION_PREFIX'        =>  'xsk',
	'DEFAULT_PAGE_SIZE' =>20,//默认每页数据量
	
	 // 加载扩展配置文件 多个用,隔开
	'LOAD_EXT_CONFIG' => 'db,rules',

	//调试信息输出
	//'SHOW_PAGE_TRACE' =>true,
	
	//上传设置
	//'UPLOAD_MAXSIZE'=>31457280,
	//'UPLOAD_EXTS'=>array('jpg','gif','png','jpeg','txt','doc','docx','xls','xlsx','ppt','pptx','pdf','rar','zip','wps','wpt','dot','rtf','dps','dpt','pot','pps','et','ett','xlt'),// 设置附件上传类型 
	//'UPLOAD_SAVEPATH'=>'./Public/',
	

	
	'PICTURE_UPLOAD_DRIVER'=>'local',

	'DEFAULT_THEME' => 'default', // 默认模板主题名称

	//'VIEW_PATH'=>'./templ/',
	//'DEFAULT_THEME' => 'xsk', // 默认模板主题名称
	
	/* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/static',
        '__IMG__'    => __ROOT__ . '/static/images',
        '__CSS__'    => __ROOT__ . '/static/css',
        '__JS__'     => __ROOT__ . '/static/js',
        '__ZUI__'     => __ROOT__ . '/static/dist',
        '__ADMIN_RESOURCE__'=>__ROOT__ . '/static/a',
		'__MOBILE__'     => __ROOT__ . '/static/mobile',
    ),

    'PICTURE_UPLOAD_DRIVER'=>'local',
    'UPLOAD_LOCAL_CONFIG'=>array(),


);
