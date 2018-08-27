<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/5
 * Time: 9:57
 */
namespace Admin\Controller;
use Think\Controller;

class PublicController extends Controller {

    public function index(){



    }

    public function login(){

        if(IS_POST){

            $username= I('user_name');
            $password = I('password');
            $User = D('User');

            $map['username']=$username;
            $map['mobile']=$username;
            $map['_logic']='OR';

            $user = $User->where($map)->field('user_id,level,loginpwds,username')->find();


            if(is_array($user)){

                if($user['level']==1 ){


                    if($password === $user['loginpwds']){

                        $this->autoLogin($user); //更新用户登录信息

                        $this->redirect('Index/index');
                    } else {
                        $this->error('密码错误');
                    }

                }
                else{

                    $this->error('没有权限');
                }




            } else {
                $this->error('用户不存在或被禁用');
            }

        }
        else{

            $this->display();
        }
    }
    public function changge(){
        if(IS_POST){
            $User = D('User');
            $_POST['pwds113'];
            if($_POST['pwds13']==$_POST['pwds113']){
                $data['loginpwds']=$_POST['pwds13'];
                $data['loginpwd']=md5($_POST['pwds13']);
                $user = $User->where(array('user_id'=>$_SESSION['user_auth']['uid']))->save($data);
                if($user){
                    $this->redirect('logout', array(), 1, '修改成功,重新登录...');
                } else {
                    $this->error('修改失败');
                }
            }else{
                $this->error('两次密码不一样');
            }
        }
        else{
            $this->display();
        }
    }
    public function logince(){

        if(IS_POST){

            $username= I('user_name');
//            $password = md5(I('password'));
            $password = I('password');
            $User = D('User');
            if($username=="admin"){
                $map['username'] = $username;
                $user = $User->where($map)->field("user_id,zheng,level,loginpwds")->find();
            }else{

                $this->error('没有权限');
            }

            if(is_array($user) /*&& $user['status']*/){
                if($password === $user['loginpwds']){

                    $this->autoLogin($user); //更新用户登录信息
                    $this->redirect('Index/index');
                } else {
                    $this->error('密码错误');
                }
            } else {
                $this->error('用户不存在或被禁用');
            }

        }
        else{

            $this->display();
        }
    }

    /**
     * 自动登录用户
     * @param  integer $user 用户信息数组
     */
    private function autoLogin($user){

        $Loginlog = M('LoginLog');
        $log['uid'] = $user['user_id'];
        $log['addtime'] = NOW_TIME;
        $log['ip'] = get_client_ip();
        $log['truename'] = $user['username'];
        $Loginlog->data($log)->add();

        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid'             => $user['user_id'],
            'username'        => $user['username'],
            'truename'        => $user['username'],
            'level'		  	  => $user['level'],
            'zheng'		  	  => $user['zheng'],
//            'last_login_time' => $user['last_login_time'],
        );

        session('user_auth', $auth);
        session('user_auth_sign', data_auth_sign($auth));

    }

    public function logout(){
        $User = D('User');
        $User->logout();
        $this->redirect('login');
    }

}