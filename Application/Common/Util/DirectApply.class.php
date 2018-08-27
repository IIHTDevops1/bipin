<?php


/**
 *  盛付通批量付款接口SDK
 * 
 */

namespace Common\Util;
use Think\Model;


class DirectApply{

	private $applyHost;
	 
	private $key='shengfutongSHENGFUTONGtest';
	private $params=array(
		'batchNo'=>'',//批次号 String(32)
		'callbackUrl'=>'',//回调地址String(256)
		'totalAmount'=>0,//批次总付款金额 Decimal(18,2)
		'customerNo'=>'100894',//商户号
		'charset'=>'utf-8',//字符集
		'signType'=>'MD5',  //报文验名类型
		'sign'=>'', //签名String(128)转成大写
		'auditFlag'=>0,
		'remark'=>'',//备注String(256)
		'details'=>null,//请求明细 List<ApplyInfoDetail>
	);

	function init(){	 
		$this->applyHost = C('APPLY_URL');//'http://mtc.shengpay.com/services/BatchPayment/BatchPayment?wsdl';
	}

	function setKey($key){
		$this->key=$key;
	}
	function setParam($key,$value){
		$this->params[$key]=$value;
	}

	function takeApply(){
		 
		//charset+signType+customerNo+batchNo+callbackUrl+totalAmount+
		//循环拼明细（id+province+city+branchName+bankName+accountType+bankUserName+bankAccount+amount+remark）+md5key
		$origin=$this->params['charset'].$this->params['signType'].$this->params['customerNo'].$this->params['batchNo'].$this->params['callbackUrl'].$this->params['totalAmount'];
		
		$str= '';
		foreach($this->params['details'] as $key=>$value){
			//id+province+city+branchName+bankName+accountType+bankUserName+bankAccount+amount+remark
			$str.= $value['id'].$value['province'].$value['city'].$value['branchName'].$value['bankName'].$value['accountType'].$value['bankUserName'].$value['bankAccount'].$value['amount'].$value['remark'];
		}
		$origin .= $str;
		  
		$sign=strtoupper(md5($origin.$this->key));
		$this->params['sign']=$sign;
		 ini_set("soap.wsdl_cache_enabled", "0"); 
		 $soap=new \SoapClient($this->applyHost); 
		  
		 try {
			 dump($this->params);
				$soap->__getLastResponseHeaders();
    //$res = $soap->directApply($this->params);
				$soap->__getLastResponse();
				$soap->__getLastResponseHeaders();
} catch(\SoapFault $e) {  
    print "Sorry an error was caught executing your request: {$e->getMessage()}";  
}  
		 //$res = $soap->directApply($this->params);//调用远程方法，提交结算参数
		 //$res = $soap->__call('directApply', $this->params);
		 
		 /*
			报文返回状态（调用服务时实时返回的状态）	
			Code	描述
			99	系统异常
			00	成功
			01	参数错误
			02	商户号不合法
			03	验签失败
			04	无权访问
			05	原交易不存在
			06	重复请求
			09	文件格式错误
			11	校验请求失败
			12	批次不存在
			13	日期区间不合法
			14	禁止查询
			15	请求明细数量超限
			16	请求的批次未进入支付
			17	文件格式错误
			18	请求的批次还未产生任务结果
			*/
			/*
			$result = array(
				'batchNo'=>'',  //批次号
				'resultCode'=>'00',   //结果代码
				'resultMessage'=>'',  //结果信息
				'signType'=>'MD5',  //报文验名类型
				'sign'=>'',//  签名
			);
			*/
		 return $res;
	}

	function returnSign(){
		$params=array(
			'Name'=>'',
			'Version'=>'',
			'Charset'=>'',
			'TraceNo'=>'',
			'MsgSender'=>'',
			'SendTime'=>'',
			'InstCode'=>'',
			'OrderNo'=>'',
			'OrderAmount'=>'',
			'TransNo'=>'',
			'TransAmount'=>'',
			'TransStatus'=>'',
			'TransType'=>'',
			'TransTime'=>'',
			'MerchantNo'=>'',
			'ErrorCode'=>'',
			'ErrorMsg'=>'',
			'Ext1'=>'',
			'Ext2'=>'',
			'SignType'=>'MD5',
		);
		foreach($_POST as $key=>$value){
			if(isset($params[$key])){
				$params[$key]=$value;
			}
		}
		$TransStatus=(int)$_POST['TransStatus'];
		$origin='';
		foreach($params as $key=>$value){
			if(!empty($value))
				$origin.=$value;
		}
		$SignMsg=strtoupper(md5($origin.$this->key));
		if($SignMsg==$_POST['SignMsg'] and $TransStatus==1){
			return true;
		}else{
			return false;
		}
	}

}
