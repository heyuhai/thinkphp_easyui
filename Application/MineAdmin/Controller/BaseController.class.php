<?php
namespace MineAdmin\Controller;
use Think\Controller;
class BaseController extends Controller {
    //初始化
    public function _initialize(){
        $this->checkLogin();
    }

    //检查是否登录
    public function checkLogin()
    {
        $adminId = session('?adminId');
        if(!$adminId){
            header("location:/MineAdmin");
        }
    }

    //检查是否有权限
    public function checkPower($action)
    {
        //登录管理员权限
        $adminPower = session('adminPower');
        $adminPowerArr = explode(',', $adminPower);

        //判断当前操作模块是否有权访问
        $mod = CONTROLLER_NAME."/".$action;
        $sysmodule = D("Sysmodule");
        $map['url'] = $mod;
        $powerId = $sysmodule->where($map)->getField("id");
        if(!in_array($powerId, $adminPowerArr)){
            $this->error('没有权限操作，请联系相关管理员！');
            exit;
        }
    }
}
