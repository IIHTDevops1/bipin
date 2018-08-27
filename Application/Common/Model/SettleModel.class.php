<?php

namespace Common\Model;
use Think\Model;
use Org\Util\Stringnew;

/**
 *  结算单模型
 *
 */

class SettleModel extends Model {


    /**
     * 结算订单完成后，处理订单结算和分润
     */
    public function handleApply($batchNo,$pname){

        //echo $batchNo;die;
        //$batchNo =I('batchNo','');  //批次号
        if(empty($batchNo)) {
            return;
        }
        $Settle = M('Settle');
        $map['settleno'] = $batchNo;
        $Settle->where($map)->find();

        if($Settle->status =='03'){//如果已经处理过，并且支付成功，直接返回，不再继续
            return;
        }

        //更新结算申请单状态
        $Settle->status = '03';//已支付
        $Settle->settletime = NOW_TIME;
        $Settle->save();


        $Settle->where($map)->find(); //对象保存后，在内存中失效，需要重新获取
        //解除冻结金额并 计算各级代理结算提成
        $User = M('User');
        $params['merchantnum'] = $Settle->merchantnum;
        $User->where($params)->setDec('frozen',$Settle->settleamount); //去除冻结中已结算的金额

        $u = $User->where($params)->find();

        //结算单保存成功后，保存对账单信息
        $trade['tradeno'] = $batchNo;
        $trade['addtime'] = NOW_TIME;
        $trade['tradeamount'] = $Settle->settleamount;
        $trade['realamount'] = $Settle->settleamount - $Settle->cost;
        $trade['tradetype'] = 'Set';
        $trade['paycost'] = 0;
        $trade['settlecost'] = $Settle->cost;
        $trade['merchantnum'] = $Settle->merchantnum;
        $trade['status'] = 'N';
        $trade['platform'] = $Settle->pname;
        //$trade['balance'] = $u['amount'];
        //$trade['balance'] = $merchant['amount'] - $settleamount;//结算后余额
        $TradeDetail = M('TradeDetail');
        $TradeDetail->create($trade);
        $TradeDetail->add();

        //各级分润
        //函数见于Common/Common/function.php
        //setApplyCommission($u,$u['agentid'],$u['fee1'],$Settle->settleamount,$batchNo);
        $cname='SFT_APPLY';
        if($Settle->pname == 'REAPAL_FAST' || $Settle->pname =='REAPAL'){
            $cname='REAPAL_APPLY';
        }
        if($Settle->pname == 'SFT'){
            $cname='SFT_APPLY';
        }
        $UserChannel = M('UserChannel');

        $pname=$pname;
        $map2['cname'] = $cname;
        $map2['merchantnum'] = $u['merchantnum'];
        $UC = $UserChannel->where($map2)->find();

        //setApplyCommission($u,$u['agentid'],$u['fee1'],$Settle->settleamount,$batchNo);
        applyCommissionEx($u['merchantnum'], $u['truename'], $u['agentid'], $pname, $cname, $UC['cost'], $Settle->settleamount, $batchNo);

    }

    /**
     *  融宝快捷
     * 结算订单完成后，处理订单结算和分润
     */
    public function handleReapalFastApply($batchNo,$pname){


        if(empty($batchNo)) {
            return;
        }
        $Settle = M('Settle');
        $map['settleno'] = $batchNo;
        $Settle->where($map)->find();

        if($Settle->status =='03'){//如果已经处理过，并且支付成功，直接返回，不再继续
            return;
        }

        //更新结算申请单状态
        $Settle->status = '03';//已支付
        $Settle->settletime = NOW_TIME;
        $Settle->save();


        $Settle->where($map)->find(); //对象保存后，在内存中失效，需要重新获取
        //解除冻结金额并 计算各级代理结算提成
        $User = M('User');
        $params['merchantnum'] = $Settle->merchantnum;
        $User->where($params)->setDec('reapal_fast_frozen',$Settle->settleamount); //去除冻结中已结算的金额

        $u = $User->where($params)->find();

        //结算单保存成功后，保存对账单信息
        $trade['tradeno'] = $batchNo;
        $trade['addtime'] = NOW_TIME;
        $trade['tradeamount'] = $Settle->settleamount;
        $trade['realamount'] = $Settle->settleamount - $Settle->cost;
        $trade['tradetype'] = 'Set';
        $trade['paycost'] = 0;
        $trade['settlecost'] = $Settle->cost;
        $trade['merchantnum'] = $Settle->merchantnum;
        $trade['status'] = 'N';
        $trade['platform'] = $Settle->pname;
        $trade['balance'] = $u['reapal_fast_amount'];

        $TradeDetail = M('TradeDetail');
        $TradeDetail->create($trade);
        $TradeDetail->add();
       // dump($trade);

        //各级分润
        //函数见于Common/Common/function.php

        $UserChannel = M('UserChannel');
        $cname='REAPAL_APPLY';
        $pname=$pname;
        $map2['cname'] = $cname;
        $map2['merchantnum'] = $u['merchantnum'];
        $UC = $UserChannel->where($map2)->find();

        applyCommissionEx($u['merchantnum'], $u['truename'], $u['agentid'], $pname, $cname, $UC['cost'], $Settle->settleamount, $batchNo);

    }

    /**
     *  手机快捷
     * 结算订单完成后，处理订单结算和分润
     */
    public function handleMobileFastApply($batchNo,$pname){


        if(empty($batchNo)) {
            return;
        }
        $Settle = M('Settle');
        $map['settleno'] = $batchNo;
        $Settle->where($map)->find();

        if($Settle->status =='03'){//如果已经处理过，并且支付成功，直接返回，不再继续
            return;
        }

        //更新结算申请单状态
        $Settle->status = '03';//已支付
        $Settle->settletime = NOW_TIME;
        $Settle->save();


        $Settle->where($map)->find(); //对象保存后，在内存中失效，需要重新获取
        //解除冻结金额并 计算各级代理结算提成

        $MoUser = M('XzgUser');
        $params['merchantnum'] = $Settle->merchantnum;
        $MoUser->where($params)->setDec('amount_frozen',$Settle->settleamount); //去除冻结中已结算的金额

        $xzguser =$MoUser->where($params)->find();

        $User = M('User');
        $params['merchantnum'] = $Settle->merchantnum;
        $u = $User->where($params)->find();

        //结算单保存成功后，保存对账单信息
        $trade['tradeno'] = $batchNo;
        $trade['addtime'] = NOW_TIME;
        $trade['tradeamount'] = $Settle->settleamount;
        $trade['realamount'] = $Settle->settleamount - $Settle->cost;
        $trade['tradetype'] = 'Set';
        $trade['paycost'] = 0;
        $trade['settlecost'] = $Settle->cost;
        $trade['merchantnum'] = $Settle->merchantnum;
        $trade['status'] = 'N';
        $trade['platform'] = $Settle->pname;
        $trade['balance'] = $xzguser['amount'];

        $TradeDetail = M('TradeDetail');
        $TradeDetail->create($trade);
        $TradeDetail->add();
        // dump($trade);

        //各级分润
        //函数见于Common/Common/function.php

        $UserChannel = M('UserChannel');
        $cname='REAPAL_MOBILE_APPLY';
        $pname=$pname;
        $map2['cname'] = $cname;
        $map2['merchantnum'] = $u['merchantnum'];
        $UC = $UserChannel->where($map2)->find();

        applyCommissionEx($u['merchantnum'], $u['truename'], $u['agentid'], $pname, $cname, $UC['cost'], $Settle->settleamount, $batchNo);

    }

    /**
     *  融宝结算
     * 结算订单完成后，处理订单结算和分润
     */
    public function handleReapalApply($batchNo,$pname){


        if(empty($batchNo)) {
            return;
        }
        $Settle = M('Settle');
        $map['settleno'] = $batchNo;
        $Settle->where($map)->find();

        if($Settle->status =='03'){//如果已经处理过，并且支付成功，直接返回，不再继续
            return;
        }

        //更新结算申请单状态
        $Settle->status = '03';//已支付
        $Settle->settletime = NOW_TIME;
        $Settle->save();


        $Settle->where($map)->find(); //对象保存后，在内存中失效，需要重新获取
        //解除冻结金额并 计算各级代理结算提成
        $User = M('User');
        $params['merchantnum'] = $Settle->merchantnum;
        $User->where($params)->setDec('reapal_frozen',$Settle->settleamount); //去除冻结中已结算的金额

        $u = $User->where($params)->find();

        //结算单保存成功后，保存对账单信息
        $trade['tradeno'] = $batchNo;
        $trade['addtime'] = NOW_TIME;
        $trade['tradeamount'] = $Settle->settleamount;
        $trade['realamount'] = $Settle->settleamount - $Settle->cost;
        $trade['tradetype'] = 'Set';
        $trade['paycost'] = 0;
        $trade['settlecost'] = $Settle->cost;
        $trade['merchantnum'] = $Settle->merchantnum;
        $trade['status'] = 'N';
        $trade['platform'] = $Settle->pname;
        $trade['balance'] = $u['reapal_amount'];

        $TradeDetail = M('TradeDetail');
        $TradeDetail->create($trade);
        $TradeDetail->add();
        // dump($trade);

        //各级分润
        //函数见于Common/Common/function.php

        $UserChannel = M('UserChannel');
        $cname='REAPAL_APPLY';
        $pname=$pname;
        $map2['cname'] = $cname;
        $map2['merchantnum'] = $u['merchantnum'];
        $UC = $UserChannel->where($map2)->find();

        applyCommissionEx($u['merchantnum'], $u['truename'], $u['agentid'], $pname, $cname, $UC['cost'], $Settle->settleamount, $batchNo);

    }

}