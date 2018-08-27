<?php
namespace Admin\Controller;

/**
 * 后台 广告位管理
 * User: 宁鲁华
 * Date: 2015/6/9
 * Time: 13:04
 */
class AdeController extends AdminController
{
    public function beijing1(){

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
    public function student_style(){
        $p = I('get.p',1);
        $News = M('student');

        //$map['status'] = 3;
        $list = $News->page($p)->where("type=1")->select();

        $this->assign('list', $list);
        $this->display();
    }
    public function student_style_add(){

        if(IS_POST){
            $News = M('student');
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
//                $_POST['thumb'] = '/Uploads' . $images['uploadbtn1']['savepath'] . $images['uploadbtn1']['savename'];
            }

            if($_POST['idd']==""){
               $arr= $News->add($_POST);
            }else{
              $arr=  $News->where(array('id'=>$_POST['idd']))->save($_POST);
            }
            if ($arr) {
                $this->redirect('student_style', array(), 1, '保存成功,正在返回列表...');
            } else {
                $this->redirect('student_style', array(), 1, '系统繁忙，请重试...');
            }
//            $this->redirect('student_style',array(),1,'修改成功,正在返回列表...');
        }
        else{
            $id = I('id');
            $News = M('student');
            $news=$News->find($id);
            $this->assign('news',$news);
            $this->display();

        }
    }
    public function blackaccount(){
        $p = I('get.p',1);
        $News = M('ads');

        //$map['status'] = 3;
        $list = $News->page($p)->order("cad_id asc")->select();
        $mapcount = $News->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }

    public function blackaccount_add(){
        $position=M("adposition")->select();
        $this->assign("position",$position);
        $type=M("types");
$activity_offset=$type->where("type=7")->select();

        $this->assign("activity_offset",$activity_offset);

        $News = M('ads');
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
                $result=$News->add($_POST);
            }else{
                $result=$News->where(array('id'=>$_POST['idd']))->save($_POST);
            }

            if($result){
                $this->redirect('blackaccount',array(),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('blackaccount',array(),1,'操作失败,正在返回列表...');
            }
        }
        else{
            $id=$_GET['id'];
            $info=$News->where(array('id'=>$id))->find();

            $this->assign("news",$info);
            $this->display();
        }
    }
    public function tankuang(){


        $News = M('notice');
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
                $_POST['beijing'] = '/Uploads' . $images['uploadbtn1']['savepath'] . $images['uploadbtn1']['savename'];
            }


            $result=$News->where(array('id'=>23))->save($_POST);
            if($result){
                $this->redirect('tankuang',array(),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('tankuang',array(),1,'操作失败,正在返回列表...');
            }
        }
        else{

            $info=$News->where(array('id'=>23))->find();

            $this->assign("infos",$info);
            $this->display();
        }
    }   public function lianren(){



        $News = M('notice');
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
                $_POST['beijing'] = '/Uploads' . $images['uploadbtn1']['savepath'] . $images['uploadbtn1']['savename'];
            }

                $result=$News->where(array('id'=>24))->save($_POST);
            if($result){
                $this->redirect('lianren',array(),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('lianren',array(),1,'操作失败,正在返回列表...');
            }
        }
        else{

            $info=$News->where(array('id'=>24))->find();

            $this->assign("infos",$info);
            $this->display();
        }
    }
    public function dele_edit(){
        $News = M('ads');
      $arr=$News->where(array('id'=>$_GET['id']))->delete();
        if($arr){

            $this->redirect('blackaccount',array(),1,'删除成功,正在返回列表...');
        }
        else{
            $this->redirect('blackaccount',array(),1,'系统繁忙，请重试...');
        }
    }
    public function blackaccount_edit(){
        $position=M("adposition")->select();
        $this->assign("position",$position);
        if(IS_POST){


            $data=$_POST;
            if(!empty($_FILES['file']['name'])){

                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     3145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','pdf');// 设置附件上传类型
                $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
                $upload->savePath  =     ''; // 设置附件上传（子）目录
                // 上传文件
                $info   =   $upload->upload();
//                if($info) {
//                   // 上传成功
//                    foreach($info as $file){
//                        $bigimg = $file['savepath'].$file['savename'];
//                    }
//                }
                // 保存当前数据对象
//                $data['thumb'] = '/Uploads/'.$bigimg;

                if ($info) {
                    $data['thumb'] = '/Uploads' . $info['uploadbtn1']['savepath'] . $info['uploadbtn1']['savename'];
                }
            }

            $News = M('ads');
            $News->where(array('id'=>$_POST['idd']))->save($data);
            $this->redirect('blackaccount',array(),1,'修改成功,正在返回列表...');
        }
        else{
            $id = I('id');
            $News = M('ads');
            $news=$News->find($id);
            $this->assign('news',$news);
            $this->display();

        }
    }





}