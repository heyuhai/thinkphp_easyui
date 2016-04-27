<?php
namespace Common\Model;
use Think\Model;
/**
 * 基层数据操作模型
 */
class BaseModel extends Model {

    function getList()
    {
        $list = $this->order("orderby asc, createtime desc")->select();
        foreach ($list as $key => $value) {
            $list[$key]['formattime'] = date("Y-m-d", $value['createtime']);
        }
        return $list;
    }

    function getPlusOrderby()
    {
        $maxOrderby = $this->max('orderby');
        if(!empty($maxOrderby)){
            $maxOrderby++;
        }else{
            $maxOrderby = 1;
        }
        return $maxOrderby;
    }

    function delRow($id)
    {
        $rs = $this->where("id=$id")->delete();
        return $rs;
    }

}
