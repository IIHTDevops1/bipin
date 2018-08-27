<?php
namespace Admin\Controller;
use \Home\Qiniu\Auth;
use \Home\Qiniu\Storage\UploadManager;
class NewsController extends AdminController
{//健康商城
//品牌
    public function brand()
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

    public function brand_add()
    {
        $News = M('types');
        if (IS_POST) {
            if(empty($_POST['type_name'])){
                $this->redirect('brand_add', array(), 1, '请填写必要参数...');
            }
            $_POST['type'] = 3;
            $_POST['times'] = time();
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
        if (IS_POST) {
            if(empty($_POST['type_name'])){
                $this->redirect('brand_edit', array('id'=>$_POST['idd']), 1, '请填写必要参数...');
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
    public function news_delete($id)
    {

        $News = M('workss');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('blackaccount', array(), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('blackaccount', array(), 1, '系统繁忙请重试...');
        }

    } public function yinpin_delete($id)
    {

        $News = M('workss');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('yinpin', array(), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('yinpin', array(), 1, '系统繁忙请重试...');
        }

    }  public function qupu_delete($id)
    {

        $News = M('workss');
        $arr = $News->where('id=' . $id)->delete();
        if ($arr) {
            $this->redirect('qupu', array(), 1, '删除成功,正在返回列表...');
        } else {
            $this->redirect('qupu', array(), 1, '系统繁忙请重试...');
        }

    }

//上传七牛图片

    public function up_img(){

        import('Home.Qiniu.functions');

        // 用于签名的公钥和私钥
        $accessKey = '6WZAXfpVzbxg0of-kIpQLi-EeG2JhgtBHNq41My0';
        $secretKey = 'KIDDOxju46_y_ZbxjqtmYrMwP-CSBbQo5IULSvrs';
        $path_url="pbp5zunaq.bkt.clouddn.com";
        // 初始化签权对象
        $auth = new Auth($accessKey, $secretKey);
        //空间名
        $bucket = 'xibaonew';
        $file=$_FILES['file'];
        if($file['name'][0]==""){
//            $this->redirect('qupu_add',array(),1,'保存成功,正在返回列表...');
            $this->redirect('blackaccount_add',array('id'=>$_POST['iddd']),1,'请选择图片...');
        }
//            var_dump($file);
        $type=strchr($file['name'],'.');
        $key=time().$type;
        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        // echo $token;exit;
        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();
        // 上传文件到七牛
        $result= $uploadMgr->putFile($token, $key, $file['tmp_name'],$params = null,$mime = $file['type'],$checkCrc = false);

        $_POST['thumb']="http://".$path_url."/".$result[0]['key'];


        $_SESSION['thumb']=$_POST['thumb'];
        $_SESSION['idd']=$_POST['iddd'];
        $this->redirect('blackaccount_add',array('id'=>$_SESSION['idd']));
    }
    //音频上传
    public function up_imgyp(){

        import('Home.Qiniu.functions');

        // 用于签名的公钥和私钥
        $accessKey = '6WZAXfpVzbxg0of-kIpQLi-EeG2JhgtBHNq41My0';
        $secretKey = 'KIDDOxju46_y_ZbxjqtmYrMwP-CSBbQo5IULSvrs';
        $path_url="pbp5zunaq.bkt.clouddn.com";
        // 初始化签权对象
        $auth = new Auth($accessKey, $secretKey);
        //空间名
        $bucket = 'xibaonew';
        $file=$_FILES['file'];
        if($file['name'][0]==""){
//            $this->redirect('qupu_add',array(),1,'保存成功,正在返回列表...');
            $this->redirect('yinpin_add',array('id'=>$_POST['iddd']),1,'请选择图片...');
        }
//            var_dump($file);
        $type=strchr($file['name'],'.');
        $key=time().$type;
        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        // echo $token;exit;
        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();
        // 上传文件到七牛
        $result= $uploadMgr->putFile($token, $key, $file['tmp_name'],$params = null,$mime = $file['type'],$checkCrc = false);

        $_POST['thumb']="http://".$path_url."/".$result[0]['key'];


        $_SESSION['thumb']=$_POST['thumb'];
        $_SESSION['idd']=$_POST['iddd'];
        $this->redirect('yinpin_add',array('id'=>$_SESSION['idd']));
    }
    public function up_accompaniment(){
        import('Api.Qiniu.functions');
        // 用于签名的公钥和私钥
        $accessKey = '6WZAXfpVzbxg0of-kIpQLi-EeG2JhgtBHNq41My0';
        $secretKey = 'KIDDOxju46_y_ZbxjqtmYrMwP-CSBbQo5IULSvrs';
        $path_url="pbp5zunaq.bkt.clouddn.com";
        // 初始化签权对象
        $auth = new  Auth($accessKey, $secretKey);
        // 空间名
        $bucket = 'xibaonew';
        $file=$_FILES['file'];
        if($file['name'][0]==""){
//            $this->redirect('qupu_add',array(),1,'保存成功,正在返回列表...');
            $this->redirect('blackaccount_add',array('id'=>$_POST['idddd']),1,'请选择伴奏文件...');
        }
        $type=strchr($file['name'],'.');
        $key=time().$type;
        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();
        // 上传文件到七牛
        $result= $uploadMgr->putFile($token, $key, $file['tmp_name'],$params = null,$mime = $file['type'],$checkCrc = false);

        $_POST['accompaniment']="http://".$path_url."/".$result[0]['key'];

        $_SESSION['workss']=$_POST['accompaniment'];
        $_SESSION['idd']=$_POST['idddd'];

        $this->redirect('blackaccount_add',array('id'=>$_SESSION['idd']));
    }
    //音频文件
    public function up_acyp(){
        import('Api.Qiniu.functions');
        // 用于签名的公钥和私钥
        $accessKey = '6WZAXfpVzbxg0of-kIpQLi-EeG2JhgtBHNq41My0';
        $secretKey = 'KIDDOxju46_y_ZbxjqtmYrMwP-CSBbQo5IULSvrs';
        $path_url="pbp5zunaq.bkt.clouddn.com";
        // 初始化签权对象
        $auth = new  Auth($accessKey, $secretKey);
        // 空间名
        $bucket = 'xibaonew';
        $file=$_FILES['file'];
        if($file['name'][0]==""){
//            $this->redirect('qupu_add',array(),1,'保存成功,正在返回列表...');
            $this->redirect('yinpin_add',array('id'=>$_POST['idddd']),1,'请选择伴奏文件...');
        }
        $type=strchr($file['name'],'.');
        $key=time().$type;
        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();
        // 上传文件到七牛
        $result= $uploadMgr->putFile($token, $key, $file['tmp_name'],$params = null,$mime = $file['type'],$checkCrc = false);

        $_POST['accompaniment']="http://".$path_url."/".$result[0]['key'];

        $_SESSION['workss']=$_POST['accompaniment'];
        $_SESSION['idd']=$_POST['idddd'];

        $this->redirect('yinpin_add',array('id'=>$_SESSION['idd']));
    }

    public function blackaccount(){
        unset($_SESSION['thumb']);
        unset($_SESSION['idd']);
        unset($_SESSION['workss']);
        $typese=M("types");
        $type1=$typese->where(array('type'=>1))->select();
        $this->assign("type1",$type1);
        $typess=$typese->where("type=3")->select();
        $this->assign("typess",$typess);
        $news_title = I('news_title',$_POST['news_title']);
        if(!empty($news_title)){
            $where['news_title'] = array('like',"%".$news_title."%");
            $this->assign('news_title', $news_title);
        }
        $yonghu = I('yonghu',$_POST['yonghu']);
        if(!empty($yonghu)){
            $where['yonghu'] = $yonghu;
            $this->assign('yonghu', $yonghu);
        }
        $types = I('types',$_POST['types']);
        if(!empty($types)){
            $where['types'] = $types;
            $this->assign('types', $types);
        }
        $type = I('type1',$_POST['type1']);
        if(!empty($type)){
            $where['type1'] =$type;
            $this->assign('level', $type);
        }
        $type2 = I('type2',$_POST['type2']);
        if(!empty($type2)){
            $where['type2'] =$type2;
            $this->assign('level2', $type2);
        }
        $p = I('get.p',1);
        $News = M('workss');
        $where['fenlei']=1;
        $list = $News->where($where)->page($p)->order("toop desc")->select();
        $mapcount = $News->where($where)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    public function yinpin(){
        unset($_SESSION['thumb']);
        unset($_SESSION['idd']);
        unset($_SESSION['workss']);
        $typese=M("types");
        $type1=$typese->where(array('type'=>1))->select();
        $this->assign("type1",$type1);
        $news_title = I('news_title',$_POST['news_title']);
        if(!empty($news_title)){
            $where['news_title'] = array('like',"%".$news_title."%");
            $this->assign('news_title', $news_title);
        }
        $yonghu = I('yonghu',$_POST['yonghu']);
        if(!empty($yonghu)){
            $where['yonghu'] = $yonghu;
            $this->assign('yonghu', $yonghu);
        }

        $type = I('type1',$_POST['type1']);
        if(!empty($type)){
            $where['type1'] =$type;
            $this->assign('level', $type);
        }
        $type2 = I('type2',$_POST['type2']);
        if(!empty($type2)){
            $where['type2'] =$type2;
            $this->assign('level2', $type2);
        }
        $p = I('get.p',1);
        $News = M('workss');
        $where['fenlei']=3;
        $list = $News->where($where)->page($p)->order("toop desc")->select();
        $mapcount = $News->where($where)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }
    public function get_type(){
        $province=M('types');
        $p_code=I('post.pid');
        $city=$province->where(array('pid'=>$p_code))->select();
        $this->ajaxReturn($city);
    }

    public function blackaccount_add(){
        $Newss = M('types');
        $News = M('workss');
        $arrr=$Newss->where(array('type'=>1))->order("toop desc")->select();
        $this->assign("position",$arrr);
        $arrr2=$Newss->where(array('type'=>3))->order("toop desc")->select();
        $this->assign("position1",$arrr2);

        if(IS_POST){
            if(empty($_POST['type1']) || empty($_POST['type2'])){
                $this->redirect('blackaccount_add',array('id'=>$_POST['idd']),1,'请选择剧种分类...');
            }
            if($_POST['idd']==""){
                $_POST['yonghu']=2;
                $_POST['fenlei']=1;
                $_POST['times']=time();
                $arr=$News->add($_POST);

            }else{
                $arr=$News->where(array('id'=>$_POST['idd']))->save($_POST);
            }
            unset($_SESSION['thumb']);
            unset($_SESSION['idd']);
            unset($_SESSION['workss']);
            if($arr){

                $this->redirect('blackaccount',array(),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('blackaccount',array(),1,'操作失败,正在返回列表...');
            }

        }
        else{
            $id = I('id');
            $news=$News->find($id);
            $this->assign('news',$news);
            $this->display();
        }
    }
    public function yinpin_add(){
        $Newss = M('types');
        $News = M('workss');
        $arrr=$Newss->where(array('type'=>1))->order("toop desc")->select();
        $this->assign("position",$arrr);
        $arrr2=$Newss->where(array('type'=>3))->order("toop desc")->select();
        $this->assign("position1",$arrr2);
        if(IS_POST){
            if(empty($_POST['type1']) || empty($_POST['type2'])){
                $this->redirect('yinpin_add',array('id'=>$_POST['idd']),1,'请选择剧种分类...');
            }
            if($_POST['idd']==""){
                $_POST['yonghu']=2;
                $_POST['fenlei']=3;
                $_POST['times']=time();
                $arr=$News->add($_POST);

            }else{
                $arr=$News->where(array('id'=>$_POST['idd']))->save($_POST);
            }
            unset($_SESSION['thumb']);
            unset($_SESSION['idd']);
            unset($_SESSION['workss']);
            if($arr){

                $this->redirect('yinpin',array(),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('yinpin',array(),1,'操作失败,正在返回列表...');
            }

        }
        else{
            $id = I('id');
            $news=$News->find($id);
            $this->assign('news',$news);
            $this->display();
        }
    }
/////曲谱
    public function qupu(){
        unset($_SESSION['thumb']);
        unset($_SESSION['idd']);
        unset($_SESSION['workss']);
        $typese=M("types");
        $type1=$typese->where(array('type'=>1))->select();
        $this->assign("type1",$type1);
        $typess=$typese->where("type=3")->select();
        $this->assign("typess",$typess);
        $news_title = I('news_title',$_POST['news_title']);
        if(!empty($news_title)){
            $where['news_title'] = array('like',"%".$news_title."%");
            $this->assign('news_title', $news_title);
        }
        $yonghu = I('yonghu',$_POST['yonghu']);
        if(!empty($yonghu)){
            $where['yonghu'] = $yonghu;
            $this->assign('yonghu', $yonghu);
        }

        $type = I('type1',$_POST['type1']);
        if(!empty($type)){
            $where['type1'] =$type;
            $this->assign('level', $type);
        }
        $type2 = I('type2',$_POST['type2']);
        if(!empty($type2)){
            $where['type2'] =$type2;
            $this->assign('level2', $type2);
        }
        $p = I('get.p',1);
        $News = M('workss');
        $where['fenlei']=2;
        $list = $News->where($where)->page($p)->order("toop desc")->select();
        foreach ($list as &$v){
            $v['workss']=explode("@",$v['workss']);
        }
        $mapcount = $News->where($where)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }

    public function up_qupu(){

        import('Home.Qiniu.functions');

        // 用于签名的公钥和私钥
        $accessKey = '6WZAXfpVzbxg0of-kIpQLi-EeG2JhgtBHNq41My0';
        $secretKey = 'KIDDOxju46_y_ZbxjqtmYrMwP-CSBbQo5IULSvrs';
        $path_url="pbp5zunaq.bkt.clouddn.com";
        // 初始化签权对象
        $auth = new Auth($accessKey, $secretKey);
        //空间名
        $bucket = 'xibaonew';
        $file=$_FILES['file'];
        if($file['name'][0]==""){
//            $this->redirect('qupu_add',array(),1,'保存成功,正在返回列表...');
            $this->redirect('qupu_add',array('id'=>$_POST['iddd']),1,'请选择图片...');
        }
//            var_dump($file);
        $type=strchr($file['name'],'.');
        $key=time().$type;
        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        // echo $token;exit;
        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();
        // 上传文件到七牛
        $result= $uploadMgr->putFile($token, $key, $file['tmp_name'],$params = null,$mime = $file['type'],$checkCrc = false);

        $_POST['thumb']="http://".$path_url."/".$result[0]['key'];


        $_SESSION['thumb']=$_POST['thumb'];
        $_SESSION['idd']=$_POST['iddd'];
        $this->redirect('qupu_add',array('id'=>$_SESSION['idd']));
    }
    public function up_aqupu(){

        import('Home.Qiniu.functions');

        // 用于签名的公钥和私钥
        $accessKey = '6WZAXfpVzbxg0of-kIpQLi-EeG2JhgtBHNq41My0';
        $secretKey = 'KIDDOxju46_y_ZbxjqtmYrMwP-CSBbQo5IULSvrs';
        $path_url="pbp5zunaq.bkt.clouddn.com";
        // 初始化签权对象
        $auth = new Auth($accessKey, $secretKey);
        //空间名
        $bucket = 'xibaonew';
        $file=$_FILES['file'];

        if($file['name'][0]==""){
            $this->redirect('qupu_add',array('id'=>$_POST['idddd']),1,'请选择曲谱图片...');
        }

        $uploadMgr = new UploadManager();
        $wordss=M("workss");
        $_POST['workss']=$wordss->where(array('id'=>$_POST['idddd']))->getfield("workss");


        foreach ($file['name'] as $k=>&$item) {
            $type=strchr($item,'.');
            $key=time().$type;
            $token = $auth->uploadToken($bucket);

            // 上传文件到七牛
            $result= $uploadMgr->putFile($token, $key, $file['tmp_name'][$k],$params = null,$mime = $file['type'][$k],$checkCrc = false);
            $_POST['workss'].="http://".$path_url."/".$result[0]['key']."@";
        }
        $_SESSION['workss']=$_POST['workss'];
        $_SESSION['worksss']=explode("@",$_POST['workss']);
        $_SESSION['idd']=$_POST['idddd'];
        $this->redirect('qupu_add',array('id'=>$_SESSION['idd']));
    }
    public function qupu_add(){
        $Newss = M('types');
        $News = M('workss');
        $arrr=$Newss->where(array('type'=>1))->order("toop desc")->select();
        $this->assign("position",$arrr);
        $arrr2=$Newss->where(array('type'=>3))->order("toop desc")->select();
        $this->assign("position1",$arrr2);
        if(IS_POST){
            if(empty($_POST['type1']) || empty($_POST['type2'])){
                $this->redirect('qupu_add',array('id'=>$_POST['idd']),1,'请选择剧种分类...');
            }
            if($_POST['idd']==""){
                $_POST['yonghu']=2;
                $_POST['fenlei']=2;
                $_POST['times']=time();
                $arr=$News->add($_POST);

            }else{
                $arr=$News->where(array('id'=>$_POST['idd']))->save($_POST);
            }
            unset($_SESSION['thumb']);
            unset($_SESSION['idd']);
            unset($_SESSION['workss']);
            if($arr){

                $this->redirect('qupu',array(),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('qupu',array(),1,'操作失败,正在返回列表...');
            }

        }
        else{
            $id = I('id');
            $news=$News->find($id);
            $news['workss']=explode("@",$news['workss']);
            $this->assign('news',$news);
            $this->display();
        }
    }

/////视频
    public function shipin(){
        unset($_SESSION['thumb']);
        unset($_SESSION['idd']);
        unset($_SESSION['workss']);
        $typese=M("types");
        $type1=$typese->where(array('type'=>1))->select();
        $this->assign("type1",$type1);

        $news_title = I('news_title',$_POST['news_title']);
        if(!empty($news_title)){
            $where['news_title'] = array('like',"%".$news_title."%");
            $this->assign('news_title', $news_title);
        }
        $yonghu = I('yonghu',$_POST['yonghu']);
        if(!empty($yonghu)){
            $where['yonghu'] = $yonghu;
            $this->assign('yonghu', $yonghu);
        }

        $type = I('type1',$_POST['type1']);
        if(!empty($type)){
            $where['type1'] =$type;
            $this->assign('level', $type);
        }
        $type2 = I('type2',$_POST['type2']);
        if(!empty($type2)){
            $where['type2'] =$type2;
            $this->assign('level2', $type2);
        }
        $p = I('get.p',1);
        $News = M('workss');
        $where['fenlei']=4;
        $list = $News->where($where)->page($p)->order("toop desc")->select();

        $mapcount = $News->where($where)->count();
        $show = getpages2($mapcount);
        $this->assign('pages', $show);//分页
        $this->assign('list', $list);
        $this->display();
    }

    public function shipin_add(){
        $Newss = M('types');
        $News = M('workss');
        $arrr=$Newss->where(array('type'=>1))->order("toop desc")->select();
        $this->assign("position",$arrr);
        $arrr2=$Newss->where(array('type'=>3))->order("toop desc")->select();
        $this->assign("position1",$arrr2);
        if(IS_POST){
            if(empty($_POST['type1']) || empty($_POST['type2'])){
                $this->redirect('shipin_add',array('id'=>$_POST['idd']),1,'请选择剧种分类...');
            }
            if($_POST['idd']==""){
                $_POST['yonghu']=2;
                $_POST['fenlei']=4;
                $_POST['times']=time();
                $arr=$News->add($_POST);

            }else{
                $arr=$News->where(array('id'=>$_POST['idd']))->save($_POST);
            }
            unset($_SESSION['thumb']);
            unset($_SESSION['idd']);
            unset($_SESSION['workss']);
            if($arr){

                $this->redirect('shipin',array(),1,'保存成功,正在返回列表...');
            }else{
                $this->redirect('shipin',array(),1,'操作失败,正在返回列表...');
            }

        }
        else{
            $id = I('id');
            $news=$News->find($id);
            $this->assign('news',$news);
            $this->display();
        }
    }
    //视频上传
    public function up_imgsp(){

        import('Home.Qiniu.functions');

        // 用于签名的公钥和私钥
        $accessKey = '6WZAXfpVzbxg0of-kIpQLi-EeG2JhgtBHNq41My0';
        $secretKey = 'KIDDOxju46_y_ZbxjqtmYrMwP-CSBbQo5IULSvrs';
        $path_url="pbp5zunaq.bkt.clouddn.com";
        // 初始化签权对象
        $auth = new Auth($accessKey, $secretKey);
        //空间名
        $bucket = 'xibaonew';
        $file=$_FILES['file'];
        if($file['name'][0]==""){
//            $this->redirect('qupu_add',array(),1,'保存成功,正在返回列表...');
            $this->redirect('yinpin_add',array('id'=>$_POST['iddd']),1,'请选择图片...');
        }
//            var_dump($file);
        $type=strchr($file['name'],'.');
        $key=time().$type;
        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        // echo $token;exit;
        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();
        // 上传文件到七牛
        $result= $uploadMgr->putFile($token, $key, $file['tmp_name'],$params = null,$mime = $file['type'],$checkCrc = false);

        $_POST['thumb']="http://".$path_url."/".$result[0]['key'];


        $_SESSION['thumb']=$_POST['thumb'];
        $_SESSION['idd']=$_POST['iddd'];
        $this->redirect('shipin_add',array('id'=>$_SESSION['idd']));
    }

    //视频文件
    public function up_acsp(){
        import('Api.Qiniu.functions');
        // 用于签名的公钥和私钥
        $accessKey = '6WZAXfpVzbxg0of-kIpQLi-EeG2JhgtBHNq41My0';
        $secretKey = 'KIDDOxju46_y_ZbxjqtmYrMwP-CSBbQo5IULSvrs';
        $path_url="pbp5zunaq.bkt.clouddn.com";
        // 初始化签权对象
        $auth = new  Auth($accessKey, $secretKey);
        // 空间名
        $bucket = 'xibaonew';
        $file=$_FILES['file'];
        if($file['name'][0]==""){
//            $this->redirect('qupu_add',array(),1,'保存成功,正在返回列表...');
            $this->redirect('yinpin_add',array('id'=>$_POST['idddd']),1,'请选择伴奏文件...');
        }
        $type=strchr($file['name'],'.');
        $key=time().$type;
        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();
        // 上传文件到七牛
        $result= $uploadMgr->putFile($token, $key, $file['tmp_name'],$params = null,$mime = $file['type'],$checkCrc = false);

        $_POST['accompaniment']="http://".$path_url."/".$result[0]['key'];

        $_SESSION['workss']=$_POST['accompaniment'];
        $_SESSION['idd']=$_POST['idddd'];

        $this->redirect('shipin_add',array('id'=>$_SESSION['idd']));
    }

}