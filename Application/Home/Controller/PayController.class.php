<?php
namespace Home\Controller;
use Think\Controller;
class PayController extends Controller {


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
                $xq=$vips->where(array('id'=>$xibi_id,'types'=>2))->field("nums,gold,tian")->find();
                if(!empty($xq)){
                    $xibilog=M("xibilog");
                    $data['user_id']=$user_id;
                    $data['addtime']=time();
                    $data['order_no']="CZ".time().mt_rand("100,999");
                    $data['status']=1;
                    $data['types']=1;//充值
                    $data['price']=$xq['gold'];
                    $data['content']="购买戏币";
                    $data['transnum']=$xq['nums'];
                    $data['xibi']=$xibi['xibi']+$xq['nums'];
                    $xibilog->add($data);
                    $order_no = $data['order_no'];
                    vendor('Alipay.AopSdk');
                    Vendor('Alipay.aop.AopClient');
                    $aop = new \AopClient;
                    $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
                    $aop->appId = "2017072407877890";
                    $aop->rsaPrivateKey = "MIIEpAIBAAKCAQEAqRC0Yj43jSYTJySJhjriBBKxYisqfGvlNW8DOwq1tJvDc/U/aZR4h66ECtWpBAI3OzvJpBfihBkmhVhAKoL0eRcJVpzHuvMpR6wKQksiCqNJHaj+AiRrYHLHcPAqIPxn41YkHxk9vsrmjyhja+MPKPrMxoEIHsP292JBvacYTBQSotgUdGa5OmyuRQ5nd33dIAISMirLr+I6JfBnw+g0S7LIn8z6bhZv2glPJbyUhmF0pwiydJx4XYAJ0ehn0JhmbFxobi8jnC7ImV8FN99xQhSchhPBunyxeoaGhIihtvGUN2GTfc5JOy94y8MW39ab/1YZmH2Hc+te3k5accL6RwIDAQABAoIBAQCNOlEVCFgrZrT1K8ZeBO4s7NiU4u44xYDRJA0U0xt65eteAG6aadZNsXDIBDeOC7PLnWQR2Yn1Q3U0SsY/POmwBZhda9ZEyz+eiY6AVnb3X/OB/VtCut2f0gHczCLFL1QxShIekF1N9fynddunkiNl3iwVXlBEMvspKEE2hlD7qyROCz/AZmWDeAepPkMctOq96Hysq8PUxzhQHLWgvFda9sQqTiDD7Dxqbiz/KrFA8yARMcbyTCRodn6Csa/TkeNSlRFtuEQNxBqUc1AG016ZW8g8xvYLaEM+GwfOiMvEGnSFSONMOw51kffE1UhjDCt+y8pl/+tia3fKsXFRZrUhAoGBAODZoKu9LM/45FdXNUnduuqoC3R/cYLmtFQuX1ENiEYX6+wULGGCkgZ35U0dGyTAMWfkZ6bFgF2rdQuUBN6OEk1kDfJi5kh/zY31yUh93Yw2rcfCwEUPwB9pNk0Fpv5LK4Xb6zV6v9sVwfOuspxKX4kIJPqr3eGPJoQh7j3jLnMZAoGBAMB8psIdptZrzpkUyDIYpzOVrdyklyVpuZj7cXN/vSTs+r4gdUqQ+4LpdySfHDroSy93EDmTSBp8pYQt+GYPtHGKTSbYZBJ1H3PtsWFdDtJ+3PiUYaR6VkzjF9cQnXykaPhL5MJDXs9VCcy4X284IthLUalBQD0qSjLCPi5xpORfAoGABK7jttAA3/AKKXuKg5hXrU2Et49z+Mr/VIWGvLRwcy1KX6dn6TwD+JiEsR97Ej/ih4xtUD7q1oicrnoNw+jnnq8Hz1WaAEaRLHTDFXxxodr9sZxvzsBuOvlBBUep28ALDwWul3WQC2sfmAi6daDi7oK56nKr82e84KGoSaeyrvkCgYEAqu9HS4T3ftz39/t7mPlJqkaWwiUr0F6mIhPQ+SeL+Xm1Zhf+8Pv1TpkzY8MkV6+n7PvH3clMM7FTbyE/wKrbrCSMRR3PKJD4IIQJjJQOMKHWa62hVGYLs3XL2wH3SRPb3/vNpzIaxPYYoMNuhJ8OWpPwbeTzPh4LDC5w99+V9fMCgYAkMVfQ6IhnGWdrS13e+erdZF/APTW7POHZsVg+0z+7sYRVwhroVEPoFNxWBeIiXL0H57VWaxcEaDTfC0ZkRSBSimw3ieSYHEzgJsP+05hnURvmjBY7J+p3AYzc5RhZ2Kt0HEnIFDW2x6g/BN34eyJOm2FhQSWbw8HJjgFfMS+bsA==";

                    $aop->format = "json";
                    $aop->charset = "UTF-8";
                    $aop->signType = "RSA2";
                    $aop->alipayrsaPublicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqRC0Yj43jSYTJySJhjriBBKxYisqfGvlNW8DOwq1tJvDc/U/aZR4h66ECtWpBAI3OzvJpBfihBkmhVhAKoL0eRcJVpzHuvMpR6wKQksiCqNJHaj+AiRrYHLHcPAqIPxn41YkHxk9vsrmjyhja+MPKPrMxoEIHsP292JBvacYTBQSotgUdGa5OmyuRQ5nd33dIAISMirLr+I6JfBnw+g0S7LIn8z6bhZv2glPJbyUhmF0pwiydJx4XYAJ0ehn0JhmbFxobi8jnC7ImV8FN99xQhSchhPBunyxeoaGhIihtvGUN2GTfc5JOy94y8MW39ab/1YZmH2Hc+te3k5accL6RwIDAQAB";

                    //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
                    Vendor('Alipay.aop.request.AlipayTradeAppPayRequest');
                    $request = new \AlipayTradeAppPayRequest();

                    $bizcontent = json_encode(array(
                        'body'=>$data['content'],
                        'out_trade_no'=>$order_no,
                        'total_amount'=>$data['price'],
                        'product_code'=>'QUICK_MSECURITY_PAY',
                        'subject'=>$data['content'],
                    ));
                    $alipay_config['notify_url']="http://".$_SERVER['HTTP_HOST']."/index.php/Home/Pay/notify_url";
                    $request->setNotifyUrl($alipay_config['notify_url']);
                    $request->setBizContent($bizcontent);
                    //这里和普通的接口调用不同，使用的是sdkExecute
                    $response = $aop->sdkExecute($request);
                    //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
//        $response= htmlspecialchars($response);///就是orderString 可以直接给客户端请求，无需再做处理。
                    $this->ajaxReturn(array('status'=>200,'data'=>$response));
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
                    $data['type'] = 1;//微信
                    $data['price'] = $xq['gold'];
                    $data['tian'] = $xq['tian'];
                    $data['content'] = "升级vip".$xq['tian']."天";
                    $data['transnum'] = $xq['nums'];
                    $data['xibi'] = $xibi['xiazai'] + $xq['nums'];//下载此次
                    $xibilog->add($data);
                    $order_no = $data['order_no'];

                    vendor('Alipay.AopSdk');
                    Vendor('Alipay.aop.AopClient');
                    $aop = new \AopClient;
                    $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
                    $aop->appId = "2017072407877890";
                    $aop->rsaPrivateKey = "MIIEpAIBAAKCAQEAqRC0Yj43jSYTJySJhjriBBKxYisqfGvlNW8DOwq1tJvDc/U/aZR4h66ECtWpBAI3OzvJpBfihBkmhVhAKoL0eRcJVpzHuvMpR6wKQksiCqNJHaj+AiRrYHLHcPAqIPxn41YkHxk9vsrmjyhja+MPKPrMxoEIHsP292JBvacYTBQSotgUdGa5OmyuRQ5nd33dIAISMirLr+I6JfBnw+g0S7LIn8z6bhZv2glPJbyUhmF0pwiydJx4XYAJ0ehn0JhmbFxobi8jnC7ImV8FN99xQhSchhPBunyxeoaGhIihtvGUN2GTfc5JOy94y8MW39ab/1YZmH2Hc+te3k5accL6RwIDAQABAoIBAQCNOlEVCFgrZrT1K8ZeBO4s7NiU4u44xYDRJA0U0xt65eteAG6aadZNsXDIBDeOC7PLnWQR2Yn1Q3U0SsY/POmwBZhda9ZEyz+eiY6AVnb3X/OB/VtCut2f0gHczCLFL1QxShIekF1N9fynddunkiNl3iwVXlBEMvspKEE2hlD7qyROCz/AZmWDeAepPkMctOq96Hysq8PUxzhQHLWgvFda9sQqTiDD7Dxqbiz/KrFA8yARMcbyTCRodn6Csa/TkeNSlRFtuEQNxBqUc1AG016ZW8g8xvYLaEM+GwfOiMvEGnSFSONMOw51kffE1UhjDCt+y8pl/+tia3fKsXFRZrUhAoGBAODZoKu9LM/45FdXNUnduuqoC3R/cYLmtFQuX1ENiEYX6+wULGGCkgZ35U0dGyTAMWfkZ6bFgF2rdQuUBN6OEk1kDfJi5kh/zY31yUh93Yw2rcfCwEUPwB9pNk0Fpv5LK4Xb6zV6v9sVwfOuspxKX4kIJPqr3eGPJoQh7j3jLnMZAoGBAMB8psIdptZrzpkUyDIYpzOVrdyklyVpuZj7cXN/vSTs+r4gdUqQ+4LpdySfHDroSy93EDmTSBp8pYQt+GYPtHGKTSbYZBJ1H3PtsWFdDtJ+3PiUYaR6VkzjF9cQnXykaPhL5MJDXs9VCcy4X284IthLUalBQD0qSjLCPi5xpORfAoGABK7jttAA3/AKKXuKg5hXrU2Et49z+Mr/VIWGvLRwcy1KX6dn6TwD+JiEsR97Ej/ih4xtUD7q1oicrnoNw+jnnq8Hz1WaAEaRLHTDFXxxodr9sZxvzsBuOvlBBUep28ALDwWul3WQC2sfmAi6daDi7oK56nKr82e84KGoSaeyrvkCgYEAqu9HS4T3ftz39/t7mPlJqkaWwiUr0F6mIhPQ+SeL+Xm1Zhf+8Pv1TpkzY8MkV6+n7PvH3clMM7FTbyE/wKrbrCSMRR3PKJD4IIQJjJQOMKHWa62hVGYLs3XL2wH3SRPb3/vNpzIaxPYYoMNuhJ8OWpPwbeTzPh4LDC5w99+V9fMCgYAkMVfQ6IhnGWdrS13e+erdZF/APTW7POHZsVg+0z+7sYRVwhroVEPoFNxWBeIiXL0H57VWaxcEaDTfC0ZkRSBSimw3ieSYHEzgJsP+05hnURvmjBY7J+p3AYzc5RhZ2Kt0HEnIFDW2x6g/BN34eyJOm2FhQSWbw8HJjgFfMS+bsA==";

                    $aop->format = "json";
                    $aop->charset = "UTF-8";
                    $aop->signType = "RSA2";
                    $aop->alipayrsaPublicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqRC0Yj43jSYTJySJhjriBBKxYisqfGvlNW8DOwq1tJvDc/U/aZR4h66ECtWpBAI3OzvJpBfihBkmhVhAKoL0eRcJVpzHuvMpR6wKQksiCqNJHaj+AiRrYHLHcPAqIPxn41YkHxk9vsrmjyhja+MPKPrMxoEIHsP292JBvacYTBQSotgUdGa5OmyuRQ5nd33dIAISMirLr+I6JfBnw+g0S7LIn8z6bhZv2glPJbyUhmF0pwiydJx4XYAJ0ehn0JhmbFxobi8jnC7ImV8FN99xQhSchhPBunyxeoaGhIihtvGUN2GTfc5JOy94y8MW39ab/1YZmH2Hc+te3k5accL6RwIDAQAB";

                    //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
                    Vendor('Alipay.aop.request.AlipayTradeAppPayRequest');
                    $request = new \AlipayTradeAppPayRequest();

                    $bizcontent = json_encode(array(
                        'body'=>$data['content'],
                        'out_trade_no'=>$order_no,
                        'total_amount'=>$data['price'],
                        'product_code'=>'QUICK_MSECURITY_PAY',
                        'subject'=>$data['content'],
                    ));
                    $alipay_config['notify_url']="http://".$_SERVER['HTTP_HOST']."/index.php/Home/Pay/notify_url";
                    $request->setNotifyUrl($alipay_config['notify_url']);
                    $request->setBizContent($bizcontent);
                    //这里和普通的接口调用不同，使用的是sdkExecute
                    $response = $aop->sdkExecute($request);
                    //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
//        $response= htmlspecialchars($response);///就是orderString 可以直接给客户端请求，无需再做处理。
                    $this->ajaxReturn(array('status'=>200,'data'=>$response));

                } else {
                    $this->ajaxReturn(array('status' => 300, 'msg' => '升级vip选项错误'));
                }




            }else{
                $this->ajaxReturn(array('status'=>300,'msg'=>'用户不存在'));
            }





        }





    }

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

 public function notify_url2(){

        Vendor('Alipay.aop.AopClient');
        $aop = new \AopClient;
        $aop->alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqRC0Yj43jSYTJySJhjriBBKxYisqfGvlNW8DOwq1tJvDc/U/aZR4h66ECtWpBAI3OzvJpBfihBkmhVhAKoL0eRcJVpzHuvMpR6wKQksiCqNJHaj+AiRrYHLHcPAqIPxn41YkHxk9vsrmjyhja+MPKPrMxoEIHsP292JBvacYTBQSotgUdGa5OmyuRQ5nd33dIAISMirLr+I6JfBnw+g0S7LIn8z6bhZv2glPJbyUhmF0pwiydJx4XYAJ0ehn0JhmbFxobi8jnC7ImV8FN99xQhSchhPBunyxeoaGhIihtvGUN2GTfc5JOy94y8MW39ab/1YZmH2Hc+te3k5accL6RwIDAQAB';
//        F('post',json_encode($_POST));
        $flag = $aop->rsaCheckV1($_POST, NULL, "RSA2");
        F('flag',$flag);
            //验证成功
            //这里可以做一下你自己的订单逻辑处理
            $order_no = $_POST['out_trade_no'];
            //查找订单
            $order = D('rechargerecord')->where(array('order_no'=>$order_no))->select();

//            if(!$order['status']){

                //更改订单状态
                D('rechargerecord')->where(array('order_no'=>$order_no))->save(array('status'=>"03",'type'=>2));
                //用户购买数量增加
     foreach ($order as &$b){
         D('healthyshop')->where(array('id'=>$b['product_id']))->setInc('nums',$b['num']);
     }
//            }
     $ret['status'] = 200;
     $ret['msg'] = '成功';
     $this->ajaxReturn($ret);
            //
            echo 'success';//这个必须返回给支付宝，响应个支付宝，

        //$flag返回是的布尔值，true或者false,可以根据这个判断是否支付成功
    }

public function changge_status(){
    $request = getClientRequest();
    $order_no = $request['order_no'];
    $type = $request['type'];
    $ddd['status']="03";
    $ddd['type']=$type;
    $rechargerecord=M('rechargerecord');
    $rechargerecord->where(array('order_no'=>$order_no))->save($ddd);
    $order =$rechargerecord->where(array('order_no'=>$order_no))->select();
    foreach ($order as &$v){
        M('healthyshop')->where(array('id'=>$v['product_id']))->setInc('nums',$v['num']);
        M('myyouhui')->where(array('user_id'=>$v['user_id'],'youhui_id'=>$v['youhui_id']))->setField('status',2);
    }

    $ret['status'] = 200;
    $ret['msg'] = '成功';
    $this->ajaxReturn($ret);

}





}