<?php
namespace Admin\Controller;

/**
 * 后台 广告位管理
 * User: 宁鲁华
 * Date: 2015/6/9
 * Time: 13:04
 */
class CarController extends AdminController
{

    public function index(){
        $types = M('types');
        $brands = $types->where('type=2')->order("toop desc")->select();
        $this->assign("brands",$brands);
        $p = I('get.p',1);
        $News = M('car_rental');
        $map = array();
        $map['type']=1;
        $brand = I('brand',$_GET['brand']);
        if(!empty($brand)){
            $map['car_type'] = $brand;
            $this->assign('brand', $brand);
        }
        //省
        $province = I('names','');
        if(!empty($province)){
            $map['names'] = $province;
            $this->assign('names', $province);
        } //市
        $city = I('mobile','');
        if(!empty($city)){
            $map['mobile'] = $city;
            $this->assign('mobile', $city);
        } //区
        $area = I('user_id','');
        if(!empty($area)){
            $map['user_id'] = $area;
            $this->assign('user_id', $area);
        }
        $list = $News->where($map)->order("id desc")->page($p)->select();
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    public function index1(){
        $types = M('types');
        $brands = $types->where('type=2')->order("toop desc")->select();
        $this->assign("brands",$brands);
        $p = I('get.p',1);
        $News = M('car_rental');
        $map = array();
        $brand = I('brand',$_GET['brand']);
        if(!empty($brand)){
            $map['car_type'] = $brand;
            $this->assign('brand', $brand);
        }

        //省
        $province = I('names','');
        if(!empty($province)){
            $map['names'] = $province;
            $this->assign('names', $province);
        } //市
        $city = I('mobile','');
        if(!empty($city)){
            $map['mobile'] = $city;
            $this->assign('mobile', $city);
        } //区
        $area = I('user_id','');
        if(!empty($area)){
            $map['user_id'] = $area;
            $this->assign('user_id', $area);
        }
    $map['type']=2;
        $list = $News->where($map)->order("id desc")->page($p)->select();
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    public function seecar(){
        $types = M('types');
        $brands = $types->where('type=2')->order("toop desc")->select();
        $this->assign("brands",$brands);
        $p = I('get.p',1);
        $News = M('tosee_car');
        $map = array();
        $brand = I('brand',$_GET['brand']);
        if(!empty($brand)){
            $map['car_type'] = $brand;
            $this->assign('brand', $brand);
        }

        $store_id=I("store_id",$_GET['store_id']);
        if(!empty($store_id)){
            $map['store_id'] = $store_id;
            $this->assign('store_id', $store_id);
        }
        //省
        $province = I('order_no','');
        if(!empty($province)){
            $map['order_no'] = $province;
            $this->assign('order_no', $province);
        } //市
        $city = I('order_noshoufu','');
        if(!empty($city)){
            $map['order_noshoufu'] = $city;
            $this->assign('order_noshoufu', $city);
        } //区
        $area = I('user_id','');
        if(!empty($area)){
            $map['user_id'] = $area;
            $this->assign('user_id', $area);
        }
    $map['type']=03;
        $list = $News->where($map)->order("id desc")->page($p)->select();
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }

    public function quota_style(){
        $id = $_POST['id'];

        $Order =M('car_rental');
        $list = $Order->where(array('id'=>$id))->setField("status",$_POST['status']);
        if($list){
            $type=10;//碳积分充值记录导出表
            $content="修改租车状态";
            $table="car_rental";
            $tables_id=$id;
            caiwu_log($type,$content,$table,$tables_id);
            $reg['info']="修改成功";
            $reg['status']=200;

        }else{
            $reg['status']=300;
            $reg['info']="系统繁忙请重试";
        }
        $this->ajaxReturn($reg);
    }
    //预约购车
    public function yuyuegouche(){
        $id = $_POST['id'];

        $Order =M('tosee_car');
        $ddd['status']=$_POST['status'];
        $ddd['content']=$_POST['content'];
        if($ddd['status']==3){
            $ddd['order_noshoufu']='FC'.time();
        }elseif($_POST['status']==6){
//该车的首付也已经付完毕了
           $ifhave= $Order->where(array('id'=>$id))->field("type_shoufu,order_noshoufu,status,car_id")->find();
           if($ifhave['status']==5 && $ifhave['type_shoufu']==2){
               $this->yongjin_logcar($ifhave['order_noshoufu']);
           }else{
               $reg['info']="该订单状态错误，请核实";
               $reg['status']=300;
               $this->ajaxReturn($reg);
           }
        }

        $list = $Order->where(array('id'=>$id))->save($ddd);
        if($list){


            $reg['info']="修改成功";
            $reg['status']=200;

        }else{
            $reg['status']=300;
            $reg['info']="系统繁忙请重试";
        }
        $this->ajaxReturn($reg);
    }

    public function yongjin_logcar($order_no){
        $dingdan=M('tosee_car');//订单
        $proportion=M('proportion');//拨比
        $vips=M('vips');//拨比
        $funddetails=M('funddetails');//佣金记录
        $accounts=M('accounts');//我的账户
        $user=M("user");
        $order_info=$dingdan->where(array('order_noshoufu'=>$order_no))->field("user_id,shoufu,order_noshoufu,status,car_id")->find();
        $data['order_price']=$order_info['shoufu'];//首付金额
        $data['order_no']=$order_no;
        $data['status']=2;//已到账佣金
        //是否有上级推荐人--爱人
        $airen=$user->where(array('user_id'=>$order_info['user_id']))->field("tj_id,province,city,area,level,level1")->find();

        if(!empty($airen['tj_id'])){
            $airen1=$user->where(array('user_id'=>$airen['tj_id']))->field("tj_id,province,city,area,level,level1")->find();
            //先判断是不是有单独的产品拨比,有拨比，按照馋哦拨比，没有的话按照会员等级，拨比
            $healthyshop=M("product");
            $product_proportion=$healthyshop->where(array('id'=>$order_info['car_id']))->field("jinpaia,jinpail,yinpail,yinpaia,tongpaia,tongpail,putonga,putongl")->find();
//先看这个推荐人的级别
            if($airen1['level']==5){
                //是经纪人
                if($airen1['level1']==3){
                    if($product_proportion['yinpaia']!=""){
                        $data['proportion']=$product_proportion['yinpaia'];
                    }else{
                        $data['proportion']=$vips->where("id=3")->getField("lover");//爱人的拨比
                    }

                }elseif($airen1['level1']==4){
                    if($product_proportion['jinpaia']!=""){
                        $data['proportion']=$product_proportion['jinpaia'];
                    }else{
                        $data['proportion']=$vips->where("id=4")->getField("lover");//爱人的拨比
                    }

                }elseif($airen1['level1']==2){
                    if($product_proportion['tongpaia']!=""){
                        $data['proportion']=$product_proportion['tongpaia'];
                    }else {

                        $data['proportion'] = $vips->where("id=2")->getField("lover");//爱人的拨比
                    }
                }else{
                    if($product_proportion['putonga']!=""){
                        $data['proportion']=$product_proportion['putonga'];
                    }else {
                        $data['proportion'] = $vips->where("id=1")->getField("lover");//爱人的拨比
                    }
                }

            }else{
                //普通用户没有佣金
                $data['proportion']=$vips->where("id=1")->getField("lover");//爱人的拨比
            }

            $proportion1=$data['proportion']*0.01;
            $data['user_id']=$airen['tj_id'];

            $data['income']=$order_info['shoufu']*$proportion1;//佣金收入
            $data['addtime']=time();
            $data['type']=14;//1省级代理佣金2市级3县级4爱人5恋人6按地区的省级代理7按地区的市代理8按区的代理
            $funddetails->add($data);

if($accounts->where(array('user_id'=>$data['user_id']))->find()){
    $accounts->where(array('user_id'=>$data['user_id']))->setInc("ccounts",$data['income']);
}else{
    $accounts->add(array('user_id'=>$data['user_id'],'account'=>$data['income'],'addtime'=>time()));
}



            //是否有上上级推荐人--恋人
            $lianren=$user->where(array('user_id'=>$airen['tj_id']))->getField("tj_id");
            if(!empty($lianren)){
                //先判断用户的等级，如果是5则看是哪种级别的经纪人
                $yituijian=$user->where(array('user_id'=>$lianren))->field("level,level1")->find();
                if($yituijian['level']==5){

                    //是经纪人
                    if($yituijian['level1']==3){
                        if($product_proportion['yinpail']!=""){
                            $data['proportion']=$product_proportion['yinpail'];
                        }else{
                            $data['proportion']=$vips->where("id=3")->getField("loverer");//爱人的拨比
                        }

                    }elseif($yituijian['level1']==4){
                        if($product_proportion['jinpail']!=""){
                            $data['proportion']=$product_proportion['jinpail'];
                        }else{
                            $data['proportion']=$vips->where("id=4")->getField("loverer");//爱人的拨比
                        }

                    }elseif($yituijian['level1']==2){
                        if($product_proportion['tongpaia']!=""){
                            $data['proportion']=$product_proportion['tongpaia'];
                        }else {

                            $data['proportion'] = $vips->where("id=2")->getField("loverer");//爱人的拨比
                        }
                    }else{
                        if($product_proportion['putonga']!=""){
                            $data['proportion']=$product_proportion['putonga'];
                        }else {
                            $data['proportion'] = $vips->where("id=1")->getField("loverer");//爱人的拨比
                        }
                    }
                }else{
//普通用户
                    $data['proportion']=$vips->where("id=1")->getField("lover");//爱人的拨比
                }

                $proportion1=$data['proportion']*0.01;
                $data['user_id']=$lianren;

                $data['income']=$order_info['shoufu']*$proportion1;//佣金收入
                $data['addtime']=time();
                $data['type']=15;//1省级代理佣金2市级3县级4爱人5恋人6按地区的省级代理7按地区的市代理8按区的代理
                $funddetails->add($data);
                if($accounts->where(array('user_id'=>$lianren))->find()){
                    $accounts->where(array('user_id'=>$lianren))->setInc("ccounts",$data['income']);
                }else{
                    $accounts->add(array('user_id'=>$lianren,'account'=>$data['income']));
                }
            }

        }
        //根据注册地区分红
        // 一 省级代理
        $is_province=$user->where(array('level'=>2,'province'=>$airen['province']))->field("user_id,bobi")->select();//获取省的代理id
        $data['proportion']=$proportion->where("id=3")->getField("proportion");//省级代理的拨比

        //该地区有省级代理
        if(!empty($is_province)){
            foreach ($is_province as &$v)
            {
                if($v['bobi']!=0){
                    $data['proportion'] =$v['bobi'];
                    $ddd=$v['bobi']*0.01;
                }else{
                    $ddd=$data['proportion']*0.01;
                }
                $data['user_id']=$v['user_id'];
                $data['income']=$order_info['shoufu']*$ddd;//佣金收入
                $data['addtime']=time();
                $data['type']=11;//1省级代理佣金2市级3县级4爱人5恋人6按地区的省级代理7按地区的市代理8按区的代理
                $funddetails->add($data);
                if($accounts->where(array('user_id'=>$v['user_id']))->find()){
                    $accounts->where(array('user_id'=>$v['user_id']))->setInc("ccounts",$data['income']);
                }else{
                    $accounts->add(array('user_id'=>$v['user_id'],'account'=>$data['income']));
                }
            }
        }
        //二 市代理
        $is_city=$user->where(array('level'=>3,'city'=>$airen['city']))->field("user_id,bobi")->select();//获取省的代理id
        $data['proportion']=$proportion->where("id=4")->getField("proportion");//市级代理的拨比

        //该地区有市级代理
        if(!empty($is_city)){
            foreach ($is_city as &$vv)
            {
                if($vv['bobi']!=0){
                    $data['proportion'] =$vv['bobi'];
                    $fff=$vv['bobi']*0.01;
                }else{
                    $fff=$data['proportion']*0.01;
                }
                $data['user_id']=$vv['user_id'];
                $data['income']=$order_info['shoufu']*$fff;//佣金收入
                $data['addtime']=time();
                $data['type']=12;//1省级代理佣金2市级3县级4爱人5恋人6按地区的省级代理7按地区的市代理8按区的代理
                $funddetails->add($data);
                if($accounts->where(array('user_id'=>$vv['user_id']))->find()){
                    $accounts->where(array('user_id'=>$vv['user_id']))->setInc("ccounts",$data['income']);
                }else{
                    $accounts->add(array('user_id'=>$vv['user_id'],'account'=>$data['income']));
                }
            }
        }

        //三 区代理
        $is_area=$user->where(array('level'=>4,'area'=>$airen['area']))->field("user_id,bobi")->select();//获取省的代理id
        $data['proportion']= $proportion->where("id=5")->getField("proportion");//区级代理的拨比

        //该地区有市级代理
        if(!empty($is_area)){
            foreach ($is_area as &$vvv)
            {
                if($vvv['bobi']!=0){
                    $data['proportion'] =$vvv['bobi'];
                    $ddds=$vvv['bobi']*0.01;
                }else{
                    $ddds=$data['proportion']*0.01;
                }
                $data['user_id']=$vvv['user_id'];
                $data['income']=$order_info['shoufu']*$ddds;//佣金收入
                $data['addtime']=time();
                $data['type']=13;//1省级代理佣金2市级3县级4爱人5恋人6按地区的省级代理7按地区的市代理8按区的代理
                $funddetails->add($data);
                if($accounts->where(array('user_id'=>$vvv['user_id']))->find()){
                    $accounts->where(array('user_id'=>$vvv['user_id']))->setInc("ccounts",$data['income']);
                }else{
                    $accounts->add(array('user_id'=>$vvv['user_id'],'account'=>$data['income']));
                }
            }
        }


//        //根据收货地址分红
//
//        $addr=M("addr");
//        $addr_info=$addr->where(array('id'=>$order_info['addr_id']))->field("province,city,area")->find();
//
//        // 一 省级代理
//        $is_province1=$user->where(array('level'=>2,'province'=>$addr_info['province']))->field("user_id,bobi")->select();//获取省的代理id
//        $proportion1=$proportion->where("id=3")->getField("proportion");//省级代理的拨比
//
//        //该地区有省级代理
//        if(!empty($is_province1)){
//
//            foreach ($is_province1 as &$b)
//            {
//                if($b['bobi']!=0){
//                    $data['proportion'] =$b['bobi']*0.01;
//                }else{
//                    $data['proportion']= $proportion1*0.01;
//                }
//                $data['user_id']=$b['user_id'];
//                $data['income']=$order_info['shoufu']*$data['proportion'];//佣金收入
//                $data['addtime']=time();
//                $data['type']=16;//1省级代理佣金2市级3县级4爱人5恋人6按地区的省级代理7按地区的市代理8按区的代理
//                $funddetails->add($data);
//            }
//        }


//        //二 市代理
//        $is_city1=$user->where(array('level'=>3,'city'=>$addr_info['city']))->field("user_id,bobi")->select();//获取省的代理id
//        $proportion1=$proportion->where("id=4")->getField("proportion");//市级代理的拨比
//
//        //该地区有市级代理
//        if(!empty($is_city1)){
//            foreach ($is_city1 as &$bb)
//            {
//                if($bb['bobi']!=0){
//                    $data['proportion'] =$bb['bobi']*0.01;
//                }else{
//                    $data['proportion']= $proportion1*0.01;
//                }
//                $data['user_id']=$bb['user_id'];
//                $data['income']=$order_info['shoufu']*$data['proportion'];//佣金收入
//                $data['addtime']=time();
//                $data['type']=17;//1省级代理佣金2市级3县级4爱人5恋人6按地区的省级代理7按地区的市代理8按区的代理
//                $funddetails->add($data);
//            }
//        }

        //三 区代理
//        $is_area1=$user->where(array('level'=>4,'area'=>$addr_info['area']))->field("user_id,bobi")->select();//获取省的代理id
//        $proportion1= $proportion->where("id=5")->getField("proportion");//区级代理的拨比
//
//        //该地区有市级代理
//        if(!empty($is_area1)){
//            foreach ($is_area1 as &$bbb)
//            {
//                if($bbb['bobi']!=0){
//                    $data['proportion'] =$bbb['bobi']*0.01;
//                }else{
//                    $data['proportion']= $proportion1*0.01;
//                }
//                $data['user_id']=$bbb['user_id'];
//                $data['income']=$order_info['shoufu']*$data['proportion'];//佣金收入
//                $data['addtime']=time();
//                $data['type']=18;//1省级代理佣金2市级3县级4爱人5恋人6按地区的省级代理7按地区的市代理8按区的代理
//                $funddetails->add($data);
//            }
//        }
//        return "正确" ;



    }


}