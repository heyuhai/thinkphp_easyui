<?php
namespace MineAdmin\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function checkLogin()
    {
        $adminId = session('?adminId');
        if(!$adminId){
            header("location:/MineAdmin");
        }
    }

    //后台登录
    public function index()
    {
        if(IS_POST)
        {
            $username = I('post.username');
            $password = I('post.password');
            $captcha = I('post.captcha');

            //判断验证码
            $checkVerify = $this->check_verify($captcha);
            if($checkVerify){
                //判断帐号密码
                $sysadmin = D("Sysadmin");
                $result = $sysadmin->checkLogin($username, md5($password."yagni"));

                if($result){
                    session("adminId", $result['id']);
                    session("adminName", $result['username']);
                    session("adminPower", $result['power']);
                    response(1);
                }else{
                    response('10002', '登录失败，请检查帐号密码！');
                }
            }else{
                response('10001', '验证码错误，请点击变换验证码！');
            }
        }
        $this->display('login');
    }

    public function logout()
    {
        session("adminId", null);
        session("adminName", null);
        session("adminPower", null);
        header("location:/MineAdmin");
    }

    //主界面
    public function main()
    {
        $this->checkLogin();
        //登录管理员权限
        $adminPower = session('adminPower');
        $adminPowerArr = explode(',', $adminPower);
        $data['adminPowerArr'] = $adminPowerArr;
        //左侧菜单
        $sysmodule = D("Sysmodule");
        $sysmoduleList = $sysmodule->getList();
        $data['sysmoduleList'] = $sysmoduleList;

        $this->assign($data);
        $this->display('main');
    }

    //低版本浏览器跳转
    public function ie6update()
    {
        $this->display('ie6update');
    }

    //验证码
    public function verify()
    {
        $config = array(
            'imageW'      => '90',
            'imageH'      => '26',
            'codeSet'     => '0123456789', //设置验证码字符为纯数字
            'fontSize'    => 14, // 验证码字体大小
            'length'      => 4, // 验证码位数
            'useNoise'    => false, // 关闭验证码杂点
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }

    //检测输入的验证码是否正确，$code为用户输入的验证码字符串
    public function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }
}
