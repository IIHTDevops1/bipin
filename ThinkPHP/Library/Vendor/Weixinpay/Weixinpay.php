<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

// 定义时区
ini_set('date.timezone','Asia/Shanghai');

class Weixinpay {
    // 定义配置项
    private $config=array(
        'APPID'              => "wxd73b1a678e28cab3", // 微信支付APPID
//        'MCHID'              => "1485652722", // 微信支付MCHID 商户收款账号
        'MCHID'              => "1498203452", // 微信支付MCHID 商户收款账号
        'KEY'                => "dhsjahdjkahjk13d6e78aedSDsaanagd", // 微信支付KEY
        'APPSECRET'          => "ea30051ddb69e4aeee9cf03a0789fc7c",  //公众帐号secert
        'NOTIFY_URL'         => "", // 接收支付状态的连接  改成自己的域名
        );

    // 构造函数
    public function __construct(){
        // 如果是在thinkphp中 那么需要补全/Application/Common/Conf/config.php中的配置
        // 如果不是在thinkphp框架中使用；那么注释掉下面一行代码；直接补全 private $config 即可
//        $this->config=C('WEIXINPAY_CONFIG');

    }

    /**
     * 统一下单
     * @param  array $order 订单 必须包含支付所需要的参数 body(产品描述)、total_fee(订单金额)、out_trade_no(订单号)、product_id(产品id)、trade_type(类型：JSAPI，NATIVE，APP)
     */
    public function unifiedOrder($order){
        // 获取配置项
//        $weixinpay_config=$this->config;
        $config=array(
            'appid'=>"wxd73b1a678e28cab3",
            'mch_id'=>"1498203452",
            'nonce_str'=>$this->getRandom(32),
            'spbill_create_ip'=>'192.168.0.1',
            'notify_url'=>"http://".$_SERVER['HTTP_HOST']."/index.php/Home/Wxpay/notify"
            );
        // 合并配置数据和订单数据
        $data=array_merge($order,$config);
//        var_dump($data);
//        dump($data);
//die;
        $sign=$this->makeSign($data);
   
        //dump($sign);die;
        $data['sign']=$sign;
        $xml=$this->toXml($data);
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';//接收xml数据的文件
        $header[] = "Content-type: text/xml";//定义content-type为xml,注意是数组
        $ch = curl_init ($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 兼容本地没有指定curl.cainfo路径的错误
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $response = curl_exec($ch);
        //dump($response);die;
        if(curl_errno($ch)){
            // 显示报错信息；终止继续执行
            die(curl_error($ch));
        }
        curl_close($ch);
        $result=$this->toArray($response);
//        dump($result);die;
        // 显示错误信息
        if ($result['return_code']=='FAIL') {
            die($result['return_msg']);
        }
        $result['sign']=$sign;
        $result['nonce_str']=$this->getRandom(32);
        return $result;
    }
    function getRandom($param){
    $str="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $key = "";
    for($i=0;$i<$param;$i++)
     {
         $key .= $str{mt_rand(0,32)};    //生成php随机数
     }
     return $key;
    }

    /**
     * 验证
     * @return array 返回数组格式的notify数据
     */
    public function notify(){
        // 获取xml
        $xml=file_get_contents('php://input', 'r'); 
        // 转成php数组
        $data=$this->toArray($xml);
        // 保存原sign
        $data_sign=$data['sign'];
       // dump($data_sign);die;
        // sign不参与签名
        unset($data['sign']);
        $sign=$this->makeSign($data);
        // 判断签名是否正确  判断支付状态
        if ($sign===$data_sign && $data['return_code']=='SUCCESS' && $data['result_code']=='SUCCESS') {
            $result=$data;
        }else{
            $result=false;
        }
        // 返回状态给微信服务器
        if ($result) {
            $str='<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
        }else{
            $str='<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[签名失败]]></return_msg></xml>';
        }
        echo $str;
        return $result;
    }

    /**
     * 输出xml字符
     * @throws WxPayException
    **/
    public function toXml($data){
        if(!is_array($data) || count($data) <= 0){
            throw new WxPayException("数组数据异常！");
        }
        $xml = "<xml>";
        foreach ($data as $key=>$val){
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml; 
    }

    /**
     * 生成签名
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    public function makeSign($data){
        // 去空
        $data=array_filter($data);
        //签名步骤一：按字典序排序参数
        ksort($data);
        $string_a=http_build_query($data);
        $string_a=urldecode($string_a);
        //签名步骤二：在string后加入KEY
        $config=$this->config;
        $string_sign_temp=$string_a."&key=".$config['KEY'];
        //签名步骤三：MD5加密
        $sign = md5($string_sign_temp);
        // 签名步骤四：所有字符转为大写
        $result=strtoupper($sign);
       // dump($result);die;
        return $result;
    }

    /**
     * 将xml转为array
     * @param  string $xml xml字符串
     * @return array       转换得到的数组
     */
    public function toArray($xml){   
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $result= json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);        
        return $result;
    }

    /**
     * 获取jssdk需要用到的数据
     * @return array jssdk需要用到的数据
     */
    public function getParameters($orderNum,$total,$openid){
        // 获取配置项
        $config=$this->config;

            // 订单数据  请根据订单号out_trade_no 从数据库中查出实际的body、total_fee、out_trade_no、product_id
            $order=array(
                'body'=>'购物商城',// 商品描述（需要根据自己的业务修改）
                'total_fee'=>$total,// 订单金额  以(分)为单位（需要根据自己的业务修改）
                'out_trade_no'=>$orderNum,// 订单号（需要根据自己的业务修改）
                'product_id'=>'1',// 商品id（需要根据自己的业务修改）
                'trade_type'=>'APP',// JSAPI公众号支付
                /*'openid'=>$openid*/// 获取到的openid
            );
            // 统一下单 获取prepay_id
            $unified_order=$this->unifiedOrder($order);
            // 获取当前时间戳
            $time=time();
            // 组合jssdk需要用到的数据
            $data=array(
                'appid'=>"wxd73b1a678e28cab3", //appid
                'timestamp'=>$time, //时间戳
                'noncestr'=>$unified_order['nonce_str'],// 随机字符串
                'prepayid'=>$unified_order['prepay_id'],// 预支付交易会话标识
                'package'=>"Sign=WXPay",
                'partnerid'=>"1498203452",
                /*'signType'=>'MD5'*///加密方式
            );
            // 生成签名
            $data['sign']=$this->makeSign($data);
            return $data;
    }

    /**
     * 生成支付二维码
     * @param  array $order 订单 必须包含支付所需要的参数 body(产品描述)、total_fee(订单金额)、out_trade_no(订单号)、product_id(产品id)、trade_type(类型：JSAPI，NATIVE，APP)
     */
    public function pay($order){
        $result=$this->unifiedOrder($order);
        $decodeurl=urldecode($result['code_url']);
        qrcode($decodeurl);
    }

    /**
     * curl 请求http
     */
    public function curl_get_contents($url){
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);                //设置访问的url地址
        // curl_setopt($ch,CURLOPT_HEADER,1);               //是否显示头部信息
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);               //设置超时
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);   //用户访问代理 User-Agent
        curl_setopt($ch, CURLOPT_REFERER,$_SERVER['HTTP_HOST']);        //设置 referer
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);          //跟踪301
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //返回结果
        $r=curl_exec($ch);
        curl_close($ch);
        return $r;
    }




}
