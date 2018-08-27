<?php

namespace Common\Model;
use Think\Model;

/**
 *  会员组模型
 *
 */

class AuthGroupModel extends Model {

    protected $_validate = array(
        //array('url','require','url必须填写'), //默认情况下用正则进行验证
    );

    /**
     * 会员组下拉列表数据
     * @return array
     */
    public function getSelectList(){

        $map    = array('status' => 1);
        $data   = $this->where($map)->field('id,title')->select();
        return $data;
    }
}