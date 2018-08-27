<?php
namespace Admin\Controller;
use Think\Controller;
class UsersController extends AdminController {


//实名审核
    public function shenhe(){
        $Order =M('user');
        $list = $Order->where(array('user_id'=>$_GET['user_id']))->setField("is_true",$_GET['is_true']);
        if($list){
            $this->redirect('istrue', array(), 1, '操作成功,正在返回列表...');

        }else{
            $this->redirect('istrue', array(), 1, '操作失败,正在返回列表...');
        }
    }


    public function delimg()
    {
$id=$_GET['id'];
        $product=$_GET['user_id'];
        $News = M('pro_img');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('addimg', array('user_id'=>$product), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('addimg', array('user_id'=>$product), 1, '系统繁忙请重试...');
        }

    }

    public function addimg(){
        $News = M('pro_img');
        $product=$_GET['user_id'];
        $this->assign("uid",$product);

        if(IS_POST){

            ///////////
            $files = array();
            $success = 0;
            foreach ($_FILES['uploadbtn1']['name'] as $k=>&$item) {

                $config = array(
                    'maxSize'    =>    2*1024*1024,
                    'savePath'   => '/Images/', //保存路径
                    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
                    'autoSub'    =>    true,
                    'subName'    =>    array('date','Ym'),
                    'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
                    'saveExt'  => '', //文件保存后缀，空则使用原后缀
                    'replace'  => false, //存在同名是否覆盖
                    'hash'     => true, //是否生成hash编码
                );
                $upload = new \Think\Upload($config);// 实例化上传类
                $images = $upload->upload();
                foreach ($images as &$n){
                    if(!empty($n['savepath'])){
//        $_POST['thumb'] = '/Uploads'.$images[$k]['savepath'].$images[$k]['savename'];
                        $_POST['thumb'] = '/Uploads'.$n['savepath'].$n['savename'];
                    }
                    if($_POST['idd']==""){
                        $_POST['type']=3;
                        $userinfo=$News->add($_POST);
                    }else{
                        $userinfo=$News->where(array('id'=>$_POST['idd']))->save($_POST);
                    }
                }


            }

            if($userinfo){
                $this->redirect('addimg',array('user_id'=>$product),1,'操作成功,正在返回列表...');
            }else{
                $this->redirect('addimg',array('user_id'=>$product),1,'操作失败,正在返回列表...');
            }

        }
        else{
            $id = I('productid');
            $news=$News->find($id);


            $img=$News->where(array('user_id'=>$product,'type'=>3))->select();

            $this->assign('img',$img);
            $this->assign('news',$news);
            $this->display();

        }
    }
    public function del_pinglun($id)
    {

        $News = M('comment');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('tousu', array(), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('tousu', array(), 1, '系统繁忙请重试...');
        }

    }  public function del_liuyan($id)
    {

        $News = M('message');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('liuyan', array(), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('liuyan', array(), 1, '系统繁忙请重试...');
        }

    }
    public function tousu(){

        $p = I('get.p',1);

        $comment =M('comment');
        $product_id = $_GET['product_id'];
        if(!empty($product_id)){
            $map['worker_id'] = $product_id;
            $this->assign("pro",$product_id);
        } $news_title = $_POST['news_title'];
        if(!empty($news_title)){
            $map['content'] = array('like','%'.$news_title.'%');
            $this->assign("news_title",$news_title);
        }
        $map['types'] = 2;
        $order_info=$comment->where($map)->order("addtime desc")->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();

        $mapcount = $comment->where($map)->count();
        $show = getpages2($mapcount);


        $this->assign('pages', $show);//分页
        $this->assign('list', $order_info);

        $this->display();
    }
    public function liuyan(){

    $p = I('get.p',1);

    $comment =M('message');
   $news_title = $_POST['news_title'];
    if(!empty($news_title)){
        $map['content'] = array('like','%'.$news_title.'%');
        $this->assign("news_title",$news_title);
    }

    $order_info=$comment->where($map)->order("addtime desc")->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();

    $mapcount = $comment->where($map)->count();
    $show = getpages2($mapcount);


    $this->assign('pages', $show);//分页
    $this->assign('list', $order_info);

    $this->display();
}

//添加经纪人
public function member_add(){
    $user=M("user");

    if($_POST){

        if($_POST['idd']){
            if($user->where(array('mobile'=>$_POST['mobile']))->find()){
                $this->ajaxReturn(array('info'=>'此手机号已被占用','status'=>'300'));
            }
            $result= $user->where(array('user_id'=>$_POST['idd']))->save($_POST);
            if($result){
                $this->ajaxReturn(array('info'=>'操作成功','status'=>'200'));
            }else{
                $this->ajaxReturn(array('info'=>'操作失败','status'=>'300'));
            }
        }else{
//          4管理员添加2移动端4pc端5微信
            $data['uidtype']=4;
            $_POST['addtime']=time();
            $_POST['user_id']=sclws();
            $_POST['level']=2;
            $_POST['loginpwd']=md5('123456');
            $_POST['loginpwds']='123456';
            if($user->where(array('mobile'=>$_POST['mobile']))->find()){
                $this->ajaxReturn(array('info'=>'此手机号已被占用','status'=>'300'));
            }
            $result= $user->add($_POST);
            if($result){
                $this->ajaxReturn(array('info'=>'添加成功，初始密码为  123456','status'=>'200'));
            }else{
                $this->ajaxReturn(array('info'=>'操作失败','status'=>'300'));
            }
        }

//          $result= $user->where(array('user_id'=>$_POST['idd']))->save($_POST);


    }else{
        $id = I('user_id');
        if($id){
            $user_info=$user->where(array('user_id'=>$id))->find();
            $this->assign("info",$user_info);
        }
        $this->display();
    }


}
public function agentdel(){
    $id = I('user_id');
    $User = M('user');
    $result=$User->where(array('user_id'=>$id))->delete();
    if($result){
        $this->redirect('member',array(),1,'删除成功，返回列表...');
    }else{
        $this->redirect('member',array(),1,'系统繁忙，请重试...');
    }

}public function jinyong(){
    $id = I('user_id');
    $User = M('user');
    $result=$User->where(array('user_id'=>$id))->setField("status",$_GET['status']);
    if($result){
        $this->redirect('member',array(),1,'操作成功，返回列表...');
    }else{
        $this->redirect('member',array(),1,'系统繁忙，请重试...');
    }

}



    //全部会员
    public function member(){
        $p = I('get.p',1);
        $Order =M('user');
        //会员电话
        $mobile = I('mobile','');
        if(!empty($mobile)){
            $map['mobile'] = $mobile;
            $this->assign('mobile', $mobile);
        }
        //会员电话
        $user_id = I('user_id','');
        if(!empty($user_id)){
            $map['user_id'] = $user_id;
            $this->assign('user_id', $user_id);
        }

        $map['level'] = array('neq',1);
        //会员姓名
        $truename = I('truename','');
        if(!empty($truename)){
            $map['truename'] = $truename;
            $this->assign('truename', $truename);
        }
        $list = $Order->where($map)->order('addtime desc')->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();
        $mapcount = $Order->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('mapcount', $mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
  //全部会员
    public function istrue(){
        $p = I('get.p',1);
        $Order =M('user');
        //会员电话
        $idcards = I('idcards','');
        if(!empty($idcards)){
            $map['idcards'] = $idcards;
            $this->assign('idcards', $idcards);
        }
        //会员电话
        $user_id = I('user_id','');
        if(!empty($user_id)){
            $map['user_id'] = $user_id;
            $this->assign('user_id', $user_id);
        }

        $map['level'] = array('neq',1);
        $map['is_true'] = array('neq',1);
        //会员姓名
        $truename = I('truename','');
        if(!empty($truename)){
            $map['truename'] = $truename;
            $this->assign('truename', $truename);
        }
        $list = $Order->where($map)->order('is_true asc')->field("user_id,zheng,fan,truename,is_true,idcards,sex")->limit(C('DEFAULT_PAGE_SIZE'))->page($p)->select();
        $mapcount = $Order->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('mapcount', $mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }


}