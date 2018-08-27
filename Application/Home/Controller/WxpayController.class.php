<?php
namespace Home\Controller;
use Think\Controller;
class WxpayController extends Controller
{


    /**
     * notify_url接收页面
     */
    public function notify()
    {
        // 导入微信支付sdk
        Vendor('Weixinpay.Weixinpay');
        $wxpay = new \Weixinpay();
        $result = $wxpay->notify();

//        $order_no = $_POST['out_trade_no'];
        $xibilog=M("xibilog");
        //查找订单
//        $order = $xibilog->where(array('order_no'=>$order_no))->find();

        //更改订单状态
//        $xibilog->where(array('order_no'=>$order_no))->save(array('addtime'=>time(),'status'=>"2",'type'=>1));
        //用户购买数量增加
//        D('user')->where(array('user_id'=>$order['user_id']))->setInc('xibi',$order['transnum']);

        if ($result) {
            $order_no = $result['out_trade_no'];
            $order = $xibilog->where(array('order_no' => $order_no))->find();

            $xibilog->where(array('order_no' => $order_no))->save(array('addtime'=>time(),'status'=>"2",'type'=>2));
            if($order['types']==1){
                D('user')->where(array('user_id'=>$order['user_id']))->setInc('xibi',$order['transnum']);
            }elseif($order['types']==3){
                $ddd['level']=3;
                $ddd['vipstart']=time();
                $ddd['vipend']=time()+3600*$order['tian'];
                $ddd['xiazai']=$order['transnum'];//充值的时候直接为购买的次数
                D('user')->where(array('user_id'=>$order['user_id']))->save($ddd);

//                D('user')->where(array('user_id'=>$order['user_id']))->setInc('xiazai',$order['transnum']);
//                D('user')->where(array('user_id'=>$order['user_id']))->setField('level',3);
            }

        }

    }

    /**
     * 公众号支付 必须以get形式传递 out_trade_no 参数
     * 示例请看 /Application/Home/Controller/IndexController.class.php
     * 中的weixinpay_js方法
     */
    public function pay1()
    {
        $reg = getClientRequest();
        $order_no = $reg['order_no'];
        //查找订单信息
        $info = D('rechargerecord')->where(array('order_no' => $order_no))->find();

        if ($info['order_no']) {
            // 导入微信支付sdk
            Vendor('Weixinpay.Weixinpay');
            $wxpay = new \Weixinpay();
            $this->ajaxReturn($wxpay);
            // 获取jssdk需要用到的数据
            $info['order_price'] = $info['order_price'] * 100;

            $data = $wxpay->getParameters($info['order_no'], $info['order_price'], '');
//            $data=getParameters($info['order_no'],$info['order_price']);
            // 将数据分配到前台页面
            $this->ajaxReturn(array('status' => '200', 'data' => $data));
        } else {
            $this->ajaxReturn(array('status' => '300', 'msg' => '未查询到订单'));
        }

    }

    function payceshi()
    {
        $reques = getClientRequest();
        $user_id = $reques['user_id'];
        $xibi_id = $reques['xibi_id'];
        $user = M("user");
        $xibi = $user->where(array('user_id' => $user_id))->getField("xibi");//现有的戏币
        if (!empty($xibi)) {
            $vips = M("vips");
            $xq = $vips->where(array('id' => $xibi_id, 'types' => 2))->field("nums,gold")->find();
            if (!empty($xq)) {

                $xibilog = M("xibilog");

                $data['user_id'] = $user_id;
                $data['addtime'] = time();
                $data['order_no'] = "CZ" . time() . mt_rand("100,999");
                $data['status'] = 1;
                $data['types'] = 1;//充值
                $data['type'] = 2;//微信
                $data['price'] = $xq['gold'];
                $data['content'] = "购买戏币";
                $data['transnum'] = $xq['nums'];
                $data['xibi'] = $xibi + $xq['nums'];
                $xibilog->add($data);

                $order_no = $data['order_no'];

                // 导入微信支付sdk
                Vendor('Weixinpay.Weixinpay');
                $wxpay = new \Weixinpay();

                $prices = $data['price']*100;

                $data = $wxpay->getParameters($order_no, $prices, '');
                if (!empty($data)) {
                    $this->ajaxReturn(array('status' => '200', 'data' => $data));
                } else {
                    $this->ajaxReturn(array('status' => '300', 'msg' => '未查询到订单'));
                }

            } else {
                $this->ajaxReturn(array('status' => 300, 'msg' => '充值选项错误'));
            }

        } else {
            $this->ajaxReturn(array('status' => 300, 'msg' => '用户不存在'));
        }

    }

    function pay()
    {
        $reques = getClientRequest();
        $user_id = $reques['user_id'];
        $xibi_id = $reques['xibi_id'];
        $type = $reques['type'];
        $user = M("user");
if($type==1){
   //戏币充值
//    $xibi = $user->where(array('user_id' => $user_id))->getField("xibi");//现有的戏币
    $xibi = $user->where(array('user_id' => $user_id))->field("xibi")->find();//现有的戏币
    if (!empty($xibi)) {
        $vips = M("vips");
        $xq = $vips->where(array('id' => $xibi_id, 'types' => 2))->field("nums,gold")->find();
        if (!empty($xq)) {

            $xibilog = M("xibilog");
            $data['user_id'] = $user_id;
            $data['addtime'] = time();
            $data['order_no'] = "CZ" . time() . mt_rand("100,999");
            $data['status'] = 1;
            $data['types'] = 1;//充值
            $data['type'] = 2;//微信
            $data['price'] = $xq['gold'];
            $data['content'] = "购买戏币";
            $data['transnum'] = $xq['nums'];
            $data['xibi'] = $xibi['xibi'] + $xq['nums'];
            $xibilog->add($data);
            $order_no = $data['order_no'];
            // 导入微信支付sdk
            Vendor('Weixinpay.Weixinpay');
            $wxpay = new \Weixinpay();
            $prices = $data['price']*100;
            $data = $wxpay->getParameters($order_no, $prices, '');
            if (!empty($data)) {
                $this->ajaxReturn(array('status' => '200', 'data' => $data));
            } else {
                $this->ajaxReturn(array('status' => '300', 'msg' => '未查询到订单'));
            }
        } else {
            $this->ajaxReturn(array('status' => 300, 'msg' => '充值选项错误'));
        }
    } else {
        $this->ajaxReturn(array('status' => 300, 'msg' => '用户不存在'));
    }
}else{
    //购买vip升级
    $xibi = $user->where(array('user_id' => $user_id))->field("level,xiazai")->find();//现有的戏币
    if (!empty($xibi)) {

        $vips = M("vips");
        $xq = $vips->where(array('id' => $xibi_id, 'types' => 1))->field("nums,gold,tian")->find();

        if (!empty($xq)) {
            if($xibi['level']==3){
                $this->ajaxReturn(array('status' => 300, 'msg' => '等您的vip到期后再续吧'));
            }
            $xibilog = M("xibilog");
            $data['user_id'] = $user_id;
            $data['addtime'] = time();
            $data['order_no'] = "SJ" . time() . mt_rand("100,999");
            $data['status'] = 1;
            $data['types'] = 3;//升级vip
            $data['type'] = 2;//微信
            $data['price'] = $xq['gold'];

            $data['transnum'] = $xq['nums'];
            $data['tian'] = $xq['tian'];
            $data['content'] = "升级vip".$xq['tian']."天";
            $data['xibi'] = $xibi['xiazai'] + $xq['nums'];//下载此次
            $xibilog->add($data);
            $order_no = $data['order_no'];
            // 导入微信支付sdk
            Vendor('Weixinpay.Weixinpay');
            $wxpay = new \Weixinpay();
            $prices = $data['price']*100;
            $data = $wxpay->getParameters($order_no, $prices, '');
            if (!empty($data)) {
                $this->ajaxReturn(array('status' => '200', 'data' => $data));
            } else {
                $this->ajaxReturn(array('status' => '300', 'msg' => '未查询到订单'));
            }

        } else {
            $this->ajaxReturn(array('status' => 300, 'msg' => '升级vip选项错误'));
        }


    } else {
        $this->ajaxReturn(array('status' => 300, 'msg' => '用户不存在'));
    }
}




    }

}
