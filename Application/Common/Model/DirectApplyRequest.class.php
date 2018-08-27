<?php

namespace Common\Model;

/**
 *  批量付款请求参数
 * 
 */

class DirectApplyRequest {
	
	public $sign = '';
	public $signType = 'MD5';
	public $charset = 'utf-8';
	public $customerNo = '';
	public $auditFlag = '0';

	public $batchNo ='';
	public $callbackUrl = '';
	public $details = array();
	public $remark='';
	public $totalAmount = 0;
		
}
