<?php
return array(
   	//'配置项'=>'配置值'
	  //数据库配置信息
	'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '', // 服务器地址
    'DB_NAME'   => 'crm', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'root', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => '', // 数据库表前缀
    'DB_CHARSET'=> 'utf8mb4', // 字符集

		
	//'配置项'=>'配置值'
		//权限验证
	'AUTH_CONFIG' => array(
		'AUTH_ON'           => true,                      // 认证开关
        'AUTH_TYPE'         => 1,                         // 认证方式，1为实时认证；2为登录认证。
        'AUTH_GROUP'        => 'group_role',        // 用户组数据表名
        'AUTH_GROUP_ACCESS' => 'group_access', // 用户-用户组关系表
        'AUTH_RULE'         => 'group_rule',         // 权限规则表
        'AUTH_USER'         => 'user'             // 用户信息表
	),

	//模板
	'TMPL_PARSE_STRING'  =>array(
        '__COMMON__' => '/Application/Home/Common',
		'__WWW__' => '',
    ),

);
