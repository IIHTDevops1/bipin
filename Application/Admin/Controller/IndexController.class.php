<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends AdminController {


    public function index(){



		$this->display();
	}

    /**
     *  后台欢迎页
     */
    public function welcome(){
        $monday = getFirstDayOfWeek();//本周开始时间

        //会员信息
        $User = M('User');
        $usercount = $User->count("id");
        $this->assign('usercount', $usercount);

        $usermap['addtime'] = array('gt',$monday);
        $usercount = $User->where($usermap)->count("id");
        $this->assign('usercount_week', $usercount);

        $dsh1 = $User->where("level=1")->count("id");
        $dsh=  $dsh1-1;
        $this->assign('dsh1', $dsh);
//        //待审核
//        $BankCard = M('signup');
        $bankmap['is_true'] = 2;
        $bacncount = $User->where($bankmap)->count('id');
        $this->assign('dsh', $bacncount);

//        $bankmap['status'] = 2;
//        $bacncount1 = $BankCard->where($bankmap)->count('id');
//        $this->assign('ytg', $bacncount1);

//        $bankmap['status'] = 3;
//        $bacncount2 = $BankCard->where($bankmap)->count('id');
//        $this->assign('ybh', $bacncount2);



        $this->display();
    }


    //代理商
    public function zhanghu(){
        $p = I('get.p',1);
        $Order =M('user');
        $map['level']=1;
        $map['id']=array('neq',1);
        $list = $Order->where($map)->order('addtime desc')->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->field('id,user_id,username,loginpwds,addtime')->select();

        $mapcount = $Order->where($map)->count();
        $show = getpages2($mapcount);


        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    public function caiwulog(){
        $p = I('get.p',1);
        $Order =M('caiwu_log');
//        $map['level']=1;
//        $map['id']=array('neq',1);
        $list = $Order->where($map)->order('addtime desc')->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();

        $mapcount = $Order->where($map)->count();
        $show = getpages2($mapcount);


        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    public function addzhanghu(){
//活动
        $News = M('user');

        if($_POST){


            $data['loginpwd']=md5($_POST['loginpwds']);
            $data['loginpwds']=$_POST['loginpwds'];
            $data['username']=$_POST['username'];


            if($_POST['idd']==""){
                $data['channel']=1;
                $data['level']=1;
                $data['mobile']=0;
                $data['addtime']=time();
                $data['user_id']=sclws();
                $result=$News->add($data);
            }else{
                $result=$News->where(array('id'=>$_POST['idd']))->save($data);
            }

            if($result){
                $this->redirect('zhanghu',array(),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('zhanghu',array(),1,'操作失败,正在返回列表...');
            }
        }else{
            $id=$_GET['user_id'];

            $infos=$News->where(array('user_id'=>$id))->field('id,user_id,username,loginpwds,addtime')->find();
//





            $this->assign("infos",$infos);

            $this->display();
        }

    }

    function vipmima13(){
        $notice=M("notice");

        if($_POST){
            if($_POST['pwds13']==$_POST['pwds113']){
                $iiii=$notice->where(array('id'=>13))->setField("news_title",$_POST['pwds13']);

                if($iiii){
                    $this->redirect('vipmima',array(),1,'VIP等级管理密码正确,正在加载...');
                }else{
                    $this->redirect('vipmima',array(),1,'VIP等级管理密码错误...');
                }
            }else{
                $this->redirect('vipmima',array(),1,'VIP等级管理密码两次密码不一致...');
            }

        }else{
            $iiii=$notice->where(array('id'=>13))->getField("news_title");
            $this->assign("pwds13",$iiii);
            $this->display();
        }
    } function vipmima14(){
        $notice=M("notice");

        if($_POST){
            if($_POST['pwds14']==$_POST['pwds114']){
                $iiii=$notice->where(array('id'=>14))->setField("news_title",$_POST['pwds14']);

                if($iiii){
                    $this->redirect('vipmima',array(),1,'拨比设置密码正确,正在加载...');
                }else{
                    $this->redirect('vipmima',array(),1,'拨比设置密码错误...');
                }
            }else{
                $this->redirect('vipmima',array(),1,'拨比设置密码两次密码不一致...');
            }

        }else{
            $iiii=$notice->where(array('id'=>14))->getField("news_title");
            $this->assign("pwds14",$iiii);
            $this->display();
        }
    }function vipmima15(){
        $notice=M("notice");

        if($_POST){
            if($_POST['pwds15']==$_POST['pwds115']){
                $iiii=$notice->where(array('id'=>15))->setField("news_title",$_POST['pwds15']);

                if($iiii){
                    $this->redirect('vipmima',array(),1,'拨比设置密码正确,正在加载...');
                }else{
                    $this->redirect('vipmima',array(),1,'拨比设置密码错误...');
                }
            }else{
                $this->redirect('vipmima',array(),1,'拨比设置密码两次密码不一致...');
            }

        }else{
            $iiii=$notice->where(array('id'=>15))->getField("news_title");
            $this->assign("pwds15",$iiii);
            $this->display();
        }
    }
    function vipmima16(){
        $notice=M("notice");

        if($_POST){
            if($_POST['pwds16']==$_POST['pwds116']){
                $iiii=$notice->where(array('id'=>16))->setField("news_title",$_POST['pwds16']);

                if($iiii){
                    $this->redirect('vipmima',array(),1,'修改推荐人密码设置成功,正在加载...');
                }else{
                    $this->redirect('vipmima',array(),1,'修改推荐人密码设置失败...');
                }
            }else{
                $this->redirect('vipmima',array(),1,'修改推荐人两次密码不一致...');
            }

        }else{
            $iiii=$notice->where(array('id'=>16))->getField("news_title");
            $this->assign("pwds16",$iiii);
            $this->display();
        }
    }
    function vipmima17(){
        $notice=M("notice");

        if($_POST){
            if($_POST['pwds17']==$_POST['pwds117']){
                $iiii=$notice->where(array('id'=>17))->setField("news_title",$_POST['pwds17']);

                if($iiii){
                    $this->redirect('vipmima',array(),1,'查看财务数据设置密码成功,正在加载...');
                }else{
                    $this->redirect('vipmima',array(),1,'查看财务数据设置密码失败...');
                }
            }else{
                $this->redirect('vipmima',array(),1,'查看财务数据两次密码不一致...');
            }

        }else{
            $iiii=$notice->where(array('id'=>17))->getField("news_title");
            $this->assign("pwds17",$iiii);
            $this->display();
        }
    } function vipmima20(){
        $notice=M("notice");

        if($_POST){
            if($_POST['pwds20']==$_POST['pwds120']){
                $iiii=$notice->where(array('id'=>18))->setField("news_title",$_POST['pwds20']);

                if($iiii){
                    $this->redirect('vipmima',array(),1,'冻结/解冻用户资金设置密码成功,正在加载...');
                }else{
                    $this->redirect('vipmima',array(),1,'冻结/解冻用户资金设置密码失败...');
                }
            }else{
                $this->redirect('vipmima',array(),1,'冻结/解冻用户资金两次密码不一致...');
            }

        }else{
            $iiii=$notice->where(array('id'=>18))->getField("news_title");
            $this->assign("pwds20",$iiii);
            $this->display();
        }
    }
    function vipmima(){
        $notice=M("notice");


            $iiii13=$notice->where(array('id'=>13))->getField("news_title");
            $this->assign("pwds13",$iiii13);
            $iiii14=$notice->where(array('id'=>14))->getField("news_title");
            $this->assign("pwds14",$iiii14);
            $iiii15=$notice->where(array('id'=>15))->getField("news_title");
            $this->assign("pwds15",$iiii15);
            $iiii16=$notice->where(array('id'=>16))->getField("news_title");
            $this->assign("pwds16",$iiii16);
            $iiii17=$notice->where(array('id'=>17))->getField("news_title");
            $this->assign("pwds17",$iiii17);
            $iiii20=$notice->where(array('id'=>18))->getField("news_title");
            $this->assign("pwds20",$iiii20);
            $this->display();

    }
    public function del(){
    $id = I('user_id');
    $News = M('user');
    $arr = $News->where(array('user_id'=>$id))->delete();
    if($arr){

        $this->redirect('zhanghu',array(),1,'删除成功,正在返回列表...');
    }
    else{
        $this->redirect('zhanghu',array(),1,'系统繁忙，请重试...');
    }
}


}