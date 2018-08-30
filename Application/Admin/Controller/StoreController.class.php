<?php
namespace Admin\Controller;

class StoreController extends  AdminController{
   
 //店铺分类获取
 
   private function store_cate(){
       $map['type']=1;
       $cate=M('Types')->where($map)->select();
       $this->assign('cate',$cate);
   }
    

   
   
   //省数据获取;所有省的parent_id为0
   private function rigion(){
       $parent_id['parent_id']=0;
       $region=M('province_city')->where($parent_id)->select();
       $this->assign('region',$region);
   }
   
   
   
   
   
   //店铺申请页面
   Public function store_apply(){
       $this->store_cate();
       $this->rigion();
       $this->display();
   }
   
   
   
   


//ajax省市区三级联动   
  
  public function add_region(){
      if(IS_POST){
          // dump($_POST);
          
          
          $arr=explode('|', I('post.pro_id'));
          $map['parent_id']=$arr[0];
          $region = M('province_city')->where($map)->select();
          $opt = '<option>--请选择市区--</option>';
          foreach($region as $key=>$val){
              $opt .= "<option value='{$val['id']}|{$val['location_code']}|{$val['name']}'>{$val['name']}</option>";
          }
          echo json_encode($opt);
      }
      
  }
  
  
 
  
 //店铺申请 提交数据处理
  public function apply_edit(){
      
      if(IS_POST){
          $shop=M('shop');
          $data=array();
          $data['shop_name']=$_POST['store_name'];
          $data['user_id']=$_SESSION['user_auth']['uid'];
          $data['contacts']=$_POST['contact_name'];
          $data['contacts_mobile']=$_POST['contact_phone'];
          $data['type']=$_POST['type_name'];
          $data['addr']=$_POST['address_detail'];
          $data['taobao_addr']=$_POST['taobao_address'];
          
          $pro=explode('|', $_POST['pro']);
          $city=explode('|', $_POST['city']);
          $area=explode('|', $_POST['area']);
          
          $data['province']=$pro[1];
          $data['city']=$city[1];
          $data['area']=$area[1];
          $data['province_name']=$pro[2];
          $data['city_name']=$city[2];
          $data['area_name']=$area[2];
          $data['addtime']=time();
          
          $imgData=$this->upload_img();
          
          $insert_array=array_merge($data,$imgData);
          
          
          $data=$shop->create($insert_array);
          $shop->add();
          if($shop->add()){
              $this->redirect('Store/sumit_result');
          }
          
          
          
          
          
      }
  }
  //店铺图片上传
  public function upload_img(){
      if(!empty($_FILES)){
          // 上传文件配置
          $config=array(
              'maxSize'   =>  $maxSize,               // 上传文件最大为50M
              'rootPath'  => './static/saveimages/', // 设置附件上传根目录
              'savePath'  =>  'store/',         // 文件上传的保存路径（相对于根路径）
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
              $this->error($upload->getError());
              
              
          }else{
              $data=array();
              
              $data['face_photo']=$info['uploadbtn1']['savepath'].$info['uploadbtn1']['savename'];
              $data['store_photo']=$info['uploadbtn2']['savepath'].$info['uploadbtn2']['savename'];
              $data['logo']=$info['uploadbtn3']['savepath'].$info['uploadbtn3']['savename'];
              $data['card_photo']=$info['uploadbtn4']['savepath'].$info['uploadbtn4']['savename'];
              $data['business_photo']=$info['uploadbtn5']['savepath'].$info['uploadbtn5']['savename'];
              $data['licence_photo']=$info['uploadbtn6']['savepath'].$info['uploadbtn6']['savename'];
              
              return  $data;
              
          }
      }
  }
    
  
  
  
  
  //店铺管理
  public function shop_info(){
      $shop=M('shop');
      $map['user_id']=$_SESSION['user_auth']['uid'];
      $map['status']=2;
      $store_info=$shop->where($map)->find();
      $this->assign('store_info',$store_info);
  }

  
  //店铺信息页面 
 Public function store_manage(){
     $this->store_cate();
       $this->shop_info();
        $this->display();
      
   }
    
  //店铺编辑页面。获取市数据以及区数据
   private function shop_info1(){
       $this->rigion();
       $shop=M('shop');
       $map['user_id']=$_SESSION['user_auth']['uid'];
       $map['status']=2;
       $store_info=$shop->where($map)->find();
       $this->assign('store_info',$store_info);
       $proCode=$store_info['province'];
       $cityCode=$store_info['city'];
       $areaCode=$store_info['area'];
       $pro=M('province_city')->where('location_code='.$proCode)->find();
       $city_map['parent_id']=$pro['id'];
       $city_info=M('province_city')->where($city_map)->select();
       $city=M('province_city')->where('location_code='.$cityCode)->find();
       $area_map['parent_id']=$city['id'];
       $area_info=M('province_city')->where($area_map)->select();
       $this->assign('city_info',$city_info);
       $this->assign('area_info',$area_info);
       
       
   }
   
 //店铺编辑页面  
   public function store_edit(){
       $this->store_cate();
       $this->rigion();
       $this->shop_info1();
       $this->display();
       
   }
  
   
}