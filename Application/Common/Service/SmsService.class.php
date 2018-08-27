<?php

namespace Common\Service;
use Think\Model;
use Org\Util\Stringnew;
/**
 *  创蓝短信Service
 * 
 */
class SmsService {


    /**  发送短信
     * @param $mobile 手机号码
     * @param $msg 短信内容
     * @param string $needstatus 是否需要状态报告
     * @param string $extno 扩展码，可选
     * @return mixed
     */
    public function sendSMS( $mobile, $msg, $needstatus = 'false', $extno = '') {
        //global $chuanglan_config;
        //创蓝接口参数
        $postArr = array (
            'account' => C('CHUANG_LAN.API_ACCOUNT'),
            'pswd' => C('CHUANG_LAN.API_PASSWORD'),
            'msg' => $msg,
            'mobile' => $mobile,
            'needstatus' => $needstatus,
            'extno' => $extno
        );

        $result = $this->curlPost( C('CHUANG_LAN.API_SEND_URL') , $postArr);
        return $result;
    }

    /**  发送短信
     * @param $mobile 手机号码
     * @param $msg 短信内容
     * @param string $needstatus 是否需要状态报告
     * @param string $extno 扩展码，可选
     * @return mixed
     */
    public function sendYingxiaoSMS( $mobile, $msg, $needstatus = 'false', $extno = '') {
        //global $chuanglan_config;
        //创蓝接口参数
        $postArr = array (
            'account' => C('CHUANG_LAN.YINGXIAO_API_ACCOUNT'),
            'pswd' => C('CHUANG_LAN.YINGXIAO_API_PASSWORD'),
            'msg' => $msg,
            'mobile' => $mobile,
            'needstatus' => $needstatus,
            'extno' => $extno
        );

        $result = $this->curlPost( C('CHUANG_LAN.YINGXIAO_URL') , $postArr);
        return $result;
    }



    /**
     * 查询额度
     *
     *  查询地址
     */
    public function queryBalance() {
        //global $chuanglan_config;
        //查询参数
        $postArr = array (
            'account' => C('CHUANG_LAN.API_ACCOUNT'),
            'pswd' => C('CHUANG_LAN.API_PASSWORD'),
        );
        $result = $this->curlPost(C('CHUANG_LAN.API_BALANCE_QUERY_URL'), $postArr);
        return $result;
    }

    /**
     * 处理返回值
     *
     */
    public function execResult($result){
        $result=preg_split("/[,\r\n]/",$result);
        return $result;
    }

    /**
     * 通过CURL发送HTTP请求
     * @param string $url  //请求URL
     * @param array $postFields //请求参数
     * @return mixed
     */
    private function curlPost($url,$postFields){
        $postFields = http_build_query($postFields);
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postFields );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    }

    //魔术获取
    public function __get($name){
        return $this->$name;
    }

    //魔术设置
    public function __set($name,$value){
        $this->$name=$value;
    }

}