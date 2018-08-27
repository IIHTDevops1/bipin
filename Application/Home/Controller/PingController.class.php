<?php
namespace Home\Controller;
use Think\Controller;
class PingController extends Controller {


    protected function _initialize()
    {

    }



    function pay(){
        $reques = getClientRequest();


        $user_id = $reques['user_id'];
        $xibi_id = $reques['xibi_id'];
        $type = $reques['type'];

        $user=M("user");
        if($type==1){
            //戏币充值
            $xibi = $user->where(array('user_id' => $user_id))->field("xibi")->find();//现有的戏币
            if(!empty($xibi)){
                $vips=M("vips");
                $xq=$vips->where(array('pingid'=>$xibi_id,'types'=>2))->field("nums,gold,tian")->find();
                if(!empty($xq)){
                    $xibilog=M("xibilog");
                    $data['user_id']=$user_id;
                    $data['addtime']=time();
                    $data['order_no']="CZ".time().mt_rand("100,999");
                    $data['status']=1;
                    $data['type']=3;//苹果内购
                    $data['types']=1;//充值
                    $data['price']=$xq['gold'];
                    $data['content']="购买戏币";
                    $data['transnum']=$xq['nums'];
                    $data['xibi']=$xibi['xibi']+$xq['nums'];
                    $xibilog->add($data);
                    $order_no = $data['order_no'];
                    $this->ajaxReturn(array('status'=>200,'data'=>array('order_no'=>$order_no,'pingid'=>$xibi_id)));
                }else{
                    $this->ajaxReturn(array('status'=>300,'msg'=>'充值选项错误'));
                }
            }else{
                $this->ajaxReturn(array('status'=>300,'msg'=>'用户不存在'));
            }
        }else{
            //购买vip升级
            $xibi = $user->where(array('user_id' => $user_id))->field("level,xiazai")->find();//现有的戏币
            if(!empty($xibi)){
                $vips = M("vips");
                $xq = $vips->where(array('pingid' => $xibi_id, 'types' => 1))->field("nums,gold,tian")->find();
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
                    $data['type']=3;//苹果内购
                    $data['price'] = $xq['gold'];
                    $data['tian'] = $xq['tian'];
                    $data['content'] = "升级vip".$xq['tian']."天";
                    $data['transnum'] = $xq['nums'];
                    $data['xibi'] = $xibi['xiazai'] + $xq['nums'];//下载此次
                    $xibilog->add($data);
                    $order_no = $data['order_no'];
                    $this->ajaxReturn(array('status'=>200,'data'=>array('order_no'=>$order_no,'pingid'=>$xibi_id)));
                } else {
                    $this->ajaxReturn(array('status' => 300, 'msg' => '升级vip选项错误'));
                }
            }else{
                $this->ajaxReturn(array('status'=>300,'msg'=>'用户不存在'));
            }





        }





    }

    /**
     * 验证AppStore内付
     * @param  string $receipt_data 付款后凭证
     * @return array                验证是否成功
     */
    function validate_apple_pay($receipt_data)
    {
        /**
         * 21000 App Store不能读取你提供的JSON对象
         * 21002 receipt-data域的数据有问题
         * 21003 receipt无法通过验证
         * 21004 提供的shared secret不匹配你账号中的shared secret
         * 21005 receipt服务器当前不可用
         * 21006 receipt合法，但是订阅已过期。服务器接收到这个状态码时，receipt数据仍然会解码并一起发送
         * 21007 receipt是Sandbox receipt，但却发送至生产系统的验证服务
         * 21008 receipt是生产receipt，但却发送至Sandbox环境的验证服务
         */
        function acurl($receipt_data, $sandbox=0){
            //小票信息
            $secret = "fc5ff7920a5041b9a2918dc52d157b6c";    // APP固定密钥，在itunes中获取
            $POSTFIELDS = array("receipt-data" => $receipt_data,'password'=>$secret);
            $POSTFIELDS = json_encode($POSTFIELDS);

            //正式购买地址 沙盒购买地址
            $url_buy     = "https://buy.itunes.apple.com/verifyReceipt";
            $url_sandbox = "https://sandbox.itunes.apple.com/verifyReceipt";
//            $url = $sandbox ? $url_sandbox : $url_buy;
            $url = $sandbox ? $url_buy : $url_sandbox;


            //简单的curl
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $POSTFIELDS);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        }

        // 验证参数
        if (strlen($receipt_data)<20){
            $result=array(
                'status'=>false,
                'msg'=>'非法参数'
            );
            return $result;
        }
        // 请求验证
        $html = acurl($receipt_data);
        $data = json_decode($html,true);

        // 如果是沙盒数据 则验证沙盒模式
        if($data['status']=='21007'){
            // 请求验证
            $html = acurl($receipt_data, 1);
            $data = json_decode($html,true);
            $data['sandbox'] = '1';
        }

        if (isset($_GET['debug'])) {
            exit(json_encode($data));
        }

        // 判断是否购买成功
        if(intval($data['status'])===0){
            $result=array(
                'status'=>true,
                'msg'=>'购买成功'
            );
        }else{
            $result=array(
                'status'=>false,
                'msg'=>'购买失败 status:'.$data['status']
            );
        }
        return $result;
    }

    public function verify()
    {
        $reques = getClientRequest();
        $order_no = $reques['order_no'];
        $user_id = $reques['user_id'];
        $xibilog=M("xibilog");
        $order = $xibilog->where(array('order_no'=>$order_no,'user_id'=>$user_id))->find();
        if(!empty($order)){
            if($order['status']==2){
                $message = "订单已支付";
                $status  = "300";//支付成功
                $result['status']  = $status;
                $result['msg'] = $message;

                $this->ajaxReturn($result);
            }

        }else{
            $message = "订单号与用户不匹配";
            $status  = "500";//支付成功
            $result['status']  = $status;
            $result['msg'] = $message;

            $this->ajaxReturn($result);
        }


        //苹果内购的验证收据
        $apple_receipt = $reques['apple_receipt'];
        // 判断是否缺少参数
        if ( empty($order_no) || empty($user_id) || empty($apple_receipt) ) {
            $message = "缺少请求参数";
            $status = "400";
        } else {
            // 代码思路
            // 1. 判断订单是否存在并且有效
            // 2. 判断用户是否存在
            // 3. 调用苹果支付凭证验证函数

            $verify_result = $this->validate_apple_pay($apple_receipt);

            // 4.判断验证结果

            if( $verify_result['status'] ) {     // 凭证验证成功


                //查找订单

                        $xibilog->where(array('order_no'=>$order_no))->save(array('addtime'=>time(),'status'=>"2",'type'=>1));
                        if($order['types']==1){
                            D('user')->where(array('user_id'=>$order['user_id']))->setInc('xibi',$order['transnum']);
                        }elseif($order['types']==3){

                            $ddd['level']=3;
                            $ddd['vipstart']=time();
                            $ddd['vipend']=time()+3600*$order['tian'];
                            $ddd['xiazai']=$order['transnum'];//充值的时候直接为购买的次数
                            D('user')->where(array('user_id'=>$order['user_id']))->save($ddd);

                        }

                        // 其他code,修改订单状态、购买商品状态……

                        $message = "支付成功";
                        $status  = "200";//支付成功





            } else {                            // 凭证验证失败
                $status  = "401";
                $message = "验证失败";
            }
        }
        // 返回接口数据
//        $result = array();
//        if( !empty($apple_receipt) ) {
//            $result['verify_result'] = $verify_result['message'];
//            $result['apple_receipt'] = $apple_receipt;
//        }
        $result['status']  = $status;
        $result['msg'] = $message;

        $this->ajaxReturn($result);  //以json方式返回数据
    }



///之前的
    public function notify_url(){
        Vendor('Alipay.aop.AopClient');
        $aop = new \AopClient;
        $aop->alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqRC0Yj43jSYTJySJhjriBBKxYisqfGvlNW8DOwq1tJvDc/U/aZR4h66ECtWpBAI3OzvJpBfihBkmhVhAKoL0eRcJVpzHuvMpR6wKQksiCqNJHaj+AiRrYHLHcPAqIPxn41YkHxk9vsrmjyhja+MPKPrMxoEIHsP292JBvacYTBQSotgUdGa5OmyuRQ5nd33dIAISMirLr+I6JfBnw+g0S7LIn8z6bhZv2glPJbyUhmF0pwiydJx4XYAJ0ehn0JhmbFxobi8jnC7ImV8FN99xQhSchhPBunyxeoaGhIihtvGUN2GTfc5JOy94y8MW39ab/1YZmH2Hc+te3k5accL6RwIDAQAB';


            //验证成功
            //这里可以做一下你自己的订单逻辑处理
            $order_no = $_POST['out_trade_no'];
            $xibilog=M("xibilog");
            //查找订单
            $order = $xibilog->where(array('order_no'=>$order_no))->find();
        $xibilog->where(array('order_no'=>$order_no))->save(array('addtime'=>time(),'status'=>"2",'type'=>1));
        if($order['types']==1){
            D('user')->where(array('user_id'=>$order['user_id']))->setInc('xibi',$order['transnum']);
        }elseif($order['types']==3){

//            D('user')->where(array('user_id'=>$order['user_id']))->setInc('xiazai',$order['transnum']);
            $ddd['level']=3;
            $ddd['vipstart']=time();
            $ddd['vipend']=time()+3600*$order['tian'];
            $ddd['xiazai']=$order['transnum'];//充值的时候直接为购买的次数
            D('user')->where(array('user_id'=>$order['user_id']))->save($ddd);

        }

            echo 'success';//这个必须返回给支付宝，响应个支付宝，

        //$flag返回是的布尔值，true或者false,可以根据这个判断是否支付成功
    }






}