<?php
//公共配置
return array(
	//'配置项'=>'配置值'
	'URL_MODEL'             =>  '2', //URL模式 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
    'URL_404_REDIRECT'      =>  '', // 404 跳转页面 部署模式有效
    'SHOW_PAGE_TRACE'       =>  true, // 显示页面Trace信息
    //模块分组
    'MULTI_MODULE'          =>  'true',
    'MODULE_ALLOW_LIST'     =>  array('Home','MineAdmin'),
    'DEFAULT_MODULE'        =>  'Home',
    'TMPL_FILE_DEPR'        =>  '/', //目录层次设定
    'TMPL_PARSE_STRING'  =>array(
         '__PICS__'  =>  '/pics', //增加新的上传路径替换规则
         '__TMPL__' =>  '/Public',
    ),

    //数据库配置
    'DB_TYPE'               =>  'mysql', // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'mine', // 数据库名
    'DB_USER'               =>  'root', // 用户名
    'DB_PWD'                =>  '123456', // 密码
    'DB_PORT'               =>  '3306', // 端口
    'DB_PREFIX'             =>  'me_', // 数据库表前缀

    'SESSION_AUTO_START'    =>  true, // 是否自动开启Session
    'SESSION_PREFIX'        =>  'me_s_', // session 前缀

    'TOKEN_ON'              =>  true, // 是否开启令牌验证 默认关闭
    'TOKEN_NAME'            =>  '__hash__', // 令牌验证的表单隐藏字段名称，默认为__hash__
    'TOKEN_TYPE'            =>  'md5', //令牌哈希验证规则 默认为MD5
    'TOKEN_RESET'           =>  true, //令牌验证出错后是否重置令牌 默认为true
);
