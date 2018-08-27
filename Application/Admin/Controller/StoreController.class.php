<?php
namespace Admin\Controller;

class StoreController extends  AdminController{
    //店铺申请
    Public function store_apply(){
        $parent_id['PARENT_ID']=7459;
        $region=M('region')->where($parent_id)->select();
        $this->assign('region',$region);
        if(IS_POST){
          $shop=M('shop');
          $shop->create();
          $this->upload_img(); 
        }
        $this->display();
    }
    
    //店铺管理
    Public function store_manage(){
        $this->display();
    }
    //店铺编辑
    Public function store_edit(){
        $this->display();
    }
    public function upload_img(){
        if(!empty($_FILES)){
            // 上传文件配置
            $config=array(
                'maxSize'   =>  $maxSize,               // 上传文件最大为50M              
                'savePath'  =>  '/static/saveimages/',         // 文件上传的保存路径（相对于根路径）
                'saveName'  =>  array('uniqid',''),     // 上传文件的保存规则，支持数组和字符串方式定义
                'autoSub'   =>  true,                   // 自动使用子目录保存上传文件 默认为true
                'exts'      =>    isset($ext_arr[$format])?$ext_arr[$format]:'',
            );
            // 实例化上传
            $upload=new \Think\Upload($config);
            // 调用上传方法
            $info=$upload->upload();
            $data=array();
            if(!$info){
                // 返回错误信息
                $error=$upload->getError();
                $data['error_info']=$error;
                echo json_encode($data);
            }else{
                // 返回成功信息
                foreach($info as $file){
                    $data['name']=trim($file['savepath'].$file['savename'],'.');
                    echo json_encode($data);
                }
            }
        }
    }
    
    public function add_region(){
        if(IS_POST){
            // dump($_POST);
            $parent_id['PARENT_ID'] = I('post.pro_id','addslashes');
            $region = M('region')->where($parent_id)->select();
            $opt = '<option>--请选择市区--</option>';
            foreach($region as $key=>$val){
                $opt .= "<option value='{$val['id']}'>{$val['region_name']}</option>";
            }
            echo json_encode($opt);
        }
            
                
    }
}