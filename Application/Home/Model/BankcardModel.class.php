<?php

namespace Home\Model;
use Think\Model;
use Org\Util\Stringnew;

/**
 *  银行卡模型
 * 
 */

class BankcardModel extends Model {

	protected $_validate = array(
		array('province','require','开户所在省份不能为空'), //默认情况下用正则进行验证
		array('city','require','开户城市不能为空'), //默认情况下用正则进行验证
		array('bankfullname','require','开户行不能为空'), //默认情况下用正则进行验证
		array('truename','require','户名不能为空'), //默认情况下用正则进行验证
		array('bankaccout','require','请输入银行账号'), //默认情况下用正则进行验证
		array('bankaccout2','require','请重复输入银行账号'), //默认情况下用正则进行验证


		array('truename', '2,20', '用户名为2-20个字符', self::EXISTS_VALIDATE, 'length'),
        array('bankaccout', '', '银行账号已经存在', self::EXISTS_VALIDATE, 'unique'), //用户名被占用
        
        array('bankaccout','bankaccout2','两次输入的银行账号不一样',0,'confirm'), // 验证确认密码是否和密码一致
       
	);
	protected $_auto = array(
        
        array('addtime', NOW_TIME, self::MODEL_INSERT),
              
    );
     
}