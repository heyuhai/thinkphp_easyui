<?php
namespace MineAdmin\Controller;
use Think\Controller;
class NewsController extends BaseController {

    public function newsList()
    {
        //权限检查
        $this->checkPower("newsList");

        
        $this->display('newsList');
    }

}