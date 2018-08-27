<?php
namespace Admin\Controller;
use Think\Controller;

class OrderController extends Controller {
//更新订单状态
    public function order_style(){
        $id = $_POST['id'];

        $Order =M('rechargerecord');
        $list = $Order->where(array('id'=>$id))->save($_POST);
        if($list){
            $reg['info']="修改成功";
            $reg['status']=200;
        }else{
            $reg['status']=300;
            $reg['info']="系统繁忙请重试";
        }
        $this->ajaxReturn($reg);
    }

    public function hou_chongzhi(){
        $user_mobile = I('user_mobile','');
        $user_id = I('userid','');
        $accounts = I('user_num','');
        $chong_jian = I('chong_jian','');
        if($accounts<=0){
            $this->redirect('chongzhi', array(), 1, '充值数量有误...');
        }
        $map['mobile'] = $user_mobile;
        $map['user_id'] = $user_id;
        $user=M("user");
        $account=M("accounts");
        $user_id=$user->where($map)->getField("user_id");
        if(!empty($user_id)){
            $if_have=$account->where(array('user_id'=>$user_id))->find();
            if(!empty($if_have)){
                if($chong_jian==1){
                    $arr=$account->where(array('id'=>$if_have['id']))->setInc("accounts",-$accounts);
                }else{
                    $arr=$account->where(array('id'=>$if_have['id']))->setInc("accounts",$accounts);
                }

            }else{
                $arr=$account->add(array('user_id'=>$user_id,'accounts'=>$accounts,'addtime'=>time()));
            }
            $rechargerecord=M("rechargerecord");
            if(!empty($arr)){
                $add['user_id']=$user_id;
                $add['order_price']=$accounts;
                $add['order_no']='FC'.time();
                if($chong_jian==1){
                    $add['order_title']='后台扣除碳积分';
                }else{
                    $add['order_title']='后台充值碳积分';
                }

                $add['type_id']=3;
                $add['status']="03";
                $add['type']=7;//后台充值
                $add['add_time']=time();
                $rechargerecord->add($add);

                $type=4;//后台充值碳积分
                if($chong_jian==1){
                    $content='后台扣除碳积分';
                }else{
                    $content="后台充值碳积分成功";
                }


                $table="accounts";
                $tables_id=$add;
                caiwu_log($type,$content,$table,$tables_id);
                $this->redirect('chongzhi', array(), 1, '充值成功...');
            }else{
                $type=5;//后台充值碳积分
//                $content="后台充值碳积分失败";
                if($chong_jian==1){
                    $content='后台扣除碳积分失败';
                }else{
                    $content="后台充值碳积分失败";
                }

                $table="accounts";
                $tables_id=0;
                caiwu_log($type,$content,$table,$tables_id);
                $this->redirect('chongzhi', array(), 1, '充值失败，请稍后...');
            }

        }else{
            $this->redirect('chongzhi', array(), 1, '用户不存在或用户ID和手机号不匹配，请重新输入...');
        }
    }
    //更新订单退货状态
    public function tuihuo(){
        $id = $_POST['id'];

        $Order =M('rechargerecord');
        $orderinfo=$Order->where(array('id'=>$id))->field("user_id,order_price,order_no,tuihuo")->find();
        if($orderinfo['tuihuo']==4){
            $reg['status']=300;
            $reg['info']="退款申请已处理完成";
        }else{
            if($_POST['tuihuo']==3){
                $_POST['status']='07';//退货处理中
            }elseif($_POST['tuihuo']==4){
                $add['user_id']=$orderinfo['user_id'];
                $add['order_price']=$orderinfo['order_price'];
                $add['order_no']='FC'.time();
                $add['order_title']=$orderinfo['order_no'];//退款的订单号
                $add['type_id']=3;
                $add['status']="03";
                $add['type']=6;//退货转换成碳积分
                $add['add_time']=time();
                $Order->add($add);
                $account=M("accounts");
                $if_have=$account->where(array('user_id'=>$orderinfo['user_id']))->find();
                if(!empty($if_have)){
                    $account->where(array('id'=>$if_have['id']))->setInc("accounts",$orderinfo['order_price']);
                }else{
                    $account->add(array('user_id'=>$orderinfo['user_id'],'accounts'=>$orderinfo['order_price'],'addtime'=>time()));
                }
//退款成功之后，查找该订单生成的佣金订单
                $Order->where(array('type'=>5,'logistics_sheet'=>$orderinfo['order_no']))->save(array('status'=>'07','tuihuo'=>4));
                $funddetails =M('funddetails');
                $dddd=$funddetails->where(array('status'=>2,'order_no'=>$orderinfo['order_no']))->select();
                foreach ($dddd as $vv){
                    $ffff=$funddetails->where(array('status'=>2,'user_id'=>$vv['user_id'],'order_no'=>$vv['order_no']))->find();//说明被退款了
                    $funddetails->where(array('status'=>2,'user_id'=>$vv['user_id'],'order_no'=>$vv['order_no']))->save(array('status'=>3));//说明被退款了
                    $account->where(array('user_id'=>$vv['user_id']))->setInc("accounts",-$ffff['income']);

                }

            }
            $_POST['tuihuo_time']=time();
            $list = $Order->where(array('id'=>$id))->save($_POST);
            if($list){
                $reg['info']="修改成功";
                $reg['status']=200;
            }else{
                $reg['status']=300;
                $reg['info']="系统繁忙请重试";
            }
        }

        $this->ajaxReturn($reg);
    }
    //订单管理
    public function chongzhi(){

        $p = I('get.p',1);
        if(!empty($type)){
            $map['type'] = $type;
            $this->assign('type', $type);
        }
        $map['type_id'] = 3;
        $order_no = I('order_no','');
        if(!empty($order_no)){
            $map['order_no'] = $order_no;
        }
        $user_id = I('user_id','');
        if(!empty($user_id)){
            $map['user_id'] = $user_id;
            $this->assign("user_id",$user_id);
        }
        $user =M('user');
        $addtime = I('addtime','');
        if(!empty($addtime)){
            $ddds=explode(" - ",$addtime);
            $ddds[0]=  strtotime($ddds[0]);
            $ddds[1]=  strtotime($ddds[1]);
            $map['add_time']=array('between',("$ddds[0],$ddds[1]"));
            $this->assign("addtime",$addtime);
        }

        $truename = I('truename','');
        if(!empty($truename)){
            $user_id=$user->where(array('truename'=>$truename))->field("user_id")->select();
            $rr="";
            foreach ($user_id as &$v){
                $rr.=$v['user_id'].",";
            }
            if(!empty($user_id)){
                $map['user_id']=array('in',$rr);
                $this->assign("truename",$truename);
            }
        }
        $mobile = I('mobile','');
        if(!empty($mobile)){
            $user_id=$user->where(array('mobile'=>$mobile))->getField("user_id");

            if(!empty($user_id)){
                $map['user_id']=$user_id;
                $this->assign("mobile",$mobile);
            }
        }
        $rechargerecord=M("rechargerecord");

        $order_info=$rechargerecord->where($map)->field("id,order_price,type,content,order_title,add_time,order_no,type_id,user_id,addr_id,status")->order("id desc")->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();
        $zongjie=$rechargerecord->where(array('status'=>03))->sum("order_price");
//            $zongjie=0;
//        foreach ($order_info as &$v){
//            if($v['status']=='03'){
//                $zongjie+=$v['order_price'];
//            }
//
//        }

        $mapcount = $rechargerecord->where($map)->count();
        $show = getpages2($mapcount);


        $this->assign('pages', $show);//分页
        $this->assign('list', $order_info);
        $this->assign('zongjie', $zongjie);

        $this->display();
    }
    public function transfer(){
        $p = I('get.p',1);
//        $user_id = I('user_id','');
        $status = I('status','');
        $expenditure_id = I('expenditure_id','');
        $expend_id = I('expend_id','');
        $truename_id = I('truename_id','');
        $expenditure_mobile = I('expenditure_mobile','');
        $incom_mobile = I('incom_mobile','');
        $truename = I('truename','');
        $Order =M('transfer');
        $user =M('user');
        if(!empty($status)){
            $where['status']=$status;
            $this->assign("status",$status);
        }

        if(!empty($expend_id)){
            $where['expenditure_id']=$expend_id;
            $this->assign("expend_id",$expend_id);
        }
        if(!empty($truename_id)){
            $where['income_id']=$truename_id;
            $this->assign("truename_id",$truename_id);
        }
        if(!empty($expenditure_id)){
            $user_id=$user->where(array('truename'=>$expenditure_id))->field("user_id")->select();
            $rr="";
            foreach ($user_id as &$v){
                $rr.=$v['user_id'].",";
            }
            if(!empty($user_id)){
                $where['expenditure_id']=array('in',$rr);
                $this->assign("expenditure_id",$expenditure_id);
            }
        }  if(!empty($expenditure_mobile)){
            $user_id=$user->where(array('mobile'=>$expenditure_mobile))->field("user_id")->select();
            $rr="";
            foreach ($user_id as &$v){
                $rr.=$v['user_id'].",";
            }
            if(!empty($user_id)){
                $where['expenditure_id']=array('in',$rr);
                $this->assign("expenditure_mobile",$expenditure_mobile);
            }
        }
        if(!empty($incom_mobile)){
            $user_id=$user->where(array('mobile'=>$incom_mobile))->field("user_id")->select();
            $rr="";
            foreach ($user_id as &$v){
                $rr.=$v['user_id'].",";
            }
            if(!empty($user_id)){
                $where['income_id']=array('in',$rr);
                $this->assign("incom_mobile",$incom_mobile);
            }
        }
        if(!empty($truename)){
            $user_id1=$user->where(array('truename'=>$truename))->field("user_id")->select();
            $rrr="";
            foreach ($user_id1 as &$vv){
                $rrr.=$vv['user_id'].",";
            }
            if(!empty($user_id1)){
                $where['income_id']=array('in',$rrr);
                $this->assign("truename",$truename);
            }
        }
        $addtime = I('addtime','');
        if(!empty($addtime)){
            $ddds=explode(" - ",$addtime);
            $ddds[0]=  strtotime($ddds[0]);
            $ddds[1]=  strtotime($ddds[1]);
            $where['addtime']=array('between',("$ddds[0],$ddds[1]"));
            $this->assign("addtime",$addtime);
        }

        $list = $Order->where($where)->order('addtime desc')->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();
//        $list = $Order->where($where)->order('addtime desc')->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();
        $zongjie=$Order->where(array('status'=>2))->sum("accounts");
//        $zongjie=0;
//        foreach ($list as &$v){
//            if($v['status']==2){
//                $zongjie+=$v['accounts'];
//            }
//
//        }
        $mapcount = $Order->where($where)->count();
        $show = getpages2($mapcount);


        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->assign('zongjie', $zongjie);

        $this->display();
    }
    //银联支付
    public function yinlian(){

        if($_POST){
            // 商户ID，由纯数字组成的字符串
            $merchant_id = "100000001303075";


            //交易安全检验码，由数字和字母组成的64位字符串
            $key = "g0be2385657fa355af68b74e9913a1320af82gb7ae5f580g79bffd04a402ba8f";

            //签约融宝支付账号或卖家收款融宝支付帐户
            $seller_email = "feicuijituan@163.com";

            $version = "3.1.3";
            //通知地址，由商户提供
            $notify_url = "http://".$_SERVER['HTTP_HOST']."/index.php/Api/Index/notify";
            //返回地址，由商户提供
            $return_url="http://".$_SERVER['HTTP_HOST']."/index.php/Api/Index/returns";
//            $return_url = "http://localhost/h5-php-LITEPAY/return.php";
            //商户私钥
            $merchantPrivateKey = "cert/itrus001_pri.pem";
            //融宝公钥
            $pubKeyUrl = "cert/itrus001.pem";

            //↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑


            $rongpay_api = "http://testapi.reapal.com";

            $charset = "utf-8";// 字符编码格式 目前支持  utf-8

            $sign_type = "MD5";// 签名方式 不需修改

            $transport = "http";//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http


            $order_no = date('YmdHis');
            $total_fee = floatval($_REQUEST['total_fee']) * 100;

            $parameter = array(
                'seller_email' => $seller_email,
                'merchant_id' => $merchant_id,
                'notify_url' => $notify_url,
                'return_url' => $return_url,
                'transtime' => '2015-10-16 14:05:00',
                'currency' => '156',
                'member_id' => date('YmdHis'),
                'member_ip' => '192.168.1.1',
                'terminal_type' => 'mobile',
                'terminal_info' => 'terminal_info',
                'sign_type' => $sign_type,
                "order_no" => $order_no,
                "total_fee" => $total_fee,
                "title" => $_REQUEST['title'],
                "body" => $_REQUEST['body'],
                "default_bank" => 'LITEPAY'
            );


            ////构造函数，生成请求URL
            $sHtmlText = \rongpayService::buildForm($parameter, $pubKeyUrl, $key);
        }else{
            $this->display();
        }


    }
//订单管理
    public function index(){
        //获取省市区
//        $province=M("province")->where(array('level'=>1))->select();
//        $this->assign("provinces",$province);
        $p = I('get.p',1);
        if(!empty($type)){
            $map['type'] = $type;
            $this->assign('type', $type);
        }
        $addr=M("addr");
        //省
        $province = I('province','');
        if(!empty($province)){

            $airen=$addr->where(array('province'=>$province))->field("id")->select();
            $aaa="";
            foreach ($airen as &$b){
                $aaa=$aaa.",".$b['id'];
            }

            $map['addr_id']=array('in',$aaa);
            $this->assign('province', $province);
        } //市
        $city = I('city','');
        if(!empty($city)){
            $airenb=$addr->where(array('city'=>$city))->field("id")->select();
            $aaab="";
            foreach ($airenb as &$bc){
                $aaab=$aaab.",".$bc['id'];
            }

            $map['addr_id']=array('in',$aaab);
            $this->assign('city', $city);
        } //区
        $area = I('area','');
        if(!empty($area)){
            $airenbc=$addr->where(array('area'=>$area))->field("id")->select();
            $aaabc="";
            foreach ($airenbc as &$bcc){
                $aaabc=$aaabc.",".$bcc['id'];
            }

            $map['addr_id']=array('in',$aaabc);
//            $map['area'] = $area;
            $this->assign('area', $area);
        }
        $map['type_id'] = 0;
        $order_no = I('order_no','');
        if(!empty($order_no)){
            $map['order_no'] = $order_no;
        }


        $user_id = I('user_id','');
        if(!empty($user_id)){
            $map['user_id'] = $user_id;
            $this->assign("user_id",$user_id);
        }
        $addtime = I('addtime','');
        if(!empty($addtime)){
            $ddds=explode(" - ",$addtime);
            $ddds[0]=  strtotime($ddds[0]);
            $ddds[1]=  strtotime($ddds[1]);
            $map['add_time']=array('between',("$ddds[0],$ddds[1]"));
            $this->assign("addtime",$addtime);
        }

        $tuihuo = I('tuihuo','');
        if(!empty($tuihuo)){
//            $map['status'] = "07";
            $map['tuihuo']=array('in',("2,3,4"));
            $this->assign("tuihuo",$tuihuo);
        }else{
            $status = I('status','03');
            if(!empty($status)){
                $map['status'] = $status;
                $this->assign("status",$status);
            }
        }

        $user =M('user');
        $healthyshop =M('healthyshop');

        $truename = I('truename','');
        if(!empty($truename)){
            $user_id=$user->where(array('truename'=>$truename))->field("user_id")->select();
            $rr="";
            foreach ($user_id as &$v){
                $rr.=$v['user_id'].",";
            }
            if(!empty($user_id)){
                $map['user_id']=array('in',$rr);
                $this->assign("truename",$truename);
            }
        }
        $pro_id = I('pro_id','');
        if(!empty($pro_id)){
            $fff['pro_name']=array('like',"%".$pro_id."%");
            $user_ids=$healthyshop->where($fff)->field("id")->select();
            $aa="";
            foreach ($user_ids as &$g){
                $aa.=$g['id'].",";
            }

                $map['product_id']=array('in',$aa);
                $this->assign("pro_id",$pro_id);

        }
        $product_id = I('product_id','');
        if(!empty($product_id)){
            $map['product_id'] = $product_id;
        }
        $mobile = I('mobile','');
        if(!empty($mobile)){
            $user_id=$user->where(array('mobile'=>$mobile))->getField("user_id");

            if(!empty($user_id)){
                $map['user_id']=$user_id;
                $this->assign("mobile",$mobile);
            }
        }

        $addr=M("addr");
        $kuaid=M("kuaidi");
        $kuaidi=$kuaid->where(array('type'=>1))->select();

        $rechargerecord=M("rechargerecord");
            $order_info=$rechargerecord->where($map)->field("id,order_price,product_id,num,content,order_title,add_time,order_no,type_id,user_id,status,logistics_sheet,logistics,tuihuo,type")->order("add_time desc")->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();
$zongjie=0;
$uuu['status']=array('in',('03,04,05,06'));
        $zongjie=$rechargerecord->where($uuu)->sum("order_price");

        foreach ($order_info as &$v){
            $v['user_info']=$user->where(array('user_id'=>$v['user_id']))->field("mobile,truename,province,city,area")->find();
            $v['addr_info']=$addr->where(array('user_id'=>$v['user_id']))->field("consignee,province,city,area,mobile,addr")->find();
//           if($v['status']=='03' || $v['status']=='04' ||$v['status']=='05' || $v['status']=='06'){
//               $zongjie+=$v['order_price'];
//           }

        }


        $mapcount = $rechargerecord->where($map)->count();
        $show = getpages2($mapcount);


        $this->assign('kuaidi', $kuaidi);//分页
        $this->assign('pages', $show);//分页
        $this->assign('list', $order_info);
        $this->assign('zongjie', $zongjie);

        $this->display();
    }
    public function pinglun(){

        $p = I('get.p',1);

        $comment =M('comment');
        $product_id = $_GET['product_id'];
        if(!empty($product_id)){
            $map['worker_id'] = $product_id;
            $this->assign("pro",$product_id);
        } $news_title = $_GET['news_title'];
        if(!empty($product_id)){
            $map['content'] = array('like','%'.$news_title.'%');
        }
        $map['types'] = 1;
        $order_info=$comment->where($map)->order("addtime desc")->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();

        $mapcount = $comment->where($map)->count();
        $show = getpages2($mapcount);


        $this->assign('pages', $show);//分页
        $this->assign('list', $order_info);

        $this->display();
    }
    public function del_pinglun($id)
    {

        $News = M('comment');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('pinglun', array('product_id'=>$_GET['proid']), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('pinglun', array('product_id'=>$_GET['proid']), 1, '系统繁忙请重试...');
        }

    }
//佣金详情
    public function yongjinxq(){
        $p = I('get.p',1);
        $Order =M('give_gifts');

        if($_GET['order_no']){
            $where['order_no']=$_GET['order_no'];
        }
        if($_GET['benefit_id']){
            $where['benefit_id']=$_GET['benefit_id'];//受益人
        }
//        $where['user_id']="dT9uk";
        $list = $Order->where($where)->order('addtime desc')->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();
//
        // var_dump($list);
        $mapcount = $Order->where($where)->count();
        $show = getpages2($mapcount);


        $this->assign('pages', $show);//分页
        $this->assign('list', $list);

        $this->display();
    }


  //税点百分比
    public function proportion(){
        $Notice =M('proportion');
        if($_POST){
//            $_POST['addtime']=time();
            $Notice->where(array('id'=>1))->save($_POST);
            $this->redirect('proportion',array(),1,'保存成功,正在重新加载...');
        }else {
            $arr = $Notice->where(array('id' => 1))->find();
            $this->assign('news', $arr);
            $this->display();
        }
    }
    public function accounts(){
        $Notice =M('proportion');
        if($_POST){
//            $_POST['addtime']=time();
            $Notice->where(array('id'=>2))->save($_POST);
            $type=7;//修改碳积分提现手续费
            $content="修改碳积分提现手续费";
            $table="proportion";
            $tables_id=2;
            caiwu_log($type,$content,$table,$tables_id);
            $this->redirect('accounts',array(),1,'保存成功,正在重新加载...');
        }else {
            $arr = $Notice->where(array('id' =>2))->find();
            $this->assign('news', $arr);
            $this->display();
        }
    }

   //提现申请
    public function withdrawals(){
        $withdrawals=M("withdrawals");
        $p = I('get.p',1);
        $order_info=$withdrawals->field("id,order_price,product_id,num,content,order_title,add_time,order_no,type_id,user_id,status")->order("add_time desc")->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();


        $mapcount = $withdrawals->count();
        $show = getpages2($mapcount);


        $this->assign('pages', $show);//分页
        $this->assign('list', $order_info);
        $this->display();
    }


    public function xiaofei1(){
//        $user_id = I('get.user_id',1);
$user=M("user");
$arr=$user->where(array('level'=>5))->field("user_id,level")->select();
//        ignore_user_abort();//关掉浏览器，PHP脚本也可以继续执行.
//        set_time_limit(0);// 通过set_time_limit(0)可以让程序无限制的执行下去
//        $interval=60*60*24;// 每隔半小时运行
//        $interval=30;// 每隔半小时运行
        $teams=M("teams");
foreach ($arr as &$v) {
//昨天的消费总额
    $his_money = $teams->where(array('user_id' => $v['user_id']))->order('addtime desc')->getField("his_money");
    if (empty($his_money)) {
        $his_money = 0;
    }
    //历史总额
    $date['user_id'] = $v['user_id'];
    $date['addtime'] = time();
    $date['his_money'] = team_hesuan($v['user_id']);
    $date['tod_money'] = $date['his_money'] - $his_money;
    if ($his_money < 1000000) {
        $date['earn'] = 0;
        $date['bili'] = 0;
    } elseif ($his_money >= 1000000 && $his_money < 10000000) {
        $date['earn'] = $date['tod_money'] * 0.1;
        $date['bili'] = 0.1;
    } elseif ($his_money >= 10000000 && $his_money < 50000000) {
        $date['earn'] = $date['tod_money'] * 0.03;
        $date['bili'] = 0.03;
    } elseif ($his_money >= 50000000) {
        $date['earn'] = $date['tod_money'] * 0.01;
        $date['bili'] =0.01;
    }
}
$teams->add($date);
$this->redirect("Admin/Healthyshop/jintie");

}
    public function dele_edit($id,$user_id)
    {

        $News = M('teams');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('xiaofei', array('user_id'=>$user_id), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('xiaofei', array('user_id'=>$user_id), 1, '系统繁忙请重试...');
        }

    }
    public function dele_edit1($id)
    {

        $News = M('rechargerecord');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('index', array(), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('index', array(), 1, '系统繁忙请重试...');
        }

    }
    public function xiaofei(){
        $user_id = I('get.user_id',1);

        $teams=M("teams");

    $his_money=$teams->where(array('user_id'=>$user_id))->order('addtime desc')->select();
   $this->assign("his_money",$his_money);
$this->display();
    }



    public function quota(){
        $id = $_POST['id'];

        $Order =M('user');
        $list = $Order->where(array('id'=>$id))->setField("quota",$_POST['quota']);
        if($list){
           $reg['info']="修改成功";
           $reg['status']=200;

        }else{
            $reg['status']=300;
            $reg['info']="请输入新的额度值";
        }
        $this->ajaxReturn($reg);
    }



    public function quota_style(){
        $id = $_POST['id'];

        $Order =M('user');
        $list = $Order->where(array('id'=>$id))->setField("quota_style",$_POST['quota_style']);
        if($list){
           $reg['info']="修改成功";
           $reg['status']=200;

        }else{
            $reg['status']=300;
            $reg['info']="系统繁忙请重试";
        }
        $this->ajaxReturn($reg);
    }

    public function quota_order(){
        $p = I('get.p',1);
        $Order =M('user');
        $is_vip = I('is_vip','');
        $interest_freeloan = I('interest_freeloan','');
        if(!empty($is_vip)){
                $map['is_vip'] = $is_vip;
            $this->assign('is_vip', $is_vip);
        }
        if(!empty($interest_freeloan)){
                $map['interest_freeloan'] = $interest_freeloan;
            $this->assign('interest_freeloan', $interest_freeloan);
        }
        //会员电话
        $mobile = I('mobile','');
        if(!empty($mobile)){
            $map['mobile'] = $mobile;
            $this->assign('mobile', $mobile);
        }
        //会员姓名
        $truename = I('truename','');
        if(!empty($truename)){
            $map['truename'] = $truename;
            $this->assign('truename', $truename);
        }

        $list = $Order->where($map)->order('addtime desc')->where("is_vip != 0 ")->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();
        $mapcount = $Order->where($map)->count();
        $show = getpages2($mapcount);


        $this->assign('pages', $show);//分页
        $this->assign('list', $list);

        $this->display();
    }

    public function tixian(){
        $p = I('get.p',1);
        $Order =M('withdrawals');
        /**
         * 处理查询条件
         *
         */
        //支付状态
        $stady = I('status','');

        if(!empty($stady)){

                $map['status'] = $stady;


            $this->assign('status', $stady);
        }
        $map['type'] = 1;
        //会员电话
        $mobile = I('mobile','');
        if(!empty($mobile)){
            $map['mobile'] = $mobile;
            $this->assign('mobile', $mobile);
        }
        //会员姓名
        $truename = I('truename','');
        if(!empty($truename)){
            $map['truename'] = $truename;
            $this->assign('truename', $truename);
        }
        //佣金提现比例
//        $proportion=M("proportion");
//        $present_account=M("present_account");
//        $propor=$proportion->where("id=1")->getField("proportion");
//        $propor1=$propor*0.01;
        $list = $Order->where($map)->order('addtime desc')->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();
        $zongjie=$Order->where(array('status'=>2))->sum("jine1");
//        $zongjie=0;
        foreach ($list as &$v){
//            $account=$present_account->where(array('id'=>$v['account_id']))->find();
//            $v['balance1']=$v['jine']-$v['jine']*$propor1;
//            $v['card_number']=$account['card_number'];
//            $v['card_type']=$account['card_type'];
//            if($v['status']==2){
//                $zongjie+=$v['jine1'];
//            }
        }
        $mapcount = $Order->where($map)->count();
        $show = getpages2($mapcount);

        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
//        $this->assign('propor', $propor);
        $this->assign('zongjie', $zongjie);

        $this->display();
    }
    //资金冻结
    public function zijindongjie(){
        $id=$_POST['id'];
        $accounts=M("accounts");
        $notice=M("notice");
        $iiii=$notice->where(array('id'=>18))->getField("news_title");
      if($iiii==$_POST['pwd18']){
          $list = $accounts->where(array('id'=>$id))->getField("is_dongjie");
          if($list==1){
              $ddd=2;//=""
              $type=1;
              $content="冻结账户";
          }else{
              $ddd=1;
              $type=2;
              $content="解冻账户";
          }
          $table="accounts";
          $tables_id=$id;
          $list = $accounts->where(array('id'=>$id))->setField("is_dongjie",$ddd);
          caiwu_log($type,$content,$table,$tables_id);
          if($list){

              $this->ajaxReturn(array('status'=>200,'info'=>'修改成功'));
              $this->redirect('zijin',array(),1,'成功，返回列表...');

          }else{
              $this->ajaxReturn(array('status'=>300,'info'=>'修改失败'));
              $this->redirect('zijin',array(),1,'系统繁忙请重试...');
//            $reg['info']="系统繁忙请重试";
          }
      }else{
          $this->ajaxReturn(array('status'=>300,'info'=>'冻结/解冻用户资金密码错误'));
          $this->redirect('zijin',array(),1,'冻结/解冻用户资金密码错误...');
      }

    }



    public function feicuibi(){
        $p = I('get.p',1);
        $Order =M('withdrawals');
        /**
         * 处理查询条件
         *
         */
        //支付状态
        $stady = I('status','');
        $user =M('user');
        if(!empty($stady)){
            if($stady==1){
                $map['status'] = array('in',('1,4'));
            }elseif($stady==5){

            }else{
                $map['status'] = $stady;
            }
        }else{
            $map['status'] = array('in',('1,4'));
            $stady=1;
        }
        $this->assign('status', $stady);
        $area = I('user_id','');
        if(!empty($area)){
            $map['user_id'] = $area;
            $this->assign('user_id', $area);
        }
        $present_account=M("present_account");
        $truename = I('mobile','');
        if(!empty($truename)){
            $user_id1=$user->where(array('mobile'=>$truename))->field("user_id")->find();

//            if(!empty($user_id1)){
                $map['user_id']=$user_id1['user_id'];
                $this->assign("mobile",$truename);
//            }
        }
        $kai = I('account_id','');
        if(!empty($kai)){
            $user_id12=$present_account->where(array('card_number'=>$kai))->field("user_id")->find();
                $map['user_id']=$user_id12['user_id'];
                $this->assign("account_id",$kai);

        }
        $map['type'] = 2;
        $addtime = I('addtime','');
        if(!empty($addtime)){
            $ddds=explode(" - ",$addtime);
            $ddds[0]=  strtotime($ddds[0]);
            $ddds[1]=  strtotime($ddds[1]);
            $map['addtime']=array('between',("$ddds[0],$ddds[1]"));
//            $map['addtime']=array('egt',$ddds[0]);
//            $map['addtime']=array('elt',$ddds[1]);
//            $map['_logic']=array('AND');


//
            $this->assign("addtime",$addtime);
        }




//        if(!empty($addtime)){
//            if($addtime==1){
////当天    1525190400
//                $times = strtotime(date('Y-m-d', time()));
//            }elseif ($addtime==2){
////本周    1525017600
//                $times = mktime(0,0,0,date('m'),date('d')-date('w')+1,date('Y'));
//            }elseif ($addtime==3){
////本月    1525104000
//                $times = mktime(0,0,0,date('m'),1,date('Y'));
//            }elseif ($addtime==4){
////本季度
//                $season = ceil(date('n') /3);
//                $times=mktime(0,0,0,($season - 1) *3 +1,1,date('Y'));
//            }elseif ($addtime==5){
////半年内   1509618187
//                $times= strtotime('-6 month');
//            }elseif ($addtime==6){
//                //本年内   1514736000
//                $times= strtotime(date("Y",time())."-1"."-1");
//            }
//

//
//        }
        //会员姓名
        $truename = I('truename','');
        if(!empty($truename)){
            $user_id1=$user->where(array('truename'=>$truename))->field("user_id")->select();
            $rrr="";
            foreach ($user_id1 as &$vv){
                $rrr.=$vv['user_id'].",";
            }
            if(!empty($user_id1)){
                $map['user_id']=array('in',$rrr);
                $this->assign("truename",$truename);
            }
        }
        //佣金提现比例
        $proportion=M("proportion");
        $present_account=M("present_account");
        $propor=$proportion->where("id=2")->getField("proportion");
        $propor1=$propor*0.01;
        $list = $Order->where($map)->order('addtime desc')->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();
        $zongjie=$Order->where(array('status'=>2))->sum("jine1");
//        $zongjie=0;
        foreach ($list as &$v){
            $account=$present_account->where(array('id'=>$v['account_id']))->find();
            $v['balance1']=$v['jine']-$v['jine']*$propor1;
            $v['card_number']=$account['card_number'];
            $v['card_type']=$account['card_type'];
//            if($v['status']==2){
//                $zongjie+=$v['jine1'];
//            }
        }



        $mapcount = $Order->where($map)->count();
        $show = getpages2($mapcount);

        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->assign('propor', $propor);
        $this->assign('zongjie', $zongjie);

        $this->display();
    }



    public function zijin(){
        $p = I('get.p',1);
        $Order =M('accounts');
        $user =M('user');
        $where=array();
        $truename = I('truename','');
        if(!empty($truename)){
            $user_id=$user->where(array('truename'=>$truename))->field("user_id")->select();
            $rr="";
            foreach ($user_id as &$v){
                $rr.=$v['user_id'].",";
            }
            if(!empty($user_id)){
                $where['user_id']=array('in',$rr);
                $this->assign("truename",$truename);
            }
        }
        $mobile = I('mobile','');
        if(!empty($mobile)){
            $user_id=$user->where(array('mobile'=>$mobile))->getField("user_id");

            if(!empty($user_id)){
                $where['user_id']=$user_id;
                $this->assign("mobile",$mobile);
            }
        }
        $addtime = I('addtime','');
        if(!empty($addtime)){
            $ddds=explode(" - ",$addtime);
            $ddds[0]=  strtotime($ddds[0]);
            $ddds[1]=  strtotime($ddds[1]);
            $where['addtime']=array('between',("$ddds[0],$ddds[1]"));
            $this->assign("addtime",$addtime);
        }


        $list = $Order->where($where)->order('addtime desc')->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();

        $mapcount = $Order->where($where)->count();
        $show = getpages2($mapcount);


        $this->assign('pages', $show);//分页
        $this->assign('list', $list);

        $this->display();
    }
//打款
    public function dakuan(){
        $id = I('id','');
        $Order =M('withdrawals');
        //支付状态
        $user=M("user");

            $list = $Order->where(array('id'=>$id))->field("user_id,status,xibi")->find();//提现申请表
            if($list['status']==2){
                $this->ajaxReturn(array('status'=>200,'info'=>'已完成打款，不可重复操作'));
            }elseif($list['status']==1){

                $commission=$user->where(array('user_id'=>$list['user_id']))->field("xibi,dongjiexibi")->find();
//                $dfd=$commission['xibi']-$commission['dongjiexibi'];
                if($commission['xibi']>=$list['xibi']){
                    $data['status']=2;
                    $data['endtime']=time();
                    $arr=$Order->where(array('id'=>$id))->save($data);
                    if($arr){
                        $user->where(array('user_id'=>$list['user_id']))->setInc("dongjiexibi",-$list['xibi']);
                        $user->where(array('user_id'=>$list['user_id']))->setInc("xibi",-$list['xibi']);
                        $this->ajaxReturn(array('status'=>200,'info'=>'完成打款'));
                    }else{
                        $this->ajaxReturn(array('status'=>300,'info'=>'系统繁忙，请重试'));
                    }
                }else{
                    $this->ajaxReturn(array('status'=>300,'info'=>'戏币余额不足'));
                }
            }else{
                $this->ajaxReturn(array('status'=>300,'info'=>'打款状态错误，稍后操作'));
            }
    }

    public function dakuanyuan(){
        $id = I('id','');
        $Order =M('withdrawals');
        /**
         * 处理查询条件
         *
         */
        //支付状态
        $accounts=M("accounts");
        $proportion=M("proportion");
        $present_account=M("present_account");
        $list = $Order->where(array('id'=>$id))->field("user_id,account_id,jine,status,type")->find();//提现申请表
        $account=$present_account->where(array('id'=>$list['account_id']))->find();//提现账户
        $data['card_number']=$account['card_number'];//提现比例
        $data['card_type']=$account['card_type'];//提现比例
        if($list['type']==1){
            //佣金提现
            $propor=$proportion->where("id=1")->getField("proportion");
            $propor1=$propor*0.01;
            if($list['status']==2){
                $this->redirect('tixian',array(),1,'不能重复打款，返回列表...');
            }else{
                $commission=$accounts->where(array('user_id'=>$list['user_id']))->getField("commission");
                if($commission>=$list['jine']){
                    $data['status']=2;
                    $data['endtime']=time();
                    $data['proportion']=$propor;//提现比例

                    $data['jine1']=$list['jine']-$list['jine']*$propor1;//提现比例

                    $arr=$Order->where(array('id'=>$id))->save($data);
                    if($arr){

                        $accounts->where(array('user_id'=>$list['user_id']))->setInc("commission",-$list['jine']);
                        $accounts->where(array('user_id'=>$list['user_id']))->setInc("withdrawals",$list['jine']);
                        $this->redirect('tixian',array(),1,'完成打款，返回列表...');
                    }else{
                        $this->redirect('tixian',array(),1,'系统繁忙，请重试...');
                    }
                }else{
                    $this->redirect('tixian',array(),1,'提现金额不足...');
                }
            }

        }else{
            //碳积分提现
            //碳积分提现比例
            $propor=$proportion->where("id=2")->getField("proportion");
            $propor1=$propor*0.01;
            if($list['status']==2){
                $this->redirect('feicuibi',array(),1,'不能重复打款，返回列表...');
            }else{
                $commission=$accounts->where(array('user_id'=>$list['user_id']))->getField("accounts");
                if($commission>=$list['jine']){
                    $data['status']=2;
                    $data['endtime']=time();
                    $data['proportion']=$propor;//提现比例

                    $data['jine1']=$list['jine']-$list['jine']*$propor1;//提现比例

                    $arr=$Order->where(array('id'=>$id))->save($data);
                    if($arr){

                        $accounts->where(array('user_id'=>$list['user_id']))->setInc("accounts",-$list['jine']);
                        $accounts->where(array('user_id'=>$list['user_id']))->setInc("haveaccounts",$list['jine']);
                        $this->redirect('feicuibi',array(),1,'完成打款，返回列表...');
                    }else{
                        $this->redirect('feicuibi',array(),1,'系统繁忙，请重试...');
                    }
                }else{
                    $this->redirect('feicuibi',array(),1,'碳积分数量不足...');
                }
            }
        }




    }



}