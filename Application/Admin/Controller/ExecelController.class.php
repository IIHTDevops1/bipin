<?php
namespace Admin\Controller;
use Think\Controller;

class ExecelController extends Controller {

//导出资金
    public function get_zijin(){
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
        $type=3;//资金导出表
        $content="资金导出表";
        $table="accounts";
        $tables_id=0;
        caiwu_log($type,$content,$table,$tables_id);
        if(!empty($addtime)){
            if($addtime==1){
//当天    1525190400
                $times = strtotime(date('Y-m-d', time()));
            }elseif ($addtime==2){
//本周    1525017600
                $times = mktime(0,0,0,date('m'),date('d')-date('w')+1,date('Y'));
            }elseif ($addtime==3){
//本月    1525104000
                $times = mktime(0,0,0,date('m'),1,date('Y'));
            }elseif ($addtime==4){
//本季度
                $season = ceil(date('n') /3);
                $times=mktime(0,0,0,($season - 1) *3 +1,1,date('Y'));
            }elseif ($addtime==5){
//半年内   1509618187
                $times= strtotime('-6 month');
            }elseif ($addtime==6){
                //本年内   1514736000
                $times= strtotime(date("Y",time())."-1"."-1");
            }

            $where['addtime']=array('gt',$times);
            $this->assign("addtime",$addtime);

        }
        $list = $Order->where($where)->order('addtime desc')->select();
        foreach ($list as $k=>&$v){
            $v['id']=$k+1;
            $v['truename']=get_truename($v['user_id']);
            $v['mobile']=get_mobile($v['user_id']);
            $v['addtime']=date('Y-m-d H:i:s',$v['add_time']);

        }
        unset($v);
//        $headArr = Array('编号','客户手机号','客户姓名','交易时间','实际入账金额','佣金类型','交易通道','收款单号','费率','客户姓名','交易金额','交易明细');
        $headArr = Array('编号','碳积分','成立时间','佣金','用户id','今日收益','总收益','已提现金额','已提现碳积分','已消费碳积分','用户姓名','用户电话');
        //函数已封装  ，随时可用，想怎么用就怎么用
        $this->ExcelOut($list,$headArr,'碳积分明细表_');

    }
//产品销售记录
    public function get_info(){
//        if(!empty($type)){
//            $map['type'] = $type;
//            $this->assign('type', $type);
//        }
        $map['type_id'] = 0;
        $order_no = I('order_no','');
        if(!empty($order_no)){
            $map['order_no'] = $order_no;
        }
        $status = I('status','');
        if(!empty($status)){
            $map['status'] = $status;
//            $this->assign("status",$status);
        }
//        $user_id = I('user_id','');
//        if(!empty($user_id)){
//            $map['user_id'] = $user_id;
//        }
        $addtime = I('addtime','');

        if(!empty($addtime)){
            if($addtime==1){
//当天    1525190400
                $times = strtotime(date('Y-m-d', time()));
            }elseif ($addtime==2){
//本周    1525017600
                $times = mktime(0,0,0,date('m'),date('d')-date('w')+1,date('Y'));
            }elseif ($addtime==3){
//本月    1525104000
                $times = mktime(0,0,0,date('m'),1,date('Y'));
            }elseif ($addtime==4){
//本季度
                $season = ceil(date('n') /3);
                $times=mktime(0,0,0,($season - 1) *3 +1,1,date('Y'));
            }elseif ($addtime==5){
//半年内   1509618187
                $times= strtotime('-6 month');
            }elseif ($addtime==6){
                //本年内   1514736000
                $times= strtotime(date("Y",time())."-1"."-1");
            }

            $map['add_time']=array('gt',$times);
//            $this->assign("addtime",$addtime);

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
        $mobile = I('mobile','');
        if(!empty($mobile)){
            $user_id=$user->where(array('mobile'=>$mobile))->getField("user_id");
            if(!empty($user_id)){
                $map['user_id']=$user_id;
                $this->assign("mobile",$mobile);
            }
        }

        $addr=M("addr");
        $rechargerecord=M("rechargerecord");
        $order_info=$rechargerecord->where($map)->field("id,order_price,product_id,num,add_time,order_no,addr_id,user_id,status,logistics_sheet,logistics")->order("add_time desc")->select();

        foreach ($order_info as $k=>&$v){
            $v['id']=$k+1;
            $user_info=$user->where(array('user_id'=>$v['user_id']))->field("mobile,truename,province,city,area")->find();
            $addr_info=$addr->where(array('id'=>$v['addr_id']))->field("consignee,province,city,area,mobile,addr")->find();
            $pro_info=$healthyshop->where(array('id'=>$v['product_id']))->field("pro_name,activity_price")->find();
            $v['user_info']="姓名：".$user_info['truename'].";手机号：".$user_info['mobile'].";地区：".get_cityname($user_info['province']).get_cityname($user_info['city']).get_cityname($user_info['area']);
            $v['addr_info']="收货人姓名：".$addr_info['consignee'].";手机号：".$addr_info['mobile'].";详细地址：".get_cityname($addr_info['province']).get_cityname($addr_info['city']).get_cityname($addr_info['area']).$addr_info['addr'];
            $v['pro_info']="产品名称：".$pro_info['pro_name'].";价格：".$pro_info['activity_price'].";购买数量：".$v['num'];
            $v['status']=get_status($v['status']);
            $v['add_time']=dateformat($v['add_time'],3);
            unset($v['addr_id']);
            unset($v['product_id']);
            unset($v['user_id']);
            unset($v['num']);
        }

        unset($v);
        $headArr = Array('编号','订单金额','交易时间','订单号','订单状态','物流单号','物流名称','下单人信息','收货人信息','产品信息');
        //函数已封装  ，随时可用，想怎么用就怎么用
        $this->ExcelOut($order_info,$headArr,'产品交易记录表_');

    }


    public function get_chongzhi(){

        $map['type_id'] = 3;
        $order_no = I('order_no','');
        if(!empty($order_no)){
            $map['order_no'] = $order_no;
        }
        $user =M('user');
        $addtime = I('addtime','');

        if(!empty($addtime)){
            if($addtime==1){
//当天    1525190400
                $times = strtotime(date('Y-m-d', time()));
            }elseif ($addtime==2){
//本周    1525017600
                $times = mktime(0,0,0,date('m'),date('d')-date('w')+1,date('Y'));
            }elseif ($addtime==3){
//本月    1525104000
                $times = mktime(0,0,0,date('m'),1,date('Y'));
            }elseif ($addtime==4){
//本季度
                $season = ceil(date('n') /3);
                $times=mktime(0,0,0,($season - 1) *3 +1,1,date('Y'));
            }elseif ($addtime==5){
//半年内   1509618187
                $times= strtotime('-6 month');
            }elseif ($addtime==6){
                //本年内   1514736000
                $times= strtotime(date("Y",time())."-1"."-1");
            }

            $map['add_time']=array('gt',$times);
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
        $type=6;//碳积分充值记录导出表
        $content="碳积分充值记录导出表";
        $table="rechargerecord";
        $tables_id=0;
        caiwu_log($type,$content,$table,$tables_id);
        $order_info=$rechargerecord->where($map)->field("id,order_price,add_time,order_no,user_id,status")->order("add_time desc")->select();
        foreach ($order_info as $k=>&$v){
            $user_info=$user->where(array('user_id'=>$v['user_id']))->field("mobile,truename,province,city,area")->find();
            $v['user_info']="姓名：".$user_info['truename'].";手机号：".$user_info['mobile'].";地区：".get_cityname($user_info['province']).get_cityname($user_info['city']).get_cityname($user_info['area']);
            $v['id']=$k+1;
            $v['status']=get_status($v['status']);
            $v['add_time']=dateformat($v['add_time'],3);
            unset($v['user_id']);
        }

        unset($v);

        $headArr = Array('编号','充值金额','交易时间','订单号','交易状态','客户信息');
//        //函数已封装  ，随时可用，想怎么用就怎么用
        $this->ExcelOut($order_info,$headArr,'碳积分充值记录明细_');
    }



//    public function get_info1(){
//        $Order =M('funddetails');
//
//        $list = $Order->where("type=8 OR type=11 OR type=9")->order('add_time asc')->select();
//        $user=M("user");
//        $rechargerecord=M("rechargerecord");
//        $pay_log=M("pay_log");
//        foreach ($list as $k=>&$v){
//            $user_info=$user->where(array('mobile'=>$v['mobile']))->field("id,truename")->find();
//            $order_info=$rechargerecord->where(array('order_no'=>$v['ext_id']))->field("id,order_price,content")->find();
//            if($order_info){
//                $v['truename']=$user_info['truename'];
//                $v['orderamount']=$order_info['order_price'];
//                $v['content']=$order_info['content'];
//            }else{
//                $order_info=$pay_log->where(array('order_id'=>$v['ext_id'],'pay_state'=>1))->field("id,price,mobile")->find();
//                $v['truename']=$user_info['truename'];
//                $v['orderamount']=$order_info['price'];
//                $v['content']="客户【".$order_info['mobile']."】消费".$order_info['price'];
//            }
//            $v['id']=$k+1;
//            $v['user_id']=get_truename($v['user_id']);
//            $v['ext_id']="'".$v['ext_id'];
//            $v['type']= in_array($v['type'],array(21,22,23))?'微信':'支付宝';
//            $v['add_time']=date('Y-m-d H:i:s',$v['add_time']);
//            unset($v['customer_id']);
//            unset($v['income']);
//            unset($v['payout']);
//        }
//        unset($v);
//        $headArr = Array('编号','客户手机号','客户姓名','交易时间','实际入账金额','佣金类型','交易通道','收款单号','费率','客户姓名','交易金额','交易明细');
//        //函数已封装  ，随时可用，想怎么用就怎么用
//        $this->ExcelOut($list,$headArr,'平台其他入账表_');
//
//    }
    public function get_transfer(){
        $status = I('status','');
        $expenditure_id = I('expenditure_id','');
        $truename = I('truename','');
        $Order =M('transfer');
        $user =M('user');
        if(!empty($status)){
            $where['status']=$status;
            $this->assign("status",$status);
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
            if($addtime==1){
//当天    1525190400
                $times = strtotime(date('Y-m-d', time()));
            }elseif ($addtime==2){
//本周    1525017600
                $times = mktime(0,0,0,date('m'),date('d')-date('w')+1,date('Y'));
            }elseif ($addtime==3){
//本月    1525104000
                $times = mktime(0,0,0,date('m'),1,date('Y'));
            }elseif ($addtime==4){
//本季度
                $season = ceil(date('n') /3);
                $times=mktime(0,0,0,($season - 1) *3 +1,1,date('Y'));
            }elseif ($addtime==5){
//半年内   1509618187
                $times= strtotime('-6 month');
            }elseif ($addtime==6){
                //本年内   1514736000
                $times= strtotime(date("Y",time())."-1"."-1");
            }

            $where['addtime']=array('gt',$times);
            $this->assign("addtime",$addtime);

        }

        $list = $Order->where($where)->order('addtime desc')->field("id,expenditure_id,income_name,income_mobile,accounts,status,addtime")->select();

        foreach ($list as $k=>&$v){
            $v['id']=$k+1;
            $user_info=$user->where(array('user_id'=>$v['expenditure_id']))->field("mobile,truename,province,city,area")->find();
            $v['expenditure_info']="姓名：".$user_info['truename'].";手机号：".$user_info['mobile'].";地区：".get_cityname($user_info['province']).get_cityname($user_info['city']).get_cityname($user_info['area']);
            $v['income_info']="姓名：".$v['income_name'].";手机号：".$v['income_mobile'];

if($v['status']==1){
    $v['status']="待处理";
}else{
    $v['status']="交易完成";
}

            $v['addtime']=date('Y-m-d H:i:s',$v['addtime']);
            unset($v['expenditure_id']);
            unset($v['income_name']);
            unset($v['income_mobile']);
        }
        unset($v);
        $headArr = Array('编号','交易数量','交易状态','交易时间','支出方信息','收入方信息');
//        //函数已封装  ，随时可用，想怎么用就怎么用
        $this->ExcelOut($list,$headArr,'碳积分转账明细_');
//
    }
    public function get_feicuibi(){
        $Order =M('withdrawals');
        /**
         * 处理查询条件
         *
         */
        //支付状态
        $stady = I('status','');
        $user =M('user');
        if(!empty($stady)){

            $map['status'] = $stady;
            $this->assign('status', $stady);
        }
        $map['type'] = 2;
        $addtime = I('addtime','');

        if(!empty($addtime)){
            if($addtime==1){
//当天    1525190400
                $times = strtotime(date('Y-m-d', time()));
            }elseif ($addtime==2){
//本周    1525017600
                $times = mktime(0,0,0,date('m'),date('d')-date('w')+1,date('Y'));
            }elseif ($addtime==3){
//本月    1525104000
                $times = mktime(0,0,0,date('m'),1,date('Y'));
            }elseif ($addtime==4){
//本季度
                $season = ceil(date('n') /3);
                $times=mktime(0,0,0,($season - 1) *3 +1,1,date('Y'));
            }elseif ($addtime==5){
//半年内   1509618187
                $times= strtotime('-6 month');
            }elseif ($addtime==6){
                //本年内   1514736000
                $times= strtotime(date("Y",time())."-1"."-1");
            }
            $map['addtime']=array('gt',$times);
            $this->assign("addtime",$addtime);

        }
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
        $list = $Order->where($map)->order('addtime desc')->field("id,user_id,jine,status,addtime,proportion,endtime,jine1,card_number,card_type")->select();

        foreach ($list as $k=>&$v){
            $v['id']=$k+1;
            $user_info=$user->where(array('user_id'=>$v['user_id']))->field("mobile,truename,province,city,area")->find();
            $v['user_info']="姓名：".$user_info['truename'].";手机号：".$user_info['mobile'].";地区：".get_cityname($user_info['province']).get_cityname($user_info['city']).get_cityname($user_info['area']);

            if($v['status']==1){
                $v['status']="待处理";
            }elseif($v['status']==2){
                $v['status']="打款成功";
            }else{
                $v['status']="申请被驳回";
            }

            $v['addtime']=date('Y-m-d H:i:s',$v['addtime']);
            $v['endtime']=date('Y-m-d H:i:s',$v['endtime']);
            unset($v['user_id']);
            unset($v['account_id']);

        }


        $headArr = Array('编号','交易金额','交易状态','申请时间','提现手续费','完成时间','实际到账','收款账户','账户分类','用户信息');
        $this->ExcelOut($list,$headArr,'碳积分提现明细表_');
//
    }

    public function ExcelOut($list,$headArr,$fileName,$width=20){
        error_reporting(E_ALL);
        header('Content-Type:text/html;charset=utf-8');
        Vendor('Excel.Classes.PHPExcel');
        vendor('Excel.Classes.PHPExcel.IOFactory');
        vendor('Excel.Classes.PHPExcel.Writer.Excel5');
        vendor('Excel.Classes.PHPExcel.Writer.Excel2007');
        //$headArr = Array('编号','客户手机号','客户姓名','交易时间','实际入账金额','佣金类型','交易通道','收款单号','费率','客户姓名','交易金额','交易明细');
        $date = date("YmdHis",time());
        $fileName .= "_{$date}.xls";//文件名
        $objPHPExcel = new \PHPExcel();
        //设置表头
        $tem_key = "A";
        foreach($headArr as $v){
            if (strlen($tem_key) > 1) {
                $arr_key = str_split($tem_key);
                $colum = '';
                foreach ($arr_key as $ke=>$va) {
                    $colum .= chr(ord($va));
                }
            } else {
                $key = ord($tem_key);
                $colum = chr($key);
            }
            $objPHPExcel->getActiveSheet()->getColumnDimension($colum)->setWidth($width); // 列宽
            $objPHPExcel->getActiveSheet()->getStyle($colum)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // 垂直居中
            $objPHPExcel->getActiveSheet()->getStyle($colum.'1')->getFont()->setBold(true); // 字体加粗
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
            $tem_key++;
        }
        $objActSheet = $objPHPExcel->getActiveSheet();
        $border_end = 'A1'; // 边框结束位置初始化
        // 写入内容
        $column = 2;
        foreach($list as $key => $rows){ //获取一行数据
            $tem_span = "A";
            foreach($rows as $keyName=>$value){// 写入一行数据
                if (strlen($tem_span) > 1) {
                    $arr_span = str_split($tem_span);
                    $j = '';
                    foreach ($arr_span as $ke=>$va) {
                        $j .= chr(ord($va));
                    }
                } else {
                    $span = ord($tem_span);
                    $j = chr($span);
                }
                $objActSheet->setCellValue($j.$column, $value);
                $border_end = $j.$column;
                $tem_span++;
            }
            $column++;
        }
        $objActSheet->getStyle("A1:".$border_end)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN); // 设置边框
        $fileName = iconv("utf-8", "gb2312", $fileName);
        //重命名表
        //$objPHPExcel->getActiveSheet()->setTitle('test');
        //设置活动单指数到第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean();//清除缓冲区,避免乱码
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header("Content-Transfer-Encoding:binary");
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        exit;
    }

//    public function quota(){
//        $id = $_POST['id'];
//
//        $Order =M('user');
//        $list = $Order->where(array('id'=>$id))->setField("quota",$_POST['quota']);
//        if($list){
//           $reg['info']="修改成功";
//           $reg['status']=200;
//
//        }else{
//            $reg['status']=300;
//            $reg['info']="请输入新的额度值";
//        }
//        $this->ajaxReturn($reg);
//    }
//    public function quota_style(){
//        $id = $_POST['id'];
//
//        $Order =M('user');
//        $list = $Order->where(array('id'=>$id))->setField("quota_style",$_POST['quota_style']);
//        if($list){
//           $reg['info']="修改成功";
//           $reg['status']=200;
//
//        }else{
//            $reg['status']=300;
//            $reg['info']="系统繁忙请重试";
//        }
//        $this->ajaxReturn($reg);
//    }

//    public function quota_order(){
//        $p = I('get.p',1);
//        $Order =M('user');
//        $is_vip = I('is_vip','');
//        $interest_freeloan = I('interest_freeloan','');
//        if(!empty($is_vip)){
//                $map['is_vip'] = $is_vip;
//            $this->assign('is_vip', $is_vip);
//        }
//        if(!empty($interest_freeloan)){
//                $map['interest_freeloan'] = $interest_freeloan;
//            $this->assign('interest_freeloan', $interest_freeloan);
//        }
//        //会员电话
//        $mobile = I('mobile','');
//        if(!empty($mobile)){
//            $map['mobile'] = $mobile;
//            $this->assign('mobile', $mobile);
//        }
//        //会员姓名
//        $truename = I('truename','');
//        if(!empty($truename)){
//            $map['truename'] = $truename;
//            $this->assign('truename', $truename);
//        }
//
//        $list = $Order->where($map)->order('addtime desc')->where("is_vip != 0 ")->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();
//        $mapcount = $Order->where($map)->count();
//        $show = getpages2($mapcount);
//
//
//        $this->assign('pages', $show);//分页
//        $this->assign('list', $list);
//
//        $this->display();
//    }

//    public function zhifu_order(){
//        $p = I('get.p',1);
//        $Order =M('withdrawals');
//        /**
//         * 处理查询条件
//         *
//         */
//        //支付状态
//        $stady = I('stady','');
//
//        if(!empty($stady)){
//            if($stady==2){
//                $map['stady'] = 0;
//            }else{
//                $map['stady'] = $stady;
//            }
//
//            $this->assign('stady', $stady);
//        }
//        //会员电话
//        $mobile = I('mobile','');
//        if(!empty($mobile)){
//            $map['mobile'] = $mobile;
//            $this->assign('mobile', $mobile);
//        }
//
//        //会员姓名
//        $truename = I('truename','');
//        if(!empty($truename)){
//            $map['truename'] = $truename;
//            $this->assign('truename', $truename);
//        }
//
//
//        $list = $Order->where($map)->order('addtime desc')->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();
//        foreach ($list as &$v){
//            $v['balance1']=$v['balance']-2;
//        }
//        $mapcount = $Order->where($map)->count();
//        $show = getpages2($mapcount);
//
//        $this->assign('pages', $show);//分页
//        $this->assign('list', $list);
//
//        $this->display();
//    }
//    public function money_order(){
//        $p = I('get.p',1);
//        $Order =M('funddetails');
//
//        $user_id=$_GET['mobile'];
//
//        $list = $Order->where(array('mobile'=>$user_id))->order('add_time desc')->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();
//		$rechargerecord=M("rechargerecord");
//		$pay_log=M("pay_log");
//		foreach($list as &$v){
//			$v['order_xq']=$rechargerecord->where(array('order_no'=>$v['ext_id']))->field("mobile,order_title,order_price")->find();
//			if($v['order_xq']==""){
//				$v['order_xq']=$pay_log->where(array('order_id'=>$v['ext_id']))->field("mobile,	price,body")->find();
//				$v['order_xq']['order_title']="产品";
//				$v['order_xq']['order_price']=$v['order_xq']['price'];
//			}
//		}
//		// var_dump($list);
//        $mapcount = $Order->where(array('mobile'=>$user_id))->count();
//        $show = getpages2($mapcount);
//
//
//        $this->assign('pages', $show);//分页
//        $this->assign('list', $list);
//
//        $this->display();
//    }

//    public function dakuan(){
//        $id = I('id','');
//        $Order =M('withdrawals');
//        /**
//         * 处理查询条件
//         *
//         */
//        //支付状态
//
//        $list = $Order->where(array('id'=>$id))->find();
//      if($list['stady']==1){
//          $this->redirect('zhifu_order',array(),1,'不能重复打款，返回列表...');
//      }else{
//          $data['stady']=1;
//          $data['endtime']=time();
//
//          $arr=$Order->where(array('id'=>$id))->save($data);
//          if($arr){
//              M("user")->where(array('mobile'=>$list['mobile']))->setInc("balance",-$list['balance']);
//              $this->redirect('zhifu_order',array(),1,'完成打款，返回列表...');
//          }else{
//              $this->redirect('zhifu_order',array(),1,'系统繁忙，请重试...');
//          }
//
//      }
//
//    }



}