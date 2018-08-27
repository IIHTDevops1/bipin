<?php
namespace Home\Controller;
use Think\Controller;
class LiveingController extends Controller {

//直播

//批量删除我的作品
public function del_work(){
    $request = getClientRequest();
    $data['user_id'] = $request['user_id'];
    $data['id'] = array('in',$request['id']);
    $workss=M("workss");
    $arr=$workss->where($data)->delete();
    if($arr){
        $ret['status'] = 200;
        $ret['msg'] = '删除成功';
    }else{
        $ret['status'] = 300;
        $ret['msg'] = '删除失败';

    }
    $this->ajaxReturn($ret);
}
//评论
public function commentss(){
    $request = getClientRequest();
    $data['user_id'] = $request['user_id'];
    $data['content'] = $request['content'];
    $data['worker_id'] = $request['worker_id'];
    $data['addtime'] = time();
    $comment=M("comment");
    $fff=$comment->add($data);
    if($fff){
        $ret['status'] = 200;
        $ret['msg'] = '评论成功';
    }else{
        $ret['status'] = 300;
        $ret['msg'] = '提交失败';
    }
    $this->ajaxReturn($ret);
}
//投诉
public function complaints(){
    $request = getClientRequest();
    $data['user_id'] = $request['user_id'];
    $data['content'] = get_notice($request['content_id']);
    $data['worker_id'] = $request['worker_id'];
    $data['addtime'] = time();
    $data['types'] = 2;
    $comment=M("comment");
    $fff=$comment->add($data);
    if($fff){
        $ret['status'] = 200;
        $ret['msg'] = '投诉成功';
    }else{
        $ret['status'] = 300;
        $ret['msg'] = '投诉失败';
    }
    $this->ajaxReturn($ret);
}
//留言
public function givecomment(){
    $request = getClientRequest();
    $data['user_id'] = $request['user_id'];
    $data['content'] = $request['content'];
    $data['addtime'] = time();
    $comment=M("message");
    $fff=$comment->add($data);
    if($fff){
        $ret['status'] = 200;
        $ret['msg'] = '反馈已提交';
    }else{
        $ret['status'] = 300;
        $ret['msg'] = '提交失败';
    }
    $this->ajaxReturn($ret);
}
//评论列表
public function comment_list(){
    $request = getClientRequest();
    $data['worker_id'] = $request['worker_id'];
    $data['types'] = 1;
    $p=$request['p'];
    if($p=="" || $p==1 || $p==0){
        $pp=0;
    }else{
        $p=$p-1;
        $p=$p*10;
        $pp=$p+1;
    }
    $comment=M("comment");
    $fff=$comment->where($data)->order("addtime desc")->limit($pp,10)->select();
    foreach ($fff as &$b){
        $b['thumb']=get_thumb($b['user_id']);
        $b['username']=get_username($b['user_id']);
        $b['level']=get_levels($b['user_id']);
        $b['level_name']=get_level($b['level']);
        $b['addtime']=dateformat($b['addtime'],10);
    }

    if($fff){
        $ret['status'] = 200;
        $ret['msg'] = '评论列表';
        $ret['data']=$fff;
    }else{
        $ret['status'] = 300;
        $ret['msg'] = '暂无更多';
    }
    $this->ajaxReturn($ret);
}

//点赞作品，点赞视频
public function is_likes(){
    $request = getClientRequest();
    $data['user_id'] = $request['user_id'];
    $data['likeid'] = $request['likeid'];
    $data['tables'] = "workss";
    $data['types'] = 3;//点赞作品

    $likelog=M("likelog");
    $if_have=$likelog->where($data)->getField("id");
    if($if_have){
        $fff=$likelog->where(array('id'=>$if_have))->delete();
        if($fff){
            $ret['status'] = 200;
            $ret['msg'] = '已取消点赞';
        }else{
            $ret['status'] = 300;
            $ret['msg'] = '取消失败';
        }
    }else{
        $data['addtime'] = time();//点赞作品
        $fff=$likelog->add($data);
        if($fff){
            $ret['status'] = 200;
            $ret['msg'] = '已点赞';
        }else{
            $ret['status'] = 300;
            $ret['msg'] = '点赞失败';
        }
    }
    $this->ajaxReturn($ret);
}
//关注某人
public function is_guanzhu(){
    $request = getClientRequest();
    $data['user_id'] = $request['user_id'];
    $data['likeid'] = $request['likeuserid'];
    $data['tables'] = "user";
    $data['types'] = 2;//点赞作品

    $likelog=M("likelog");
    $if_have=$likelog->where($data)->getField("id");
    if($if_have){
        $fff=$likelog->where(array('id'=>$if_have))->delete();
        if($fff){
            $ret['status'] = 200;
            $ret['msg'] = '已取消关注';
        }else{
            $ret['status'] = 300;
            $ret['msg'] = '取消失败';
        }
    }else{
        $data['addtime'] = time();//点赞作品
        $fff=$likelog->add($data);
        if($fff){
            $ret['status'] = 200;
            $ret['msg'] = '已关注';
        }else{
            $ret['status'] = 300;
            $ret['msg'] = '关注失败';
        }
    }
    $this->ajaxReturn($ret);
}//我的
public function my_guanzhu(){
    $request = getClientRequest();
    $data['user_id'] = $request['user_id'];
    $type = $request['type'];
    $p=$request['p'];
    if($p=="" || $p==1 || $p==0){
        $pp=0;
    }else{
        $p=$p-1;
        $p=$p*15;
        $pp=$p+1;
    }
    $data['types'] = 2;//点赞作品
    $data['tables'] = "user";//点赞作品
    $likelog=M("likelog");

    if($type==1){
        $data1['types'] = 2;//点赞作品
        $data1['tables'] = "user";//点赞作品
        $data1['likeid'] = $request['user_id'];
        $list=$likelog->where($data1)->limit($pp,15)->field("user_id,likeid")->select();
        foreach ($list as &$v){
            $v['username']=get_username($v['user_id']);
            $v['thumb']=get_thumb($v['user_id']);
            $v['jiguang']=get_jiguang($v['user_id']);
            $v['likeuserid']=$v['user_id'];

            $map['likeid']= $v['user_id'];
            $map['tables']="user";
            $map['user_id']=$request['user_id'];
            $map['types']=2;//关注的人
            if($likelog->where($map)->getField('id')){
                $v['is_guanzhu']=1;//已关注发布人
            }else{
                $v['is_guanzhu']=2;//未关注发布人
            }

        }
        if($list){
            $ret['status'] = 200;
            $ret['msg'] = '我的关注';
            $ret['data'] = $list;

        }else{
            $ret['status'] = 300;
            $ret['msg'] = '暂无更多数据';

        }
    }else{
        $list=$likelog->where($data)->limit($pp,15)->field("user_id,likeid")->select();
        foreach ($list as &$v){
            $v['username']=get_username($v['likeid']);
            $v['jiguang']=get_jiguang($v['likeid']);
            $v['thumb']=get_thumb($v['likeid']);
            $v['likeuserid']=$v['likeid'];
            $v['is_guanzhu']=1;//已关注发布人
        }
        if($list){
            $ret['status'] = 200;
            $ret['msg'] = '我的关注';
            $ret['data'] = $list;

        }else{
            $ret['status'] = 300;
            $ret['msg'] = '暂时没有关注';

        }
    }



    $this->ajaxReturn($ret);
}


//我的戏币
public function my_xibi(){
    $request = getClientRequest();
    $user_id = $request['user_id'];
    $user=M("user");
    $xibi=$user->where(array('user_id'=>$user_id))->getField("xibi");

    $News = M('vips');
    $Notice =M('Notice');
    $list = $News->where("types=2")->field("id,nums,gold,pingid")->order("toop asc")->select();
    foreach ($list as &$v){
        $v['nums']=$v['nums']."个戏币";
    }
    $arrw=$Notice->where(array('id'=>14))->field("news_title,content")->find();
    if($list){
        $ret['status'] = 200;
        $ret['msg'] = '戏币充值选项列表';
        $ret['xibi'] = $xibi."个戏币";
        $ret['data'] = $list;
        $ret['wenan'] = $arrw;
    }else{
        $ret['status'] = 300;
        $ret['msg'] = '暂时没有戏币充值活动';
        $ret['xibi'] = "0个戏币";


    }
    $this->ajaxReturn($ret);
}


//礼物列表
    public function gifts(){
        $News = M('gifts');
        $list = $News->field("id,thumb,gold")->order("toop desc")->select();
        foreach ($list as &$v){
            $v['gold']=$v['gold']."戏币";
        }
        if($list){
            $ret['status'] = 200;
            $ret['msg'] = '礼物列表';
            $ret['data'] = $list;

        }else{
            $ret['status'] = 300;
            $ret['msg'] = '暂时没有礼物';

        }
        $this->ajaxReturn($ret);
    }

    //小剧种
    public function small_play(){
        $type=M("types");
        $arr=$type->where(array('type'=>2))->field("id,type_name")->select();
        $where['id']=3;
        $where['type']=4;
        $where['_logic'] = 'OR';
        $xibi=$type->where($where)->order("toop desc")->field("id,type_name")->select();
if($xibi){
    foreach ($xibi as &$v){
        if($v['id']!=3){
            $v['type_name']=$v['type_name']."戏币";
        }
    }

    $ret['xibi'] = $xibi;
}
        if($arr){
            $ret['status'] = 200;
            $ret['msg'] = '小剧种列表+下载需要戏币';
            $ret['data'] = $arr;

        }else{
            $ret['status'] = 300;
            $ret['msg'] = '暂无列表';
//            $ret['data'] = array();
        }
        $this->ajaxReturn($ret);
    }

    //上传伴奏
    public function upbanzou(){
        $request = getClientRequest();
        $data['user_id'] = $request['user_id'];
        $data['news_title'] = $request['news_title'];//伴奏名称
        $data['authors'] = $request['authors'];//作者信息

        if($request['types']==3){
            $data['types'] = $request['types'];//3免费 5vip收费
            $data['operas'] = 0;//需要话费的戏币
        }else{
            $data['types'] = 5;//3免费 5vip收费
            $data['operas'] = get_types($request['types']);//需要话费的戏币
        }
        $data['describes'] = $request['describes'];//简介
        $data['content'] = $request['describes'];//简介
        $data['workss'] = $request['workss'];//简介
        $data['type2'] = $request['type'];//简介
        $data['type1'] = getpid($request['type']);//一级大类

        $data['thumb'] = $request['thumb'];//
        $data['times'] = time();
        $data['yonghu'] = 1;//用户
        $data['fenlei'] = 1;//伴奏
        $workss=M("workss");
        $ar=$workss->add($data);
        if(!empty($ar)){
            $ret['status'] = 200;
            $ret['msg'] = '上传成功';
        }else{
            $ret['status'] = 300;
            $ret['msg'] = '上传失败';
        }
        $this->ajaxReturn($ret);

    }
    //上传曲谱
    public function upqupu(){
        $request = getClientRequest();
        $data['user_id'] = $request['user_id'];
        $data['news_title'] = $request['news_title'];//伴奏名称
        $data['authors'] = $request['authors'];//作者信息
//        $data['types'] = $request['types'];//3免费 5vip收费
        $data['describes'] = $request['describes'];//简介
        $data['content'] = $request['describes'];//简介
        $data['workss'] = $request['workss'];//曲谱文件用@拼接
        $data['type2'] = $request['type'];//小剧种
        $data['type1'] = getpid($request['type']);//一级大类
        $data['operas'] = 0;//需要话费的戏币
        $data['thumb'] = $request['thumb'];//
        $data['times'] = time();//需要话费的戏币
        $data['yonghu'] = 1;//用户
        $data['fenlei'] = 2;//曲谱
        $workss=M("workss");
        $ar=$workss->add($data);
        if(!empty($ar)){
            $ret['status'] = 200;
            $ret['msg'] = '上传成功';
        }else{
            $ret['status'] = 300;
            $ret['msg'] = '上传失败';
        }
        $this->ajaxReturn($ret);

    } //上传音频
    public function upyinpin(){
        $request = getClientRequest();
        $data['user_id'] = $request['user_id'];
        $data['news_title'] = $request['news_title'];//伴奏名称
//        $data['authors'] = $request['authors'];//作者信息
        $data['describes'] = $request['describes'];//简介
        $data['content'] = $request['describes'];//简介
        $data['workss'] = $request['workss'];//视频
        $data['thumb'] = $request['thumb'];//视频
        $data['type2'] = $request['type'];//小剧种
        $data['type1'] = getpid($request['type']);//一级大类
        $data['operas'] = 0;//需要话费的戏币
        $data['times'] = time();//
        $data['yonghu'] = 1;//用户
        $data['fenlei'] = 3;//视频
        $workss=M("workss");
        $ar=$workss->add($data);
        if(!empty($ar)){
            $ret['status'] = 200;
            $ret['msg'] = '上传成功';
        }else{
            $ret['status'] = 300;
            $ret['msg'] = '上传失败';
        }
        $this->ajaxReturn($ret);
    } //上传视频
    public function upvideo(){
        $request = getClientRequest();
        $data['user_id'] = $request['user_id'];
        $data['news_title'] = $request['news_title'];//伴奏名称
        $data['authors'] = $request['authors'];//作者信息
        $data['describes'] = $request['describes'];//简介
        $data['content'] = $request['describes'];//简介
        $data['workss'] = $request['workss'];//视频
        $data['thumb'] = $request['workss']."?vframe/jpg/offset/5";//视频
        $data['type2'] = $request['type'];//小剧种
        $data['type1'] = getpid($request['type']);//一级大类
        $data['operas'] = 0;//需要话费的戏币
        $data['times'] = time();//
        $data['yonghu'] = 1;//用户
        $data['fenlei'] = 4;//视频
        $workss=M("workss");
        $ar=$workss->add($data);
        if(!empty($ar)){
            $ret['status'] = 200;
            $ret['msg'] = '上传成功';
        }else{
            $ret['status'] = 300;
            $ret['msg'] = '上传失败';
        }
        $this->ajaxReturn($ret);
    }
    //各种列表
    public function banzou_list(){
        $request = getClientRequest();
        $user_id = $request['user_id'];
        if(!empty($user_id)){
            $data['user_id'] =$user_id;
        }
        $p=$request['p'];
        if($p=="" || $p==1 || $p==0){
            $pp=0;
        }else{
            $p=$p-1;
            $p=$p*15;
            $pp=$p+1;
        }

        if($request['news_title']){
            $data['news_title'] =array('like',"%".$request['news_title']."%");
        }else{
            $types = $request['types'];
            $fenlei = $request['fenlei'];

            //用户传1是个人，不传是所有
            $yonghu = $request['yonghu'];
            if($yonghu==1){
                $data['yonghu'] =$yonghu;
            }
            //用户作品
            if(!empty($types)){
                $data['types'] =$types;
            }

            if(!empty($fenlei)){//1伴奏2曲谱4视频3音频
                $data['fenlei'] =$fenlei;
            }
        }


        $workss=M("workss");
        $ar=$workss->where($data)->order("toop desc")->order("times desc")->limit($pp,15)->field("id,news_title,thumb,describes,plays,fenlei,yonghu,user_id,workss")->select();
        $user=M("user");
        foreach ($ar as &$v){
            if($v['fenlei']==4 || $v['fenlei']==3){
                if($v['yonghu']==1){
                    $userinfo=$user->where(array('user_id'=>$ar['user_id']))->field("username,thumb")->find();
                    $v['username']=$userinfo['username'];
                    $v['userthumb']=$userinfo['thumb'];
                }else{
                    $v['username']="戏宝后台";
                    $v['userthumb']="http://pbp5zunaq.bkt.clouddn.com/80x80.png";
                }
            }

        }
        if(!empty($ar)){
            $ret['status'] = 200;
            $ret['msg'] = '数据列表';
            $ret['data']=$ar;
        }else{
            $ret['status'] = 300;
            $ret['msg'] = '暂无更多';
        }
        $this->ajaxReturn($ret);

    }
    public function worker_xq(){
        $request = getClientRequest();
        $user_id = $request['user_id'];
        $data['id'] = $request['worker_id'];
        $workss=M("workss");
        $likelog=M("likelog");
        $ar=$workss->where($data)->order("toop desc")->order("times desc")->field("id,type1,type2,news_title,thumb,describes,plays,fenlei,types,authors,content,operas,times,workss,yonghu,user_id")->find();
        $workss->where($data)->setInc("plays");
if(!empty($ar)){
    if($ar['fenlei']==1){
    //伴奏

        $map['likeid']=$data['id'];
        $map['tables']="workss";
        $map['user_id']=$user_id;
        $map['types']=3;//点赞作品
        $data['news_title']=$ar['news_title'];
        $data['thumb']=$ar['thumb'];//圆头像
        $data['workss']=$ar['workss'];//圆头像
        $data['authors']=$ar['authors'];//圆头像
        $data['content']=strip_tags($ar['content']);//歌词

//
        $data['content'] = htmlspecialchars_decode($data['content'], ENT_NOQUOTES);
        $data['content'] = str_replace('&lt;', '<', $data['content']);
        $data['content'] = str_replace('&gt;', '>', $data['content']);
        $data['content'] = str_replace('&n;', ' ', $data['content']);
        $data['content'] = str_replace('amp;', '', $data['content']);
        $data['content'] = str_replace('&quot;', '', $data['content']);



        if($data['content']==""){
            $data['content']="暂无歌词";
        }
        $data['times']=dateformat($ar['times'],3);//时间
$data['fenxing']="http://".$_SERVER['HTTP_HOST']."/index.php/Home/Index/netease/xqid/".$data['id'];
        if($likelog->where($map)->getField('id')){
            $data['is_likes']=1;//已经点赞
        }else{
            $data['is_likes']=2;
        }
        if($ar['operas']>=0.01){
            $data['is_down']=1;//可以下载
        }else{
            $data['is_down']=2;
        }
        $ret['types'] = 1;//音频页面

    }
    elseif ($ar['fenlei']==3){
    //音频
        $map['likeid']=$data['id'];
        $map['tables']="workss";
        $map['user_id']=$user_id;
        $map['types']=3;//点赞作品
        $data['news_title']=$ar['news_title'];
        $data['thumb']=$ar['thumb'];//圆头像
        $data['workss']=$ar['workss'];//圆头像
        $data['authors']=$ar['authors'];//圆头像
        $data['content']="暂无歌词";//歌词
        $data['times']=dateformat($ar['times'],3);//时间
        if($likelog->where($map)->getField('id')){
            $data['is_likes']=1;//已经点赞
        }else{
            $data['is_likes']=2;
        }
        $data['fenxing']="http://".$_SERVER['HTTP_HOST']."/index.php/Home/Index/netease/xqid/".$data['id'];
        $data['is_down']=2;//不可以展示下载按钮
        $ret['types'] =3;//音频分类

    }
    elseif ($ar['fenlei']==2){
    //曲谱
        $data['workss']=explode("@",$ar['workss']);//
        foreach( $data['workss'] as $k=>$v){
            if( !$v )
                unset( $data['workss'][$k] );
        }
        $ret['types'] = 2;//曲谱


    }
    else{
    //视频
        $data['fenxing']="http://".$_SERVER['HTTP_HOST']."/index.php/Home/Index/singer_lj/xqid/".$data['id'];
        $data['news_title']=get_types($ar['type1'])."、".get_types($ar['type2'])."、".$ar['news_title'];
        $data['thumb']=$ar['thumb'];//封面
        $data['workss']=$ar['workss'];//圆头像
        $data['describes']=$ar['describes'];//圆头像

        if($ar['yonghu']==1){
            //说明是用户上传的
            $data['yonghu']=1;//用户
            $user=M("user");
            $userinfo=$user->where(array('user_id'=>$ar['user_id']))->field("username,sex,thumb,user_id,jiguang")->find();
            if(!empty($userinfo)){
                $data['username']=$userinfo['username'];
                $data['usersex']=$userinfo['sex'];
                $data['userthumb']=$userinfo['thumb'];
                $data['user_id']=$userinfo['user_id'];
                $data['jiguang']=$userinfo['jiguang'];

                $map['likeid']= $data['user_id'];
                $map['tables']="user";
                $map['user_id']=$user_id;
                $map['types']=2;//关注的人
                if($likelog->where($map)->getField('id')){
                    $data['is_guanzhu']=1;//已关注发布人
                }else{
                    $data['is_guanzhu']=2;//未关注发布人
                }
            }
        }else{
        //说明是后台上传的
            $data['yonghu']=2;//后台上传的
            $data['jiguang']='1111111';//后台官方极光号
        }
        $map['likeid']= $data['id'];
        $map['tables']="workss"; 
        $map['user_id']=$user_id;
        $map['types']=3;//点赞作品
        if($likelog->where($map)->getField('id')){
            $data['is_likes']=1;//已点赞该作品
        }else{
            $data['is_likes']=2;//未点赞该作品
        }
        $give_gifts=M("give_gifts");
$ddd=$give_gifts->where(array('worker_id'=>$data['id']))->field("user_id,nums,gifts_title")->order("addtime desc")->limit(6)->select();
if(!empty($ddd)){
    foreach ($ddd as &$v){
        $v['gifts_title']="打赏了".$v['nums']."个".$v['gifts_title'];
        $v['username']=get_username($v['user_id']);
        $v['thumb']=get_thumb($v['user_id']);
        $v['jiguang']=get_jiguang($v['user_id']);
        $v['is_guanzhu']=get_guanzhu($user_id,$v['user_id']);
    }
    $ret['dashang']=$ddd;
}else{
    $ret['dashang']=array();
}





    }


    $ret['status'] = 200;
    $ret['msg'] = '详细数据';
    $ret['data']=$data;
}else{
    $ret['status'] = 300;
    $ret['msg'] = '暂无数据';
}
$this->ajaxReturn($ret);



    }


    //我的收益
    public function my_shouyi(){
        $request = getClientRequest();
        $data['benefit_id'] = $request['user_id'];
        $Notice =M('Notice');
        $user=M("user");
        $ishave=$user->where(array('user_id'=>$data['benefit_id']))->field("alipay,alipay_name,wechat,wechat_name")->find();

        $give_gifts=M("give_gifts");
        $mmm=$user->where(array('user_id'=>$request['user_id']))->field("xibi,dongjiexibi")->find();//可提现戏币
        $kkk=$mmm['xibi']-$mmm['dongjiexibi'];

        $iii=$give_gifts->where($data)->sum("allgold");//历史总收益戏币
        if(empty($iii)){
            $iii="0";
        }
        $data['addtime']=array('gt',strtotime(date('Y-m-d')));
        $jjj=$give_gifts->where($data)->sum("allgold");
        if(empty($jjj)){
            $jjj="0";
        }
        $ret['status'] = 200;
        $ret['msg'] = '我的收益';
        $arr=$Notice->where(array('id'=>15))->field("news_title,content")->find();
        $arr1=$Notice->where(array('id'=>16))->field("news_title,content")->find();
        if($ishave['alipay']==1){
            $dd=array();
        }else{
            $dd['id']=1;
            $dd['alipay']=$ishave['alipay'];
            $ret['alipay']=$dd;
        }
        if($ishave['wechat']==1){
            $ddw=array();
        }else{
            $ddw['id']=2;
            $ddw['wechat']=$ishave['wechat'];
            $ret['wechat']=$ddw;
        }
        if(!empty($arr)){
            $ret['shouyi']=$arr;
        }if(!empty($arr1)){
            $ret['tixian']=$arr1;
        }
        $ret['meygold']="$kkk";
        $ret['allgold']=$iii;
        $ret['taygold']=$jjj;
        $this->ajaxReturn($ret);
    }


   //打赏
    public function give_gifts(){

        $request = getClientRequest();
        $user_id = $request['user_id'];//谁大赏的

        $user=M("user");
        $userinfo=$user->where(array('user_id'=>$user_id))->field("user_id,xibi")->find();
        if(!empty($userinfo)){
            $data['worker_id']=$request['worker_id'];//大赏的作品id
            $workss=M("workss");
$workssinfo=$workss->where(array('id'=>$data['worker_id']))->field("yonghu,user_id")->find();

if(!empty($workssinfo)){
    $data['gifts_id']=$request['gifts_id'];//大赏的礼物id
    $data['nums']=$request['nums'];//大赏的数量

    $gifts=M("gifts");
    $giftinfo=$gifts->where(array('id'=>$data['gifts_id']))->field("gifts_title,gold")->find();
    if(!empty($giftinfo)){
        $allxibi=$giftinfo['gold']*$data['nums'];
        if($allxibi>$userinfo['xibi']){
            //戏币余额不足
            $ret['status'] = 400;
            $ret['msg'] = '用户戏币余额不足';
        }else{
            $data['gifts_title']=$giftinfo['gifts_title'];//大赏的礼物名称
            $data['gold']=$giftinfo['gold'];//当时大赏的单价戏币数
            $data['allgold']=$allxibi;//当时大赏的总戏币
            $data['yonghu']=$workssinfo['yonghu'];//用户作品还是个人作品
            $data['benefit_id']=$workssinfo['user_id'];//受益的人
            $data['addtime']=time();//受益的人
            $data['user_id']=$user_id;//出血的人
//            $data['thumb']=$userinfo['thumb'];//出血的人头像
//            $data['jiguang']=$userinfo['jiguang'];//出血的人极光账户
            $give_gifts=M("give_gifts");
            $iii=$give_gifts->add($data);
            if($iii){
                $user->where(array('user_id'=>$user_id))->setInc("xibi",-$allxibi);
                $user->where(array('user_id'=>$data['benefit_id']))->setInc("xibi",$allxibi);
                $ret['status'] = 200;
                $ret['msg'] = '打赏成功';
            }else{
                $ret['status'] = 300;
                $ret['msg'] = '打赏失败';
            }
        }
    }else{
        $ret['status'] = 600;
        $ret['msg'] = '选取礼物失败';
    }
}else{
    $ret['status'] = 700;
    $ret['msg'] = '打赏作品不存在';
}
            }else{
                $ret['status'] = 300;
                $ret['msg'] = '用户不存在';
            }
        $this->ajaxReturn($ret);

    }

//投诉示例列表
public function tousu_list(){
    $News = M('notice');

    $map['type'] = 1;
    $ar = $News->where($map)->order("news_title desc")->field("content,id")->select();

    if(!empty($ar)){
        $ret['status'] = 200;
        $ret['msg'] = '投诉示例列表';
        $ret['data']=$ar;
    }else{
        $ret['status'] = 300;
        $ret['msg'] = '暂无更多';
    }
    $this->ajaxReturn($ret);
}


//投诉某作品



//各种轮播图
public function bunners(){
    $request = getClientRequest();
    $data['cad_id'] = $request['cad_id'];
    $ads=M("ads");
    $ar=$ads->where($data)->field("id,thumb,url,web_title")->select();

    if(!empty($ar)){
        $ret['status'] = 200;
        $ret['msg'] = 'bunner图';
        $ret['data']=$ar;
    }else{
        $ret['status'] = 300;
        $ret['msg'] = '暂无bunner图';
        $ret['data']=array();
    }
    $this->ajaxReturn($ret);
}

public function index(){
    //热门伴奏6个
$workss=M("workss");
$banzou=$workss->where(array('types'=>6,'fenlei'=>1))->order("plays desc")->limit(6)->field("id,news_title,thumb,describes,plays,workss")->select();
//热门曲谱6个
    $qupu=$workss->where(array('fenlei'=>2))->order("plays desc")->field("id,news_title,thumb,describes,plays")->limit(6)->select();
    $data['cad_id'] = 5;
    $ads=M("ads");
    $ar=$ads->where($data)->field("id,thumb,url,web_title")->limit(3)->select();
    $ret['status'] = 200;
    $ret['msg'] = '首页数据';

    if(!empty($ar)){
        $ret['san']=$ar;
    }else{
        $ret['san']=array();
    } if(!empty($banzou)){
        $ret['banzou']=$banzou;
    }else{
        $ret['banzou']=array();
    }
    if(!empty($qupu)){
        $ret['qupu']=$qupu;
    }else{
        $ret['qupu']=array();
    }
    $this->ajaxReturn($ret);


}





}