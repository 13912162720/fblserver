<?php
return array(
		//数据库配置信息
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => '123.206.47.20', // 服务器地址
	'DB_NAME'   => 'cosdna', // 数据库名
	'DB_USER'   => 'wlmx', // 用户名
	'DB_PWD'    => 'rootroot', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => 'cd_', // 数据库表前缀 
	'DB_CHARSET'=> 'utf8', // 字符集
	'DB_DEBUG'  =>  FALSE, // 数据库调试模式 
	//'配置项'=>'配置值'
	'URL_ROUTER_ON' => true,

	'URL_MODEL' => '2',

	'MODULE_ALLOW_LIST'    =>    array('Api'),

	'DEFAULT_MODULE'       =>    'Api',  // 
);