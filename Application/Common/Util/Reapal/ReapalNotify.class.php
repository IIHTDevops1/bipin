<?php
/**
 * 平台：融宝支付
 * 功能：付款过程中服务器通知类
 * 详细：该页面是通知返回核心处理文件，不需要修改
 * User: 隋涛
 * Date: 2015/6/11
 * Time: 15:28
 */
namespace Common\Util\Reapal;
use Think\Model;


class ReapalNotify{

    private $gateway;           //网关地址
    private $_key;  			//安全校验码
    private $merchant_ID;           //合作伙伴ID
    private $sign_type;         //签名方式 系统默认
    private $mysign;            //签名结果
    private $charset;    //字符编码格式
    private $transport;         //访问模式


    /**
     * 初始化函数
     * 从配置文件中初始化变量
     * @param $merchant_ID 合作身份者ID
     * @param $key  安全校验码
     * @param $sign_type 签名类型
     * @param string $charset 字符编码格式
     * @param string $transport 访问模式
     */
    function init($merchant_ID,$key,$sign_type,$charset = "GBK",$transport= "http")
    {

        $this->transport = $transport;
        if($this->transport == "https")
        {
            $this->gateway = "";
        }
        else
        {
            $this->gateway = "http://interface.reapal.com/verify/notify?";
        }
        $this->merchant_ID          = $merchant_ID;
        $this->_key    			= $key;
        $this->mysign           = "";
        $this->sign_type	    = $sign_type;
        $this->charset   = $charset;
    }

    /**
     * 对notify_url的认证
     * 返回的验证结果：true/false
     */
    function notify_verify()
    {
        //获取远程服务器ATN结果，验证是否是融宝支付服务器发来的请求
        if($this->transport == "https")
        {
            $veryfy_url = $this->gateway. "service=notify_verify" ."&merchant_ID=" .$this->merchant_ID. "&notify_id=".$_POST["notify_id"];
        }
        else
        {
            $veryfy_url = $this->gateway. "merchant_ID=".$this->merchant_ID."&notify_id=".$_POST["notify_id"];
        }
        $veryfy_result = file_get_contents($veryfy_url);

        if(empty($_POST))
        {							//判断POST来的数组是否为空
            return false;
        }
        else
        {
            $post          = para_filter($_POST);	//对所有POST返回的参数去空
            $sort_post     = arg_sort($post);	    //对所有POST反馈回来的数据排序
            $this->mysign  = build_mysign($sort_post,$this->_key,$this->sign_type);   //生成签名结果

            //判断veryfy_result是否为ture，生成的签名结果mysign与获得的签名结果sign是否一致
            //$veryfy_result的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
            //mysign与sign不等，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
            if (preg_match("/true$/i",$veryfy_result) && $this->mysign == $_POST["sign"])
            {
                return true;
            }
            else
            {
                return false;
            }
        }

    }

    /**对return_url的认证
     *return 验证结果：true/false
     */

    function return_verify()
    {
        //获取远程服务器ATN结果，验证是否是融宝支付服务器发来的请求
        if($this->transport == "https")
        {
            $veryfy_url = $this->gateway. "service=notify_verify" ."&merchant_ID=" .$this->merchant_ID. "&notify_id=".$_POST["notify_id"];
        }
        else
        {
            $veryfy_url = $this->gateway. "merchant_ID=".$this->merchant_ID."&notify_id=".$_POST["notify_id"];
        }

        $veryfy_result =file_get_contents($veryfy_url);

        //生成签名结果
        if(empty($_POST))
        {							//判断GET来的数组是否为空
            return false;
        }
        else
        {
            $post          = para_filter($_POST);	    //对所有GET反馈回来的数据去空
            $sort_post     = arg_sort($post);		    //对所有GET反馈回来的数据排序
            $this->mysign  = build_mysign($sort_post,$this->_key,$this->sign_type);    //生成签名结果


            //判断veryfy_result是否为ture，生成的签名结果mysign与获得的签名结果sign是否一致
            //$veryfy_result的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
            //mysign与sign不等，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
            if (preg_match("/true$/i",$veryfy_result) && $this->mysign == $_POST["sign"])
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    /**获取远程服务器ATN结果
     *$url 指定URL路径地址
     *return 服务器ATN结果集
     */

    function get_verify($url,$time_out = "60")
    {
        $urlarr     = parse_url($url);
        $errno      = "";
        $errstr     = "";
        $transports = "";
        if($urlarr["scheme"] == "https")
        {
            $transports = "ssl://";
            $urlarr["port"] = "443";
        }
        else
        {
            $transports = "tcp://";
            $urlarr["port"] = "18183";
        }
        $fp=@fsockopen($transports . $urlarr['host'],$urlarr['port'],$errno,$errstr,$time_out);
        if(!$fp)
        {
            die("ERROR: $errno - $errstr<br />\n");
        }
        else
        {
            fputs($fp, "POST ".$urlarr["path"]." HTTP/1.1\r\n");
            fputs($fp, "Host: ".$urlarr["host"]."\r\n");
            fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
            fputs($fp, "Content-length: ".strlen($urlarr["query"])."\r\n");
            fputs($fp, "Connection: close\r\n\r\n");
            fputs($fp, $urlarr["query"] . "\r\n\r\n");
            while(!feof($fp))
            {
                $info[]=@fgets($fp, 1024);
            }
            fclose($fp);
            $info = implode(",",$info);
            return $info;
        }
    }
}