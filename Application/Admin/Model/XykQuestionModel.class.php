<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Model;
use Think\Model\ViewModel;


class XykQuestionModel extends ViewModel {


    public $viewFields = array(
        'XykMember'=>array('truename','mobile','qq','level'),
        'XykQuestion'=>array('id','status','add_time','update_time','content','type', '_on'=>'XykQuestion.uid=XykMember.id'), );
}
