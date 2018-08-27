<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/5
 * Time: 9:19
 */
namespace Admin\Controller;
use Think\Controller;

class AdminController extends Controller {

    protected function _initialize()
    {

        define('UID', is_login());

        if (!UID) {// 还没登录 跳转到登录页面
            $this->redirect('Public/login');
        }

        $this->assign('uuname', session('user_auth.truename'));
        define('IS_ROOT', is_administrator());




    }



}