<?php
namespace Admin\Controller;
use Think\Controller;
class AgentController extends AdminController {



    public function signup(){
        $p = I('get.p',1);
        $News = M('mysign');
        if($_POST['user_id']){
            $where['user_id']=$_POST['user_id'];
        }

        $list = $News->where($where)->page($p)->order("addtime desc")->select();
        $mapcount = $News->where($where)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    public function sign_up(){
        $p = I('get.p',1);
        $News = M('signup');

        //$map['status'] = 3;
        $list = $News->page($p)->order("addtime desc")->select();
        $mapcount = $News->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }

    public function dele_sign(){
        $id = I('id');
        $News = M('signup');
        $arr = $News->where(array('id'=>$id))->delete();
        if($arr){

            $this->redirect('sign_up',array(),1,'删除成功,正在返回列表...');
        }
        else{
            $this->redirect('sign_up',array(),1,'系统繁忙，请重试...');
        }
    }

    public function quota_style(){
        $id = $_POST['id'];
        $data['status']=$_POST['status'];
        $data['ccc_content']=$_POST['ccc_content'];
        $Order =M('signup');
        $list = $Order->where(array('id'=>$id))->save($data);
        if($list){
            $reg['info']="修改成功";
            $reg['status']=200;

        }else{
            $reg['status']=300;
            $reg['info']="系统繁忙请重试";
        }
        $this->ajaxReturn($reg);
    }  public function xiugai(){
        $id = $_POST['id'];

        $Order =M('learning_experience');
        $list = $Order->where(array('id'=>$id))->setField("status",$_POST['status']);
        if($list){
            $reg['info']="修改成功";
            $reg['status']=200;

        }else{
            $reg['status']=300;
            $reg['info']="系统繁忙请重试";
        }
        $this->ajaxReturn($reg);
    }
    public function experience(){
        $p = I('get.p',1);
        $News = M('learning_experience');

        //$map['status'] = 3;
        $list = $News->page($p)->order("addtime desc")->select();
        $mapcount = $News->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    //考试管理
    public function examination(){
        $p = I('get.p',1);
        $News = M('examination');

        //$map['status'] = 3;
        $list = $News->page($p)->group("user_id")->order("addtime desc")->select();
        $mapcount = $News->group("user_id")->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
 public function pingyue(){
        $status['status']=$_POST['status'];
        $News = M('examination');

        $list = $News->where(array('id'=>$_POST['id']))->save($status);
        if($status['status']==2){
$user['user_id']=$News->where(array('id'=>$_POST['id']))->getField("user_id");

            M("user")->where($user)->setField("level",5);
        }
        if($list){
            $this->ajaxReturn(array('status'=>200,'msg'=>"成功"));
        }else{
            $this->redirect(array('status'=>300,'msg'=>"失败"));
        }
    }

    //jingjirenzhilujieduan
    public function stage(){
        $p = I('get.p',1);
        $News = M('types');

        $map['type'] = 1;
        $list = $News->page($p)->where($map)->order("toop desc")->select();
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
            $this->display();
    }

    public function stage_add(){
        $News=M("types");
        if($_POST){
        $data['type_name']=$_POST['type_name'];
        $data['times']=$_POST['times'];
        $data['toop']=$_POST['toop'];
            if($_POST['idd']==""){
                $result=$News->add($data);
            }else{
                $result=$News->where(array('id'=>$_POST['idd']))->save($data);
            }

            if($result){
                $this->redirect('stage',array(),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('stage',array(),1,'操作失败,正在返回列表...');
            }
        }else{
            $id=$_GET['id'];
            $infos=$News->where(array('id'=>$id))->find();
            $this->assign("infos",$infos);
            $this->display();
        }

    }
    public function dele_edit(){
        $News = M('types');
        $arr=$News->where(array('id'=>$_GET['id']))->delete();
        if($arr){

            $this->redirect('stage',array(),1,'删除成功,正在返回列表...');
        }
        else{
            $this->redirect('stage',array(),1,'系统繁忙，请重试...');
        }
    }
    //tikuguanli
    public function questions(){
        $p = I('get.p',1);
        $News = M('questions');

        //guanjianzi
        $mobile = $_POST['stem'];
        if(!empty($mobile)){
            $map['stem'] = array('like',"%".$mobile."%");
            $this->assign('stem', $mobile);
        }
//阶段
//        $level=0;
        $level = $_POST['types'];
        if($level != 0){
            $map['types'] = $level;
            $this->assign('types', $level);
        }



        $position=M("types")->order("toop desc")->where("type=1")->select();
        $this->assign("position",$position);
        $list = $News->page($p)->where($map)->order("toop desc")->select();
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    public function student_video(){
        $p = I('get.p',1);
        $News = M('video');


        $list = $News->page($p)->order("toop desc")->select();
        $mapcount = $News->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    public function student_video_add(){
        $News = M('video');
        if(IS_POST){
            ///////////



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

                    if($images){
//        $_POST['thumb'] = '/Uploads'.$images[$k]['savepath'].$images[$k]['savename'];
                        $_POST['thumb'] = '/Uploads' . $images['uploadbtn1']['savepath'] . $images['uploadbtn1']['savename'];
//                        $_POST['thumb'] = '/Uploads'.$images['savepath'].$images['savename'];
                    }
                    if($_POST['idd']==""){
                        $_POST['addtime']=time();
                        $userinfo=$News->add($_POST);
                    }else{
                        $userinfo=$News->where(array('id'=>$_POST['idd']))->save($_POST);
                    }





            if($userinfo){
                $this->redirect('student_video',array(),1,'操作成功,正在返回列表...');
            }else{
                $this->redirect('student_video',array(),1,'操作失败,正在返回列表...');
            }

        }
        else{
            $id = I('id');
            $news=$News->where(array('id'=>$id))->find($id);

            $this->assign('news',$news);
            $this->display();

        }
    }
    public function student_video_edit(){
        $News = M('video');
        $arr=$News->where(array('id'=>$_GET['id']))->delete();
        if($arr){

            $this->redirect('student_video',array(),1,'删除成功,正在返回列表...');
        }
        else{
            $this->redirect('student_video',array(),1,'系统繁忙，请重试...');
        }
    }
    public function questions_add(){
        $position=M("types")->order("toop desc")->where("type=1")->select();
        $this->assign("position",$position);
        $News=M("questions");
        if($_POST){

            if($_POST['idd']==""){
                $_POST['addtime']=time();
                $result=$News->add($_POST);
            }else{
                $result=$News->where(array('id'=>$_POST['idd']))->save($_POST);
            }

            if($result){
                $this->redirect('questions',array(),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('questions',array(),1,'操作失败,正在返回列表...');
            }
        }else{
            $id=$_GET['id'];
            $infos=$News->where(array('id'=>$id))->find();
            $this->assign("infos",$infos);
            $this->display();
        }

    }
    public function questions_dele(){
        $News = M('questions');
        $arr=$News->where(array('id'=>$_GET['id']))->delete();
        if($arr){

            $this->redirect('stage',array(),1,'删除成功,正在返回列表...');
        }
        else{
            $this->redirect('stage',array(),1,'系统繁忙，请重试...');
        }
    }


    //changjianwenti
    public function common_problem(){
        $p = I('get.p',1);
        $News = M('news');
        //guanjianzi
        $mobile = $_POST['stem'];
        if(!empty($mobile)){
            $map['news_title'] = array('like',"%".$mobile."%");
            $this->assign('stem', $mobile);
        }
        $list = $News->where($map)->page($p)->order("toop desc")->select();
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    public function common_add(){

        $News=M("news");
        if($_POST){

            if($_POST['idd']==""){
                $_POST['addtime']=time();
                $result=$News->add($_POST);
            }else{
                $result=$News->where(array('id'=>$_POST['idd']))->save($_POST);
            }

            if($result){
                $this->redirect('common_problem',array(),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('common_problem',array(),1,'操作失败,正在返回列表...');
            }
        }else{
            $id=$_GET['id'];
            $infos=$News->where(array('id'=>$id))->find();
            $this->assign("infos",$infos);
            $this->display();
        }

    } public function common_dele(){

        $News=M("news");

            $id=$_GET['id'];
            $infos=$News->where(array('id'=>$id))->delete();
    if($infos){
        $this->redirect('common_problem',array(),1,'保存成功,正在返回列表...');
    }else{
        $this->redirect('common_problem',array(),1,'操作失败,正在返回列表...');
    }
//            $this->assign("infos",$infos);
//            $this->display();


    }


}