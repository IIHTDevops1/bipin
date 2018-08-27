<?php

namespace Home\Model;
use Think\Model;
use Org\Util\Stringnew;

/**
 *  用户模型
 * 
 */

class UserModel extends Model {

	protected $_validate = array(
		array('username','require','用户名不能为空'), //默认情况下用正则进行验证
		array('username', '6,20', '用户名为6-20个字符', self::EXISTS_VALIDATE, 'length'),
        array('username', '', '用户名已存在', self::EXISTS_VALIDATE, 'unique'), //用户名被占用
        
        array('loginpwd','loginpwd2','两次登录密码不一致',0,'confirm'), // 验证确认密码是否和密码一致
        array('cashpwd','cashpwd2','两次结算密码不一致',0,'confirm'), // 验证确认密码是否和密码一致
        array('remark', '0,1000', '备注内容不能超过1000个字符', self::VALUE_VALIDATE , 'length', self::MODEL_BOTH),
		
        array('mobile', '', '手机已经被注册', self::EXISTS_VALIDATE, 'unique'), 
        //array('rate', 'checkRate', '费率设置不能低于本身费率', self::EXISTS_VALIDATE, 'callback'), //检查新建的用户费率不低于自己
		/*array('login', 0, self::MODEL_INSERT),
        array('reg_ip', 'get_client_ip', self::MODEL_INSERT, 'function', 1),
        array('reg_time', NOW_TIME, self::MODEL_INSERT),
        array('last_login_ip', 0, self::MODEL_INSERT),
        array('last_login_time', 0, self::MODEL_INSERT),
        array('status', 1, self::MODEL_INSERT),*/
	);
	protected $_auto = array(
        
        array('addtime', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
        array('last_login_time', NOW_TIME, self::MODEL_BOTH),
        array('last_login_time', NOW_TIME, self::MODEL_BOTH),
        array('last_login_ip', 'get_client_ip', self::MODEL_BOTH, 'function', 1),
  
       
    );
    protected function haltpwd($pwd){ 
    	return uc_md5($pwd, UC_AUTH_KEY) ;
    }
    
    /**
	 * 检查新建的用户费率不低于自己
	 * @param  string $rate 费率
	 * @return boolean       ture - 正常，false - 不能注册
	 */
	protected function checkRate($rate){

		$rate = session('user_auth.rate');

		return true; 
	}

	protected function new_merchant_num(){ 
		return String::keyGen();
	}

	/**
	 * 用户结算时检查结算密码
	 * @param  integer  $uid 用户id
	 * @param  string  $password 用户密码
	 * @return integer           登录成功-用户ID，登录失败-错误编号
	 */
	public function checkSettlePwd($uid, $password){
		$map['id'] = $uid; 
		/* 获取用户数据 */
		$user = $this->where($map)->find();
		if(is_array($user) && $user['status']){
			/* 验证用户密码 */
			if(uc_md5($password, C('UC_AUTH_KEY')) === $user['cashpwd']){
				return $user['id']; //登录成功，返回用户ID
			} else {
				return -2; //密码错误
			}
		} else {
			return -1; //用户不存在或被禁用
		}

	}
	
	/**
	 * 用户登录认证
	 * @param  string  $username 用户名
	 * @param  string  $password 用户密码
	 * @param  integer $type     用户名类型 （1-用户名，2-邮箱，3-手机，4-UID）
	 * @return integer           登录成功-用户ID，登录失败-错误编号
	 */
	public function login($username, $password, $type = 1){

		$map = array();
		switch ($type) {
			case 1:
				$map['username'] = $username;
				break;
			case 2:
				$map['email'] = $username;
				break;
			case 3:
				$map['mobile'] = $username;
				break;
			case 4:
				$map['id'] = $username;
				break;
			default:
				return 0; //参数错误
		}



		/* 获取用户数据 */
		$user = $this->where($map)->find();


		if(is_array($user) /*&& $user['status']*/){
			/* 验证用户密码 */
			if(uc_md5($password, C('UC_AUTH_KEY')) === $user['loginpwd']){
				//$this->autoLogin($user['id']); //更新用户登录信息
				$this->autoLogin($user); //更新用户登录信息

				return $user['id']; //登录成功，返回用户ID
			} else {
				return -2; //密码错误
			}
		} else {
			return -1; //用户不存在或被禁用
		}
	}
	
	
	/**
     * 登录指定用户
     * @param  integer $uid 用户ID
     * @return boolean      ture-登录成功，false-登录失败
     */
    public function loginById($uid){
        /* 检测是否在当前应用注册 */
        $user = $this->find($uid);

		if(1 != $user['status']) {
            $this->error = '用户未激活或已禁用！'; 
            return false;
        }
      
        /* 登录用户 */
        $this->autoLogin($user);

        //记录行为
        action_log('user_login', 'member', $uid, $uid);

        return true;
    }

    /**
     * 注销当前用户
     * @return void
     */
    public function logout(){
        session('user_auth', null);
        session('user_auth_sign', null);
    }

    /**
     * 自动登录用户
     * @param  integer $user 用户信息数组
     */
    private function autoLogin($user){

    	
        /* 更新登录信息 */
        $data = array(
            'id'             => $user['id'],
            'logins'           => array('exp', 'logins+1'),
            'last_login_time' => NOW_TIME,
            'last_login_ip'   => get_client_ip(),
        );
        
        $this->save($data);

        $Loginlog = M('LoginLog');
        $log['uid'] = $user['id'];
        $log['addtime'] = NOW_TIME;
        $log['ip'] = get_client_ip();
        $log['truename'] = $user['truename'];
        $Loginlog->data($log)->add();

        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid'             => $user['id'],
            'username'        => $user['username'],
            'truename'        => $user['truename'],
            'rate'		  	  => $user['rate'],
            'level'		  	  => $user['level'],
            'merchantnum'	  => $user['merchantnum'],
            'last_login_time' => $user['last_login_time'],
        );

        session('user_auth', $auth);
        session('user_auth_sign', data_auth_sign($auth));

    }

	//获取树的根到子节点的路径
	public function getPath($id){
		$path = array();
		$nav = $this->where("id={$id}")->field('id,pid,title')->find();
		$path[] = $nav;
		if($nav['pid'] >1){
			$path = array_merge($this->getPath($nav['pid']),$path);
		}
		return $path;
	}
}