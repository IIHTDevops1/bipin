<?php
namespace Admin\Controller;
use Think\Controller;
class SystemController extends AdminController {


    public function beijing1(){

        $News = M('pro_img');
        if(IS_POST){

            $config = array(
                'maxSize' => 2 * 1024 * 1024,
                'savePath' => '/Images/', //保存路径
                'exts' => array('jpg', 'gif', 'png', 'jpeg'),
                'autoSub' => true,
                'subName' => array('date', 'Ym'),
                'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
                'saveExt' => '', //文件保存后缀，空则使用原后缀
                'replace' => false, //存在同名是否覆盖
                'hash' => true, //是否生成hash编码
            );

            $upload = new \Think\Upload($config);// 实例化上传类
            $images = $upload->upload();
            if ($images) {
                $_POST['thumb'] = '/Uploads' . $images['uploadbtn1']['savepath'] . $images['uploadbtn1']['savename'];
            }

            if(!empty($_POST['x_jl']) && !empty($_POST['y_jl'])){

                    $result= $product=M("pro_img")->where("type=3")->save($_POST);


                if($result){
                    $this->ajaxReturn(array('status'=>200));
                }else{
                    $this->ajaxReturn(array('status'=>300));;
                }
            }

            $_POST['addtime']=time();

            if($_POST['idd']==""){
                $result= $product=M("pro_img")->where("type=3")->save($_POST);
            }else{
                $result=$News->where(array('id'=>$_POST['idd']))->save($_POST);
            }

            if($result){
                $this->redirect('beijing1',array(),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('beijing1',array(),1,'操作失败,正在返回列表...');
            }
        }
        else{
            $info=$News->where(array('type'=>3))->find();

            $this->assign("news",$info);
            $this->display();
        }
    }
    public function beijing(){

        $News = M('pro_img');
        if(IS_POST){
//            var_dump($_POST);
//            exit;
            $config = array(
                'maxSize' => 2 * 1024 * 1024,
                'savePath' => '/Images/', //保存路径
                'exts' => array('jpg', 'gif', 'png', 'jpeg'),
                'autoSub' => true,
                'subName' => array('date', 'Ym'),
                'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
                'saveExt' => '', //文件保存后缀，空则使用原后缀
                'replace' => false, //存在同名是否覆盖
                'hash' => true, //是否生成hash编码
            );

            $upload = new \Think\Upload($config);// 实例化上传类
            $images = $upload->upload();
            if ($images) {
                $_POST['thumb'] = '/Uploads' . $images['uploadbtn1']['savepath'] . $images['uploadbtn1']['savename'];
            }

            $_POST['addtime']=time();

            if($_POST['idd']==""){
                $result= $product=M("pro_img")->where("type=3")->save($_POST);
            }else{
                $result=$News->where(array('id'=>$_POST['idd']))->save($_POST);
            }

            if($result){
                $this->redirect('beijing',array(),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('beijing',array(),1,'操作失败,正在返回列表...');
            }
        }
        else{
            $info=$News->where(array('type'=>3))->find();

            $this->assign("news",$info);
            $this->display();
        }
    }


//关于我们
    function about(){
        $Notice =M('Notice');
        if($_POST){
            $_POST['addtime']=time();
            $Notice->where(array('id'=>7))->save($_POST);
            $this->redirect('about',array(),1,'保存成功,正在重新加载...');
        }else{
            $arr=$Notice->where(array('id'=>7))->find();
            $this->assign('news',$arr);
            $this->display();
        }
    }
//订金支付协议
    function zhifu(){
        $Notice =M('Notice');
        if($_POST){
            $_POST['addtime']=time();
            $Notice->where(array('id'=>10))->save($_POST);
            $this->redirect('zhifu',array(),1,'保存成功,正在重新加载...');
        }else{
            $arr=$Notice->where(array('id'=>10))->find();
            $this->assign('news',$arr);
            $this->display();
        }
    }
    //提现协议
    function tixian(){
        $Notice =M('Notice');
        if($_POST){
            $_POST['addtime']=time();
            $Notice->where(array('id'=>16))->save($_POST);
            $this->redirect('tixian',array(),1,'保存成功,正在重新加载...');
        }else{
            $arr=$Notice->where(array('id'=>16))->find();
            $this->assign('news',$arr);
            $this->display();
        }
    }//充值协议
    function chong(){
        $Notice =M('Notice');
        if($_POST){
            $_POST['addtime']=time();
            $Notice->where(array('id'=>15))->save($_POST);
            $this->redirect('chong',array(),1,'保存成功,正在重新加载...');
        }else{
            $arr=$Notice->where(array('id'=>15))->find();
            $this->assign('news',$arr);
            $this->display();
        }
    }    function yuyue(){
        $Notice =M('Notice');
        if($_POST){
            $_POST['addtime']=time();
            $Notice->where(array('id'=>13))->save($_POST);
            $this->redirect('yuyue',array(),1,'保存成功,正在重新加载...');
        }else{
            $arr=$Notice->where(array('id'=>13))->find();
            $this->assign('news',$arr);
            $this->display();
        }
    }
    function shuoming(){
        $Notice =M('Notice');
        if($_POST){
            $_POST['addtime']=time();
            $Notice->where(array('id'=>20))->save($_POST);
            $this->redirect('shuoming',array(),1,'保存成功,正在重新加载...');
        }else{
            $arr=$Notice->where(array('id'=>20))->find();
            $this->assign('news',$arr);
            $this->display();
        }
    }function xiedai(){
        $Notice =M('Notice');
        if($_POST){
            $_POST['addtime']=time();
            $Notice->where(array('id'=>21))->save($_POST);
            $this->redirect('xiedai',array(),1,'保存成功,正在重新加载...');
        }else{
            $arr=$Notice->where(array('id'=>21))->find();
            $this->assign('news',$arr);
            $this->display();
        }
    }function fanhuan(){
        $Notice =M('Notice');
        if($_POST){
            $_POST['addtime']=time();
            $Notice->where(array('id'=>22))->save($_POST);
            $this->redirect('fanhuan',array(),1,'保存成功,正在重新加载...');
        }else{
            $arr=$Notice->where(array('id'=>22))->find();
            $this->assign('news',$arr);
            $this->display();
        }
    }
    //拨比
    function vipmima14(){
        $notice=M("notice");
        $iiii=$notice->where(array('id'=>14))->getField("news_title");
        if($_POST){

            if($_POST['pwds']==$iiii){
                $this->redirect('bobi',array(),1,'密码正确,正在加载...');
            }else{
                $this->redirect('vipmima14',array(),1,'密码错误...');
            }
        }else{
            $this->display();
        }
    }
    //VIP等级管理密码
    function vipmima13(){
        $notice=M("notice");
        $iiii=$notice->where(array('id'=>13))->getField("news_title");
        if($_POST){

            if($_POST['pwds']==$iiii){
                $this->redirect('vips',array(),1,'VIP等级管理密码正确,正在加载...');
            }else{
                $this->redirect('vipmima13',array(),1,'VIP等级管理密码错误...');
            }
        }else{
            $this->display();
        }
    }

    function bili(){
        $Notice =M('notice');
        if($_POST){
                $Notice->where(array('id'=>11))->save($_POST);


            $this->redirect('bili',array(),1,'保存成功,正在重新加载...');
        }else{

            $arr=$Notice->where('id=11')->field("content")->find();
            $this->assign('news',$arr);
            $this->display();
        }
    }
    //公司jianjie
    function jianjie(){
        $Notice =M('Notice');
        if($_POST){
            $_POST['addtime']=time();
            $Notice->where(array('id'=>12))->save($_POST);
            $this->redirect('jianjie',array(),1,'保存成功,正在重新加载...');
        }else{
            $arr=$Notice->where(array('id'=>12))->find();
            $this->assign('news',$arr);
            $this->display();
        }
    }//公司资质
    function zizhi(){
        $Notice =M('Notice');
        if($_POST){
            $_POST['addtime']=time();
            $Notice->where(array('id'=>14))->save($_POST);
            $this->redirect('zizhi',array(),1,'保存成功,正在重新加载...');
        }else{
            $arr=$Notice->where(array('id'=>14))->find();
            $this->assign('news',$arr);
            $this->display();
        }
    }//公司模式
    function moshi(){
        $Notice =M('Notice');
        if($_POST){
            $_POST['addtime']=time();
            $Notice->where(array('id'=>7))->save($_POST);
            $this->redirect('moshi',array(),1,'保存成功,正在重新加载...');
        }else{
            $arr=$Notice->where(array('id'=>7))->find();
            $this->assign('news',$arr);
            $this->display();
        }
    }//公司模式
    function tuandui(){
        $Notice =M('Notice');
        if($_POST){
            $_POST['addtime']=time();
            $Notice->where(array('id'=>9))->save($_POST);
            $this->redirect('tuandui',array(),1,'保存成功,正在重新加载...');
        }else{
            $arr=$Notice->where(array('id'=>9))->find();
            $this->assign('news',$arr);
            $this->display();
        }
    }
    //用户协议
    function agreement(){
        $Notice =M('Notice');
        if($_POST){
            $_POST['addtime']=time();
            $Notice->where(array('id'=>9))->save($_POST);
            $this->redirect('agreement',array(),1,'保存成功,正在重新加载...');
        }else{
            $arr=$Notice->where(array('id'=>9))->find();
            $this->assign('news',$arr);
            $this->display();
        }
    }


    //微信公众号
    function wechat(){
        $Notice =M('Notice');
        if($_POST){
            $_POST['addtime']=time();
            $Notice->where(array('id'=>8))->save($_POST);
            $this->redirect('wechat',array(),1,'保存成功,正在重新加载...');
        }else{
            $arr=$Notice->where(array('id'=>8))->field("content")->find();
            $this->assign('news',$arr);
            $this->display();
        }
    }

//区域管理
    public function region(){
        $p = I('get.p',1);
        $province=M("province");
        $prov=$province->where(array('is_open'=>1,'level'=>2))->field("name,code")->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();
        $mapcount = $province->where(array('is_open'=>1,'level'=>2))->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $prov);
        $this->display();
	}

//城市开启
    public function open_city(){
        $province=M('province');
        $status=$province->where(array('code'=>$_POST['city']))->setField('is_open',1);
        if($status){
//            M('province')->where(array('p_code'=>$_POST['city']))->setField('is_open',1);
            $province->where(array('code'=>$_POST['province']))->setField('is_open',1);
            $msg['info']="修改成功";
            $msg['status']=1;
        }else{
            $msg['info']="修改失败";
            $msg['status']=0;
        }

        $this->ajaxReturn($msg);
    }//城市开启
    public function is_guan(){
        $province=M('province');
        $status=$province->where(array('code'=>$_GET['code']))->setField('is_open',2);
        if($status){
            $this->redirect('region',array(),1,'操作成功，返回列表...');
//            M('province')->where(array('p_code'=>$_POST['city']))->setField('is_open',1);
//            $province->where(array('code'=>$_POST['province']))->setField('is_open',1);
            $msg['info']="修改成功";
            $msg['status']=1;

        }else{
            $this->redirect('region',array(),1,'操作失败，返回列表...');
            $msg['info']="修改失败";
            $msg['status']=0;
        }

        $this->ajaxReturn($msg);
    }

    public function region_add(){
        $province=M('province');

        if($_POST){
            $where['p_code']=array('eq',$_POST['p_code']);
            $where['code']=array('eq',$_POST['code']);
            $where['name']=array('like',"%".$_POST['name']."%");
            $where['level']=$_POST['level'];
            $result=$province->where($where)->find();
            if($result){
                $msg['info']="该城市已存在";
                $msg['status']=300;
            }else{
                $arr=$province->add($_POST);
                if($arr){
                    $msg['info']="操作成功";
                    $msg['status']=200;
                }else{
                    $msg['info']="系统繁忙，请重试";
                    $msg['status']=400;
                }
            }

            $this->ajaxReturn($msg);
        }else{

            $this->display();
        }
    }

    public function get_city(){
        $province=M('province');
        $p_code=I('post.p_code');
        $city=$province->where(array('p_code'=>$p_code))->select();
        $this->ajaxReturn($city);

    }

    //vip等级
    public function vips(){
        $p = I('get.p',1);
        $Order =M('vips');

        $list = $Order->where()->order('toop desc')->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();
        $mapcount = $Order->where()->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    public function vips_add(){
        $province=M('vips');

        if($_POST){

            if($_POST['idd']==''){
                $arr=$province->add($_POST);

            }else{
                $arr=$province->where(array('id'=>$_POST['idd']))->save($_POST);
            }
            if($arr){
                $this->redirect('vips',array(),1,'操作成功，返回列表...');

            }else{
                $this->redirect('vips',array(),1,'系统繁忙，请重试...');

            }


        }else{
            $result=$province->where(array('id'=>$_GET['id']))->find();
            $this->assign("news",$result);
            $this->display();
        }
    }
    public function vip_del(){
        $id = I('id');
        $User = M('vips');
        $result=$User->where(array('id'=>$id))->delete();
        if($result){
            $this->redirect('vips',array(),1,'删除成功，返回列表...');
        }else{
            $this->redirect('vips',array(),1,'系统繁忙，请重试...');
        }

    }

    //版本号
    function edition(){
        $Notice =M('Notice');
        if($_POST){
//            $_POST['addtime']=time();
            $Notice->where(array('id'=>1))->save($_POST);
            $this->redirect('edition',array(),1,'保存成功,正在重新加载...');
        }else{
            $arr=$Notice->where(array('id'=>1))->find();
            $this->assign('news',$arr);
            $this->display();
        }
    }


    public function vipdengji(){
        $classification=M("Notice");
        if(IS_POST){
            $config = array(
                'maxSize' => 2 * 1024 * 1024,
                'savePath' => '/Images/', //保存路径
                'exts' => array('jpg', 'gif', 'png', 'jpeg'),
                'autoSub' => true,
                'subName' => array('date', 'Ym'),
                'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
                'saveExt' => '', //文件保存后缀，空则使用原后缀
                'replace' => false, //存在同名是否覆盖
                'hash' => true, //是否生成hash编码
            );
            $upload = new \Think\Upload($config);// 实例化上传类
            $images = $upload->upload();
            if ($images) {
                $_POST['thumb'] = '/Uploads' . $images['uploadbtn1']['savepath'] . $images['uploadbtn1']['savename'];
            }

                $result=$classification->where(array('id'=>2))->save($_POST);


            if($result){
                $this->redirect('vipdengji',array(),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('vipdengji',array(),1,'操作失败,正在返回列表...');
            }
        }
        else{

            $info=$classification->where(array('id'=>2))->find();
            $this->assign("news",$info);
            $this->display();
        }
    }

    //公告
    public function ggadd(){

        $News=M("notice");
        if($_POST){

            if($_POST['idd']==""){
                $_POST['addtime']=time();
                $_POST['type'] = 2;
                $result=$News->add($_POST);
            }else{
                $result=$News->where(array('id'=>$_POST['idd']))->save($_POST);
            }

            if($result){
                $this->redirect('gonggao',array(),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('gonggao',array(),1,'操作失败,正在返回列表...');
            }
        }else{
            $id=$_GET['id'];
            $infos=$News->where(array('id'=>$id))->find();
            $this->assign("infos",$infos);
            $this->display();
        }

    }
    public function gonggao(){
        $p = I('get.p',1);
        $News = M('notice');
        //guanjianzi
        $mobile = $_POST['stem'];
        if(!empty($mobile)){
            $map['news_title'] = array('like',"%".$mobile."%");
            $this->assign('stem', $mobile);
        }
        $map['type'] = 2;
        $list = $News->where($map)->page($p)->field("id,news_title,content,content1")->order("addtime desc")->select();
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    public function common_dele(){

    $News=M("notice");

    $id=$_GET['id'];
    $infos=$News->where(array('id'=>$id))->delete();
    if($infos){
        $this->redirect('gonggao',array(),1,'保存成功,正在返回列表...');
    }else{
        $this->redirect('gonggao',array(),1,'操作失败,正在返回列表...');
    }
//            $this->assign("infos",$infos);
//            $this->display();


}


}