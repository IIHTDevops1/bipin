<?php
namespace Admin\Controller;

class MerchandiseController extends AdminController{
    public function mer_add(){
        $this->display();
    }
    
    public function mer_list(){
        $p = I('get.p', 1);
        $m=D('product');
        $map['status']=1;
        if(I('post.pro_id')){
            $map['id']=I('post.pro_id');
        }
        if(I('post.cate_id')){
            $map['type2']=I('post.cate_id');
        }
        
        
        $product=$m->where($map)->order("id desc")->page($p)->select();
        $count=$m->where($map)->count();
        $pages=getpages2($count);
        $this->assign('product',$product);
        $this->assign('pages',$pages);
        $this->display();
    }
  
    public function mer_edit(){
        $m=D('product');
        
       //规格
        $standard1=I('post.standard1');
        $standard2=I('post.standard2');
        $standard_nums=I('post.standard_nums');
        $standard_price=I('post.standard_price');
        $standard_pro_name=I('post.standard_pro_name');
        
        
        
        foreach($standard_nums as $k=>$v){
            $allnums+=$v;
        }

        //product数据
        $data=array();
        $data['pro_name']=I('post.pro_name');
        $data['price']=I('post.price');
        $data['express_fee']=I('post.express_fee');
        $data['weight']=I('post.weight');
        $data['type1']=I('post.type_name');
        $data['shop']=$_SESSION['user_auth']['uid'];
        $data['allnums']=$allnums;
        $newProId=$m->data($data)->add();
  
    
     
     //product_standard添加
     $standard_data=array();
     $standard=M('product_standard');
     
   foreach($standard1 as $k=>$v){
      $standard_data['pro_id']=$newProId;     
      $standard_data['standard1']=$standard1[$k];
      $standard_data['standard2']=$standard2[$k];
      $standard_data['price']=$standard_price[$k];
      $standard_data['nums']= $standard_nums[$k];
      $standard_data['pro_name']=$standard_pro_name[$k];
      
      $standard->data($standard_data)->add();
     
   }
        
       
        if(!empty($_FILES)){
            $upload=new \Think\Upload();
            
            // 上传文件配置
            $config=array(
                'maxSize'   =>  $maxSize,               // 上传文件最大为50M
                'rootPath'  => './static/saveimages/', // 设置附件上传根目录
                'savePath'  =>  'product/',         // 文件上传的保存路径（相对于根路径）
                'saveName'  =>  array('uniqid',''),     // 上传文件的保存规则，支持数组和字符串方式定义
                'autoSub'   =>  true,                   // 自动使用子目录保存上传文件 默认为true
                'exts'      =>    isset($ext_arr[$format])?$ext_arr[$format]:'',
            );
            // 实例化上传
            $upload=new \Think\Upload($config);
            // 调用上传方法
            $info=$upload->upload();
            
           if(!$info){
               $this->error($upload->getError());
           }else{
               
               
               $pro_img=M('product_img');
               foreach($info as $k=>$v){
                   
                       $imgData['pro_id']=$newProId;
                       $imgData['images']=$v['savepath'].$v['savename'];
                       if($v['key']=='uploadbtn1'){
                           $imgData['cover_map']=1;
                       }else{
                           $imgData['cover_map']=2;
                       }
                       
                       
                       $pro_img->data($imgData)->add();         
                       
               }
           }
        }
        
        
        
        $this->success('添加成功');
        
        
        
        
        
        

    }
    
    
    
    private function  pro_cate(){
      
    }
    
    
    
    
    //逻辑删除一条商品
    public function mer_delete(){
       
       if(I('get.id')){
           $id=I('get.id');
           $map['id']=$id;
           $data['status']=2;
           $pro=D('product');
           $pro->where($map)->save($data);
           $this->success('删除成功');
       }else{
           halt('404');
       }
      
    }
    
    
}