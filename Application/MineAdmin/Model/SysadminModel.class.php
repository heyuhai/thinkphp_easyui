<?php
namespace MineAdmin\Model;
use Think\Model;
use Common\Model\BaseModel as BaseModel;

class SysadminModel extends BaseModel {

    function checkLogin($username, $password)
    {
        $map['username'] = $username;
        $map['password'] = $password;
        $rs = $this->where($map)->find();
        return $rs;
    }

    function checkOldPwd($uid, $oldpwd)
    {
        $map['id'] = $uid;
        $map['password'] = $oldpwd;
        $rs = $this->where($map)->find();
        return $rs;
    }

    function editPwd($uid, $newpwd)
    {
        $data['id'] = $uid;
        $data['password'] = $newpwd;
        $rs = $this->save($data);
        return $rs;
    }

}
