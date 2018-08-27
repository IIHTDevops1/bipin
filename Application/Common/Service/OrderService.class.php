<?php

namespace Common\Service;
use Think\Model;
use Org\Util\Stringnew;
/**
 *  订单服务
 * 
 */

class OrderService extends Model {

    Protected $autoCheckFields = false;

    public function getList(){

        $list = M('Order')->order('addtime desc')->limit(10)->select();
        return $list;
    }

    /**
     * @param $params
     *
     * $params['merchantnum'] 用户编号
     * $params['amount']  金额
     * $params['pname'] 平台编码
     * $params['ptitle'] 平台名称
     * $params['cname'] 通道编码
     * $params['ctitle'] 通道名称
     * $params['rate'] 通道费率
     */
    public function createOrder($params){


        //生成订单号
        $orderno = String::buildFormatRand(date('YmdHis'.'##########'));

        //检查商户
        $merchantnum = $params['merchantnum']; //获取商户号
        $amount = $params['amount'];//订单金额
        $productname = $params['productname'];//商品名称


        $ip = get_client_ip();

        //计算费率和实际金额
        $rate = $params['rate'];
        $realamount = floorEx(floatval($amount)*(1-floatval($rate/100)));//实际入账金额
        $cost = floatval($amount) - $realamount;//手续费

        $Order = M('Order');
        $Order->create();
        $Order->merchantnum = $merchantnum;
        $Order->orderno     = $orderno;
        $Order->orderamount = $params['amount'];
        $Order->rate        = $params['rate'];
        $Order->realamount  = $realamount;
        $Order->cost  = $cost;
        $Order->addtime     = dateformat(NOW_TIME);

        $Order->productname  = $productname;
        //$Order->bankcode    = $bankinfo['instcode'];
        //$Order->bankname    = $bankinfo['bankname'];
        $Order->buyerip     = $ip;
        $Order->status      = '00';
        $Order->pname       = $params['pname'];
        $Order->ptitle      = $params['ptitle'];
        $Order->cname       = $params['cname'] ;
        $Order->ctitle      = $params['ctitle'];
        $Order->add();



        
    }
}