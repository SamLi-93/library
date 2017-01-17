<?php
namespace LaneWeChat;

<<<<<<< .mine
if (isset($_SESSION)) {

} else {
    session_start();
}

||||||| .r138
session_start();
=======
//session_start();
>>>>>>> .r144
//引入配置文件
include_once __DIR__.'/config.php';
//引入自动载入函数
include_once __DIR__.'/autoloader.php';
//调用自动载入函数
AutoLoader::register();