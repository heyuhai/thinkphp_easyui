<?php
namespace MineAdmin\Controller;
use Think\Controller;
class SysadminController extends BaseController {

    //-=-=-=-=-=-=-=模块管理-=-=-=-=-=-=-=-=-=
    public function sysmoduleList()
    {
        $sysmodule = D("Sysmodule");
        $maxOrderby = $sysmodule->getPlusOrderby();
        $data['maxOrderby'] = $maxOrderby;

        //父级分类
        $pList = $sysmodule->getPidList();
        $data['pList'] = $pList;

        $this->assign($data);
        $this->display('sysmoduleList');
    }

    //列表输出json数据
    public function sysmoduleJsonData()
    {
        $sysmodule = D("Sysmodule");
        $sysmoduleList = $sysmodule->getList();
        //var_dump($sysmoduleList);
        echo json_encode($sysmoduleList);
    }

    //新增---===---修改
    public function sysmoduleModify()
    {
        if(IS_POST){
            $sysmodule = D("Sysmodule");
            $id = I("get.id");

            //数据
            $arr['pid'] = I("post.pid");
            $arr['title'] = I("post.title");
            $arr['module'] = I("post.module");
            $arr['action'] = I("post.action");
            $arr['param'] = I("post.param");
            $arr['orderby'] = I("post.orderby");

            if($id){
                $arr['id'] = $id;
                $rs = $sysmodule->save($arr);
                if($rs){
                    $data['status'] = 1;
                    $data['msg'] = "修改成功！";
                }else{
                    $data['status'] = -2;
                    $data['msg'] = "修改出错！";
                }
            }else{
                $arr['createtime'] = time();
                $rs = $sysmodule->add($arr);
                if($rs){
                    $data['status'] = 1;
                    $data['msg'] = "新增成功！";
                }else{
                    $data['status'] = -2;
                    $data['msg'] = "新增出错！";
                }
            }
        }else{
            $data['status'] = -1;
            $data['msg'] = "提交出错！";
        }
        $this->ajaxReturn($data);
    }

    //删除
    public function sysmoduleDel()
    {
        $id = I("get.id");
        $sysmodule = D("Sysmodule");

        $rs = $sysmodule->delRow($id);

        if($rs){
            $data['status'] = 1;
            $data['msg'] = "删除成功！";
        }else{
            $data['status'] = -2;
            $data['msg'] = "删除出错！";
        }
        $this->ajaxReturn($data);
    }

    //=-=-=-=-=-=- 管理员管理 -=-=-=-=-=-=
    public function sysadminList()
    {
        $sysadmin = D("Sysadmin");
        $maxOrderby = $sysadmin->getPlusOrderby();
        $data['maxOrderby'] = $maxOrderby;

        //角色
        $sysadminGroup = D("SysadminGroup");
        $sysadminGroupList = $sysadminGroup->getList();
        $data['sysadminGroupList'] = $sysadminGroupList;

        $this->assign($data);
        $this->display('sysadminList');
    }

    public function sysadminJsonData()
    {
        $sysadmin = D("Sysadmin");
        $sysadminList = $sysadmin->getList();

        $jsonArr['total'] = count($sysadminList);
        $jsonArr['rows'] = $sysadminList;
        echo json_encode($jsonArr);
    }

    //管理员新增修改
    public function sysadminModify()
    {
        if(IS_POST){
            $sysadmin = D("Sysadmin");
            $id = I("get.id");

            //数据
            $arr['username'] = I("post.username");
            $password = I("post.password");
            if(!empty($password)){
                $arr['password'] = md5($password.'yagni');
            }
            $arr['pid'] = I("post.pid");
            $arr['power'] = I("post.power");
            $arr['orderby'] = I("post.orderby");

            if($id){
                $arr['id'] = $id;
                $rs = $sysadmin->save($arr);
                if($rs){
                    $data['status'] = 1;
                    $data['msg'] = "修改成功！";
                }else{
                    $data['status'] = -2;
                    $data['msg'] = "修改出错！";
                }
            }else{
                $arr['createtime'] = time();
                $rs = $sysadmin->add($arr);
                if($rs){
                    $data['status'] = 1;
                    $data['msg'] = "新增成功！";
                }else{
                    $data['status'] = -2;
                    $data['msg'] = "新增出错！";
                }
            }
        }else{
            $data['status'] = -1;
            $data['msg'] = "提交出错！";
        }
        $this->ajaxReturn($data);
    }

    //管理员修改密码
    public function editPwd()
    {
        $adminId = session('adminId');
        $oldpass = I("post.oldpass");
        $newpass = I("post.newpass");

        $sysadmin = D("Sysadmin");
        //检查旧密码是否正确
        $checkOldPwd = $sysadmin->checkOldPwd($adminId, md5($oldpass."yagni"));
        if($checkOldPwd){
            $rs = $sysadmin->editPwd($adminId, md5($newpass."yagni"));
            if($rs){
                $data['status'] = 1;
                $data['msg'] = "修改成功！";
            }elseif($rs === 0){
                $data['status'] = -2;
                $data['msg'] = "旧密码跟新密码一致！";
            }else{
                $data['status'] = -1;
                $data['msg'] = "修改密码出错！";
            }
        }else{
            $data['status'] = -2;
            $data['msg'] = "旧密码输入错误，请再确认！";
        }
        $this->ajaxReturn($data);
    }

    //管理员删除
    public function sysadminDel()
    {
        $id = I("get.id");
        $sysadmin = D("Sysadmin");

        $rs = $sysadmin->delRow($id);

        if($rs){
            $data['status'] = 1;
            $data['msg'] = "删除成功！";
        }else{
            $data['status'] = -2;
            $data['msg'] = "删除出错！";
        }
        $this->ajaxReturn($data);
    }

    //-=-=-=-=-= 角色管理 -=-=-=-=-=-=-=-
    public function sysadminGroupList()
    {
        //权限检查
        $this->checkPower("sysadminGroupList");
        $sysadminGroup = D("SysadminGroup");
        $maxOrderby = $sysadminGroup->getPlusOrderby();
        $data['maxOrderby'] = $maxOrderby;

        $this->assign($data);
        $this->display('sysadminGroupList');
    }

    //-=-=-=-=-= 角色列表 -=-=-=-=-=-=-=-
    public function sysadminGroupJsonData()
    {
        //权限检查
        $this->checkPower("sysadminGroupList");
        $sysadminGroup = D("SysadminGroup");
        $sysadminGroupList = $sysadminGroup->getList();

        $jsonArr['total'] = count($sysadminGroupList);
        $jsonArr['rows'] = $sysadminGroupList;
        echo json_encode($jsonArr);
    }

    //角色新增修改
    public function sysadminGroupModify()
    {
        //权限检查
        $this->checkPower("sysadminGroupList");
        if(IS_POST){
            $sysadminGroup = D("SysadminGroup");
            $id = I("get.id");

            //数据
            $arr['title'] = I("post.title");
            $arr['power'] = I("post.power");
            $arr['orderby'] = I("post.orderby");

            if($id){
                $arr['id'] = $id;
                //TODO: 修改--关联管理员所对应角色，权限修改
                $sysadminGroup->save($arr);
                $sysadmin = D("Sysadmin");
                $powerArr['power'] = $arr['power'];
                $rs = $sysadmin->where("pid=$id")->save($powerArr);
                if($rs){
                    $data['status'] = 1;
                    $data['msg'] = "修改成功！";
                }else{
                    $data['status'] = -2;
                    $data['msg'] = "修改出错！";
                }
            }else{
                $arr['createtime'] = time();
                $rs = $sysadminGroup->add($arr);
                if($rs){
                    $data['status'] = 1;
                    $data['msg'] = "新增成功！";
                }else{
                    $data['status'] = -2;
                    $data['msg'] = "新增出错！";
                }
            }
        }else{
            $data['status'] = -1;
            $data['msg'] = "提交出错！";
        }
        $this->ajaxReturn($data);
    }

    //删除
    public function sysadminGroupDel()
    {
        //权限检查
        $this->checkPower("sysadminGroupList");
        $id = I("get.id");
        $sysadminGroup = D("SysadminGroup");

        $rs = $sysadminGroup->delRow($id);

        if($rs){
            $data['status'] = 1;
            $data['msg'] = "删除成功！";
        }else{
            $data['status'] = -2;
            $data['msg'] = "删除出错！";
        }
        $this->ajaxReturn($data);
    }

    //-=-=-=-=-= 权限列表 -=-=-=-=-=-=-=-
    public function sysmodulePowerJsonList()
    {
        //模块权限
        $sysmodule = D("Sysmodule");
        $sysmoduleList = $sysmodule->getPowerList();

        $power = I("get.power");
        if($power){
            $powerArr = explode(',', $power);
            //只需判断子节点是否选中
            foreach ($sysmoduleList as $key => $value) {
                if(isset($value['children']) && count($value['children']) > 0){
                    foreach ($value['children'] as $k => $val) {
                        if(in_array($val['id'], $powerArr)){
                            $value['children'][$k]['checked'] = true;
                        }
                    }
                    $sysmoduleList[$key]['children'] = $value['children'];
                }
            }
        }
        echo json_encode($sysmoduleList);
    }

    //根据角色ID查询权限power
    public function groupIdForPower()
    {
        $id = I("get.id");
        $sysadminGroup = D("SysadminGroup");
        $power = $sysadminGroup->where("id=$id")->getField('power');
        echo json_encode($power);
    }

    //-=-=-==-=-=-= 系统日志 ==========================
    public function syslogList()
    {
        $this->display('syslogList');
    }
}
