<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {


    protected function _initialize()
    {

    }

    //音频的分享链接
    public function singer_lj(){
        $id= $_GET['xqid'];
        $workss=M("workss");
        $comment=M("comment");
        $arr=$workss->where(array('id'=>$id))->find();
        $arr['addtime']=dateformat($arr['times'],3);
        $ping=$comment->where(array('worker_id'=>$id,'types'=>1))->order("addtime desc")->limit(10)->select();

        $this->assign("arr",$arr);
        $this->assign("ping",$ping);
        $this->display();
    }
    //音频的分享链接
    public function netease(){
       $id= $_GET['xqid'];
        $workss=M("workss");
        $comment=M("comment");
        $arr=$workss->where(array('id'=>$id))->find();
        $ping=$comment->where(array('worker_id'=>$id,'types'=>1))->order("addtime desc")->limit(10)->select();

        $this->assign("arr",$arr);
        $this->assign("ping",$ping);
        $this->display();
    }

///2
public function make_xiazai(){
    $request = getClientRequest();
    $user_id = $request['user_id'];
    $work_id = $request['work_id'];
    $xzlog=M("likelog");
$isxiazai=$xzlog->where(array('user_id'=>$user_id,'likeid'=>$work_id,'tables'=>'workss','types'=>1))->find();
    if(!empty($isxiazai)){
        $ret['status'] = 200;
        $ret['msg'] = '下载成功';
    }else{
    //之前没载过

        $workss=M("workss");
        $user=M("user");
        $isxibi=$workss->where(array('id'=>$work_id))->field("operas,yonghu")->find();//下载需要的戏币

        if(!empty($isxibi)){
            $userinfo=$user->where(array('user_id'=>$user_id))->field("xibi,level,xiazai,dongjiexibi")->find();

            if(!empty($userinfo)){

                $xibi=$userinfo['xibi']-$userinfo['dongjiexibi'];//用户可用的戏币数
                if($isxibi['yonghu']==1){
                    //用户上传的只能用戏币下载
                    if($isxibi['operas']<=$xibi){
                        $data['user_id']=$user_id;
                        $data['likeid']=$work_id;
                        $data['tables']="workss";
                        $data['types']=1;//添加下载记录
                        $data['addtime']=time();
                        $xzlog->add($data);//添加下载日志
                        $xibilog=M("xibilog");//戏币消耗日志
                        $kou=   $user->where(array('user_id'=>$user_id))->setInc("xibi",-$isxibi['operas']);//扣除戏币
                        if(!empty($kou)){
                            $xib['user_id']=$user_id;
                            $xib['xibi']=$userinfo['xibi']-$isxibi['operas'];//执行当前操作的后剩余的戏币数量
                            $xib['addtime']=time();
                            $xib['content']='下载伴奏消耗'.$isxibi['operas'].'戏币';
                            $xib['price']=$isxibi['operas'];
                            $xib['transnum']=$isxibi['operas'];//消耗的戏币
                            $xib['status']=2;//1未支付2已支付
                            $xib['types']=2;//2消费戏币
                            $xib['type']=4;//戏币抵扣
                            $xib['order_no']="XZ" . time() . mt_rand("100,999");//下载消耗记录
                            $xibilog->add($xib);
                            $ret['status'] = 200;
                            $ret['msg'] = '下载成功';
                            //下载成功
                            //戏币扣除成功
                        }else{
//戏币扣除失败
                            $ret['status'] = 300;
                            $ret['msg'] = '请稍后下载';
                        }
                    }else{
                        $ret['status'] = 300;
                        $ret['msg'] = '戏币不足请充值!';
                    }

                }else{
//后台上传的作品
                    if($userinfo['level']==2){
                        //用户上传的只能用戏币下载
                        if($isxibi['operas']<=$xibi){
                            $data['user_id']=$user_id;
                            $data['likeid']=$work_id;
                            $data['tables']="workss";
                            $data['types']=1;//添加下载记录
                            $data['addtime']=time();
                            $xzlog->add($data);//添加下载日志
                            $xibilog=M("xibilog");//戏币消耗日志
                            $kou=   $user->where(array('user_id'=>$user_id))->setInc("xibi",-$isxibi['operas']);//扣除戏币
                            if(!empty($kou)){
                                $xib['user_id']=$user_id;
                                $xib['xibi']=$userinfo['xibi']-$isxibi['operas'];//执行当前操作的后剩余的戏币数量
                                $xib['addtime']=time();
                                $xib['content']='下载伴奏消耗'.$isxibi['operas'].'戏币';
                                $xib['price']=$isxibi['operas'];
                                $xib['transnum']=$isxibi['operas'];//消耗的戏币
                                $xib['status']=2;//1未支付2已支付
                                $xib['types']=2;//2消费戏币
                                $xib['type']=4;//戏币抵扣
                                $xib['order_no']="XZ" . time() . mt_rand("100,999");//下载消耗记录
                                $xibilog->add($xib);
                                $ret['status'] = 200;
                                $ret['msg'] = '下载成功';
                                //下载成功
                                //戏币扣除成功
                            }else{
//戏币扣除失败
                                $ret['status'] = 300;
                                $ret['msg'] = '请稍后下载';
                            }
                            $this->ajaxReturn($ret);
                        }else{
                            $ret['status'] = 300;
                            $ret['msg'] = '戏币不足请充值!';
                        }
                        $this->ajaxReturn($ret);
                    }else{
                        if($userinfo['xiazai']>=1){

                            $cc=  $user->where(array('user_id'=>$user_id))->setInc("xiazai",-1);
                            if(!empty($cc)){
                                //下载次数已扣除

                                $ret['status'] = 200;
                                $ret['msg'] = '下载成功';
                            }else{

                                $ret['status'] = 300;
                                $ret['msg'] = '请稍后下载';
                            }
                            $this->ajaxReturn($ret);
                        }else{
                            //下载次数不够
                            if($isxibi['operas']<=$xibi){
                                $data['user_id']=$user_id;
                                $data['likeid']=$work_id;
                                $data['tables']="workss";
                                $data['types']=1;//添加下载记录
                                $data['addtime']=time();
                                $xzlog->add($data);//添加下载日志
                                $xibilog=M("xibilog");//戏币消耗日志
                                $kou=   $user->where(array('user_id'=>$user_id))->setInc("xibi",-$isxibi['operas']);//扣除戏币
                                if(!empty($kou)) {
                                    $xib['user_id'] = $user_id;
                                    $xib['xibi'] = $userinfo['xibi'] - $isxibi['operas'];//执行当前操作的后剩余的戏币数量
                                    $xib['addtime'] = time();
                                    $xib['content'] = '下载伴奏消耗' . $isxibi['operas'] . '戏币';
                                    $xib['price'] = $isxibi['operas'];
                                    $xib['transnum'] = $isxibi['operas'];//消耗的戏币
                                    $xib['status'] = 2;//1未支付2已支付
                                    $xib['types'] = 2;//2消费戏币
                                    $xib['type'] = 4;//戏币抵扣
                                    $xib['order_no'] = "XZ" . time() . mt_rand("100,999");//下载消耗记录
                                    $xibilog->add($xib);
                                    $ret['status'] = 200;
                                    $ret['msg'] = '下载成功';
                                }else{
                                    $ret['status'] = 300;
                                    $ret['msg'] = '请稍后下载!';
                                }


                            }else{
                                $ret['status'] = 300;
                                $ret['msg'] = '戏币不足请充值!';
                            }
                            $this->ajaxReturn($ret);
                        }
                    }


                }
            }else{
                $ret['status'] = 300;
                $ret['msg'] = '请先登录!';
            }

        }else{
            $ret['status'] = 500;
            $ret['msg'] = '下载伴奏不存在!';
        }




    }

$this->ajaxReturn($ret);



}
public function make_xiazaiyuan(){
    $request = getClientRequest();
    $user_id = $request['user_id'];
    $work_id = $request['work_id'];
    $xzlog=M("likelog");
$isxiazai=$xzlog->where(array('user_id'=>$user_id,'likeid'=>$work_id,'tables'=>'workss','types'=>1))->find();
    if(!empty($isxiazai)){
        $ret['status'] = 200;
        $ret['msg'] = '下载成功';
    }else{
    //之前没载过

        $user=M("user");

        //先判断是否是vip有下载次数
        $userinfo=$user->where(array('user_id'=>$user_id))->field("xibi,level,xiazai,dongjiexibi")->find();
        if(!empty($userinfo)){
            $workss=M("workss");
            $isxibi=$workss->where(array('id'=>$work_id))->getField("operas");//下载需要的戏币
            $xibi=$userinfo['xibi']-$userinfo['dongjiexibi'];
            if($userinfo['level']==2){
//非会员
                if($isxibi<=$xibi){
//                    $ret['status'] = 200;
//                    $ret['msg'] = '是否扣除'.$isxibi.'戏币下载该伴奏';
                    $data['user_id']=$user_id;
                    $data['likeid']=$work_id;
                    $data['tables']="workss";
                    $data['types']=1;//添加下载记录
                    $data['addtime']=time();
                    $xzlog->add($data);//添加下载日志
                    $xibilog=M("xibilog");//戏币消耗日志
                 $kou=   $user->where(array('user_id'=>$user_id))->setInc("xibi",-$isxibi);//扣除戏币
                 if(!empty($kou)){
                     $xib['user_id']=$user_id;
                     $xib['xibi']=$userinfo['xibi']-$isxibi;//执行当前操作的后剩余的戏币数量
                     $xib['addtime']=time();
                     $xib['content']='下载伴奏消耗'.$isxibi.'戏币';
                     $xib['price']=$isxibi;
                     $xib['transnum']=$isxibi;//消耗的戏币
                     $xib['status']=2;//1未支付2已支付
                     $xib['types']=2;//2消费戏币
                     $xib['type']=4;//戏币抵扣
                     $xib['order_no']="XZ" . time() . mt_rand("100,999");//下载消耗记录
                     $xibilog->add($xib);
                     $ret['status'] = 200;
                     $ret['msg'] = '下载成功';

                 }else{
//戏币扣除失败
                     $ret['status'] = 300;
                     $ret['msg'] = '请稍后下载';
                 }
                }else{
                    $ret['status'] = 300;
                    $ret['msg'] = '戏币不足请充值1';
                }

            }else{
//3是会员，减下载次数
                if($userinfo['xiazai']>=1){

                  $cc=  $user->where(array('user_id'=>$user_id))->setInc("xiazai",-1);
if(!empty($cc)){
    //下载次数已扣除
    //
    $cish=$user->where(array('user_id'=>$user_id))->getField("xiazai");
    if($cish<1){
        $user->where(array('user_id'=>$user_id))->save(array('level'=>2));//把会员改回去
    }
    $ret['status'] = 200;
    $ret['msg'] = '下载成功';
}else{

    $ret['status'] = 300;
    $ret['msg'] = '请稍后下载';
}
                }else{
                    //下载次数不够
                    $user->where(array('user_id'=>$user_id))->save(array('level'=>2));//把会员改回去

                    if($isxibi<=$xibi){
//                        $ret['status'] = 200;
//                        $ret['msg'] = '是否扣除'.$isxibi.'戏币下载该伴奏';
                        $data['user_id']=$user_id;
                        $data['likeid']=$work_id;
                        $data['tables']="workss";
                        $data['types']=1;//添加下载记录
                        $data['addtime']=time();
                        $xzlog->add($data);//添加下载日志
                        $xibilog=M("xibilog");//戏币消耗日志
                        $kou=   $user->where(array('user_id'=>$user_id))->setInc("xibi",-$isxibi);//扣除戏币
                        if(!empty($kou)) {
                            $xib['user_id'] = $user_id;
                            $xib['xibi'] = $userinfo['xibi'] - $isxibi;//执行当前操作的后剩余的戏币数量
                            $xib['addtime'] = time();
                            $xib['content'] = '下载伴奏消耗' . $isxibi . '戏币';
                            $xib['price'] = $isxibi;
                            $xib['transnum'] = $isxibi;//消耗的戏币
                            $xib['status'] = 2;//1未支付2已支付
                            $xib['types'] = 2;//2消费戏币
                            $xib['type'] = 4;//戏币抵扣
                            $xib['order_no'] = "XZ" . time() . mt_rand("100,999");//下载消耗记录
                            $xibilog->add($xib);
                            $ret['status'] = 200;
                            $ret['msg'] = '下载成功';
                        }else{
                            $ret['status'] = 300;
                            $ret['msg'] = '请稍后下载';
                        }


                    }else{
                        $ret['status'] = 300;
                        $ret['msg'] = '戏币不足请充值';
                    }
                }
            }
        }else{
            $ret['status'] = 300;
            $ret['msg'] = '请先登录';
        }

    }

$this->ajaxReturn($ret);



}
///2
public function xiazai(){
    $request = getClientRequest();
    $user_id = $request['user_id'];
    $work_id = $request['work_id'];
    $xzlog=M("likelog");
$isxiazai=$xzlog->where(array('user_id'=>$user_id,'likeid'=>$work_id,'tables'=>'workss','types'=>1))->find();
    if(!empty($isxiazai)){
    //之前下载过
        $ret['status'] = 100;
        $ret['msg'] = '确认下载?';
    }else{
    //之前没载过

        $user=M("user");

        //先判断是否是vip有下载次数
        $userinfo=$user->where(array('user_id'=>$user_id))->field("xibi,level,xiazai,dongjiexibi")->find();
        if(!empty($userinfo)){


            $workss=M("workss");
            $isxibi=$workss->where(array('id'=>$work_id))->field("operas,yonghu")->find();//下载需要的戏币
            $xibi=$userinfo['xibi']-$userinfo['dongjiexibi'];

            if($isxibi['yonghu']==1){
                //用户上传的必须只能用戏币下载
                if($isxibi['operas']<=$xibi){
                    $ret['status'] = 200;
                    $ret['msg'] = '是否扣除'.$isxibi['operas'].'戏币下载该伴奏?';
                }else{
                    $ret['status'] = 300;
                    $ret['msg'] = '戏币不足请充值!';
                }
            }else{
                //后台上传的作品
                if($userinfo['level']==2){
//非会员
                    if($isxibi['operas']<=$xibi){
                        $ret['status'] = 200;
                        $ret['msg'] = '是否扣除'.$isxibi['operas'].'戏币下载该伴奏?';
                    }else{
                        $ret['status'] = 300;
                        $ret['msg'] = '戏币不足请充值!';
                    }
                }else{
//3是会员，减下载次数
                    if($userinfo['xiazai']>=1){
                        $ret['status'] = 200;
                        $ret['msg'] = '是否消耗1次下载机会来下载该伴奏?';
                    }else{
                        //下载次数不够

                        if($isxibi['operas']<=$xibi){
                            $ret['status'] = 200;
                            $ret['msg'] = '是否扣除'.$isxibi['operas'].'戏币下载该伴奏?';
                        }else{
                            $ret['status'] = 300;
                            $ret['msg'] = '戏币不足请充值!';
                        }
                    }
                }
            }



        }else{
            $ret['status'] = 300;
            $ret['msg'] = '请先登录';
        }



    }

$this->ajaxReturn($ret);



}

    //手机绑定
    public function bindingm(){
        $request = getClientRequest();
        $user_id = $request['user_id'];
        $mobile = $request['mobile'];
        $pwd = $request['pwd'];
        $code = $request['code'];
        $user=M("user");
        $userinfo=$user->where(array('user_id'=>$user_id))->field("id,mobile")->find();
        if($userinfo['mobile']==""){
            $dd['mobile']=$mobile;
            $dd['id']=array('neq',$userinfo['id']);
            $hhh=$user->where($dd)->getField("id");
            if(!empty($hhh)){
                $ret['status'] = 600;
                $ret['msg'] = '此手机号已被注册';
            }else{
                $table=M('duanxin');
                $log= $table->where(array('mobile'=>$mobile,'code'=>$code))->order("addtime desc")->find();
                if($log){
                    $data['loginpwd']=md5($pwd);
                    $data['loginpwds']=$pwd;
                    $data['mobile']=$mobile;
                    $ddd=$user->where(array('user_id'=>$user_id))->save($data);
                    if(!empty($ddd)){
                        $likelog=M("likelog");
                        $workss=M("workss");
                        $ret['status'] = 200;
                        $ret['msg'] = '您已完成了手机号的绑定';
                        $ret['data'] = $user->where(array('user_id'=>$user_id))->field("username,user_id,mobile,level,thumb,email,truename,addr,sex,is_true,jiguang,jiguangpwd")->find();
                        $ret['data']['level_name']=get_level($ret['data']['level']);
                        $ret['data']['following'] = $likelog->where(array('types'=>2,'user_id'=>$user_id,'tables'=>'user'))->count();//关注
                        $ret['data']['fans'] =  $likelog->where(array('types'=>2,'likeid'=>$user_id,'tables'=>'user'))->count();//粉丝
                        $ret['data']['letters'] =  $user->count();//私信
                        $ret['data']['works'] =  $workss->where(array('user_id'=>$user_id))->count();//作品
                    }else{
                        $ret['status'] = 300;
                        $ret['msg'] = '手机绑定失败，请重试';
                    }
                }else{
                    $ret['status'] = 400;
                    $ret['msg'] = '验证码错误';
                }
            }
        }else{
            $ret['status'] = 500;
            $ret['msg'] = '不可重复手机号的绑定';
        }
            $this->ajaxReturn($ret);
    }
    function wenan(){
        $Notice =M('Notice');
        $request = getClientRequest();
        $id = $request['id'];
        if($id==12){
            $ads=M("ads");
            $data['cad_id'] = 6;
            $ar=$ads->where($data)->getfield("thumb");
$ret['thumb']=$ar;
        }
        $arr=$Notice->where(array('id'=>$id))->field("news_title,content")->find();
        $ret['status'] = 200;
        $ret['msg'] = $arr['news_title'];
        $ret['data']=$arr;
$this->ajaxReturn($ret);
    }

//提现记录
public function tixian_log(){
    $request = getClientRequest();
    $user_id = $request['user_id'];
    $p=$request['p'];
    if($p=="" || $p==1 || $p==0){
        $pp=0;
    }else{
        $p=$p-1;
        $p=$p*15;
        $pp=$p+1;
    }
    $withdrawals=M("withdrawals");//提现申请记录
    $list=$withdrawals->where(array('user_id'=>$user_id))->limit($pp,15)->order("addtime desc")->field("xibi,status,jine1,addtime")->select();
   if(!empty($list)){
       foreach ($list as &$v){
           $v['addtime']=dateformat($v['addtime'],2);
           $v['xibi']=$v['xibi']."戏币";
           if($v['status']==1){
               $v['statusname']="待打款";
           }elseif($v['status']==2){
               $v['statusname']="已打款";
           }else{
               $v['statusname']="被驳回";
           }
       }
       $ret['status'] = 200;
       $ret['msg'] = '提现列表';
       $ret['data']=$list;
   }else{
       $ret['status'] = 300;
       $ret['msg'] = '暂无更多提现申请';
   }
$this->ajaxReturn($ret);
}
  //提现申请
    public function tixian(){
        $request = getClientRequest();
        $user_id = $request['user_id'];

        $jine = $request['jine'];
        if($jine< '0.01'){
            $ret['status'] = 500;
            $ret['msg'] = '提现金额过小';
            $this->ajaxReturn($ret);
        }
        $account_id = $request['account_id'];//提现账户的id
//        $give_gifts=M("give_gifts");
        $user=M("user");


        $mmm=$user->where(array('user_id'=>$request['user_id']))->field("xibi,dongjiexibi")->find();//可提现戏币
$mey=$mmm['xibi']-$mmm['dongjiexibi'];
        if($jine<=$mey){
            //提现金额小于等于可提现金额
            $withdrawals=M("withdrawals");//提现申请记录
                $data['user_id']=$user_id;
                $data['xibi']=$jine;
                $data['account_id']=$account_id;
                $data['addtime']=time();
                $data['type']=1;//1戏币提现
                $data['proportion']=M('notice')->where('id=11')->getfield('content');//提现比例
            if(empty($data['proportion'])){
                $data['proportion']=1;
            }
                $data['content']="戏币提现";//提现比例
                $data['jine1']=$jine*$data['proportion'];//提现比例
            if($account_id==1){
                $data['card_number']=$user->where(array('user_id'=>$user_id))->getField("alipay");//账户账号
                $data['card_type']=$user->where(array('user_id'=>$user_id))->getField("alipay_name");//账户账号
            }else{
                $data['card_number']=$user->where(array('user_id'=>$user_id))->getField("wechat");//账户账号
                $data['card_type']=$user->where(array('user_id'=>$user_id))->getField("wechat_name");//账户账号
            }
          $fff=  $withdrawals->add($data);
            if(!empty($fff)){
                $user->where(array('user_id'=>$request['user_id']))->setInc("dongjiexibi",$jine);//冻结资金
                $ret['status'] = 200;
                $ret['msg'] = '提现申请已提交，等待审核';
            }else{
                $ret['status'] = 400;
                $ret['msg'] = '提现申请失败请重新提交';
            }

        }else{
            //提现金额大于可提现金额
            $ret['status'] = 300;
            $ret['msg'] = '提现金额大于可提现金额，请确认后提交';
        }
        $this->ajaxReturn($ret);


    }
    public function jubao(){
        $request = getClientRequest();
        $jiguang = $request['jiguang'];
        $user_id = $request['user_id'];
        $content = $request['content'];
//        $content = '1';
        $user=M("user");
        $some=$user->where(array('jiguang'=>$jiguang))->field("user_id")->find();
        if(!empty($some)){
$where['worker_id']=$some['user_id'];
$where['user_id']=$user_id;
$where['content']=$content;
$where['addtime']=time();
$where['types']=3;//投诉某人
            $comment=M("comment");
            $ddd=$comment->add($where);
            if(!empty($ddd)){
                $ret['status'] = 200;
                $ret['msg'] = '已成功投诉该账户';
            }else{
                $ret['status'] = 400;
                $ret['msg'] = '请稍后提交';
            }
        }else{
            $ret['status'] = 300;
            $ret['msg'] = '该用户已被注销';
        }
        $this->ajaxReturn($ret);
    }

    public function upvip(){
        $request = getClientRequest();
        $user_id = $request['user_id'];
        $classification=M("Notice");
        $table=M('user');
        $arr=$table->where(array('user_id'=>$user_id))->field("user_id,xiazai,	vipstart,vipend,level")->find();
        $info=$classification->where(array('id'=>2))->field("thumb,content")->find();
        $vips=M("vips");
        $list=$vips->where("types=1")->field("id,vip_title,gold,nums,tian,pingid")->order("toop desc")->select();
        $ret['status'] = 200;
        $ret['msg'] = '升级vip';
        $ret['thumb'] = $info['thumb'];
        $ret['content'] = $info['content'];
        $ret['xiazai'] = $arr['xiazai'];
        $ret['vipstart'] = dateformat($arr['vipstart'],2);
        $ret['vipend'] = dateformat($arr['vipend'],2);
        $ret['level'] = $arr['level'];
        $ret['level_name'] = get_level($arr['level']);

        $ret['data'] = $list;
//        $ret['data'] = $info;
//        $ret['vip'] = $list;
        $this->ajaxReturn($ret);
    }

    //修改密码
    public function change_pwd(){
        $request = getClientRequest();
        $user_id = $request['user_id'];
        $oldpwd = $request['oldpwd'];
        $newpwd = $request['newpwd'];
        $table=M('user');
        $arr=$table->where(array('user_id'=>$user_id))->field("user_id,loginpwds")->find();
        if(!empty($arr)){
            if($oldpwd==$arr['loginpwds']){
                if($oldpwd==$newpwd){
                    $ret['status'] = 400;
                    $ret['msg'] = '与原密码相同';
                }else{
                    $data['loginpwd']=md5($newpwd);
                    $data['loginpwds']=$newpwd;
                    $user=$table->where(array('user_id'=>$user_id))->save($data);
                    if($user){
                        $ret['status'] = 200;
                        $ret['msg'] = '密码修改成功';
                    }else{
                        $ret['status'] = 400;
                        $ret['msg'] = '不能使用原密码';
                    }
                }
            }else{
                $ret['status'] = 100;
                $ret['msg'] = '原密码输入错误';
            }

        }else{
            $ret['status'] = 300;
            $ret['msg'] = '用户不存在';
        }
        $this->ajaxReturn($ret);
    }


    //忘记密码
    public function find_pwd(){
        $request=getClientRequest();
        $mobile=$request['mobile'];
        $code=$request['code'];
//        $code=1234;
        $pwd=$request['pwd'];
        $log= M('duanxin')->where(array('mobile'=>$mobile,'code'=>$code))->find();
        if($code){
            $table=M('user');
            $arr=$table->where(array('mobile'=>$mobile))->find();
            if($arr){
                $data['loginpwd']=md5($pwd);
                $data['loginpwds']=$pwd;
                $user=$table->where(array('mobile'=>$mobile))->save($data);
                if($user){
                    $ret['status'] = 200;
                    $ret['msg'] = '密码修改成功';
                }else{
                    $ret['status'] = 100;
                    $ret['msg'] = '与原密码相同';
                }
            }else{
                $ret['status'] = 300;
                $ret['msg'] = '用户不存在';
            }
        }else{
            $ret['status'] = 400;
            $ret['msg'] = '验证码错误';
        }
        $this->ajaxReturn($ret);
    }
//短信
    public function sendmsg(){
        require_once 'ChuanglanSmsHelper/ChuanglanSmsApi.php';

        $request = getClientRequest();
        $mobile = $request['mobile'];
        $type = $request['type'];
        $user=M("user");
        $clapi  = new \ChuanglanSmsApi();
//$user
        $code = mt_rand(100000,999999);
        if($type==1){//注册
            if(empty($user->where(array('mobile'=>$mobile))->find())){
                $result = $clapi->sendSMS($mobile, '【戏宝】注册操作，您的验证码是'. $code);
                $content="【戏宝】注册操作，您的验证码是".$code;
            }else{
                $data['status']  = 400;
                $data['msg'] = "该手机号已被注册";
                $this->ajaxReturn($data);
            }
        }elseif($type==2){//找回密码
            if($user->where(array('mobile'=>$mobile))->find()){
                $result = $clapi->sendSMS($mobile, '【戏宝】找回密码操作，您的验证码是'. $code);
                $content="【戏宝】找回密码操作，您的验证码是".$code;
            }else{
                $data['status']  = 400;
                $data['msg'] = "手机号不存在";
                $this->ajaxReturn($data);
            }


        }elseif($type==3){//验证手机号
            if(empty($user->where(array('mobile'=>$mobile))->find())){
                $result = $clapi->sendSMS($mobile, '【戏宝】绑定手机操作，您的验证码是'. $code);
                $content="【戏宝】绑定手机操作，您的验证码是".$code;
            }else{
                $data['status']  = 400;
                $data['msg'] = "该手机号已被注册";
                $this->ajaxReturn($data);
            }

        }else{//验证码登录
            if($user->where(array('mobile'=>$mobile))->find()){
                $result = $clapi->sendSMS($mobile, '【戏宝】验证码登录操作，您的验证码是'. $code);
                $content="【戏宝】验证码登录操作，您的验证码是".$code;
            }else{
                $data['status']  = 400;
                $data['msg'] = "手机号不存在";
                $this->ajaxReturn($data);
            }
        }
        if(!is_null(json_decode($result))){

            $output=json_decode($result,true);
            if(isset($output['code'])  && $output['code']=='0'){

                $smsLog=M("duanxin");
                $dat['mobile']=$mobile;
                $dat['addtime']=time();
                $dat['code']=$code;
                $dat['content']=$content;
                $iii=$smsLog->add($dat);

                $data['status']  = 200;
//                $data['time']  = time();
                $data['msg'] = '发送成功';

            }else{

                $data['status']  = 300;
                $data['msg'] = $output['errorMsg'];
            }
        }else{

            $data['status']  = 400;
            $data['msg'] = $result;
        }
        $this->ajaxReturn($data);
    }

    function about(){
        $Notice =M('Notice');

        $arr=$Notice->where(array('id'=>7))->field("content,news_title")->find();
        $arr['content']=strip_tags($arr['content']);
        $this->assign('ret',$arr);
        $this->display();

    }
    function iiii(){
        $Notice =M('Notice');
$id=$_GET['idsse'];
        $arr=$Notice->where(array('id'=>$id))->field("content,news_title")->find();
        $arr['content']=strip_tags($arr['content']);
        $this->assign('ret',$arr);
        $this->display();

    }
    function agreement(){
        $Notice =M('Notice');

        $arr=$Notice->where(array('id'=>9))->field("content,news_title")->find();
        $arr['content']=strip_tags($arr['content']);
        $this->assign('ret',$arr);
        $this->display();

    }
 function qqkf(){
        $Notice =M('Notice');

        $arr=$Notice->where(array('id'=>8))->getField("content");
     $data['status']  = 200;
     $data['msg'] = "QQ客服";
     $data['data'] = $arr;
       $this->ajaxReturn($data);

    }




    public function gonggao(){
        $request = getClientRequest();
        $p=$request['p'];
        if($p=="" || $p==1 || $p==0){
            $pp=0;
        }else{
            $p=$p-1;
            $p=$p*10;
            $pp=$p+1;
        }

        $News = M('notice');
        $map['type'] = 2;
        $list = $News->where($map)->field("id,news_title,content1,addtime")->limit($pp,10)->order("addtime desc")->select();
        foreach ($list as &$v){
            $v['addtime']=dateformat($v['addtime'],2);
            $v['link_url']="http://".$_SERVER['HTTP_HOST']."/index.php/Home/Index/iiii/idsse/".$v['id'];
        }
       if(!empty($list)){
           $ret['status'] = 200;
           $ret['msg'] = '公告列表';
           $ret['data'] = $list;
       }else{
           $ret['status'] = 300;
           $ret['msg'] = '暂无更多';
       }
       $this->ajaxReturn($ret);
    }


}