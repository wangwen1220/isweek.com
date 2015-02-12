<?php
return  array(
 		'TMPL_FILE_DEPR'        => '.', //模板文件MODULE_NAME与ACTION_NAME之间的分割符
	  // 'SHOW_PAGE_TRACE'		=> true,
		'DB_TYPE'               =>  'mysql',     // 数据库类型
		'DB_HOST'               =>  '192.168.2.180', // 服务器地址
		'DB_NAME'               =>  'isweek',          // 数据库名
		'DB_USER'               =>  'isweek',      // 用户名
		'DB_PWD'                =>  'isweek',          // 密码
		'DB_PREFIX'                =>  'sp_',          // 密码
		'TMPL_PARSE_STRING'		=>	array(
			'__TMPL__res'	=>	'/Public/Admin',
			'__UPLOAD__' 	=> __ROOT__.'/Uploads/',
		),
		'UPLOADPATH' 		=> __ROOT__.'/Uploads/',
		'VAR_PAGE' 			=> 'p',
);

