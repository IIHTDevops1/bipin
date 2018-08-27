<?php
namespace Admin\Controller;
use Think\Controller;
class HealthyshopController extends AdminController
{//健康商城

    //剧种大类
    public function down_payments()
    {
        $p = I('get.p', 1);
        $News = M('types');
        $map = array();
        $map['type'] = 1;
        $list = $News->where($map)->order("toop desc")->page($p)->select();
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }

    public function down_payments_edit()
    {
        if (IS_POST) {
            $News = M('types');
            if ($_POST['idd'] == "") {
                $_POST['type'] = 1;
                $_POST['times'] = time();

                $fchar = ord($_POST['type_name']{0});
                if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($_POST['type_name']{0});
                $s1 = @iconv("UTF-8","gb2312", $_POST['type_name']);
                $s2 = @iconv("gb2312","UTF-8", $s1);
                if($s2 == $_POST['type_name']){$s = $s1;}else{$s = $_POST['type_name'];}
                $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
                if($asc >= -20319 and $asc <= -20284){$_POST['initials']="A";}
                if($asc >= -20283 and $asc <= -19776){$_POST['initials']="B";}
                if($asc >= -19775 and $asc <= -19219){$_POST['initials']="C";}
                if($asc >= -19218 and $asc <= -18711){$_POST['initials']="D";}
                if($asc >= -18710 and $asc <= -18527){$_POST['initials']="E";}
                if($asc >= -18526 and $asc <= -18240){$_POST['initials']="F";}
                if($asc >= -18239 and $asc <= -17923){$_POST['initials']="G";}
                if($asc >= -17922 and $asc <= -17418){$_POST['initials']="H";}
                if($asc >= -17417 and $asc <= -16475){$_POST['initials']="J";}
                if($asc >= -16474 and $asc <= -16213){$_POST['initials']="K";}
                if($asc >= -16212 and $asc <= -15641){$_POST['initials']="L";}
                if($asc >= -15640 and $asc <= -15166){$_POST['initials']="M";}
                if($asc >= -15165 and $asc <= -14923){$_POST['initials']="N";}
                if($asc >= -14922 and $asc <= -14915){$_POST['initials']="O";}
                if($asc >= -14914 and $asc <= -14631){$_POST['initials']="P";}
                if($asc >= -14630 and $asc <= -14150){$_POST['initials']="Q";}
                if($asc >= -14149 and $asc <= -14091){$_POST['initials']="R";}
                if($asc >= -14090 and $asc <= -13319){$_POST['initials']="S";}
                if($asc >= -13318 and $asc <= -12839){$_POST['initials']="T";}
                if($asc >= -12838 and $asc <= -12557){$_POST['initials']="W";}
                if($asc >= -12556 and $asc <= -11848){$_POST['initials']="X";}
                if($asc >= -11847 and $asc <= -11056){$_POST['initials']="Y";}
                if($asc >= -11055 and $asc <= -10247){$_POST['initials']="Z";}
                $arr = $News->add($_POST);
            } else {
                $fchar = ord($_POST['type_name']{0});
                if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($_POST['type_name']{0});
                $s1 = @iconv("UTF-8","gb2312", $_POST['type_name']);
                $s2 = @iconv("gb2312","UTF-8", $s1);
                if($s2 == $_POST['type_name']){$s = $s1;}else{$s = $_POST['type_name'];}
                $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
                if($asc >= -20319 and $asc <= -20284){$_POST['initials']="A";}
                if($asc >= -20283 and $asc <= -19776){$_POST['initials']="B";}
                if($asc >= -19775 and $asc <= -19219){$_POST['initials']="C";}
                if($asc >= -19218 and $asc <= -18711){$_POST['initials']="D";}
                if($asc >= -18710 and $asc <= -18527){$_POST['initials']="E";}
                if($asc >= -18526 and $asc <= -18240){$_POST['initials']="F";}
                if($asc >= -18239 and $asc <= -17923){$_POST['initials']="G";}
                if($asc >= -17922 and $asc <= -17418){$_POST['initials']="H";}
                if($asc >= -17417 and $asc <= -16475){$_POST['initials']="J";}
                if($asc >= -16474 and $asc <= -16213){$_POST['initials']="K";}
                if($asc >= -16212 and $asc <= -15641){$_POST['initials']="L";}
                if($asc >= -15640 and $asc <= -15166){$_POST['initials']="M";}
                if($asc >= -15165 and $asc <= -14923){$_POST['initials']="N";}
                if($asc >= -14922 and $asc <= -14915){$_POST['initials']="O";}
                if($asc >= -14914 and $asc <= -14631){$_POST['initials']="P";}
                if($asc >= -14630 and $asc <= -14150){$_POST['initials']="Q";}
                if($asc >= -14149 and $asc <= -14091){$_POST['initials']="R";}
                if($asc >= -14090 and $asc <= -13319){$_POST['initials']="S";}
                if($asc >= -13318 and $asc <= -12839){$_POST['initials']="T";}
                if($asc >= -12838 and $asc <= -12557){$_POST['initials']="W";}
                if($asc >= -12556 and $asc <= -11848){$_POST['initials']="X";}
                if($asc >= -11847 and $asc <= -11056){$_POST['initials']="Y";}
                if($asc >= -11055 and $asc <= -10247){$_POST['initials']="Z";}
                $arr = $News->where(array('id' => $_POST['idd']))->save($_POST);
            }
            if ($arr) {
                $this->redirect('down_payments', array(), 1, '保存成功,正在返回列表...');
            } else {
                $this->redirect('down_payments', array(), 1, '系统繁忙，请重试...');
            }
        } else {
            $id = I('id');
            $News = M('types');
            $news = $News->find($id);
            $this->assign('news', $news);
            $this->display();
        }
    }
    public function down_payments_delete($id)
    {

        $News = M('types');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('down_payments', array(), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('down_payments', array(), 1, '系统繁忙请重试...');
        }

    }

    //剧种小类
    public function brand()
    {
        $p = I('get.p', 1);
        $News = M('types');
        $map = array();
        $map['type'] = 2;
        $list = $News->where($map)->order("toop desc")->page($p)->select();
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }

    public function brand_add()
    {
        $News = M('types');
        $arrr=$News->where(array('type'=>1))->order("toop desc")->select();
        $this->assign("position",$arrr);
        if (IS_POST) {
            $_POST['type'] = 2;
            $_POST['times'] = time();
            $fchar = ord($_POST['type_name']{0});
            if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($_POST['type_name']{0});
            $s1 = @iconv("UTF-8","gb2312", $_POST['type_name']);
            $s2 = @iconv("gb2312","UTF-8", $s1);
            if($s2 == $_POST['type_name']){$s = $s1;}else{$s = $_POST['type_name'];}
            $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
            if($asc >= -20319 and $asc <= -20284){$_POST['initials']="A";}
            if($asc >= -20283 and $asc <= -19776){$_POST['initials']="B";}
            if($asc >= -19775 and $asc <= -19219){$_POST['initials']="C";}
            if($asc >= -19218 and $asc <= -18711){$_POST['initials']="D";}
            if($asc >= -18710 and $asc <= -18527){$_POST['initials']="E";}
            if($asc >= -18526 and $asc <= -18240){$_POST['initials']="F";}
            if($asc >= -18239 and $asc <= -17923){$_POST['initials']="G";}
            if($asc >= -17922 and $asc <= -17418){$_POST['initials']="H";}
            if($asc >= -17417 and $asc <= -16475){$_POST['initials']="J";}
            if($asc >= -16474 and $asc <= -16213){$_POST['initials']="K";}
            if($asc >= -16212 and $asc <= -15641){$_POST['initials']="L";}
            if($asc >= -15640 and $asc <= -15166){$_POST['initials']="M";}
            if($asc >= -15165 and $asc <= -14923){$_POST['initials']="N";}
            if($asc >= -14922 and $asc <= -14915){$_POST['initials']="O";}
            if($asc >= -14914 and $asc <= -14631){$_POST['initials']="P";}
            if($asc >= -14630 and $asc <= -14150){$_POST['initials']="Q";}
            if($asc >= -14149 and $asc <= -14091){$_POST['initials']="R";}
            if($asc >= -14090 and $asc <= -13319){$_POST['initials']="S";}
            if($asc >= -13318 and $asc <= -12839){$_POST['initials']="T";}
            if($asc >= -12838 and $asc <= -12557){$_POST['initials']="W";}
            if($asc >= -12556 and $asc <= -11848){$_POST['initials']="X";}
            if($asc >= -11847 and $asc <= -11056){$_POST['initials']="Y";}
            if($asc >= -11055 and $asc <= -10247){$_POST['initials']="Z";}
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


            $arr = $News->add($_POST);
            if ($arr) {
                $this->redirect('brand', array(), 1, '保存成功,正在返回列表...');
            } else {
                $this->redirect('brand', array(), 1, '系统繁忙，请重试...');
            }
        } else {
            $this->display();
        }
    }

    public function brand_edit()
    {
        $News = M('types');
        $arrr=$News->where(array('type'=>1))->order("toop desc")->select();
        $this->assign("position",$arrr);
        if (IS_POST) {

            $fchar = ord($_POST['type_name']{0});
            if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($_POST['type_name']{0});
            $s1 = @iconv("UTF-8","gb2312", $_POST['type_name']);
            $s2 = @iconv("gb2312","UTF-8", $s1);
            if($s2 == $_POST['type_name']){$s = $s1;}else{$s = $_POST['type_name'];}
            $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
            if($asc >= -20319 and $asc <= -20284){$_POST['initials']="A";}
            if($asc >= -20283 and $asc <= -19776){$_POST['initials']="B";}
            if($asc >= -19775 and $asc <= -19219){$_POST['initials']="C";}
            if($asc >= -19218 and $asc <= -18711){$_POST['initials']="D";}
            if($asc >= -18710 and $asc <= -18527){$_POST['initials']="E";}
            if($asc >= -18526 and $asc <= -18240){$_POST['initials']="F";}
            if($asc >= -18239 and $asc <= -17923){$_POST['initials']="G";}
            if($asc >= -17922 and $asc <= -17418){$_POST['initials']="H";}
            if($asc >= -17417 and $asc <= -16475){$_POST['initials']="J";}
            if($asc >= -16474 and $asc <= -16213){$_POST['initials']="K";}
            if($asc >= -16212 and $asc <= -15641){$_POST['initials']="L";}
            if($asc >= -15640 and $asc <= -15166){$_POST['initials']="M";}
            if($asc >= -15165 and $asc <= -14923){$_POST['initials']="N";}
            if($asc >= -14922 and $asc <= -14915){$_POST['initials']="O";}
            if($asc >= -14914 and $asc <= -14631){$_POST['initials']="P";}
            if($asc >= -14630 and $asc <= -14150){$_POST['initials']="Q";}
            if($asc >= -14149 and $asc <= -14091){$_POST['initials']="R";}
            if($asc >= -14090 and $asc <= -13319){$_POST['initials']="S";}
            if($asc >= -13318 and $asc <= -12839){$_POST['initials']="T";}
            if($asc >= -12838 and $asc <= -12557){$_POST['initials']="W";}
            if($asc >= -12556 and $asc <= -11848){$_POST['initials']="X";}
            if($asc >= -11847 and $asc <= -11056){$_POST['initials']="Y";}
            if($asc >= -11055 and $asc <= -10247){$_POST['initials']="Z";}

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

            $arr = $News->where(array('id' => $_POST['idd']))->save($_POST);
            if ($arr) {
                $this->redirect('brand', array(), 1, '保存成功,正在返回列表...');
            } else {
                $this->redirect('brand', array(), 1, '系统繁忙，请重试...');
            }
        } else {
            $id = I('id');
            $News = M('types');
            $news = $News->find($id);
            $this->assign('news', $news);
            $this->display();
        }
    }

    public function brand_delete($id)
    {

        $News = M('types');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('brand', array(), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('brand', array(), 1, '系统繁忙请重试...');
        }

    }


//礼物管理

    public function gifts(){
        $p = I('get.p',1);
        $News = M('gifts');
        $list = $News->order("toop desc")->page($p)->select();
        $mapcount = $News->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);

        $this->display();
    }

    public function gifts_add(){
        $classification=M("gifts");
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


            if($_POST['idd']==""){
                $_POST['times']=time();
                $result=$classification->add($_POST);
            }else{
                $result=$classification->where(array('id'=>$_POST['idd']))->save($_POST);
            }

            if($result){
                $this->redirect('gifts',array(),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('gifts',array(),1,'操作失败,正在返回列表...');
            }
        }
        else{
            $id=$_GET['id'];
            $info=$classification->where(array('id'=>$id))->find();
            $this->assign("news",$info);
            $this->display();
        }
    }
    public function gifts_delete($id){
        $News = M('gifts');
        $arr= $News-> where('id='.$id)->delete();
        if($arr){
//            M("order_num")->where(array('goods_id'=>$id))->delete();
            $this->redirect('gifts',array(),1,'删除成功,正在返回列表...');
        }else{
            $this->redirect('gifts',array(),1,'系统繁忙请重试...');
        }
    }

//剧种大类
    public function vips()
    {
        $p = I('get.p', 1);
        $News = M('vips');
        $map = array();
        $map['types'] = 1;
        $list = $News->where($map)->order("toop desc")->page($p)->select();
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    //戏币
    public function xibi()
    {
        $p = I('get.p', 1);
        $News = M('vips');
        $map = array();
        $map['types'] = 2;
        $list = $News->where($map)->order("toop desc")->page($p)->select();
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }

    public function addvip()
    {
        if (IS_POST) {
            $News = M('vips');
            if ($_POST['idd'] == "") {
                $_POST['times'] = time();
                $arr = $News->add($_POST);
            } else {

                $arr = $News->where(array('id' => $_POST['idd']))->save($_POST);
            }
            if ($arr) {
                $this->redirect('vips', array(), 1, '保存成功,正在返回列表...');
            } else {
                $this->redirect('vips', array(), 1, '系统繁忙，请重试...');
            }
        } else {
            $id = I('id');
            $News = M('vips');
            $news = $News->find($id);
            $this->assign('news', $news);
            $this->display();
        }
    }   public function addxibi()
    {
        if (IS_POST) {
            $News = M('vips');

            $_POST['vip_title']=$_POST['gold']/$_POST['nums'];
            if ($_POST['idd'] == "") {
                $_POST['times'] = time();
                $_POST['types'] = 2;
                $arr = $News->add($_POST);
            } else {
                $arr = $News->where(array('id' => $_POST['idd']))->save($_POST);
            }
            if ($arr) {
                $this->redirect('xibi', array(), 1, '保存成功,正在返回列表...');
            } else {
                $this->redirect('xibi', array(), 1, '系统繁忙，请重试...');
            }
        } else {
            $id = I('id');
            $News = M('vips');
            $news = $News->find($id);
            $this->assign('news', $news);
            $this->display();
        }
    }
    public function vip_delete($id)
    {

        $News = M('vips');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('vips', array(), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('vips', array(), 1, '系统繁忙请重试...');
        }

    } public function xibi_delete($id)
    {

        $News = M('vips');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('xibi', array(), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('xibi', array(), 1, '系统繁忙请重试...');
        }

    }







    public function xiajia(){
        $id = $_GET['id'];
        $News = M('healthyshop');

        $list = $News->where(array('id'=>$id))->getField("type");
        if($list==1){
            $arr= $News->where(array('id'=>$id))->setField("type",2);
        }else{
            $arr=$News->where(array('id'=>$id))->setField("type",1);
        }
        if ($arr) {
            $this->redirect('stores', array(), 1, '操作成功,正在返回列表...');
        } else {
            $this->redirect('stores', array(), 1, '系统繁忙，请重试...');
        }
    }
    public function yanseimg(){
        $News=M("healthyshop");
        $product=$_GET['product'];
        $this->assign("pid",$product);//产品的id
        if(IS_POST) {
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
                $_POST['yansetubiao'] = '/Uploads' . $images['uploadbtn1']['savepath'] . $images['uploadbtn1']['savename'];
            }


            $userinfo = $News->where(array('id' => $_POST['idd']))->save($_POST);

            if ($userinfo) {
                $this->redirect('stores', array(), 1, '操作成功,正在返回列表...');
            } else {
                $this->redirect('stores', array(), 1, '操作失败,正在返回列表...');
            }
        }

        else{

            $news=$News->where(array('id'=>$product))->field("id,yansetubiao")->find();
            $this->assign('news',$news);
            $this->display();

        }
    }
    public function chicunimg(){
        $News=M("healthyshop");
        $product=$_GET['product'];
        $this->assign("pid",$product);//产品的id
        if(IS_POST) {
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
                $_POST['chicuntubiao'] = '/Uploads' . $images['uploadbtn1']['savepath'] . $images['uploadbtn1']['savename'];
            }


            $userinfo = $News->where(array('id' => $_POST['idd']))->save($_POST);

            if ($userinfo) {
                $this->redirect('stores', array(), 1, '操作成功,正在返回列表...');
            } else {
                $this->redirect('stores', array(), 1, '操作失败,正在返回列表...');
            }
        }

        else{

            $news=$News->where(array('id'=>$product))->field("id,yansetubiao")->find();
            $this->assign('news',$news);
            $this->display();

        }
    }


    public function delimg($id,$product)
    {

        $News = M('pro_img');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('addimg', array('user_id'=>$product), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('addimg', array('user_id'=>$product), 1, '系统繁忙请重试...');
        }

    }








    public function addimg1(){
        $News = M('pro_img');
        $product=$_GET['product'];
        $this->assign("pid",$product);
        if(IS_POST){
//            print_r($_FILES);
//            exit;
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
                $_POST['thumb'] = '/Uploads'.$images['uploadbtn1']['savepath'].$images['uploadbtn1']['savename'];
            }

            if($_POST['idd']==""){
                $_POST['type']=2;
                $userinfo=$News->add($_POST);
            }else{
                $userinfo=$News->where(array('id'=>$_POST['idd']))->save($_POST);
            }
            if($userinfo){
                $this->redirect('stores',array(),1,'操作成功,正在返回列表...');
            }else{
                $this->redirect('stores',array(),1,'操作失败,正在返回列表...');
            }

        }
        else{
            $id = I('productid');
            $news=$News->find($id);
            $this->assign('news',$news);
            $this->display();

        }
    }
    public function addimg(){
        $News = M('pro_img');
        $product=$_GET['product'];
        $this->assign("pid",$product);
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
        $_POST['type']=2;
        $userinfo=$News->add($_POST);
    }else{
        $userinfo=$News->where(array('id'=>$_POST['idd']))->save($_POST);
    }
}


            }

            if($userinfo){
                $this->redirect('addimg',array('product'=>$product),1,'操作成功,正在返回列表...');
            }else{
                $this->redirect('addimg',array('product'=>$product),1,'操作失败,正在返回列表...');
            }

        }
        else{
            $id = I('productid');
            $news=$News->find($id);
            $product_img=M("pro_img");

            $img=$product_img->where(array('pro_id'=>$product,'type'=>2))->select();
//var_dump($news);
            $this->assign('img',$img);
            $this->assign('news',$news);
            $this->display();

        }
    }
    /**
     * 确保文件夹存在并可写
     *
     * @param string $dir
     */
    function ensure_writable_dir($dir) {
        if(!file_exists($dir)) {
            mkdir($dir, 0766, true);
            chmod($dir, 0766);
            chmod($dir, 0777);
        }
        else if(!is_writable($dir)) {
            chmod($dir, 0766);
            chmod($dir, 0777);
            if(!is_writable($dir)) {
                throw new FileSystemException("目录 $dir 不可写");
            }
        }
    }

    //changjianwenti
    public function stores(){
        if($_GET['p']==''){
            $_GET['p']=1;
        }
        $p = I('get.p',$_GET['p']);
        $News = M('healthyshop');
        $types=M("types");

        $type1=$types->where(array('type'=>7))->select();
        $this->assign("type1",$type1);

        $tj_id = I('pro_name',$_GET['pro_name']);
        if(!empty($tj_id)){
            $map['pro_name'] = array('like',"%".$tj_id."%");
            $this->assign('pro_name', $tj_id);
        }
        if(!empty($p)){
            $this->assign('p', $p);
        }
        $type = I('type1',$_GET['type1']);
        if(!empty($type)){
            $map['type1'] =$type;
            $this->assign('level', $type);
        }
        $type2 = I('type2',$_GET['type2']);
        if(!empty($type2)){
            $map['type2'] =$type2;
            $this->assign('level2', $type2);
        }


        $list = $News->where($map)->page($p)->order("toop desc")->order("id desc")->select();
        $product_img=M("pro_img");
        foreach ($list as &$v){
            $v['img']=$product_img->where(array('pro_id'=>$v['id'],'type'=>2))->select();
        }
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    public function stores_add(){

//活动
        $News = M('types');
        $activity_offset = $News->where("type=7")->order("toop desc")->select();
        $this->assign("activity_offset",$activity_offset);

        $Newss=M("healthyshop");
        if($_POST){

            $config = array(
                'maxSize' => 2 * 1024 * 1024,
                'savePath' => '/Videos/', //保存路径
                'exts' => array('jpg', 'gif', 'png', 'jpeg','mp4','rmvb'),
                'autoSub' => true,
                'subName' => array('date', 'Ym'),
                'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
                'saveExt' => '', //文件保存后缀，空则使用原后缀
                'replace' => false, //存在同名是否覆盖
                'hash' => true, //是否生成hash编码
            );

            $upload = new \Think\Upload($config);// 实例化上传类
            $images = $upload->upload();
//var_dump($images);
//exit;
            if (!empty($images)) {
//                $_POST['videos']=$images;

                $_POST['vadios'] = '/Uploads' . $images[0]['savepath'] . $images[0]['savename'];
            }

            if($_POST['idd']==""){

                $result=$Newss->add($_POST);
            }else{
                $result=$Newss->where(array('id'=>$_POST['idd']))->save($_POST);
            }
            if($result){
                $this->redirect('stores',array('pro_name'=>$_POST['pppp'],'type1'=>$_POST['ttt1'],'type2'=>$_POST['ttt2'],'p'=>$_POST['p']),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('stores',array('pro_name'=>$_POST['pppp'],'type1'=>$_POST['ttt1'],'type2'=>$_POST['ttt2'],'p'=>$_POST['p']),1,'操作失败,正在返回列表...');
            }
            if($result){

                $msg['info']="操作成功";
                $msg['status']=200;
            }else{
                $msg['info']="系统繁忙，请重试";
                $msg['status']=400;
            }
            $this->ajaxReturn($msg);
        }else{
            $id=$_GET['id'];
            $pro_name=$_GET['pro_name'];
            $type1=$_GET['type1'];
            $type2=$_GET['type2'];
            $p=$_GET['p'];
            $infos=$Newss->where(array('id'=>$id))->find();
            $this->assign("infos",$infos);
            $this->assign("pro_name",$pro_name);
            $this->assign("type1",$type1);
            $this->assign("type2",$type2);
            $this->assign("p",$p);
            $this->display();
        }

    }
    public function stores_delete($id)
    {

        $News = M('healthyshop');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('stores', array(), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('stores', array(), 1, '系统繁忙请重试...');
        }

    }
    public function get_type(){
        $province=M('types');
        $p_code=I('post.initials');
        $city=$province->where(array('initials'=>$p_code))->select();
        $this->ajaxReturn($city);
    }
    public function get_shop(){
        $province=M('healthyshop');
        $p_code=I('post.initials');
        $city=$province->where(array('type1'=>$p_code))->field("id,pro_name")->select();
        $this->ajaxReturn($city);
    }
    //剧种大类
    public function needs()
    {
        $p = I('get.p', 1);
        $News = M('types');
        $map = array();
        $map['type'] = 4;
        $list = $News->where($map)->order("toop desc")->page($p)->select();
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    } public function tousu()
    {
        $p = I('get.p', 1);
        $News = M('notice');
        $map = array();
        $map['type'] = 1;
        $list = $News->where($map)->order("news_title desc")->field("news_title,content,id")->page($p)->select();
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }

    public function tousu_edit()
    {
        if (IS_POST) {
            $News = M('notice');
            if ($_POST['idd'] == "") {
                $_POST['type'] = 1;
                $_POST['times'] = time();

                $arr = $News->add($_POST);
            } else {

                $arr = $News->where(array('id' => $_POST['idd']))->save($_POST);
            }
            if ($arr) {
                $this->redirect('tousu', array(), 1, '保存成功,正在返回列表...');
            } else {
                $this->redirect('tousu', array(), 1, '系统繁忙，请重试...');
            }
        } else {
            $id = I('id');
            $News = M('notice');
            $news = $News->find($id);
            $this->assign('news', $news);
            $this->display();
        }
    } public function needs_edit()
    {
        if (IS_POST) {
            $News = M('types');
            if ($_POST['idd'] == "") {
                $_POST['type'] = 4;
                $_POST['times'] = time();

                $arr = $News->add($_POST);
            } else {

                $arr = $News->where(array('id' => $_POST['idd']))->save($_POST);
            }
            if ($arr) {
                $this->redirect('needs', array(), 1, '保存成功,正在返回列表...');
            } else {
                $this->redirect('needs', array(), 1, '系统繁忙，请重试...');
            }
        } else {
            $id = I('id');
            $News = M('types');
            $news = $News->find($id);
            $this->assign('news', $news);
            $this->display();
        }
    }
    public function needs_delete($id)
    {

        $News = M('types');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('needs', array(), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('needs', array(), 1, '系统繁忙请重试...');
        }

    } public function tousu_delete($id)
    {

        $News = M('notice');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('tousu', array(), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('tousu', array(), 1, '系统繁忙请重试...');
        }

    }


}