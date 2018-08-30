<?php
namespace Admin\Controller;

class StatisticsController extends AdminController{
    public function money_manage(){
       
        $this->display();
    }
    
    public function card_add(){
        if(IS_POST){
            
            $bank=D('banks');
            $bank->create();
            $bank->add();
            $this->success('添加成功');
            
        }       
    }
}