-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 22, 2018 at 11:04 AM
-- Server version: 5.7.21
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


-- --------------------------------------------------------

--
-- Table structure for table `bp_addr`
--

CREATE TABLE `bp_addr` (
  `id` int(11) NOT NULL,
  `user_id` char(30) NOT NULL COMMENT '用户id、',
  `province` char(30) DEFAULT NULL COMMENT '省的code值',
  `city` char(30) DEFAULT NULL COMMENT '市的code值',
  `area` char(30) DEFAULT NULL COMMENT '区的code值',
  `province_name` char(100) DEFAULT NULL COMMENT '省的名字',
  `city_name` char(100) DEFAULT NULL COMMENT '市的名字',
  `area_name` char(100) DEFAULT NULL COMMENT '区的名字',
  `addr` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `defaul` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1默认推荐地址2普通地址',
  `consignee` varchar(30) NOT NULL COMMENT '收货人',
  `mobile` char(20) NOT NULL COMMENT '电话'
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='收获地址';

-- --------------------------------------------------------

--
-- Table structure for table `bp_banks`
--

CREATE TABLE `bp_banks` (
  `id` int(11) NOT NULL,
  `account` varchar(32) NOT NULL COMMENT '账号',
  `bank` varchar(100) NOT NULL COMMENT '开户行',
  `cardholder` varchar(50) NOT NULL COMMENT '持卡人',
  `user_id` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='银行卡管理';

-- --------------------------------------------------------

--
-- Table structure for table `bp_collections`
--

CREATE TABLE `bp_collections` (
  `id` int(11) NOT NULL,
  `user_id` varchar(30) NOT NULL COMMENT '主动关注user_id',
  `pro_id` varchar(30) NOT NULL COMMENT '收藏的产品id',
  `addtime` int(11) NOT NULL COMMENT '操作时间'
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='收藏';

-- --------------------------------------------------------

--
-- Table structure for table `bp_comment`
--

CREATE TABLE `bp_comment` (
  `user_id` varchar(30) NOT NULL COMMENT '谁提交的评论',
  `addtime` int(11) DEFAULT NULL COMMENT '发布时间',
  `stars` int(11) DEFAULT '100' COMMENT '分数0-100',
  `order_no` varchar(50) NOT NULL COMMENT '评论的订单号',
  `shop_id` varchar(30) NOT NULL COMMENT '根据订单号获取商铺id',
  `id` int(11) NOT NULL,
  `content` text COMMENT '评论详情'
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='订单评论表';

-- --------------------------------------------------------

--
-- Table structure for table `bp_coupon`
--

CREATE TABLE `bp_coupon` (
  `id` int(11) NOT NULL,
  `coupon_name` varchar(100) NOT NULL COMMENT '优惠券名称',
  `coupon_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '抵扣价格',
  `start_time` int(11) NOT NULL COMMENT '有效起始时间',
  `end_time` int(11) NOT NULL COMMENT '优惠券的到期时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券种类列表';

-- --------------------------------------------------------

--
-- Table structure for table `bp_following`
--

CREATE TABLE `bp_following` (
  `id` int(11) NOT NULL,
  `user_id` varchar(30) NOT NULL COMMENT '主动关注user_id',
  `shop_id` varchar(30) NOT NULL,
  `addtime` int(11) NOT NULL COMMENT '操作时间'
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='关注';

-- --------------------------------------------------------

--
-- Table structure for table `bp_footprint`
--

CREATE TABLE `bp_footprint` (
  `id` int(11) NOT NULL,
  `user_id` varchar(30) NOT NULL COMMENT '主动关注user_id',
  `pro_id` varchar(30) NOT NULL COMMENT '收藏的产品id',
  `addtime` int(11) NOT NULL COMMENT '操作时间'
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='足迹';

-- --------------------------------------------------------

--
-- Table structure for table `bp_integralslog`
--

CREATE TABLE `bp_integralslog` (
  `id` int(11) NOT NULL,
  `integrals` int(11) DEFAULT NULL COMMENT '获得、消费的积分数',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1获得积分2消耗积分',
  `addtime` int(11) NOT NULL COMMENT '记录生成时间',
  `content` varchar(255) DEFAULT NULL COMMENT '积分记录备注',
  `user_id` char(20) NOT NULL COMMENT '用户'
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='积分明细表--积分日志';

-- --------------------------------------------------------

--
-- Table structure for table `bp_level`
--

CREATE TABLE `bp_level` (
  `id` int(11) NOT NULL DEFAULT '0',
  `level_name` varchar(100) DEFAULT NULL COMMENT '会员种类名称',
  `discount` int(11) DEFAULT NULL COMMENT '享受的折扣价，填写0-100的整数',
  `integrals` int(11) DEFAULT NULL COMMENT '每月获取积分数',
  `content` text COMMENT '会员特权备注'
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='会员等级权益表';

-- --------------------------------------------------------

--
-- Table structure for table `bp_messages`
--

CREATE TABLE `bp_messages` (
  `id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `code` int(11) NOT NULL,
  `addtime` int(11) NOT NULL,
  `mobile` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短信验证吗';

-- --------------------------------------------------------

--
-- Table structure for table `bp_my_coupon`
--

CREATE TABLE `bp_my_coupon` (
  `id` int(11) NOT NULL,
  `coupon_name` varchar(100) NOT NULL COMMENT '优惠券名称',
  `coupon_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '抵扣价格',
  `start_time` int(11) NOT NULL COMMENT '有效起始时间',
  `end_time` int(11) NOT NULL COMMENT '优惠券的到期时间',
  `user_id` varchar(30) NOT NULL COMMENT '领取的用户id',
  `status` tinyint(1) NOT NULL COMMENT '1可用2已使用3不可用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='我的优惠券';

-- --------------------------------------------------------

--
-- Table structure for table `bp_notice`
--

CREATE TABLE `bp_notice` (
  `id` int(11) NOT NULL,
  `news_title` varchar(100) DEFAULT NULL COMMENT '文案名称',
  `content` text COMMENT '文案详情',
  `additive` int(11) DEFAULT NULL COMMENT '发布时间',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '分类'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bp_order`
--

CREATE TABLE `bp_order` (
  `id` int(11) NOT NULL,
  `flow_no` varchar(30) NOT NULL COMMENT '流水号----唯一的',
  `order_no` varchar(30) NOT NULL COMMENT '订单交易号',
  `user_id` varchar(30) NOT NULL COMMENT '下单客户',
  `shop_id` varchar(30) NOT NULL COMMENT '产品所属商店的user_id',
  `shop_name` varchar(255) DEFAULT NULL COMMENT '店铺名称',
  `pay_ment` varchar(30) NOT NULL COMMENT '支付方式',
  `pay_time` int(11) DEFAULT NULL COMMENT '支付时间',
  `addtime` int(11) NOT NULL COMMENT '下单时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1代支付2已支付3已发货4已收获5已评价6申请退款7退款驳回8退款成功',
  `allpro_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '此流水号购买的产品总价',
  `standard` text COMMENT '可用序列化的形式展现购买的产品id，型号，数量，价格集合',
  `order_nums` int(11) DEFAULT '1' COMMENT '购买的所有型号的数量',
  `consignee` varchar(30) NOT NULL COMMENT '收货人',
  `mobile` char(20) NOT NULL COMMENT '收货电话',
  `addr` varchar(255) NOT NULL COMMENT '收货地址',
  `order_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际支付的价格，即订单减去优惠券后，或使用折扣后的价格',
  `discounts` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1不使用任何折扣，2只使用优惠券，3只使用会员折扣价，4既使用优惠券又使用会员折扣，抵扣规则是：总价先减去优惠券的价格再使用会员折扣',
  `my_couponid` int(11) DEFAULT NULL COMMENT '被使用的我账户中的优惠券的id',
  `my_couponprice` decimal(10,2) DEFAULT '0.00' COMMENT '被使用的我账户中的优惠券的抵扣价格',
  `discount` int(11) DEFAULT '100' COMMENT '会员身份中用户的折扣比例填写0-100中的数字',
  `my_couponendtime` int(11) NOT NULL COMMENT '被我使用的优惠券到期时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='下单表';

-- --------------------------------------------------------

--
-- Table structure for table `bp_product`
--

CREATE TABLE `bp_product` (
  `id` int(11) NOT NULL,
  `pro_name` varchar(255) NOT NULL COMMENT '所有产品名称',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '产品价格',
  `allsales` int(11) NOT NULL DEFAULT '0' COMMENT '所有规格销售总量',
  `express_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '快递费',
  `weight` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '重量',
  `standard` text COMMENT '规格，有对应的单独的表',
  `shop` char(30) NOT NULL DEFAULT '0' COMMENT '店家的user_id',
  `evaluate` int(11) NOT NULL DEFAULT '0' COMMENT '评价数量',
  `type1` tinyint(2) NOT NULL DEFAULT '0' COMMENT '产品一级分类',
  `type2` tinyint(2) NOT NULL DEFAULT '0' COMMENT '产品二级分类',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1正常销售2已被下架',
  `property` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1普通产品2折扣产品3积分产品',
  ` recommend` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1普通产品2推荐产品（商家商铺首页的三个产品也使用推荐自段）',
  `allnums` int(11) NOT NULL DEFAULT '0' COMMENT '所有规格的总货存'
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='产品表';

-- --------------------------------------------------------

--
-- Table structure for table `bp_product_img`
--

CREATE TABLE `bp_product_img` (
  `id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `images` varchar(100) NOT NULL,
  `cover_map` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1作为封面2作为详情页产品图'
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='产品图集';

-- --------------------------------------------------------

--
-- Table structure for table `bp_product_standard`
--

CREATE TABLE `bp_product_standard` (
  `id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL COMMENT '产品表id',
  `standard1` text NOT NULL COMMENT '规格1',
  `standard2` text NOT NULL COMMENT '规格2',
  `nums` int(11) NOT NULL DEFAULT '0' COMMENT '此规格的货存数量',
  `sales` int(11) NOT NULL DEFAULT '0' COMMENT '此规格的销售量',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '此规格的产品价格',
  `pro_name` varchar(255) NOT NULL COMMENT '此规格产品名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品规格表';

-- --------------------------------------------------------

--
-- Table structure for table `bp_recharge`
--

CREATE TABLE `bp_recharge` (
  `id` int(11) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `addtime` int(11) NOT NULL,
  `order_no` varchar(50) NOT NULL COMMENT '流水号',
  `status` char(6) NOT NULL DEFAULT '1' COMMENT '1微支付2已支付'
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='用户充值记录';

-- --------------------------------------------------------

--
-- Table structure for table `bp_reflect`
--

CREATE TABLE `bp_reflect` (
  `id` int(11) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `additive` int(11) NOT NULL COMMENT '提交时间',
  `endtime` int(11) NOT NULL COMMENT '审核时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1待审核2完成打款3拒绝打款',
  `content` varchar(255) DEFAULT NULL COMMENT '理由'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提现申请表';

-- --------------------------------------------------------

--
-- Table structure for table `bp_shop`
--

CREATE TABLE `bp_shop` (
  `id` int(11) NOT NULL,
  `user_id` char(30) NOT NULL COMMENT '申请会员的用户id',
  `shop_name` varchar(100) DEFAULT NULL COMMENT '店铺名称',
  `contacts` char(30) DEFAULT NULL COMMENT '联系人姓名',
  `contacts_mobile` varchar(20) DEFAULT NULL COMMENT '联系人电话',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '店铺分类  0代表其他分类',
  `province_name` char(100) DEFAULT NULL,
  `area_name` char(100) DEFAULT NULL,
  `city_name` char(100) DEFAULT NULL,
  `province` char(20) DEFAULT NULL COMMENT '省 code',
  `city` char(20) DEFAULT NULL COMMENT '市code',
  `area` char(20) DEFAULT NULL COMMENT '区code',
  `addr` varchar(255) DEFAULT NULL COMMENT '门店详细地址',
  `face_photo` varchar(100) DEFAULT NULL COMMENT '门脸照',
  `store_photo` varchar(100) DEFAULT NULL COMMENT '店内照片',
  `logo` varchar(100) DEFAULT NULL COMMENT '店铺logo',
  `card_photo` varchar(100) DEFAULT NULL COMMENT '身份证照片',
  `business_photo` varchar(100) DEFAULT NULL COMMENT '营业执照',
  `licence_photo` varchar(100) DEFAULT NULL COMMENT '行业许可证',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1待审核2审核通过3审核驳回',
  `content` varchar(255) DEFAULT '' COMMENT '备注、驳回理由或通过理由',
  `addtime` int(11) NOT NULL COMMENT '信息提交时间',
  `sales` int(11) NOT NULL DEFAULT '0' COMMENT '销售量'
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='店铺详情资料';

-- --------------------------------------------------------

--
-- Table structure for table `bp_shop_cart`
--

CREATE TABLE `bp_shop_cart` (
  `id` int(11) NOT NULL,
  `user_id` varchar(30) NOT NULL COMMENT '用户id',
  `pro_id` int(11) NOT NULL COMMENT '产品的id',
  `shop_id` varchar(30) NOT NULL COMMENT '产品所属商户的user_id',
  `nums` int(11) NOT NULL DEFAULT '1' COMMENT '加购数量',
  `purchase_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '加购价',
  `addtime` int(11) NOT NULL COMMENT '加购时间'
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='购物车';

-- --------------------------------------------------------

--
-- Table structure for table `bp_types`
--

CREATE TABLE `bp_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL COMMENT '分类名称',
  `pid` int(11) DEFAULT NULL COMMENT '父级分类',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1店铺分类2一级产品分类3二级产品分类',
  `toop` int(11) DEFAULT NULL COMMENT '排序'
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='分类表';

-- --------------------------------------------------------

--
-- Table structure for table `bp_user`
--

CREATE TABLE `bp_user` (
  `id` int(11) NOT NULL,
  `user_id` varchar(20) DEFAULT NULL COMMENT '用户身份id具有唯一性',
  `username` char(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL COMMENT '会员头像',
  `loginpwd` char(32) DEFAULT NULL COMMENT '录登秘密加密',
  `loginpwds` char(32) DEFAULT NULL COMMENT '登录秘密未加密',
  `loginblog` char(32) DEFAULT NULL COMMENT '微博登录',
  `loginwechar` char(32) DEFAULT NULL COMMENT '微信登录',
  `loginqq` char(32) DEFAULT NULL COMMENT 'qq登录',
  `loginalipay` char(32) DEFAULT NULL COMMENT '支付宝支付',
  `status` tinyint(1) DEFAULT '1' COMMENT '1表示正常用户、商家正常营业、骑手正常上班；2表示商家休息中、骑手下班中；3表示该用户被封禁',
  `addtime` int(11) DEFAULT NULL COMMENT '注册时间',
  `level` tinyint(1) DEFAULT '1' COMMENT '员会等级   1普通用户；2白金会员；3钻石会员；4黑卡会员；目前几种会员等级的名字是暂定，后期有肯能改动',
  `integral` int(11) NOT NULL DEFAULT '0' COMMENT '用户现有积分',
  `user_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '用户现有资金',
  `frozen_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结资金',
  `rank` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1普通会员2提交了骑手的申请3被拒绝了骑手申请4骑手5提交了商户的申请6商户申请被拒绝7商户',
  `mailbox` varchar(40) DEFAULT NULL COMMENT '邮箱 若没有@说明未绑定'
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='用户表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bp_addr`
--
ALTER TABLE `bp_addr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_banks`
--
ALTER TABLE `bp_banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_collections`
--
ALTER TABLE `bp_collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_comment`
--
ALTER TABLE `bp_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_coupon`
--
ALTER TABLE `bp_coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_following`
--
ALTER TABLE `bp_following`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_footprint`
--
ALTER TABLE `bp_footprint`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_integralslog`
--
ALTER TABLE `bp_integralslog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_level`
--
ALTER TABLE `bp_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_messages`
--
ALTER TABLE `bp_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_my_coupon`
--
ALTER TABLE `bp_my_coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_notice`
--
ALTER TABLE `bp_notice`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `bp_order`
--
ALTER TABLE `bp_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_product`
--
ALTER TABLE `bp_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_product_img`
--
ALTER TABLE `bp_product_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_product_standard`
--
ALTER TABLE `bp_product_standard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_recharge`
--
ALTER TABLE `bp_recharge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_reflect`
--
ALTER TABLE `bp_reflect`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_shop`
--
ALTER TABLE `bp_shop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_shop_cart`
--
ALTER TABLE `bp_shop_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_types`
--
ALTER TABLE `bp_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bp_user`
--
ALTER TABLE `bp_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bp_addr`
--
ALTER TABLE `bp_addr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_banks`
--
ALTER TABLE `bp_banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_collections`
--
ALTER TABLE `bp_collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_comment`
--
ALTER TABLE `bp_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_coupon`
--
ALTER TABLE `bp_coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_following`
--
ALTER TABLE `bp_following`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_footprint`
--
ALTER TABLE `bp_footprint`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_integralslog`
--
ALTER TABLE `bp_integralslog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_messages`
--
ALTER TABLE `bp_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_my_coupon`
--
ALTER TABLE `bp_my_coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_notice`
--
ALTER TABLE `bp_notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_order`
--
ALTER TABLE `bp_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_product`
--
ALTER TABLE `bp_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_product_img`
--
ALTER TABLE `bp_product_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_product_standard`
--
ALTER TABLE `bp_product_standard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_recharge`
--
ALTER TABLE `bp_recharge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_reflect`
--
ALTER TABLE `bp_reflect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_shop`
--
ALTER TABLE `bp_shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_shop_cart`
--
ALTER TABLE `bp_shop_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_types`
--
ALTER TABLE `bp_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_user`
--
ALTER TABLE `bp_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;