<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8">
<title>艾思电商管理系统</title>
<link href="/bipin/static/a/default/css/skin_0.css" rel="stylesheet" type="text/css" id="cssfile"/>

<script type="text/javascript" src="/bipin/static/a/resource/js/jquery.js"></script>
<script type="text/javascript" src="/bipin/static/a/resource/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="/bipin/static/a/resource/js/jquery.cookie.js"></script>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="/bipin/static/a/resource/js/html5shiv.js"></script>
<script src="/bipin/static/a/resource/js/respond.min.js"></script>
<![endif]-->
<script>
    //
    $(document).ready(function () {
        $('span.bar-btn').click(function () {
            $('ul.bar-list').toggle('fast');
        });
    });

    $(document).ready(function () {
        var pagestyle = function () {
            var iframe = $("#workspace");
            var h = $(window).height() - iframe.offset().top;
            var w = $(window).width() - iframe.offset().left;
            if (h < 300) h = 300;
            if (w < 973) w = 973;
            iframe.height(h);
            iframe.width(w);
        }
        pagestyle();
        $(window).resize(pagestyle);
        //turn location
        if ($.cookie('now_location_act') != null) {
            openItem($.cookie('now_location_op') + ',' + $.cookie('now_location_act') + ',' + $.cookie('now_location_nav'));
        } else {
            $('#mainMenu>ul').first().css('display', 'block');
            //第一次进入后台时，默认定到欢迎界面
            $('#item_welcome').addClass('selected');
            $('#workspace').attr('src', "<?php echo U('Index/welcome');?>");
        }
        $('#iframe_refresh').click(function () {
            var fr = document.frames ? document.frames("workspace") : document.getElementById("workspace").contentWindow;
            ;
            fr.location.reload();
        });

    });
    //收藏夹
    function addBookmark(url, label) {
        if (document.all) {
            window.external.addFavorite(url, label);
        }
        else if (window.sidebar) {
            window.sidebar.addPanel(label, url, '');
        }
    }


    function openItem(args) {
        closeBg();
        //cookie

        if ($.cookie('866D_sys_key') === null) {
            //location.href = 'index.php?act=login&op=login';
            //return false;
        }

        spl = args.split(',');
        op = spl[0];


        try {
            act = spl[1];
            nav = spl[2];
        }
        catch (ex) {
        }

        if (typeof(act) == 'undefined') {
            var nav = args;
        }

//       alert('op:'+op+'  act:'+act+'  nav:'+nav);
        $('.actived').removeClass('actived');
        $('#nav_' + nav).addClass('actived');

        $('.selected').removeClass('selected');

        //show
        $('#mainMenu ul').css('display', 'none');
        $('#sort_' + nav).css('display', 'block');

        if (typeof(act) == 'undefined') {
            //顶部菜单事件
            html = $('#sort_' + nav + '>li>dl>dd>ol>li').first().html();
            str = html.match(/openItem\('(.*)'\)/ig);
            arg = str[0].split("'");
            spl = arg[1].split(',');
            op = spl[0];
            act = spl[1];
            nav = spl[2];
            first_obj = $('#sort_' + nav + '>li>dl>dd>ol>li').first().children('a');
            $(first_obj).addClass('selected');
            //crumbs
            $('#crumbs').html('<span>' + $('#nav_' + nav + ' > span').html() + '</span><span class="arrow">&nbsp;</span><span>' + $(first_obj).text() + '</span>');
        } else {
            //左侧菜单事件
            //location

            $.cookie('now_location_nav', nav);
            $.cookie('now_location_act', act);
            $.cookie('now_location_op', op);

            var _name =  $("a[name='item_" + op + act + "']")
            _name.addClass('selected');

            //crumbs

            $('#crumbs').html('<span>' + $('#nav_' + nav + ' > span').html() + '</span><span class="arrow">&nbsp;</span><span>' + $('#item_' + op + act).html() + '</span>');
        }
        src = '/bipin/index.php?m=admin&c='+act+'&a='+op;
//       alert('act:'+act+'  op:'+op);
        //src = 'goods.html';
        $('#workspace').attr('src', src);

    }

    $(function () {
        bindAdminMenu();
    })
    function bindAdminMenu() {

        $("[nc_type='parentli']").click(function () {
            var key = $(this).attr('dataparam');
            if ($(this).find("dd").css("display") == "none") {
                $("[nc_type='" + key + "']").slideDown("fast");
                $(this).find('dt').css("background-position", "-322px -170px");
                $(this).find("dd").show();
            } else {
                $("[nc_type='" + key + "']").slideUp("fast");
                $(this).find('dt').css("background-position", "-483px -170px");
                $(this).find("dd").hide();
            }
        });
    }
</script>
<script type="text/javascript">
    //显示灰色JS遮罩层
    function showBg(ct, content) {
        var bH = $("body").height();
        var bW = $("body").width();
        var objWH = getObjWh(ct);
        $("#pagemask").css({width: bW, height: bH, display: "none"});
        var tbT = objWH.split("|")[0] + "px";
        var tbL = objWH.split("|")[1] + "px";
        $("#" + ct).css({top: tbT, left: tbL, display: "block"});
        $(window).scroll(function () {
            resetBg()
        });
        $(window).resize(function () {
            resetBg()
        });
    }
    function getObjWh(obj) {
        var st = document.documentElement.scrollTop;//滚动条距顶部的距离
        var sl = document.documentElement.scrollLeft;//滚动条距左边的距离
        var ch = document.documentElement.clientHeight;//屏幕的高度
        var cw = document.documentElement.clientWidth;//屏幕的宽度
        var objH = $("#" + obj).height();//浮动对象的高度
        var objW = $("#" + obj).width();//浮动对象的宽度
        var objT = Number(st) + (Number(ch) - Number(objH)) / 2;
        var objL = Number(sl) + (Number(cw) - Number(objW)) / 2;
        return objT + "|" + objL;
    }
    function resetBg() {
        var fullbg = $("#pagemask").css("display");
        if (fullbg == "block") {
            var bH2 = $("body").height();
            var bW2 = $("body").width();
            $("#pagemask").css({width: bW2, height: bH2});
            var objV = getObjWh("dialog");
            var tbT = objV.split("|")[0] + "px";
            var tbL = objV.split("|")[1] + "px";
            $("#dialog").css({top: tbT, left: tbL});
        }
    }

    //关闭灰色JS遮罩层和操作窗口
    function closeBg() {
        $("#pagemask").css("display", "none");
        $("#dialog").css("display", "none");
    }
</script>


</head>

<body style="min-width: 1200px; margin: 0px; ">
<div id="pagemask"></div>
<div id="dialog" style="display:none">
    <div class="title">
        <h3>管理中心导航</h3>
        <span><a href="JavaScript:void(0);" onclick="closeBg();">关闭</a></span></div>
    <div class="content">

    </div>
</div>
<table style="width: 100%;" id="frametable" height="100%" width="100%" cellpadding="0" cellspacing="0">
<tbody>
<tr>
    <td colspan="2" height="90" class="mainhd">
        <div class="layout-header"> <!-- Title/Logo - can use text instead of image -->
            <div id="title"><a href="index.php"><img src="../images/sky/search.svg"></img></a></div>
            <!-- Top navigation -->
            <div id="topnav" class="top-nav">
                <ul>
                    <li class="adminid" title="您好:admin">您好&nbsp;:&nbsp;<strong><?php echo ($_SESSION['user_auth']['username']); ?></strong></li>
                    <li><a href="<?php echo U('Public/changge');?>" target="workspace"><span>修改密码</span></a></li>
                    <li><a href="<?php echo U('Public/logout');?>" title="安全退出"><span>安全退出</span></a></li>
                    <!--<li><a href="<?php echo U('Index/welcome');?>" title="后台首页"><span>后台首页</span></a></li>-->
                </ul>
            </div>
            <!-- End of Top navigation -->
            <!-- Main navigation -->
            <nav id="nav" class="main-nav">
                <ul>
                   <li><a class="link  actived" id="nav_index" href="javascript:;" onclick="openItem('index');"><span>控制台</span></a></li>

                    <li><a class="link" id="nav_ade" href="javascript:;" onclick="openItem('ade');"><span>广告管理</span></a></li>
                    <li><a class="link" id="nav_users" href="javascript:;" onclick="openItem('users');"><span>会员管理</span></a></li>
                     <li><a class="link" id="nav_users" href="javascript:;" onclick="openItem('users');"><span>骑手管理</span></a></li>
                    <li><a class="link" id="nav_agent" href="javascript:;" onclick="openItem('agent');"><span>伴奏管理</span></a></li>
                    <li><a class="link" id="nav_carshop" href="javascript:;" onclick="openItem('carshop');"><span>汽车商城</span></a></li>
                    <li><a class="link" id="nav_healthyshop" href="javascript:;" onclick="openItem('healthyshop');"><span>商城管理</span></a></li>
                    <li><a class="link" id="nav_order" href="javascript:;" onclick="openItem('order');"><span>资金管理</span></a></li>
                    <li><a class="link" id="nav_news" href="javascript:;" onclick="openItem('news');"><span>资源管理</span></a></li>
                    <li><a class="link" id="nav_xiaoxi" href="javascript:;" onclick="openItem('xiaoxi');"><span>公告/说明</span></a></li>
                    <li><a class="link" id="nav_system" href="javascript:;" onclick="openItem('system');"><span>设置</span></a></li>
                  <li><a class="link" id="nav_car" href="javascript:;" onclick="openItem('car');"><span>租赁部</span></a></li>
					
					
					
				 <li><a class="link" id="nav_statistics" href="javascript:;" onclick="openItem('statistics');"><span>统计/资金</span></a></li>
                <li><a class="link" id="nav_stores" href="javascript:;" onclick="openItem('stores');"><span>店铺/商品</span></a></li>
				 <li><a class="link" id="nav_message" href="javascript:;" onclick="openItem('message');"><span>消息</span></a></li>	





                </ul>
            </nav>
            <div class="loca"><strong>您的位置:</strong>

                <div id="crumbs" class="crumbs"><span>商品</span><span class="arrow">&nbsp;</span><span>品牌管理</span></div>
            </div>


            </div>
        </div>
        <div></div>
    </td>
</tr>
<tr>
    <td class="menutd" valign="top" width="256">
        <div id="mainMenu" class="main-menu">




  <ul id="sort_stores" style="display: block;">
                <li>
                    <dl>
                        <dd>
                            <ol>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_apply" id="item_apply"
                                                  onclick="openItem('store_apply,store,store');">商家入驻</a></li>

                            </ol>
                        </dd>
                    </dl>
                </li>
                 <li>
                    <dl>
                        <dd>
                            <ol>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_manage" id="item_manage"
                                                  onclick="openItem('merchandise_manage,store,store');">商品管理</a></li>

                            </ol>
                        </dd>
                    </dl>
                </li>
                <li>
                    <dl>
                        <dd>
                            <ol>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_manage" id="item_manage"
                                                  onclick="openItem('store_temp,store,store');">店铺模板</a></li>

                            </ol>
                        </dd>
                    </dl>
                </li>
                <li>
                    <dl>
                        <dd>
                            <ol>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_manage" id="item_manage"
                                                  onclick="openItem('after_sale,store,store');">售后管理</a></li>

                            </ol>
                        </dd>
                    </dl>
                </li>
                <li>
                    <dl>
                        <dd>
                            <ol>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_manage" id="item_manage"
                                                  onclick="openItem('store_manage,store,store');">店铺管理</a></li>

                            </ol>
                        </dd>
                    </dl>
                </li>
            </ul>





  <ul id="sort_statistics" style="display: block;">
                <li>
                    <dl>
                        <dd>
                            <ol>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_order" id="item_order"
                                                  onclick="openItem('order_stat,statistics,statistics');">订单统计</a></li>

                            </ol>
                        </dd>
                    </dl>
                </li>
                   <li>
                    <dl>
                        <dd>
                            <ol>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_money" id="item_money"
                                                  onclick="openItem('money_manage,statistics,statistics');">资金管理</a></li>

                            </ol>
                        </dd>
                    </dl>
                </li>
            </ul>













            <ul id="sort_index" style="display: block;">
                <li>
                    <dl>
                        <dd>
                            <ol>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_welcomeindex" id="item_welcomeindex"
                                                  onclick="openItem('welcome,index,index');">欢迎页面</a></li>

                            </ol>
                        </dd>
                    </dl>
                </li>
            </ul>

            <ul id="sort_xiaoxi" style="display: block;">
                <li>
                    <dl>
                        <dd>
                            <ol>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_gonggaosystem" id="item_gonggaosystem"
                                       onclick="openItem('gonggao,system,xiaoxi');">系统消息</a></li>

                                <li nc_type="">
                                <a href="JavaScript:void(0);" name="item_jianjiesystem" id="item_jianjiesystem"
                                onclick="openItem('jianjie,system,xiaoxi');">发布说明</a></li>
                                <!--<li nc_type="">-->
                                <!--<a href="JavaScript:void(0);" name="item_yuyuesystem" id="item_yuyuesystem"-->
                                <!--onclick="openItem('yuyue,system,xiaoxi');">会员特权说明</a></li>-->
                                <li nc_type="">
                                <a href="JavaScript:void(0);" name="item_zizhisystem" id="item_zizhisystem"
                                onclick="openItem('zizhi,system,xiaoxi');">戏币说明</a></li>

                                <li nc_type="">
                                <a href="JavaScript:void(0);" name="item_chongsystem" id="item_chongsystem"
                                onclick="openItem('chong,system,xiaoxi');">收益说明</a></li>
                                <li nc_type="">
                                <a href="JavaScript:void(0);" name="item_tixiansystem" id="item_tixiansystem"
                                onclick="openItem('tixian,system,xiaoxi');">提现说明</a></li>
                            </ol>
                        </dd>
                    </dl>
                </li>
            </ul>
            <ul id="sort_system" style="display: block;">
                <li>
                    <dl>
                        <dd>
                            <ol>
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_gonggaosystem" id="item_gonggaosystem"-->
                                       <!--onclick="openItem('gonggao,system,system');">系统消息</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_regionsystem" id="item_regionsystem"-->
                                                  <!--onclick="openItem('region,system,system');">区域管理</a></li>-->
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_editionsystem" id="item_editionsystem"
                                                  onclick="openItem('edition,system,system');">版本管理</a></li>

                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_vipmima13system" id="item_vipmima13system"-->
                                                  <!--onclick="openItem('vipmima13,system,system');">VIP等级管理</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_vipmima14system" id="item_vipmima14system"-->
                                                  <!--onclick="openItem('vipmima14,system,system');">拨比设置</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_bobisystem" id="item_bobisystem"-->
                                                  <!--onclick="openItem('bobi,system,system');">拨比设置</a></li>-->
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_aboutsystem" id="item_aboutsystem"
                                                  onclick="openItem('about,system,system');">关于我们</a></li>


                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_moshisystem" id="item_moshisystem"-->
                                                  <!--onclick="openItem('moshi,system,system');">提现比例</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_tuanduisystem" id="item_tuanduisystem"-->
                                                  <!--onclick="openItem('tuandui,system,system');">公司团队</a></li>-->
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_wechatsystem" id="item_wechatsystem"
                                                  onclick="openItem('wechat,system,system');">客服团队</a></li>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_agreementsystem" id="item_agreementsystem"
                                                  onclick="openItem('agreement,system,system');">用户协议</a></li>

                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_bilisystem" id="item_bilisystem"
                                       onclick="openItem('bili,system,system');">提现比例</a></li>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_vipdengjisystem" id="item_vipdengjisystem"
                                       onclick="openItem('vipdengji,system,system');">VIP会员特权</a></li>
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_beijingsystem" id="item_beijingsystem"-->
                                                  <!--onclick="openItem('beijing,system,system');">二维码背景图</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_beijing1system" id="item_beijing1system"-->
                                                  <!--onclick="openItem('beijing1,system,system');">二维码背景图</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_zhifusystem" id="item_zhifusystem"-->
                                                  <!--onclick="openItem('zhifu,system,system');">定金支付协议</a></li>-->


                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_yuyuesystem" id="item_yuyuesystem"-->
                                                  <!--onclick="openItem('yuyue,system,system');">预约租车协议</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_shuomingsystem" id="item_shuomingsystem"-->
                                                  <!--onclick="openItem('shuoming,system,system');">购车告知书</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_xiedaisystem" id="item_xiedaisystem"-->
                                                  <!--onclick="openItem('xiedai,system,system');">购车携带材料</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_fanhuansystem" id="item_fanhuansystem"-->
                                                  <!--onclick="openItem('fanhuan,system,system');">交车返回材料</a></li>-->

                            </ol>
                        </dd>
                    </dl>
                </li>
            </ul>

            <ul id="sort_users" style="display: block;">
                <li>
                    <dl>
                        <dd>
                            <ol>

 <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_memberusers" id="item_memberusers"
                                                  onclick="openItem('member,users,users');">用户管理</a></li>
<li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_istrueusers" id="item_istrueusers"
                                                  onclick="openItem('istrue,users,users');">实名认证</a></li>

                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_tousuusers" id="item_tousuusers" onclick="openItem('tousu,users,users');">客户投诉</a>
                                </li>
 <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_liuyanusers" id="item_liuyanusers" onclick="openItem('liuyan,users,users');">意见反馈</a>
                                </li>

                            </ol>
                        </dd>
                    </dl>
                </li>
            </ul>

            <!--<ul id="sort_agent" style="display: block;">-->
                <!--<li>-->
                    <!--<dl>-->
                        <!--<dd>-->
                            <!--<ol>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_stageagent" id="item_stageagent"-->
                                                  <!--onclick="openItem('stage,agent,agent');">阶段管理</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_sign_upagent" id="item_sign_upagent"-->
                                                  <!--onclick="openItem('sign_up,agent,agent');">报名管理</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_examinationagent" id="item_examinationagent"-->
                                                  <!--onclick="openItem('examination,agent,agent');">考试管理</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_questionsagent" id="item_questionsagent"-->
                                       <!--onclick="openItem('questions,agent,agent');">题库管理</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_common_problemagent" id="item_common_problemagent"-->
                                       <!--onclick="openItem('common_problem,agent,agent');">常见问题</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_experienceagent" id="item_experienceagent"-->
                                       <!--onclick="openItem('experience,agent,agent');">心得审核</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_signupagent" id="item_signupagent"-->
                                       <!--onclick="openItem('signup,agent,agent');">签到管理</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_student_styleade" id="item_student_styleade"-->
                                       <!--onclick="openItem('student_style,ade,agent');">学员风采</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_student_videoagent" id="item_student_videoagent"-->
                                       <!--onclick="openItem('student_video,agent,agent');">学员视频</a></li>-->
                                <!--<li nc_type="">-->
                                <!--<a href="JavaScript:void(0);" name="item_shaidannews" id="item_shaidannews"-->
                                <!--onclick="openItem('shaidan,news,agent');">车主晒单</a></li>-->
                                <!--&lt;!&ndash;<li nc_type="">&ndash;&gt;-->
                                    <!--&lt;!&ndash;<a href="JavaScript:void(0);" name="item_examinationade" id="item_examinationade"&ndash;&gt;-->
                                       <!--&lt;!&ndash;onclick="openItem('examination,ade,agent');">在线考试</a></li>&ndash;&gt;-->
                            <!--</ol>-->
                        <!--</dd>-->
                    <!--</dl>-->
                <!--</li>-->
            <!--</ul>-->
            <ul id="sort_carshop" style="display: block;">
                <li>
                    <dl>
                        <dd>
                            <ol>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_brandcarshop" id="item_brandcarshop" onclick="openItem('brand,carshop,carshop');">汽车品牌</a>
                                </li>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_blackaccountcarshop" id="item_blackaccountcarshop" onclick="openItem('blackaccount,carshop,carshop');">车型管理</a>
                                </li>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_price_rangecarshop" id="item_price_rangecarshop" onclick="openItem('price_range,carshop,carshop');">价格区间</a>
                                </li>
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_down_paymentscarshop" id="item_down_paymentscarshop" onclick="openItem('down_payments,carshop,carshop');">首付</a>-->
                                <!--</li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_forthe_monthcarshop" id="item_forthe_monthcarshop" onclick="openItem('forthe_month,carshop,carshop');">月供</a>-->
                                <!--</li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_timescarshop" id="item_timescarshop" onclick="openItem('times,carshop,carshop');">活动抵扣</a>-->
                                <!--</li>-->
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_storescarshop" id="item_storescarshop" onclick="openItem('stores,carshop,carshop');">产品管理</a>
                                </li>
                            </ol>
                        </dd>
                    </dl>
                </li>
            </ul>
            <ul id="sort_healthyshop" style="display: block;">
                <li>
                    <dl>
                        <dd>
                            <ol>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_down_paymentshealthyshop" id="item_down_paymentshealthyshop" onclick="openItem('down_payments,healthyshop,healthyshop');">分类管理</a>
                                </li>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_brandhealthyshop" id="item_brandhealthyshop" onclick="openItem('brand,healthyshop,healthyshop');">店铺管理</a>
                                </li>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_giftshealthyshop" id="item_giftshealthyshop" onclick="openItem('gifts,healthyshop,healthyshop');">入驻商申请列表</a>
                                </li>
                               <!--  <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_vipshealthyshop" id="item_vipshealthyshop" onclick="openItem('vips,healthyshop,healthyshop');">vip管理</a>
                                </li>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_xibihealthyshop" id="item_xibihealthyshop" onclick="openItem('xibi,healthyshop,healthyshop');">戏币充值管理</a>
                                </li>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_needshealthyshop" id="item_needshealthyshop" onclick="openItem('needs,healthyshop,healthyshop');">下载需戏币数</a>
                                </li> <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_tousuhealthyshop" id="item_tousuhealthyshop" onclick="openItem('tousu,healthyshop,healthyshop');">投诉理由示例</a>
                                </li> -->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_indexorder" id="item_indexorder"-->
                                       <!--onclick="openItem('index,order,healthyshop');">dd</a></li>-->
                                <!-- <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_pinglunorder" id="item_pinglunorder" onclick="openItem('pinglun,order,healthyshop');">评论列表</a>
                                </li> -->
                            </ol>
                        </dd>
                    </dl>
                </li>
            </ul>
            <ul id="sort_news" style="display: block;">
                <li>
                    <dl>
                        <dd>
                            <ol>

                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_brandnews" id="item_brandnews" onclick="openItem('brand,news,news');">上传分类</a>
                                </li>

                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_blackaccountnews" id="item_blackaccountnews" onclick="openItem('blackaccount,news,news');">伴奏管理</a>
                                </li>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_qupunews" id="item_qupunews" onclick="openItem('qupu,news,news');">曲谱管理</a>
                                </li>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_yinpinnews" id="item_yinpinnews" onclick="openItem('yinpin,news,news');">音频管理</a>
                                </li>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_shipinnews" id="item_shipinnews" onclick="openItem('shipin,news,news');">视频管理</a>
                                </li>

                            </ol>
                        </dd>
                    </dl>
                </li>
            </ul>
            <ul id="sort_ade" style="display: block;">
                <li>
                    <dl>
                        <dd>
                            <ol>
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_blackaccountade" id="item_blackaccountade"
                                                  onclick="openItem('blackaccount,ade,ade');">广告位管理</a></li>
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_tankuangade" id="item_tankuangade"-->
                                       <!--onclick="openItem('tankuang,ade,ade');">翡翠爱人弹窗广告位</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_lianrenade" id="item_lianrenade"-->
                                       <!--onclick="openItem('lianren,ade,ade');">翡翠恋人弹窗广告位</a></li>-->
                            </ol>
                        </dd>
                    </dl>
                </li>
            </ul>

            <ul id="sort_order" style="display: block;">
                <li>
                    <dl>
                        <dd>
                            <ol>
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_zijinorder" id="item_zijinorder"-->
                                       <!--onclick="openItem('zijin,order,order');">用户资金明细记录</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_indexorder" id="item_indexorder"-->
                                                  <!--onclick="openItem('index,order,order');">健康商城产品销售记录</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_chongzhiorder" id="item_chongzhiorder"-->
                                       <!--onclick="openItem('chongzhi,order,order');">碳积分充值记录</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_transferorder" id="item_transferorder"-->
                                       <!--onclick="openItem('transfer,order,order');">碳积分流通记录</a></li>-->

                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_proportionorder" id="item_proportionorder"-->
                                                  <!--onclick="openItem('proportion,order,order');">佣金提现手续费</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_accountsorder" id="item_accountsorder"-->
                                                  <!--onclick="openItem('accounts,order,order');">碳积分提现手续费</a></li>-->
                                <li nc_type="">
                                    <a href="JavaScript:void(0);" name="item_tixianorder" id="item_tixianorder"
                                                  onclick="openItem('tixian,order,order');">提现处理记录</a></li>
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_feicuibiorder" id="item_feicuibiorder"-->
                                                  <!--onclick="openItem('feicuibi,order,order');">碳积分提现记录</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_jintiehealthyshop" id="item_jintiehealthyshop" onclick="openItem('jintie,healthyshop,order');">管理津贴</a>-->
                                <!--</li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_indexcar" id="item_indexcar"-->
                                       <!--onclick="openItem('index,car,order');">预约租车</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_index1car" id="item_index1car"-->
                                       <!--onclick="openItem('index1,car,order');">临时用车</a></li>-->
                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_seecarcar" id="item_seecarcar"-->
                                       <!--onclick="openItem('seecar,car,order');">预约看车</a></li>-->

                            </ol>
                        </dd>
                    </dl>
                </li>
            </ul>
            <!--<ul id="sort_order1" style="display: block;">-->
                <!--<li>-->
                    <!--<dl>-->
                        <!--<dd>-->
                            <!--<ol>-->


                                <!--<li nc_type="">-->
                                    <!--<a href="JavaScript:void(0);" name="item_feicuibiorder" id="item_feicuibiorder"-->
                                       <!--onclick="openItem('feicuibi,order,order1');">碳积分提现记录</a></li>-->

                            <!--</ol>-->
                        <!--</dd>-->
                    <!--</dl>-->
                <!--</li>-->
            <!--</ul>-->









        </div>
    </td>
    <td valign="top" width="100%">
        <iframe src="#" id="workspace" name="workspace" style="overflow: visible;" frameborder="0" width="100%"
                height="100%" scrolling="yes" onload="window.parent">
        </iframe>
    </td>
</tr>
</tbody>
</table>
</body>
</html>