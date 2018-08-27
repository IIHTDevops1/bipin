<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Controller;
use \Home\Qiniu\Auth;
use \Home\Qiniu\Storage\UploadManager;
class IndexController extends AdminController {
    
    
     /**
     * 七牛测试 文件上传执行部分
     * 
     */
    public function uploadQiNiu(){
        //import('Qiniu.functions');
        import('Tool.Qiniu.functions');
       // var_dump($_FILES);exit;
        // 用于签名的公钥和私钥
        $accessKey = 'T3nYCy3vjkv5I0Vu3-Of5cLyf9H25QQ9h35TpbRT';
        $secretKey = 'aPun0f4UEk8SgjUq211JaE-Jb_cqHW67uWUJbd6M';
        $path_url="http://orrxj0wnt.bkt.clouddn.com";
        // 初始化签权对象
        $auth = new Auth($accessKey, $secretKey);        
        // 空间名  https://developer.qiniu.io/kodo/manual/concepts
        $bucket = 'dome';        
        $file=$_FILES['file'];
        $type=strchr($file['name'],'.');  
        $key=time().$type;
        // 生成上传Token
            //转码时使用的队列名称 
      $pipeline = 'abc';
      //要进行转码的转码操作 
      $fops = "avthumb/mp4/s/640x360/vb/1.25m";
      //可以对转码后的文件进行使用saveas参数自定义命名，当然也可以不指定文件会默认命名并保存在当间
      $savekey = \Home\Qiniu\base64_urlSafeEncode("$bucket: $key");
      $fops = $fops.'|saveas/'.$savekey;
      $policy = array(
        'persistentOps' => $fops,
        'persistentPipeline' => $pipeline
      );
        $token = $auth->uploadToken($bucket, null, 3600, $policy);
       // echo $token;exit;
        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();
        // 上传文件到七牛
        $result= $uploadMgr->putFile($token, $key, $file['tmp_name']);       
       
    }
}

?>
