<?php
namespace Admin\Controller;
use Think\Controller;
class CarshopController extends AdminController
{
//品牌

    public function brand()
    {
        $p = I('get.p', 1);
        $News = M('types');
        $tj_id = I('type_name',$_GET['type_name']);
        if(!empty($tj_id)){
            $map['type_name'] = array('like',"%".$tj_id."%");
            $this->assign('type_name', $tj_id);
        }

        $map['type'] = 2;
        $list = $News->where($map)->order("toop desc")->page($p)->select();
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    public function xiajia(){
        $id = $_GET['id'];
        $News = M('product');

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

    public function brand_add()
    {
        if (IS_POST) {
            $_POST['type'] = 2;
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
            $News = M('types');

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
        if (IS_POST) {
            $News = M('types');
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

//车型
    public function blackaccount()
    {
        $p = I('get.p', 1);
        $News = M('types');
        $map = array();
        $map['type'] = 3;
        $list = $News->where($map)->order("toop desc")->page($p)->select();
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }

    public function blackaccount_add()
    {
        if (IS_POST) {
            $_POST['type'] = 3;
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
            $News = M('types');
            $arr = $News->add($_POST);
            if ($arr) {
                $this->redirect('blackaccount', array(), 1, '保存成功,正在返回列表...');
            } else {
                $this->redirect('blackaccount', array(), 1, '系统繁忙，请重试...');
            }
        } else {
            $this->display();
        }
    }

    public function blackaccount_edit()
    {
        if (IS_POST) {
            $News = M('types');
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
                $this->redirect('blackaccount', array(), 1, '保存成功,正在返回列表...');
            } else {
                $this->redirect('blackaccount', array(), 1, '系统繁忙，请重试...');
            }
        } else {
            $id = I('id');
            $News = M('types');
            $news = $News->find($id);
            $this->assign('news', $news);
            $this->display();
        }
    }

    public function news_delete($id)
    {

        $News = M('types');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('blackaccount', array(), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('blackaccount', array(), 1, '系统繁忙请重试...');
        }

    }
    //  价格区间
    //品牌
    public function price_range()
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
    }

    public function price_range_edit()
    {
        if (IS_POST) {
            $News = M('types');
            if ($_POST['idd'] == "") {
                $_POST['type'] = 4;
                $arr = $News->add($_POST);
            } else {

                $arr = $News->where(array('id' => $_POST['idd']))->save($_POST);
            }
            if ($arr) {
                $this->redirect('price_range', array(), 1, '保存成功,正在返回列表...');
            } else {
                $this->redirect('price_range', array(), 1, '系统繁忙，请重试...');
            }
        } else {
            $id = I('id');
            $News = M('types');
            $news = $News->find($id);
            $this->assign('news', $news);
            $this->display();
        }
    }

    public function price_range_delete($id)
    {

        $News = M('types');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('price_range', array(), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('price_range', array(), 1, '系统繁忙请重试...');
        }

    }

//首付
    public function down_payments()
    {
        $p = I('get.p', 1);
        $News = M('types');
        $map = array();
        $map['type'] = 5;
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
                $_POST['type'] = 5;
                $arr = $News->add($_POST);
            } else {

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
//月供
    public function forthe_month()
    {
        $p = I('get.p', 1);
        $News = M('types');
        $map = array();
        $map['type'] = 6;
        $list = $News->where($map)->order("toop desc")->page($p)->select();
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }

    public function forthe_month_edit()
    {
        if (IS_POST) {
            $News = M('types');
            if ($_POST['idd'] == "") {
                $_POST['type'] = 6;
                $arr = $News->add($_POST);
            } else {

                $arr = $News->where(array('id' => $_POST['idd']))->save($_POST);
            }
            if ($arr) {
                $this->redirect('forthe_month', array(), 1, '保存成功,正在返回列表...');
            } else {
                $this->redirect('forthe_month', array(), 1, '系统繁忙，请重试...');
            }
        } else {
            $id = I('id');
            $News = M('types');
            $news = $News->find($id);
            $this->assign('news', $news);
            $this->display();
        }
    }
    public function forthe_month_delete($id)
    {

        $News = M('types');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('forthe_month', array(), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('forthe_month', array(), 1, '系统繁忙请重试...');
        }

    }
    //changjianwenti
    public function times(){
        $p = I('get.p',1);
        $News = M('activity_offset');

        $list = $News->page($p)->order("toop desc")->select();
        $mapcount = $News->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    public function times_edit(){

        $News=M("activity_offset");
        if($_POST){


            if($_POST['idd']==""){

                $result=$News->add($_POST);
            }else{
                $result=$News->where(array('id'=>$_POST['idd']))->save($_POST);
            }

            if($result){
                $this->redirect('times',array(),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('times',array(),1,'操作失败,正在返回列表...');
            }
        }else{
            $id=$_GET['id'];
            $infos=$News->where(array('id'=>$id))->find();
            $this->assign("infos",$infos);
            $this->display();
        }

    }
    //changjianwenti
    public function stores(){
        $types = M('types');
        $brands = $types->where('type=2')->order("toop desc")->select();
        $this->assign("brands",$brands);
        $chexing = $types->where('type=3')->order("toop desc")->select();
        $this->assign("chexing",$chexing);
        if($_GET['p']==''){
            $_GET['p']=1;
        }
        $p = I('get.p',$_GET['p']);
        if(!empty($p)){
            $this->assign('p', $p);
        }
        $News = M('product');
        //上级推荐人
        $tj_id = I('pro_name',$_GET['pro_name']);
        if(!empty($tj_id)){
            $map['pro_name'] = array('like',"%".$tj_id."%");
            $this->assign('pro_name', $tj_id);
        }
        $brand = I('brand',$_GET['brand']);
        if(!empty($brand)){
            $map['brand'] = $brand;
            $this->assign('brand', $brand);
        }
        $car_models = I('car_models',$_GET['car_models']);
        if(!empty($car_models)){
            $map['car_models'] = $car_models;
            $this->assign('car_models', $car_models);
        }
        $is_tj = I('is_tj',$_GET['is_tj']);
        if(!empty($is_tj)){
            $map['is_tj'] = $is_tj;
            $this->assign('is_tj', $is_tj);
        }
        $list = $News->page($p)->where($map)->order("toop desc")->select();
        $product_img=M("pro_img");
        foreach ($list as &$v){
            $v['img']=$product_img->where(array('pro_id'=>$v['id'],'type'=>1))->select();
        }
        $mapcount = $News->where($map)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    public function stores_add(){
//活动
        $News = M('activity_offset');
        $activity_offset = $News->order("toop desc")->select();
        $this->assign("activity_offset",$activity_offset);
        //门店
        $merchant = M('merchant');
        $store = $merchant->where("status=2")->order("addtime desc")->select();
        $this->assign("store",$store);
        //品牌
        $types = M('types');
        $brand = $types->where('type=2')->order("toop desc")->select();
        $this->assign("brand",$brand);

//        $down_payments = $types->where('type=5')->order("toop desc")->select();首付
//        $this->assign("down_payments",$down_payments);
//        $forthe_month = $types->where('type=6')->order("toop desc")->select();月供
//        $this->assign("forthe_month",$forthe_month);

        //车型
        $car_models = $types->where('type=3')->order("toop desc")->select();
        $this->assign("car_models",$car_models);

        $News=M("product");
        if($_POST){

$data['pro_name']=$_POST['pro_name'];
$data['brand']=implode("*",$_POST['brand']);
$data['car_models']=implode("*",$_POST['car_models']);
$data['activitys']=implode("*",$_POST['activitys']);
$data['store']=implode("*",$_POST['store']);
$data['key_word']=$_POST['key_word'];
$data['guidance_price']=$_POST['guidance_price'];
$data['colour']=$_POST['colour'];
$data['telephone']=$_POST['telephone'];
$data['introduce']=$_POST['introduce'];
$data['specifications']=$_POST['specifications'];
$data['problem']=$_POST['problem'];
$data['toop']=$_POST['toop'];
$data['dingjin']=$_POST['dingjin'];
$data['mobiles']=$_POST['mobiles'];
$data['is_tj']=$_POST['is_tj'];
$data['bobi']=$_POST['bobi'];
$data['shoufu']=$_POST['shoufu'];
$data['jinpaia']=$_POST['jinpaia'];
$data['jinpail']=$_POST['jinpail'];
$data['yinpaia']=$_POST['yinpaia'];
$data['tongpaia']=$_POST['tongpaia'];
$data['yinpail']=$_POST['yinpail'];
$data['tongpail']=$_POST['tongpail'];
$data['putonga']=$_POST['putonga'];
$data['putongl']=$_POST['putongl'];
$data['kefu']=$_POST['kefu'];


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
            if (!empty($images)) {
//                $_POST['videos']=$images;

                $data['videos'] = '/Uploads' . $images[0]['savepath'] . $images[0]['savename'];
            }

//$data['videos']=$_POST['videos'];
            if($_POST['idd']==""){

                $result=$News->add($data);
            }else{
                $result=$News->where(array('id'=>$_POST['idd']))->save($data);
            }

            if($result){
                $this->redirect('stores',array('pro_name'=>$_POST['pppp'],'brand'=>$_POST['p1'],'car_models'=>$_POST['p2'],'is_tj'=>$_POST['p3'],'p'=>$_POST['p']),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('stores',array('pro_name'=>$_POST['pppp'],'brand'=>$_POST['p1'],'car_models'=>$_POST['p2'],'is_tj'=>$_POST['p3'],'p'=>$_POST['p']),1,'操作失败,正在返回列表...');
            }
        }else{
            $id=$_GET['id'];
            $pro_name=$_GET['pro_name'];
            $p=$_GET['p'];
            $brand=$_GET['brand'];
            $is_tj=$_GET['is_tj'];
            $car_models=$_GET['car_models'];
            $infos=$News->where(array('id'=>$id))->find();
            $infos['store']=explode("*",$infos['store']);
            $infos['car_models']=explode("*",$infos['car_models']);
            $this->assign("pro_name",$pro_name);
            $this->assign("infos",$infos);
            $this->assign("p",$p);
            $this->assign("p1",$brand);
            $this->assign("p2",$car_models);
            $this->assign("p3",$is_tj);
            $this->display();
        }

    }




    public function delimg($id,$product)
    {

        $News = M('pro_img');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('addimg', array('product'=>$product), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('addimg', array('product'=>$product), 1, '系统繁忙请重试...');
        }

    }
    public function stores_delete($id)
    {

        $News = M('product');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('stores', array(), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('stores', array(), 1, '系统繁忙请重试...');
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
                        $_POST['type']=1;
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

            $img=$product_img->where(array('pro_id'=>$product,'type'=>1))->select();
//var_dump($news);
            $this->assign('img',$img);
            $this->assign('news',$news);
            $this->display();

        }
    }
    public function yanseimg(){
        $News=M("product");
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
    public function addimg1(){
        $News = M('pro_img');
        $product=$_GET['product'];
        $this->assign("pid",$product);
        if(IS_POST){
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
$_POST['type']=1;
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

}