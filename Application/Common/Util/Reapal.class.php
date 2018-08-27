<?php
/**
 * 融宝支付SDK
 * User: 隋涛
 * Date: 2015/6/11
 * Time: 11:14
 */


namespace Common\Util;
use Think\Model;


class Reapal{
    private $gateway;			//网关地址
    private $_key;				//安全校验码
    private $mysign;			//签名结果
    private $sign_type;			//签名类型
    private $parameter;			//需要签名的参数数组
    private $charset;           //字符编码格式

    /**构造函数
     *从配置文件及入口文件中初始化变量
     *$parameter 需要签名的参数数组
     *$key 安全校验码
     *$sign_type 签名类型
     */

    function init($parameter,$key,$sign_type)
    {
        $this->gateway		= "https://epay.reapal.com/portal?";
        $this->_key  		= $key;
        $this->sign_type	= $sign_type;
        $this->parameter	= para_filter($parameter);

        //设定charset的值,为空值的情况下默认为GBK
        if($parameter['charset'] == '')
        {
            $this->parameter['charset'] = 'GBK';
        }
        $this->charset   = $this->parameter['charset'];

        //获得签名结果
        $sort_array   = arg_sort($this->parameter);    //得到从字母a到z排序后的签名参数数组
        $this->mysign = build_mysign($sort_array,$this->_key,$this->sign_type);
    }

    function BuildForm()
    {
        //GET方式传递
        //$sHtml = "<form id='rongpaysubmit' name='rongpaysubmit' action='".$this->gateway."' method='get'>";
        //POST方式传递（GET与POST二必选一）
        //$sHtml = "<form id='rongpaysubmit' name='rongpaysubmit' action='".$this->gateway."charset=".$this->parameter['charset']."' method='post'>";
        $sHtml='';
        while (list ($key, $val) = each ($this->parameter))
        {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }

        $sHtml = $sHtml."<input type='hidden' name='sign' value='".$this->mysign."'/>";
        $sHtml = $sHtml."<input type='hidden' name='sign_type' value='".$this->sign_type."'/>";

        //submit按钮控件请不要含有name属性
        //$sHtml = $sHtml."<input type='submit' value='融宝支付确认付款'></form>";

        //$sHtml = $sHtml."<script>document.forms['rongpaysubmit'].submit();</script>";
        return $sHtml;
    }
    function takeorder()
    {
        //GET方式传递
        //$sHtml = "<form id='rongpaysubmit' name='rongpaysubmit' action='".$this->gateway."' method='get'>";
        //POST方式传递（GET与POST二必选一）
        $sHtml = "<form id='rongpaysubmit' name='rongpaysubmit' action='".$this->gateway."charset=".$this->parameter['charset']."' method='post'>";

        while (list ($key, $val) = each ($this->parameter))
        {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }

        $sHtml = $sHtml."<input type='hidden' name='sign' value='".$this->mysign."'/>";
        $sHtml = $sHtml."<input type='hidden' name='sign_type' value='".$this->sign_type."'/>";

        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit' value='支付到融宝'></form>";

        $sHtml = $sHtml."<script>document.forms['rongpaysubmit'].submit();</script>";
        echo $sHtml;
    }
}