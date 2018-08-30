<?php
namespace Admin\Model;
use Think\Model;

class BanksModel extends Model{
    protected $_map=array(
        'true_name'=>'cardholder',
        'card_number'=>'account',
        'bank_name'=>'bank'        
    );
    protected $_auto=array(
        array('user_id','adduid',3,'callback'),
        
    );
    protected function adduid($data){
        $data=$_SESSION['user_auth']['uid'];
        return $data;
    }
}