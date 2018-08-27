<?php
namespace Home\Controller;
use Think\Controller;
class PercenController extends Controller {




//个人中心

//VIP升级记录+戏币购买记录
public function viplist(){
    $request = getClientRequest();
    $user_id = $request['user_id'];
    $types = $request['types'];//1戏币充值3VIP升级
    $p=$request['p'];
    if($p=="" || $p==1 || $p==0){
        $pp=0;
    }else{
        $p=$p-1;
        $p=$p*15;
        $pp=$p+1;
    }
    $xibilog=M("xibilog");
    $where['user_id']=$user_id;
    $where['types']=$types;
    $where['status']=2;//已支付

    $arr=$xibilog->where($where)->order("addtime desc")->limit($pp,15)->field("user_id,xibi,addtime,transnum,price,content")->select();
    foreach ($arr as &$v){
        $v['addtime']=dateformat($v['addtime'],2);
    }
    if(!empty($arr)){
        $ret['status']=200;
        $ret['msg'] = '数据列表';
        $ret['data']=$arr;
    }else{
        $ret['status'] = 300;
        $ret['msg'] = '暂无更多';
    }
    $this->ajaxReturn($ret);
}

//实名提交
public function go_true(){
    $request = getClientRequest();
    $user_id = $request['user_id'];


    $user=M("user");
    $is_true=$user->where(array('user_id'=>$user_id))->field("truename,sex,user_id,zheng,fan,idcards,is_true,addr")->find();
    if($is_true['is_true']==1 || $is_true['is_true']==3){

//        $is_idcard=isIdCard($request['idcards']);
        $is_idcard=strlen($request['idcards']);
        if($is_idcard>14 && $is_idcard<19){

            $data['truename']=$request['truename'];
            $data['sex']=$request['sex'];
            $data['zheng']=$request['zheng'];
            $data['fan']=$request['fan'];
            $data['addr']=$request['addr'];
            $data['idcards']=$request['idcards'];
            $data['is_true']=2;//待审核
            $ddd=$user->where(array('user_id'=>$user_id))->save($data);
            if($ddd){
                $ret['status'] = 200;
                $ret['msg'] = '已提交，等待审核';
            }else{
                $ret['status'] = 300;
                $ret['msg'] = '请重新提交';
            }

        }else{
            $ret['status'] = 500;
            $ret['msg'] = '身份证格式错误';
        }


    }elseif($is_true['is_true']==2){
        $ret['status'] = 200;
        $ret['msg'] = '已提交，等待审核';
    }else{
        $ret['status'] = 400;
        $ret['msg'] = '已实名成功';
    }


$this->ajaxReturn($ret);

}


//删除账户
public function del_pay(){
    $request = getClientRequest();
    $user_id = $request['user_id'];
    $type = $request['type'];
    if($type==1){
        $add['alipay']=1;
        $add['alipay_name']=1;
    }else{
        $add['wechat']=1;
        $add['wechat_name']=1;
    }
    $table=M("user");
    $ddd=$table->where(array('user_id'=>$user_id))->save($add);
    if($ddd){
        $ret['status'] = 200;
        $ret['msg'] = '删除成功';
    }else{
        $ret['status'] = 300;
        $ret['msg'] = '账户未添加';
    }

    $this->ajaxReturn($ret);
}

//我的账户
public function my_pay(){
    $request = getClientRequest();
    $user_id = $request['user_id'];
    $table=M("user");
    $ddd=$table->where(array('user_id'=>$user_id))->field("user_id,alipay,wechat")->find();
    if($ddd){
        if($ddd['alipay']==1){
            $dd=array();
        }else{
            $dd['id']=1;
            $dd['alipay']=$ddd['alipay'];
            $ret['alipay']=$dd;
        }
        if($ddd['wechat']==1){
            $ddw=array();
        }else{
            $ddw['id']=2;
            $ddw['wechat']=$ddd['wechat'];
            $ret['wechat']=$ddw;
        }

        $ret['status'] = 200;
        $ret['msg'] = '我的账户';


    }else{
        $ret['status'] = 300;
        $ret['msg'] = '用户不存在';
    }

$this->ajaxReturn($ret);
}

//添加/修改支付宝账户或微信账户
public function add_pay(){
    $request = getClientRequest();
    $user_id = $request['user_id'];
    $type = $request['type'];
    if($type==1){
        $add['alipay']=$request['account'];
        $add['alipay_name']=$request['account_name'];
    }else{
        $add['wechat']=$request['account'];
        $add['wechat_name']=$request['account_name'];
    }
$table=M("user");
    $ddd=$table->where(array('user_id'=>$user_id))->save($add);
    if($ddd){
        $ret['status'] = 200;
        $ret['msg'] = '添加成功';
    }else{
        $ret['status'] = 300;
        $ret['msg'] = '系统繁忙，请重试';
    }

    $this->ajaxReturn($ret);
}

    //修改用户信息
    public function chenge_img(){
        $request = getClientRequest();
        $user_id = $request['user_id'];

        if(!empty($request['thumb'])){
            $data['thumb']=$request['thumb'];
        }
        if(!empty($request['username'])){
            $data['username']=$request['username'];
        }
        if(!empty($request['email'])){
            $data['email']=$request['email'];
        }
        if(!empty($request['sex'])){
            $data['sex']=$request['sex'];
        }
        if(!empty($request['addr'])){
            $data['addr']=$request['addr'];
        }


        $user=M("user");
        $is_user=$user->where(array('user_id'=>$user_id))->find();
        if($is_user){
            $result=$user->where(array('user_id'=>$user_id))->save($data);
            if($result){
                $ret['status'] = 200;
                $ret['msg'] = '修改成功';
            }else{
                $ret['status'] = 300;
                $ret['msg'] = '系统繁忙，请重试';
            }
        }else{
            $ret['status'] = 300;
            $ret['msg'] = '用户不存在，请登录';
        }
        $this->ajaxReturn($ret);
    }
    //用户基本信息
    public function user_info(){
        $request = getClientRequest();
        $user_id = $request['user_id'];
        $user=M("user");
//        $result=$user->where(array('user_id'=>$user_id))->field("thumb,email,truename,sex,addr")->find();
        $result=$user->where(array('user_id'=>$user_id))->field("username,user_id,mobile,level,thumb,email,truename,sex,addr,is_true,jiguang,jiguangpwd")->find();
        if(!empty($result)){

            if($result['jiguang']==1){
                require_once 'Jiguang/JMessage.php';
                require_once 'Jiguang/Http.php';
                require_once 'Jiguang/IM.php';
                require_once 'Jiguang/User.php';
                $appKey = '97f6c9343428cc19be157730';
                $masterSecret = '37302ebc40bb4ddd006de69f';

                $client = new \JMessage($appKey, $masterSecret);

                $user11 = new \User($client);
                $response = $user11->register($result['mobile'], "111111");
                if(empty($response['body'][0]['error'])){

                    $data['jiguang']=$result['mobile'];
                    $data['jiguangpwd']="111111";
                    $user->where(array('user_id'=>$user_id))->save($data);
                }
                $result['jiguang'] = $data['jiguang'];
                $result['jiguangpwd'] = $data['jiguangpwd'];
            }


            $likelog=M("likelog");
            $workss=M("workss");
            if($result['email'] !=0){

            }else{
                $result['email'] = "";
            }
            $result['following'] = $likelog->where(array('types'=>2,'user_id'=>$user_id,'tables'=>'user'))->count();//关注
            $result['fans'] =  $likelog->where(array('types'=>2,'likeid'=>$user_id,'tables'=>'user'))->count();//粉丝
            $result['letters'] =  $user->count();//私信
            $result['works'] =  $workss->where(array('user_id'=>$user_id))->count();//作品
            $result['level_name']=get_level($result['level']);
//            if($result['is_true']==4 || $result['is_true']==2){
//                $result['is_true']="2";//已经实名
//            }else{
//                $result['is_true']="1";//未实名认证
//            }
            $ret['status'] = 200;
            $ret['msg'] = '用户信息';
            $ret['data'] = $result;

        }else{
            $ret['status'] = 300;
            $ret['msg'] = '用户不存在';
        }
        $this->ajaxReturn($ret);
    }
    //个人主页
    public function home_page(){
        $request = getClientRequest();
        $user_id = $request['user_id'];
        $likeid = $request['likeid'];
        $p = $request['p'];
        if($p=="" || $p==1 || $p==0){
            $pp=0;
        }else{
            $p=$p-1;
            $p=$p*15;
            $pp=$p+1;
        }
        $user=M("user");
        $likelog=M("likelog");

        $workss=M("workss");
//        $result=$user->where(array('user_id'=>$user_id))->field("thumb,email,truename,sex,addr")->find();
        $ret=$user->where(array('user_id'=>$likeid))->field("username,user_id,thumb")->find();
        if(!empty($ret)){
            $ret['following'] = $likelog->where(array('user_id'=>$likeid,'types'=>2,'tables'=>'user'))->count();//关注
            $ret['fans'] = $likelog->where(array('likeid'=>$likeid,'types'=>2,'tables'=>'user'))->count();//粉丝
            $ret['zan'] = $likelog->where(array('user_id'=>$likeid))->count();//获赞
            $ret['nums'] = $workss->where(array('user_id'=>$likeid))->count();//作品
            $ret['likes'] = $likelog->where(array('user_id'=>$likeid))->count();//喜欢

            $map['likeid']= $likeid;
            $map['tables']="user";
            $map['user_id']=$user_id;
            $map['types']=2;//关注的人
            if($likelog->where($map)->getField('id')){
                $ret['is_guanzhu']=1;//已关注发布人
            }else{
                $ret['is_guanzhu']=2;//未关注发布人
            }
            $workss=M("workss");
$arr=$workss->where(array('yonghu'=>1,'user_id'=>$likeid))->field("id,news_title,thumb,describes,plays,fenlei,workss")->limit($pp,15)->select();

            $ret['status'] = 200;
            $ret['msg'] = '个人主页';

            if(!empty($arr)){
                $ret['data']=$arr;
            }else{
                $ret['data']=array();
            }
        }else{
            $ret['status'] = 300;
            $ret['msg'] = '用户不存在';
        }
        $this->ajaxReturn($ret);
    }
    //某人喜欢的作品
    public function some_like(){
        $request = getClientRequest();
        $user_id = $request['user_id'];

        $p = $request['p'];
        if($p=="" || $p==1 || $p==0){
            $pp=0;
        }else{
            $p=$p-1;
            $p=$p*15;
            $pp=$p+1;
        }
        $workss=M("workss");
        $likelog=M("likelog");
        $result=$likelog->where(array('user_id'=>$user_id,'types'=>3,'tables'=>'workss'))->field("id,likeid")->order("addtime desc")->limit($pp,15)->select();
        if(!empty($result)){
            foreach ($result as &$v){
                $ff= $workss->where(array('id'=>$v['likeid']))->field("id,news_title,thumb,describes,plays,fenlei,workss")->find();
                if(empty($ff)){
                    $likelog->where(array('id'=>$v['likeid']))->delete();
unset($v);
                }else{
                    $v['id']=$ff['id'];
                    $v['news_title']=$ff['news_title'];
                    $v['thumb']=$ff['thumb'];
                    $v['describes']=$ff['describes'];
                    $v['plays']=$ff['plays'];
                    $v['fenlei']=$ff['fenlei'];
                    $v['workss']=$ff['workss'];
                }

            }sort($result);

            $ret['status'] = 200;
            $ret['msg'] = '喜欢的作品列表';
            $ret['data']=$result;
        }else{
            $ret['status'] = 300;
            $ret['msg'] = '暂无更多';
        }
        $this->ajaxReturn($ret);


    }



//验证码登录
    public function login_code(){

        $request = getClientRequest();
        $mobile = $request['mobile'];
        $code = $request['code'];
        $tables=M('user');
        $result =$tables->where(array('mobile'=>$mobile))->Field("username,user_id,mobile,level,thumb,loginpwd,email,truename,sex,addr,is_true,jiguang,jiguangpwd,status,vipend")->find();
        if($result){
if($result['vipend']< time()){//判断vip过期时间
   $tables->where(array('mobile'=>$mobile))->save(array('level'=>2,'xiazai'=>0));
    $result =$tables->where(array('mobile'=>$mobile))->Field("username,user_id,mobile,level,thumb,loginpwd,email,truename,sex,addr,is_true,jiguang,jiguangpwd,status,vipend")->find();

}
            if($result['status']==2){
                $ret['status'] = 500;
                $ret['msg'] = '该用户被禁用';
                $this->ajaxReturn($ret);
            }
            $log= M('duanxin')->where(array('mobile'=>$mobile,'code'=>$code))->find();
            if($log){
                if($result['jiguang']==1){
                    require_once 'Jiguang/JMessage.php';
                    require_once 'Jiguang/Http.php';
                    require_once 'Jiguang/IM.php';
                    require_once 'Jiguang/User.php';
                    $appKey = '97f6c9343428cc19be157730';
                    $masterSecret = '37302ebc40bb4ddd006de69f';

                    $client = new \JMessage($appKey, $masterSecret);

                    $user11 = new \User($client);
                    $response = $user11->register($result['mobile'], "111111");
                    if(empty($response['body'][0]['error'])){

                        $data['jiguang']=$result['mobile'];
                        $data['jiguangpwd']="111111";
                        $tables->where(array('mobile'=>$mobile))->save($data);
                    }
                }

                $ret['status'] = 200;
                $ret['msg'] = '登录成功';
                $ret['data']['username'] = $result['username'];
                $ret['data']['user_id'] = $result['user_id'];
                $ret['data']['mobile'] = $result['mobile'];
                $ret['data']['level'] = $result['level'];
                $ret['data']['truename'] = $result['truename'];
                if($result['email'] !=0){
                    $ret['data']['email'] = $result['email'];
                }else{
                    $ret['data']['email'] = "";
                }
                $ret['data']['sex'] = $result['sex'];
                $ret['data']['level_name']=get_level($result['level']);
                $ret['data']['thumb'] = $result['thumb'];
                $ret['data']['addr'] = $result['addr'];
                if($result['jiguang']==1){
                    $ret['data']['jiguang'] = $data['jiguang'];
                    $ret['data']['jiguangpwd'] = $data['jiguangpwd'];
                }else{
                    $ret['data']['jiguang'] = $result['jiguang'];
                    $ret['data']['jiguangpwd'] = $result['jiguangpwd'];
                }

                $likelog=M("likelog");
                $workss=M("workss");
                $ret['data']['following'] = $likelog->where(array('types'=>2,'user_id'=>$ret['data']['user_id'],'tables'=>'user'))->count();//关注
                $ret['data']['fans'] =  $likelog->where(array('types'=>2,'likeid'=>$ret['data']['user_id'],'tables'=>'user'))->count();//粉丝
                $ret['data']['letters'] =  $likelog->count();//私信
                $ret['data']['works'] =  $workss->where(array('user_id'=>$ret['data']['user_id']))->count();//作品
                $ret['data']['is_true']=$result['is_true'];
//                if($result['is_true']==4 || $result['is_true']==2){
//                    $ret['data']['is_true']="2";//已经实名
//                }else{
//                    $ret['data']['is_true']="1";//未实名认证
//                }
            }
            else{
                $ret['status'] = 300;
                $ret['msg'] = '验证码错误，请重试';
            }
        }else{
            $ret['status'] = 400;
            $ret['msg'] = '账户不存在，请重试';
        }

        $this->ajaxReturn($ret);
    }
//密码登录
    public function login_pwd(){
        $request = getClientRequest();
        $mobile = $request['mobile'];
        $pwd = md5($request['pwd']);
        $tables=M('user');
        $result =$tables->where(array('mobile'=>$mobile))->Field("username,user_id,mobile,level,thumb,loginpwd,email,truename,sex,addr,is_true,jiguang,jiguangpwd,status,vipend")->find();
        if($result){
            if($result['vipend']< time()){//判断vip过期时间
                $tables->where(array('mobile'=>$mobile))->save(array('level'=>2,'xiazai'=>0));
                $result =$tables->where(array('mobile'=>$mobile))->Field("username,user_id,mobile,level,thumb,loginpwd,email,truename,sex,addr,is_true,jiguang,jiguangpwd,status,vipend")->find();

            }
            if($result['status']==2){
                $ret['status'] = 500;
                $ret['msg'] = '该用户被禁用';
                $this->ajaxReturn($ret);
            }
            if($pwd == $result['loginpwd']){
                if($result['jiguang']==1){
                    require_once 'Jiguang/JMessage.php';
                    require_once 'Jiguang/Http.php';
                    require_once 'Jiguang/IM.php';
                    require_once 'Jiguang/User.php';
                    $appKey = '97f6c9343428cc19be157730';
                    $masterSecret = '37302ebc40bb4ddd006de69f';

                    $client = new \JMessage($appKey, $masterSecret);

                    $user11 = new \User($client);
                    $response = $user11->register($result['mobile'], $pwd);
                    if(empty($response['body'][0]['error'])){

                        $data['jiguang']=$result['mobile'];
                        $data['jiguangpwd']=$pwd;
                        $tables->where(array('mobile'=>$mobile))->save($data);
                    }
                }
                $ret['status'] = 200;
                $ret['msg'] = '登录成功';
                $ret['data']['username'] = $result['username'];
                $ret['data']['user_id'] = $result['user_id'];
                $ret['data']['mobile'] = $result['mobile'];
                $ret['data']['level'] = $result['level'];
                $ret['data']['truename'] = $result['truename'];
                $ret['data']['sex'] = $result['sex'];
                if($result['email'] !=0){
                    $ret['data']['email'] = $result['email'];
                }else{
                    $ret['data']['email'] = "";
                }

                $ret['data']['level_name']=get_level($result['level']);
                $ret['data']['thumb'] = $result['thumb'];
                $ret['data']['addr'] = $result['addr'];
                if($result['jiguang']==1){
                    $ret['data']['jiguang'] = $data['jiguang'];
                    $ret['data']['jiguangpwd'] = $data['jiguangpwd'];
                }else{
                    $ret['data']['jiguang'] = $result['jiguang'];
                    $ret['data']['jiguangpwd'] = $result['jiguangpwd'];
                }

                $likelog=M("likelog");
                $workss=M("workss");
                $ret['data']['following'] = $likelog->where(array('types'=>2,'user_id'=>$ret['data']['user_id'],'tables'=>'user'))->count();//关注
                $ret['data']['fans'] =  $likelog->where(array('types'=>2,'likeid'=>$ret['data']['user_id'],'tables'=>'user'))->count();//粉丝
                $ret['data']['letters'] =  $tables->count();//私信
                $ret['data']['works'] =  $workss->where(array('user_id'=>$ret['data']['user_id']))->count();//作品
                $ret['data']['is_true']=$result['is_true'];
//                if($result['is_true']==4 || $result['is_true']==2){
//                        $ret['data']['is_true']="2";//已经实名
//                }else{
//                    $ret['data']['is_true']="1";//未实名认证
//                }
            }
            else{
                $ret['status'] = 300;
                $ret['msg'] = '密码错误，请重试';
            }
        }else{
            $ret['status'] = 400;
            $ret['msg'] = '账户不存在，请重试';
        }
        $this->ajaxReturn($ret);
    }

    //注册
    public function Reg(){
        $request = getClientRequest();
        $data['mobile'] = $request['mobile'];
        $code = $request['code'];
        $pwd = $request['pwd'];
        $table=M('duanxin');
        $log= $table->where(array('mobile'=>$data['mobile'],'code'=>$code))->order("addtime desc")->find();
        if($log){
            $user=M("user");
            $is_mobile=$user->where(array("mobile"=>$data['mobile']))->find();
            if($is_mobile){
                $ret['status'] = 400;
                $ret['msg'] = '此手机号已被注册，可直接登录';
            }else{


                //等级，1总管理员2用户
                $data['level']=2;
                $data['addtime']=time();
                $data['user_id']=sclws();
                $data['loginpwd']=md5($pwd);
                $data['loginpwds']=$pwd;

                require_once 'Jiguang/JMessage.php';
                require_once 'Jiguang/Http.php';
                require_once 'Jiguang/IM.php';
                require_once 'Jiguang/User.php';
                $appKey = '97f6c9343428cc19be157730';
                $masterSecret = '37302ebc40bb4ddd006de69f';

                $client = new \JMessage($appKey, $masterSecret);

                $user11 = new \User($client);
                $response = $user11->register($data['mobile'], $pwd);
                if(empty($response['body'][0]['error'])){

                    $data['jiguang']=$data['mobile'];
                    $data['jiguangpwd']=$pwd;
                }

                $result= $user->add($data);
                if($result){
                    $reg['user_id']=$data['user_id'];
                    $reg['level']=$data['level'];
                    $reg['jiguang']=$data['mobile'];
                    $reg['jiguangpwd']=$pwd;
                    $reg['level_name']=get_level($data['level']);
                    $ret['status'] = 200;
                    $ret['msg'] = '注册成功';
                    $ret['data'] = $reg;
                }else{
                    $ret['status'] = 300;
                    $ret['msg'] = '系统繁忙，请重试';
                }
            }

        }else{
            $ret['status'] = 300;
            $ret['msg'] = '验证码错误';
        }

        $this->ajaxReturn($ret);

    }

    public function streelogin(){
        $request = getClientRequest();
        $data['unid'] = $request['unid'];
        $data['uidtype'] = $request['uidtype'];


            $user=M("user");
            $likelog=M("likelog");
            $workss=M("workss");
            $is_mobile=$user->where($data)->find();
        $data['sex'] = $request['sex'];

        $data['username']=$request['username'];
        $data['thumb']=$request['thumb'];
            if($is_mobile){

                if($is_mobile['vipend']< time()){//判断vip过期时间
                    $user->where(array('unid'=>$data['unid'],'uidtype'=>$data['uidtype']))->save(array('level'=>2,'xiazai'=>0));
                    $is_mobile =$user->where(array('unid'=>$data['unid'],'uidtype'=>$data['uidtype']))->Field("username,user_id,mobile,level,thumb,loginpwd,email,truename,sex,addr,is_true,jiguang,jiguangpwd,status,vipend")->find();
                }
                if($is_mobile['status']==2){
                    $ret['status'] = 500;
                    $ret['msg'] = '该用户被禁用';
                    $this->ajaxReturn($ret);
                }


//                $user->where(array('unid'=>$data['unid']))->save(array('username'=>$data['username'],'thumb'=>$data['thumb'],'sex'=>$data['sex']));
                $ret['status'] = 200;
                $ret['msg'] = '登录成功';
                $ret['data']['username'] = $data['username'];
                $ret['data']['user_id'] = $is_mobile['user_id'];
                $ret['data']['mobile'] = $is_mobile['mobile'];
                $ret['data']['level'] = $is_mobile['level'];
                $ret['data']['truename'] = $is_mobile['truename'];
                $ret['data']['email'] = $is_mobile['email'];
                $ret['data']['sex'] = $is_mobile['sex'];
                $ret['data']['level_name']=get_level($is_mobile['level']);
                $ret['data']['thumb'] = $data['thumb'];
                $ret['data']['addr'] = $is_mobile['addr'];
                $ret['data']['jiguang'] = $is_mobile['jiguang'];
                $ret['data']['jiguangpwd'] = $is_mobile['jiguangpwd'];

                $ret['data']['following'] = $likelog->where(array('types'=>2,'user_id'=>$ret['data']['user_id'],'tables'=>'user'))->count();//关注
                $ret['data']['fans'] =  $likelog->where(array('types'=>2,'likeid'=>$ret['data']['user_id'],'tables'=>'user'))->count();//粉丝
                $ret['data']['letters'] =  $user->count();//私信
                $ret['data']['works'] =  $workss->where(array('user_id'=>$ret['data']['user_id']))->count();//作品
                $ret['data']['is_true']=$is_mobile['is_true'];
//                if($is_mobile['is_true']==4 || $is_mobile['is_true']==2){
//                    $ret['data']['is_true']="2";//已经实名
//                }else{
//                    $ret['data']['is_true']="1";//未实名认证
//                }

            }else{
                //等级，1总管理员2用户
                $data['level']=2;
                $data['addtime']=time();
                $data['user_id']=sclws();

                require_once 'Jiguang/JMessage.php';
                require_once 'Jiguang/Http.php';
                require_once 'Jiguang/IM.php';
                require_once 'Jiguang/User.php';
                $appKey = '97f6c9343428cc19be157730';
                $masterSecret = '37302ebc40bb4ddd006de69f';

                $client = new \JMessage($appKey, $masterSecret);

                $user11 = new \User($client);
                $response = $user11->register($data['user_id'], '111111');
                if(empty($response['body'][0]['error'])){

                    $data['jiguang']=$data['user_id'];
                    $data['jiguangpwd']='111111';
                }

                $result= $user->add($data);
                if($result){
                    $ret['status'] = 200;
                    $ret['msg'] = '登录成功';
                    $ret['data']['username'] =  $data['username'];
                    $ret['data']['user_id'] = $data['user_id'];
                    $ret['data']['mobile'] = "";
                    $ret['data']['level'] = $data['level'];
                    $ret['data']['truename'] = "";
                    $ret['data']['email'] ="";
                    $ret['data']['sex'] ="";
                    $ret['data']['level_name']=get_level($data['level']);
                    $ret['data']['thumb'] = $data['thumb'];
                    $ret['data']['addr'] = "";
                    $ret['data']['jiguang'] = $data['jiguang'];
                    $ret['data']['jiguangpwd'] = $data['jiguangpwd'];
                    $ret['data']['following'] = $likelog->where(array('types'=>2,'user_id'=>$ret['data']['user_id'],'tables'=>'user'))->count();//关注
                    $ret['data']['fans'] =  $likelog->where(array('types'=>2,'likeid'=>$ret['data']['user_id'],'tables'=>'user'))->count();//粉丝
                    $ret['data']['letters'] =  $user->count();//私信
                    $ret['data']['works'] =  $workss->where(array('user_id'=>$ret['data']['user_id']))->count();//作品
                    $ret['data']['is_true']="1";//未实名认证
                }else{
                    $ret['status'] = 300;
                    $ret['msg'] = '系统繁忙，请重试';
                }
            }


        $this->ajaxReturn($ret);

    }
}